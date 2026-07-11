<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly TransactionRepositoryInterface $transactions,
    ) {}

    public function __invoke(): View
    {
        $countsByService = $this->transactions->countsByServiceType();

        return view('admin.dashboard', [
            'totalUsers' => $this->users->count(),
            'totalTransactions' => array_sum($countsByService),
            'electricityCount' => $countsByService['electricity'] ?? 0,
            'fastagCount' => $countsByService['fastag'] ?? 0,
            'rechargeCount' => $countsByService['recharge'] ?? 0,
            'dailyCounts' => $this->transactions->dailyCounts(14),
            'monthlyCounts' => $this->transactions->monthlyCounts(6),
        ]);
    }
}
