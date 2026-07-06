<?php

namespace App\Services\Recharge;

use App\Models\RechargeRequest;
use App\Models\User;
use App\Repositories\Contracts\RechargeRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\TransactionReferenceGenerator;

class RechargeService
{
    /**
     * Static plan catalog. Kept server-side so the client can never
     * influence the amount charged for a given plan.
     */
    private const PLANS = [
        'plan_199' => ['id' => 'plan_199', 'price' => 199, 'data_per_day' => '1.5GB/Day', 'validity_days' => 28, 'benefits' => ['Unlimited Calls', '100 SMS/Day', '1.5GB/Day Data']],
        'plan_299' => ['id' => 'plan_299', 'price' => 299, 'data_per_day' => '2GB/Day', 'validity_days' => 28, 'benefits' => ['Unlimited Calls', '100 SMS/Day', '2GB/Day Data']],
        'plan_666' => ['id' => 'plan_666', 'price' => 666, 'data_per_day' => '1.5GB/Day', 'validity_days' => 84, 'benefits' => ['Unlimited Calls', '100 SMS/Day', '1.5GB/Day Data']],
        'plan_999' => ['id' => 'plan_999', 'price' => 999, 'data_per_day' => '2.5GB/Day', 'validity_days' => 84, 'benefits' => ['Unlimited Calls', '100 SMS/Day', '2.5GB/Day Data']],
    ];

    public function __construct(
        private readonly RechargeOperatorService $operators,
        private readonly RechargeRepositoryInterface $rechargeRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly TransactionReferenceGenerator $referenceGenerator,
    ) {}

    public function plans(): array
    {
        return array_values(self::PLANS);
    }

    public function findPlan(string $planId): ?array
    {
        return self::PLANS[$planId] ?? null;
    }

    public function createPendingRequest(User $user, string $mobile, string $operator, string $planId): RechargeRequest
    {
        $plan = $this->findPlan($planId);

        $request = $this->rechargeRepository->create([
            'user_id' => $user->id,
            'mobile' => $mobile,
            'operator' => $this->operators->label($operator),
            'plan_name' => '₹'.$plan['price'].' · '.$plan['data_per_day'],
            'amount' => $plan['price'],
            'validity' => $plan['validity_days'].' Days',
            'data_benefit' => $plan['data_per_day'],
            'benefits' => $plan['benefits'],
            'status' => 'pending',
        ]);

        $this->transactionRepository->create([
            'user_id' => $user->id,
            'service_type' => 'recharge',
            'service_id' => $request->id,
            'reference_number' => $this->referenceGenerator->generate('RCHG'),
            'amount' => $plan['price'],
            'status' => 'pending',
        ]);

        return $request;
    }
}
