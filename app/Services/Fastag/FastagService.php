<?php

namespace App\Services\Fastag;

use App\Models\FastagRequest;
use App\Models\User;
use App\Repositories\Contracts\FastagRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\BillAvenue\BillAvenueClient;
use App\Services\TransactionReferenceGenerator;
use Illuminate\Support\Facades\Cache;

class FastagService
{
    public function __construct(
        private readonly FastagBankService $banks,
        private readonly FastagRepositoryInterface $fastagRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly TransactionReferenceGenerator $referenceGenerator,
        private readonly BillAvenueClient $billAvenue,
    ) {}

    public function fetchDetails(string $vehicleNumber, string $issuerBank, User $user): array
    {
        $normalized = strtoupper(str_replace(' ', '', $vehicleNumber));
        $inputParamName = $this->primaryInputParamName($issuerBank);

        $response = $this->billAvenue->billFetch([
            'agentId' => $this->billAvenue->agentId(),
            'agentDeviceInfo' => $this->billAvenue->agentDeviceInfo(),
            'customerInfo' => [
                'customerMobile' => $user->mobile,
            ],
            'billerId' => $issuerBank,
            'inputParams' => [
                'input' => [
                    ['paramName' => $inputParamName, 'paramValue' => $normalized],
                ],
            ],
        ]);

        $billerResponse = $response['billerResponse'] ?? [];
        $additionalInfo = collect($response['additionalInfo']['info'] ?? [])
            ->pluck('infoValue', 'infoName');

        return [
            'vehicle_number' => $normalized,
            'issuer_bank' => $issuerBank,
            'issuer_bank_label' => $this->banks->label($issuerBank),
            'customer_name' => $billerResponse['customerName'] ?? 'N/A',
            'current_balance' => (float) ($additionalInfo->get('Fast Tag Balance') ?? $additionalInfo->get('Wallet Balance') ?? 0),
            'status' => $additionalInfo->get('Tag Status') === 'ACTIVE' ? 'Active' : ($additionalInfo->get('Tag Status') ?? 'Active'),
        ];
    }

    public function createPendingRequest(User $user, string $vehicleNumber, string $issuerBank, float $amount): FastagRequest
    {
        $details = $this->fetchDetails($vehicleNumber, $issuerBank, $user);

        $request = $this->fastagRepository->create([
            'user_id' => $user->id,
            'vehicle_number' => $details['vehicle_number'],
            'issuer_bank' => $details['issuer_bank_label'],
            'customer_name' => $details['customer_name'],
            'current_balance' => $details['current_balance'],
            'amount' => $amount,
            'status' => 'pending',
        ]);

        $this->transactionRepository->create([
            'user_id' => $user->id,
            'service_type' => 'fastag',
            'service_id' => $request->id,
            'reference_number' => $this->referenceGenerator->generate('FTAG'),
            'amount' => $amount,
            'status' => 'pending',
        ]);

        return $request;
    }

    private function primaryInputParamName(string $billerId): string
    {
        $cacheKey = "billavenue:biller-info:{$billerId}";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($billerId) {
            $response = $this->billAvenue->billerInfo([$billerId]);

            $biller = $response['biller'][0] ?? null;
            $paramsList = $biller['billerInputParams'][0]['paramsList'] ?? [];

            return $paramsList[0]['paramName'] ?? 'Vehicle Number';
        });
    }
}
