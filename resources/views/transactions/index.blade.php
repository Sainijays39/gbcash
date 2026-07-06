@php
$serviceIcon = fn (string $type) => match ($type) {
    'electricity' => 'bolt',
    'fastag' => 'car',
    'recharge' => 'phone',
    default => 'receipt',
};

$ranges = [
    ['value' => null, 'label' => 'All'],
    ['value' => 'today', 'label' => 'Today'],
    ['value' => 'this_week', 'label' => 'This Week'],
    ['value' => 'this_month', 'label' => 'This Month'],
];
@endphp

<x-layouts.app title="Transactions">
    <div class="mx-auto max-w-5xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-2xl text-ink">Transactions</h1>
                <p class="mt-1 text-sm text-ink-muted">All your electricity, Fastag and recharge requests.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('transactions.index') }}" class="card mb-5 flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-2">
                @foreach ($ranges as $range)
                    <button
                        type="submit" name="range" value="{{ $range['value'] }}"
                        class="rounded-full px-4 py-2 text-sm font-medium transition-colors {{ $filters['range'] === $range['value'] ? 'bg-primary-600 text-white' : 'bg-surface-muted text-ink-muted hover:bg-border' }}"
                    >
                        {{ $range['label'] }}
                    </button>
                @endforeach
            </div>

            <div class="relative sm:w-64">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-subtle" />
                <input
                    type="text" name="search" value="{{ $filters['search'] }}"
                    placeholder="Search reference..."
                    class="w-full rounded-lg border border-border bg-surface py-2 pl-9 pr-3 text-sm text-ink focus:border-primary-500 focus:outline-none"
                >
                @if ($filters['range'])
                    <input type="hidden" name="range" value="{{ $filters['range'] }}">
                @endif
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
                                <th class="px-5 py-3 font-medium">Service</th>
                                <th class="px-5 py-3 font-medium">Amount</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                                <th class="px-5 py-3 font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-surface-muted/60">
                                    <td class="px-5 py-4 font-mono text-xs font-semibold text-ink">{{ $transaction->reference_number }}</td>
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
</x-layouts.app>
