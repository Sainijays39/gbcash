@php
$serviceIcon = match ($transaction->service_type->value) {
    'electricity' => 'bolt',
    'fastag' => 'car',
    'recharge' => 'phone',
    default => 'receipt',
};
@endphp

<x-layouts.admin title="Transaction Detail">
    <div class="mx-auto max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('admin.transactions.index') }}" class="flex h-9 w-9 items-center justify-center rounded-xl border border-border text-ink-muted hover:bg-surface-muted">
                <x-icon name="arrow-right" class="h-4 w-4 rotate-180" />
            </a>
            <div>
                <h1 class="font-display text-2xl text-ink">Transaction Detail</h1>
                <p class="mt-1 font-mono text-sm text-ink-muted">{{ $transaction->reference_number }}</p>
            </div>
        </div>

        <div class="card p-6 sm:p-8">
            <div class="flex items-center justify-between border-b border-border pb-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-surface-muted text-ink-muted">
                        <x-icon :name="$serviceIcon" class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="font-semibold text-ink">{{ $transaction->service_type->label() }}</p>
                        <p class="text-sm text-ink-muted">{{ $transaction->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
                <x-ui.status-badge :status="$transaction->status" />
            </div>

            <dl class="grid grid-cols-1 gap-4 py-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Amount</dt>
                    <dd class="mt-1 text-lg font-semibold text-ink">&#8377;{{ number_format($transaction->amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Reference Number</dt>
                    <dd class="mt-1 font-mono text-sm text-ink">{{ $transaction->reference_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">User</dt>
                    <dd class="mt-1 text-sm font-medium text-ink">{{ $transaction->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Contact</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $transaction->user->email }} &middot; +91 {{ $transaction->user->mobile }}</dd>
                </div>
            </dl>

            @if ($serviceRequest)
                <div class="border-t border-border pt-5">
                    <h2 class="mb-3 text-sm font-semibold text-ink">Service Request Details</h2>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @if ($transaction->service_type->value === 'electricity')
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Provider</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->provider }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Consumer Number</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->consumer_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Customer Name</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->customer_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Bill Number</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->bill_number }}</dd>
                            </div>
                        @elseif ($transaction->service_type->value === 'fastag')
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Vehicle Number</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->vehicle_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Issuer Bank</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->issuer_bank }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Customer Name</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->customer_name }}</dd>
                            </div>
                        @elseif ($transaction->service_type->value === 'recharge')
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Mobile Number</dt>
                                <dd class="mt-1 text-sm text-ink">+91 {{ $serviceRequest->mobile }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Operator</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->operator }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Plan</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->plan_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-ink-subtle">Validity</dt>
                                <dd class="mt-1 text-sm text-ink">{{ $serviceRequest->validity }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

            @if ($transaction->status->value === 'pending')
                <div class="mt-6 flex gap-3 border-t border-border pt-6">
                    <form method="POST" action="{{ route('admin.transactions.approve', $transaction) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-primary w-full !bg-success hover:!bg-success/90">Mark as Success</button>
                    </form>
                    <form method="POST" action="{{ route('admin.transactions.reject', $transaction) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full rounded-xl border border-danger px-4 py-2.5 text-sm font-semibold text-danger transition hover:bg-danger/10">Mark as Failed</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
