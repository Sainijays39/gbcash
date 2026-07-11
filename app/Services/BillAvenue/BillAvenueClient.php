<?php

namespace App\Services\BillAvenue;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Thin HTTP client for the BillAvenue BBPS API (JSON variant).
 *
 * Every call: encrypt the JSON payload, POST it as query-string parameters
 * (matching BillAvenue's documented URL format), decrypt + JSON-decode the
 * response, and normalize failures into exceptions.
 */
class BillAvenueClient
{
    private readonly BillAvenueCrypto $crypto;

    private readonly BillAvenueRequestIdGenerator $requestIds;

    private readonly string $baseUrl;

    public function __construct()
    {
        $this->crypto = new BillAvenueCrypto((string) config('billavenue.working_key'));
        $this->requestIds = new BillAvenueRequestIdGenerator;

        $environment = config('billavenue.environment', 'uat');
        $this->baseUrl = config("billavenue.base_urls.{$environment}");
    }

    public function billerInfo(array $billerIds = []): array
    {
        return $this->call('/extMdmCntrl/mdmRequestNew/json', [
            'billerId' => $billerIds,
        ]);
    }

    public function billFetch(array $payload): array
    {
        return $this->call('/extBillCntrl/billFetchRequest/json', $payload);
    }

    public function rechargePlans(string $billerId, string $circle): array
    {
        return $this->call('/extFetchPlans/fetchPlansRequest/json', [
            'billerId' => $billerId,
            'circle' => $circle,
        ]);
    }

    public function billPay(array $payload): array
    {
        return $this->call('/extBillPayCntrl/billPayRequest/json', $payload);
    }

    public function transactionStatus(string $trackingType, string $trackingValue): array
    {
        return $this->call('/transactionStatus/fetchInfo/json', [
            'trackingType' => $trackingType,
            'trackingValue' => $trackingValue,
        ]);
    }

    /**
     * Standard device/agent info block required on Bill Fetch and Bill Payment requests.
     */
    public function agentDeviceInfo(): array
    {
        return [
            'initChannel' => config('billavenue.device.init_channel'),
            'ip' => config('billavenue.device.ip'),
            'mac' => config('billavenue.device.mac'),
        ];
    }

    public function agentId(): string
    {
        return (string) config('billavenue.agent_id');
    }

    private function call(string $path, array $payload): array
    {
        $requestId = $this->requestIds->generate();
        $encRequest = $this->crypto->encrypt(json_encode($payload, JSON_UNESCAPED_SLASHES));

        $query = [
            'accessCode' => config('billavenue.access_code'),
            'encRequest' => $encRequest,
            'requestId' => $requestId,
            'ver' => config('billavenue.api_version'),
            'instituteId' => config('billavenue.institute_id'),
        ];

        $url = rtrim($this->baseUrl, '/').$path.'?'.http_build_query($query);

        $response = Http::timeout((int) config('billavenue.timeout', 60))->post($url);

        if ($response->failed()) {
            Log::error('BillAvenue HTTP request failed', [
                'path' => $path,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new RuntimeException("BillAvenue request to {$path} failed with HTTP {$response->status()}.");
        }

        $decrypted = $this->crypto->decrypt($response->body());

        $decoded = json_decode($decrypted, true);

        if (! is_array($decoded)) {
            Log::error('BillAvenue response could not be parsed as JSON', [
                'path' => $path,
                'decrypted' => $decrypted,
            ]);

            throw new RuntimeException("BillAvenue response for {$path} could not be parsed.");
        }

        $responseCode = $decoded['responseCode'] ?? null;

        if ($responseCode !== null && $responseCode !== '000') {
            $reason = $decoded['responseReason']
                ?? ($decoded['errorInfo']['error']['errorMessage'] ?? null)
                ?? 'Unknown error';

            Log::warning('BillAvenue returned a non-success response', [
                'path' => $path,
                'responseCode' => $responseCode,
                'reason' => $reason,
            ]);

            throw new BillAvenueException($reason, $responseCode, $decoded);
        }

        return $decoded;
    }
}
