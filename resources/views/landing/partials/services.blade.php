@php
$services = [
    ['icon' => 'bolt', 'title' => 'Electricity Bill', 'desc' => 'Look up your bill instantly across every major provider and pay in a few taps.', 'classes' => 'bg-accent-100 text-accent-600 dark:bg-accent-500/15 dark:text-accent-400'],
    ['icon' => 'car', 'title' => 'Fastag Recharge', 'desc' => 'Top up any issuer\'s Fastag by vehicle number — check balance before you pay.', 'classes' => 'bg-primary-100 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400'],
    ['icon' => 'phone', 'title' => 'Mobile Recharge', 'desc' => 'Browse live plans from Jio, Airtel, Vi and BSNL, and recharge in seconds.', 'classes' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400'],
];
@endphp

<section id="services" class="px-4 py-20 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <h2 class="font-display text-3xl text-ink sm:text-4xl">Everything you pay for, in one place</h2>
            <p class="mt-4 text-lg text-ink-muted">Three essential services, designed to feel effortless.</p>
        </div>

        <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $index => $service)
                <div class="card group relative overflow-hidden p-8 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" data-reveal style="--reveal-delay: {{ $index * 120 }}ms">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $service['classes'] }}">
                        <x-icon :name="$service['icon']" class="h-7 w-7" />
                    </div>
                    <h3 class="mt-6 font-display text-xl text-ink">{{ $service['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-muted">{{ $service['desc'] }}</p>
                    <a href="{{ route('register') }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-primary-600 group-hover:gap-2 transition-all">
                        Get started <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
