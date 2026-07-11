<?php

namespace App\Services\Electricity;

use App\Models\ElectricityRequest;
use App\Models\User;
use App\Repositories\Contracts\ElectricityRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\BillAvenue\BillAvenueClient;
use App\Services\TransactionReferenceGenerator;
use Illuminate\Support\Facades\Cache;

class ElectricityBillService
{
    public function __construct(
        private readonly ElectricityProviderService $providers,
        private readonly ElectricityRepositoryInterface $electricityRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly TransactionReferenceGenerator $referenceGenerator,
        private readonly BillAvenueClient $billAvenue,
    ) {}

    /**
     * Fetch a real bill from BillAvenue's Bill Fetch API for the given provider
     * (billerId) + consumer number.
     */
    public function fetchBill(string $provider, string $consumerNumber, User $user): array
    {
        $inputParamName = $this->primaryInputParamName($provider);

        $response = $this->billAvenue->billFetch([
            'agentId' => $this->billAvenue->agentId(),
            'agentDeviceInfo' => $this->billAvenue->agentDeviceInfo(),
            'customerInfo' => [
                'customerMobile' => $user->mobile,
            ],
            'billerId' => $provider,
            'inputParams' => [
                'input' => [
                    ['paramName' => $inputParamName, 'paramValue' => $consumerNumber],
                ],
            ],
        ]);

        $billerResponse = $response['billerResponse'] ?? [];

        return [
            'provider' => $provider,
            'provider_label' => $this->providers->label($provider),
            'consumer_number' => $consumerNumber,
            'customer_name' => $billerResponse['customerName'] ?? 'N/A',
            'bill_number' => $billerResponse['billNumber'] ?? 'N/A',
            'bill_date' => $billerResponse['billDate'] ?? now()->toDateString(),
            'due_date' => $billerResponse['dueDate'] ?? now()->toDateString(),
            // BillAvenue amounts are in paise.
            'bill_amount' => round((float) ($billerResponse['billAmount'] ?? 0) / 100, 2),
        ];
    }

    public function createPendingRequest(User $user, string $provider, string $consumerNumber): ElectricityRequest
    {
        $bill = $this->fetchBill($provider, $consumerNumber, $user);

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

    /**
     * BillAvenue recommends caching Biller Info (it changes at most daily) rather
     * than calling it before every single Bill Fetch.
     */
    private function primaryInputParamName(string $billerId): string
    {
        $cacheKey = "billavenue:biller-info:{$billerId}";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($billerId) {
            $response = $this->billAvenue->billerInfo([$billerId]);

            $biller = $response['biller'][0] ?? null;
            $paramsList = $biller['billerInputParams'][0]['paramsList'] ?? [];

            return $paramsList[0]['paramName'] ?? 'Consumer Number';
        });
    }
}
