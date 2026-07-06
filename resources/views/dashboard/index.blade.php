@php
$services = [
    ['icon' => 'bolt', 'title' => 'Electricity Bill', 'desc' => 'Look up and pay your electricity bill in a few taps.', 'href' => route('electricity.index'), 'classes' => 'bg-accent-100 text-accent-600 dark:bg-accent-500/15 dark:text-accent-400'],
    ['icon' => 'car', 'title' => 'Fastag Recharge', 'desc' => 'Check balance and top up your Fastag instantly.', 'href' => route('fastag.index'), 'classes' => 'bg-primary-100 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400'],
    ['icon' => 'phone', 'title' => 'Mobile Recharge', 'desc' => 'Browse live plans and recharge any number.', 'href' => route('recharge.index'), 'classes' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400'],
];
@endphp

<x-layouts.app title="Dashboard">
    <div class="mx-auto max-w-6xl space-y-6">
        <!-- Welcome Card -->
        <div class="glass-panel relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-600 to-primary-700 p-6 text-white shadow-glass-lg sm:p-8">
            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
            <p class="text-sm text-primary-100">Welcome back,</p>
            <h1 class="mt-1 font-display text-2xl sm:text-3xl">{{ auth()->user()->name }}</h1>
            <p class="mt-3 max-w-md text-sm text-primary-100">
                Manage your bills, Fastag and recharges — all from one calm, simple dashboard.
            </p>
        </div>

        <!-- Promo Slider -->
        <x-ui.promo-slider />

        <!-- Service Cards -->
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-ink">Services</h2>
                <a href="{{ route('services.index') }}" class="text-sm font-medium text-primary-600 hover:underline">View all</a>
            </div>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-ui.service-card :icon="$service['icon']" :title="$service['title']" :desc="$service['desc']" :href="$service['href']" :classes="$service['classes']" />
                @endforeach
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-ink">Recent Transactions</h2>
                <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-primary-600 hover:underline">View all</a>
            </div>

            @if ($recentTransactions->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-surface-muted text-ink-subtle">
                        <x-icon name="receipt" class="h-7 w-7" />
                    </span>
                    <p class="mt-4 text-sm font-medium text-ink">No transactions yet</p>
                    <p class="mt-1 text-sm text-ink-muted">Your bill payments and recharges will show up here.</p>
                </div>
            @else
                <div class="mt-4 divide-y divide-border">
                    @foreach ($recentTransactions as $transaction)
                        <div class="flex items-center justify-between gap-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-surface-muted text-ink-muted">
                                    <x-icon :name="$transaction->service_type->value === 'electricity' ? 'bolt' : ($transaction->service_type->value === 'fastag' ? 'car' : 'phone')" class="h-5 w-5" />
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-ink">{{ $transaction->service_type->label() }}</p>
                                    <p class="truncate font-mono text-xs text-ink-subtle">{{ $transaction->reference_number }}</p>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-4">
                                <span class="text-sm font-semibold text-ink">&#8377;{{ number_format($transaction->amount, 2) }}</span>
                                <x-ui.status-badge :status="$transaction->status" class="hidden sm:inline-flex" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
