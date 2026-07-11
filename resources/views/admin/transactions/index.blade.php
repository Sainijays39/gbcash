@php
$serviceIcon = fn (string $type) => match ($type) {
    'electricity' => 'bolt',
    'fastag' => 'car',
    'recharge' => 'phone',
    default => 'receipt',
};

$serviceTypes = [
    ['value' => '', 'label' => 'All Services'],
    ['value' => 'electricity', 'label' => 'Electricity Bill'],
    ['value' => 'fastag', 'label' => 'Fastag Recharge'],
    ['value' => 'recharge', 'label' => 'Mobile Recharge'],
];

$statuses = [
    ['value' => '', 'label' => 'All Statuses'],
    ['value' => 'pending', 'label' => 'Pending'],
    ['value' => 'success', 'label' => 'Success'],
    ['value' => 'failed', 'label' => 'Failed'],
];
@endphp

<x-layouts.admin title="Transactions">
    <div class="mx-auto max-w-6xl">
        <div class="mb-6">
            <h1 class="font-display text-2xl text-ink">Transactions</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ number_format($transactions->total()) }} transactions across all services.</p>
        </div>

        <form method="GET" action="{{ route('admin.transactions.index') }}" class="card mb-5 grid grid-cols-1 gap-3 p-4 sm:grid-cols-2 lg:grid-cols-5">
            <select name="service_type" class="input-field" onchange="this.form.submit()">
                @foreach ($serviceTypes as $option)
                    <option value="{{ $option['value'] }}" @selected(($filters['service_type'] ?? '') === $option['value'])>{{ $option['label'] }}</option>
                @endforeach
            </select>

            <select name="status" class="input-field" onchange="this.form.submit()">
                @foreach ($statuses as $option)
                    <option value="{{ $option['value'] }}" @selected(($filters['status'] ?? '') === $option['value'])>{{ $option['label'] }}</option>
                @endforeach
            </select>

            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="input-field">
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="input-field">

            <div class="flex gap-2">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Reference..." class="input-field">
                <button type="submit" class="btn-primary shrink-0 !px-4">
                    <x-icon name="search" class="h-4 w-4" />
                </button>
            </div>
        </form>

        <div class="card overflow-hidden">
            @if ($transactions->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-surface-muted text-ink-subtle">
                        <x-icon name="receipt" class="h-7 w-7" />
                    </span>
                    <p class="mt-4 text-sm font-medium text-ink">No transactions found</p>
                    <p class="mt-1 text-sm text-ink-muted">Try adjusting your filters or search term.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-border bg-surface-muted text-xs uppercase tracking-wide text-ink-subtle">
                            <tr>
                                <th class="px-5 py-3 font-medium">Reference ID</th>
                                <th class="px-5 py-3 font-medium">User</th>
                                <th class="px-5 py-3 font-medium">Service</th>
                                <th class="px-5 py-3 font-medium">Amount</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                                <th class="px-5 py-3 font-medium">Date</th>
                                <th class="px-5 py-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-surface-muted/60">
                                    <td class="px-5 py-4 font-mono text-xs font-semibold text-ink">{{ $transaction->reference_number }}</td>
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-ink">{{ $transaction->user->name }}</p>
                                        <p class="text-xs text-ink-muted">+91 {{ $transaction->user->mobile }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-surface-muted text-ink-muted">
                                                <x-icon :name="$serviceIcon($transaction->service_type->value)" class="h-4 w-4" />
                                            </span>
                                            <span class="font-medium text-ink">{{ $transaction->service_type->label() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-ink">&#8377;{{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-5 py-4"><x-ui.status-badge :status="$transaction->status" /></td>
                                    <td class="px-5 py-4 text-ink-muted">{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium text-ink-muted transition hover:bg-surface-muted hover:text-ink">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-border px-5 py-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
