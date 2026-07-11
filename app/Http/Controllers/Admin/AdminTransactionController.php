<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServiceType;
use App\Http\Controllers\Controller;
use App\Models\ElectricityRequest;
use App\Models\FastagRequest;
use App\Models\RechargeRequest;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminTransactionController extends Controller
{
    public function __construct(private readonly TransactionRepositoryInterface $transactions) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['service_type', 'status', 'from', 'to', 'search']);

        return view('admin.transactions.index', [
            'transactions' => $this->transactions->paginateForAdmin($filters),
            'filters' => $filters,
        ]);
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load('user:id,name,email,mobile');

        return view('admin.transactions.show', [
            'transaction' => $transaction,
            'serviceRequest' => $this->relatedServiceRequest($transaction),
        ]);
    }

    public function approve(Transaction $transaction): RedirectResponse
    {
        $this->updateStatus($transaction, 'success');

        return back()->with('status', 'Transaction marked as successful.');
    }

    public function reject(Transaction $transaction): RedirectResponse
    {
        $this->updateStatus($transaction, 'failed');

        return back()->with('status', 'Transaction marked as failed.');
    }

    private function updateStatus(Transaction $transaction, string $status): void
    {
        $this->transactions->updateStatus($transaction, $status);

        $this->relatedServiceRequest($transaction)?->update(['status' => $status]);
    }

    private function relatedServiceRequest(Transaction $transaction): ElectricityRequest|FastagRequest|RechargeRequest|null
    {
        return match ($transaction->service_type) {
            ServiceType::Electricity => ElectricityRequest::find($transaction->service_id),
            ServiceType::Fastag => FastagRequest::find($transaction->service_id),
            ServiceType::Recharge => RechargeRequest::find($transaction->service_id),
        };
    }
}
