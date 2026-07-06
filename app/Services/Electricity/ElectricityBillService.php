<?php

namespace App\Services\Electricity;

use App\Models\ElectricityRequest;
use App\Models\User;
use App\Repositories\Contracts\ElectricityRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\TransactionReferenceGenerator;
use Illuminate\Support\Carbon;

class ElectricityBillService
{
    private const NAME_POOL = [
        'Rohan Mehta', 'Aarav Sharma', 'Priya Nair', 'Sanjay Gupta', 'Ananya Iyer',
        'Vikram Rao', 'Neha Kapoor', 'Arjun Reddy', 'Kavya Menon', 'Rajesh Kumar',
    ];

    public function __construct(
        private readonly ElectricityProviderService $providers,
        private readonly ElectricityRepositoryInterface $electricityRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly TransactionReferenceGenerator $referenceGenerator,
    ) {}

    /**
     * Deterministically generate a mock bill for the given provider + consumer number,
     * so repeated lookups return the same result.
     */
    public function fetchMockBill(string $provider, string $consumerNumber): array
    {
        $seed = crc32($provider.'|'.$consumerNumber);

        $customerName = self::NAME_POOL[$seed % count(self::NAME_POOL)];
        $billAmount = 350 + ($seed % 4500) + (($seed % 100) / 100);
        $billNumber = 'BILL'.str_pad((string) ($seed % 900000 + 100000), 6, '0', STR_PAD_LEFT);
        $billDate = Carbon::now()->subDays(($seed % 20) + 5);
        $dueDate = Carbon::now()->addDays(($seed % 15) + 3);

        return [
            'provider' => $provider,
            'provider_label' => $this->providers->label($provider),
            'consumer_number' => $consumerNumber,
            'customer_name' => $customerName,
            'bill_number' => $billNumber,
            'bill_date' => $billDate->toDateString(),
            'due_date' => $dueDate->toDateString(),
            'bill_amount' => round($billAmount, 2),
        ];
    }

    public function createPendingRequest(User $user, string $provider, string $consumerNumber): ElectricityRequest
    {
        $bill = $this->fetchMockBill($provider, $consumerNumber);

        $request = $this->electricityRepository->create([
            'user_id' => $user->id,
            'provider' => $bill['provider_label'],
            'consumer_number' => $bill['consumer_number'],
            'customer_name' => $bill['customer_name'],
            'bill_number' => $bill['bill_number'],
            'bill_date' => $bill['bill_date'],
            'due_date' => $bill['due_date'],
            'bill_amount' => $bill['bill_amount'],
            'status' => 'pending',
        ]);

        $this->transactionRepository->create([
            'user_id' => $user->id,
            'service_type' => 'electricity',
            'service_id' => $request->id,
            'reference_number' => $this->referenceGenerator->generate('ELEC'),
            'amount' => $bill['bill_amount'],
            'status' => 'pending',
        ]);

        return $request;
    }
}
