<?php

namespace App\Http\Controllers;

use App\Http\Requests\Electricity\FetchBillRequest;
use App\Http\Requests\Electricity\PayBillRequest;
use App\Services\Electricity\ElectricityBillService;
use App\Services\Electricity\ElectricityProviderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ElectricityController extends Controller
{
    public function __construct(
        private readonly ElectricityProviderService $providers,
        private readonly ElectricityBillService $billService,
    ) {}

    public function index(): View
    {
        return view('electricity.index', [
            'providers' => $this->providers->all(),
        ]);
    }

    public function fetchBill(FetchBillRequest $request): JsonResponse
    {
        $bill = $this->billService->fetchMockBill(
            $request->validated('provider'),
            $request->validated('consumer_number'),
        );

        return response()->json(['bill' => $bill]);
    }

    public function pay(PayBillRequest $request): JsonResponse
    {
        $this->billService->createPendingRequest(
            Auth::user(),
            $request->validated('provider'),
            $request->validated('consumer_number'),
        );

        return response()->json([
            'message' => 'This service will start soon.',
        ]);
    }
}
