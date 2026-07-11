@php
$statCards = [
    ['label' => 'Total Users', 'value' => $totalUsers, 'icon' => 'users'],
    ['label' => 'Total Transactions', 'value' => $totalTransactions, 'icon' => 'receipt'],
    ['label' => 'Electricity Requests', 'value' => $electricityCount, 'icon' => 'bolt'],
    ['label' => 'Fastag Requests', 'value' => $fastagCount, 'icon' => 'car'],
    ['label' => 'Recharge Requests', 'value' => $rechargeCount, 'icon' => 'phone'],
];
@endphp

<x-layouts.admin title="Dashboard">
    <div class="mx-auto max-w-6xl">
        <div class="mb-6">
            <h1 class="font-display text-2xl text-ink">Dashboard</h1>
            <p class="mt-1 text-sm text-ink-muted">Overview of users and transaction activity.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($statCards as $card)
                <div class="card p-5">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 text-primary-700">
                        <x-icon :name="$card['icon']" class="h-5 w-5" />
                    </span>
                    <p class="mt-3 text-2xl font-semibold text-ink">{{ number_format($card['value']) }}</p>
                    <p class="text-sm text-ink-muted">{{ $card['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="card p-5">
                <h2 class="mb-4 text-sm font-semibold text-ink">Transactions — Last 14 Days</h2>
                <canvas id="dailyChart" height="220"></canvas>
            </div>
            <div class="card p-5">
                <h2 class="mb-4 text-sm font-semibold text-ink">Transactions — Last 6 Months</h2>
                <canvas id="monthlyChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const daily = @json($dailyCounts);
            const monthly = @json($monthlyCounts);

            new window.Chart(document.getElementById('dailyChart'), {
                type: 'line',
                data: {
                    labels: Object.keys(daily),
                    datasets: [{
                        label: 'Transactions',
                        data: Object.values(daily),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.35,
                        fill: true,
                    }],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                },
            });

            new window.Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(monthly),
                    datasets: [{
                        label: 'Transactions',
                        data: Object.values(monthly),
                        backgroundColor: '#4f46e5',
                        borderRadius: 6,
                    }],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                },
            });
        });
    </script>
</x-layouts.admin>
