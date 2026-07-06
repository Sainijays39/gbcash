@php
$steps = [
    ['title' => 'Sign Up', 'desc' => 'Create an account with your mobile number — no password to remember.', 'icon' => 'user'],
    ['title' => 'Pick a Service', 'desc' => 'Choose Electricity, Fastag or Mobile Recharge from your dashboard.', 'icon' => 'grid'],
    ['title' => 'Verify Details', 'desc' => 'We fetch your bill or plan details instantly for you to review.', 'icon' => 'search'],
    ['title' => 'Confirm & Done', 'desc' => 'Confirm the request — your reference is saved and tracked automatically.', 'icon' => 'check-circle'],
];
@endphp

<section id="how-it-works" class="bg-surface px-4 py-20 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <h2 class="font-display text-3xl text-ink sm:text-4xl">How it works</h2>
            <p class="mt-4 text-lg text-ink-muted">Four simple steps from sign up to a saved request.</p>
        </div>

        <div class="relative mt-16 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <div class="pointer-events-none absolute inset-x-0 top-8 hidden h-px bg-border lg:block"></div>

            @foreach ($steps as $index => $step)
                <div class="relative text-center" data-reveal style="--reveal-delay: {{ $index * 120 }}ms">
                    <div class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/25">
                        <x-icon :name="$step['icon']" class="h-7 w-7" />
                        <span class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-accent-500 text-xs font-bold text-white">{{ $index + 1 }}</span>
                    </div>
                    <h3 class="mt-5 font-display text-lg text-ink">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-ink-muted">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
