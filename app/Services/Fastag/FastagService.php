<?php

namespace App\Services\Fastag;

use App\Models\FastagRequest;
use App\Models\User;
use App\Repositories\Contracts\FastagRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\TransactionReferenceGenerator;

class FastagService
{
    private const NAME_POOL = [
        'Rohan Mehta', 'Aarav Sharma', 'Priya Nair', 'Sanjay Gupta', 'Ananya Iyer',
        'Vikram Rao', 'Neha Kapoor', 'Arjun Reddy', 'Kavya Menon', 'Rajesh Kumar',
    ];

    public function __construct(
        private readonly FastagBankService $banks,
        private readonly FastagRepositoryInterface $fastagRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly TransactionReferenceGenerator $referenceGenerator,
    ) {}

    public function fetchMockDetails(string $vehicleNumber, string $issuerBank): array
    {
        $normalized = strtoupper(str_replace(' ', '', $vehicleNumber));
        $seed = crc32($normalized.'|'.$issuerBank);

        return [
            'vehicle_number' => $normalized,
            'issuer_bank' => $issuerBank,
            'issuer_bank_label' => $this->banks->label($issuerBank),
            'customer_name' => self::NAME_POOL[$seed % count(self::NAME_POOL)],
            'current_balance' => round(50 + ($seed % 950), 2),
            'status' => $seed % 10 === 0 ? 'Inactive' : 'Active',
        ];
    }

    public function createPendingRequest(User $user, string $vehicleNumber, string $issuerBank, float $amount): FastagRequest
    {
        $details = $this->fetchMockDetails($vehicleNumber, $issuerBank);

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
}
