<?php

namespace App\Http\Controllers;

use App\Http\Requests\Electricity\FetchBillRequest;
use App\Http\Requests\Electricity\PayBillRequest;
use App\Services\BillAvenue\BillAvenueException;
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
        try {
            $bill = $this->billService->fetchBill(
                $request->validated('provider'),
                $request->validated('consumer_number'),
                Auth::user(),
            );
        } catch (BillAvenueException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['bill' => $bill]);
    }

    public function pay(PayBillRequest $request): JsonResponse
    {
        try {
            $this->billService->createPendingRequest(
                Auth::user(),
                $request->validated('provider'),
                $request->validated('consumer_number'),
            );
        } catch (BillAvenueException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'This service will start soon.',
        ]);
    }
}
