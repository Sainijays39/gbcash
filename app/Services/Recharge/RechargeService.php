<?php

namespace App\Services\Recharge;

use App\Models\RechargeRequest;
use App\Models\User;
use App\Repositories\Contracts\RechargeRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\BillAvenue\BillAvenueClient;
use App\Services\TransactionReferenceGenerator;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class RechargeService
{
    public function __construct(
        private readonly RechargeOperatorService $operators,
        private readonly RechargeRepositoryInterface $rechargeRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly TransactionReferenceGenerator $referenceGenerator,
        private readonly BillAvenueClient $billAvenue,
    ) {}

    /**
     * Live recharge plans from BillAvenue's Recharge Plan API.
     *
     * Circle defaults to "All" since our UI doesn't collect a circle/location —
     * that's a valid value per BillAvenue's Location/Circle reference list.
     *
     * Results are cached per-user so createPendingRequest() can re-validate the
     * selected plan server-side instead of trusting a client-supplied price.
     */
    public function plans(string $operatorBillerId, string $circle, User $user): array
    {
        $response = $this->billAvenue->rechargePlans($operatorBillerId, $circle);

        $plans = $response['rechargePlan']['rechargePlansDetails'] ?? [];

        $mapped = collect($plans)->values()->map(fn (array $plan, int $index) => [
            'id' => "plan_{$index}",
            'price' => (float) $plan['Amount'],
            'data_per_day' => $plan['PlanName'] ?? 'Plan',
            'validity_days' => $this->parseValidityDays($plan['Validity'] ?? ''),
            'validity_label' => $plan['Validity'] ?? '',
            'description' => $plan['Description'] ?? '',
            'benefits' => array_values(array_filter([
                $plan['Description'] ?? null,
                isset($plan['Talktime']) && (float) $plan['Talktime'] > 0 ? '₹'.$plan['Talktime'].' Talktime' : null,
            ])),
        ])->all();

        Cache::put($this->plansCacheKey($user, $operatorBillerId), $mapped, now()->addMinutes(10));

        return $mapped;
    }

    public function createPendingRequest(User $user, string $mobile, string $operatorBillerId, string $planId): RechargeRequest
    {
        $plans = Cache::get($this->plansCacheKey($user, $operatorBillerId), []);
        $plan = collect($plans)->firstWhere('id', $planId);

        if (! $plan) {
            throw new RuntimeException('This plan has expired. Please pick a plan again.');
        }

        $response = $this->billAvenue->billPay([
            'agentId' => $this->billAvenue->agentId(),
            'agentDeviceInfo' => $this->billAvenue->agentDeviceInfo(),
            'billerId' => $operatorBillerId,
            'billerAdhoc' => true,
            'customerInfo' => [
                'customerMobile' => $mobile,
            ],
            'inputParams' => [
                'input' => [
                    ['paramName' => 'Mobile Number', 'paramValue' => $mobile],
                    ['paramName' => 'Location', 'paramValue' => 'All'],
                ],
            ],
            'amountInfo' => [
                'amount' => (int) round($plan['price'] * 100), // paise
                'currency' => '356',
                'custConvFee' => 0,
            ],
            'paymentMethod' => [
                'paymentMode' => 'Cash',
                'quickPay' => 'N',
                'splitPay' => 'N',
            ],
            'paymentInfo' => [
                'info' => [
                    ['infoName' => 'Remarks', 'infoValue' => 'Received'],
                ],
            ],
        ]);

        $request = $this->rechargeRepository->create([
            'user_id' => $user->id,
            'mobile' => $mobile,
            'operator' => $this->operators->label($operatorBillerId),
            'plan_name' => '₹'.$plan['price'].' · '.$plan['data_per_day'],
            'amount' => $plan['price'],
            'validity' => $plan['validity_label'] ?? ($plan['validity_days'].' Days'),
            'data_benefit' => $plan['data_per_day'],
            'benefits' => $plan['benefits'],
            'status' => 'pending',
        ]);

        $this->transactionRepository->create([
            'user_id' => $user->id,
            'service_type' => 'recharge',
            'service_id' => $request->id,
            'reference_number' => $response['txnRefId'] ?? $this->referenceGenerator->generate('RCHG'),
            'amount' => $plan['price'],
            'status' => 'pending',
        ]);

        return $request;
    }

    private function parseValidityDays(string $validity): int
    {
        preg_match('/(\d+)/', $validity, $matches);

        return isset($matches[1]) ? (int) $matches[1] : 0;
    }

    private function plansCacheKey(User $user, string $operatorBillerId): string
    {
        return "recharge-plans:{$user->id}:{$operatorBillerId}";
    }
}
