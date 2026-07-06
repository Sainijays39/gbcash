<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recharge\ConfirmRechargeRequest;
use App\Http\Requests\Recharge\FetchPlansRequest;
use App\Services\Recharge\RechargeOperatorService;
use App\Services\Recharge\RechargeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        return response()->json(['plans' => $this->rechargeService->plans()]);
    }

    public function pay(ConfirmRechargeRequest $request): JsonResponse
    {
        $this->rechargeService->createPendingRequest(
            Auth::user(),
            $request->validated('mobile'),
            $request->validated('operator'),
            $request->validated('plan_id'),
        );

        return response()->json([
            'message' => 'This service will start soon.',
        ]);
    }
}
