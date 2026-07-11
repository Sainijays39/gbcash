<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recharge\ConfirmRechargeRequest;
use App\Http\Requests\Recharge\FetchPlansRequest;
use App\Services\BillAvenue\BillAvenueException;
use App\Services\Recharge\RechargeOperatorService;
use App\Services\Recharge\RechargeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

class RechargeController extends Controller
{
    public function __construct(
        private readonly RechargeOperatorService $operators,
        private readonly RechargeService $rechargeService,
    ) {}

    public function index(): View
    {
        return view('recharge.index', [
            'operators' => $this->operators->all(),
        ]);
    }

    public function plans(FetchPlansRequest $request): JsonResponse
    {
        try {
            $plans = $this->rechargeService->plans(
                $request->validated('operator'),
                'All',
                Auth::user(),
            );
        } catch (BillAvenueException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['plans' => $plans]);
    }

    public function pay(ConfirmRechargeRequest $request): JsonResponse
    {
        try {
            $this->rechargeService->createPendingRequest(
                Auth::user(),
                $request->validated('mobile'),
                $request->validated('operator'),
                $request->validated('plan_id'),
            );
        } catch (BillAvenueException|RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'This service will start soon.',
        ]);
    }
}
