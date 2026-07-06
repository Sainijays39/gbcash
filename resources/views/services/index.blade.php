@php
$services = [
    ['icon' => 'bolt', 'title' => 'Electricity Bill', 'desc' => 'Look up your bill instantly across every major provider and pay in a few taps.', 'href' => route('electricity.index'), 'classes' => 'bg-accent-100 text-accent-600 dark:bg-accent-500/15 dark:text-accent-400'],
    ['icon' => 'car', 'title' => 'Fastag Recharge', 'desc' => 'Top up any issuer\'s Fastag by vehicle number — check balance before you pay.', 'href' => route('fastag.index'), 'classes' => 'bg-primary-100 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400'],
    ['icon' => 'phone', 'title' => 'Mobile Recharge', 'desc' => 'Browse live plans from Jio, Airtel, Vi and BSNL, and recharge in seconds.', 'href' => route('recharge.index'), 'classes' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400'],
];
@endphp

<x-layouts.app title="Services">
    <div class="mx-auto max-w-4xl">
        <div>
            <h1 class="font-display text-2xl text-ink">Services</h1>
            <p class="mt-1 text-sm text-ink-muted">Everything you can pay for, in one place.</p>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach ($services as $service)
                <x-ui.service-card :icon="$service['icon']" :title="$service['title']" :desc="$service['desc']" :href="$service['href']" :classes="$service['classes']" />
            @endforeach
        </div>
    </div>
</x-layouts.app>
