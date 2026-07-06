<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly TransactionRepositoryInterface $transactions) {}

    public function __invoke(): View
    {
        $recentTransactions = $this->transactions->recentForUser(Auth::user(), 5);

        return view('dashboard.index', [
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
