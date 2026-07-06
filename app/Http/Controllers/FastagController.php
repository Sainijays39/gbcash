<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fastag\FetchFastagRequest;
use App\Http\Requests\Fastag\RechargeFastagRequest;
use App\Services\Fastag\FastagBankService;
use App\Services\Fastag\FastagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FastagController extends Controller
{
    public function __construct(
        private readonly FastagBankService $banks,
        private readonly FastagService $fastagService,
    ) {}

    public function index(): View
    {
        return view('fastag.index', [
            'banks' => $this->banks->all(),
        ]);
    }

    public function fetchDetails(FetchFastagRequest $request): JsonResponse
    {
        $details = $this->fastagService->fetchMockDetails(
            $request->validated('vehicle_number'),
            $request->validated('issuer_bank'),
        );

        return response()->json(['details' => $details]);
    }

    public function recharge(RechargeFastagRequest $request): JsonResponse
    {
        $this->fastagService->createPendingRequest(
            Auth::user(),
            $request->validated('vehicle_number'),
            $request->validated('issuer_bank'),
            (float) $request->validated('amount'),
        );

        return response()->json([
            'message' => 'This service will start soon.',
        ]);
    }
}
