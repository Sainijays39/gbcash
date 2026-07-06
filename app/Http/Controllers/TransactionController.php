<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionRepositoryInterface $transactions) {}

    public function index(Request $request): View
    {
        $filters = [
            'range' => $request->string('range')->value() ?: null,
            'search' => $request->string('search')->value() ?: null,
        ];

        $transactions = $this->transactions->paginateForUser(Auth::user(), $filters, 10);

        return view('transactions.index', [
            'transactions' => $transactions,
            'filters' => $filters,
        ]);
    }
}
