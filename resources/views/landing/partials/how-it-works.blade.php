@php
$steps = [
    ['title' => 'Sign Up', 'desc' => 'Create an account with your mobile number — no password to remember.', 'icon' => 'phone'],
    ['title' => 'Pick a Service', 'desc' => 'Choose Electricity, Fastag or Mobile Recharge from your dashboard.', 'icons' => ['bolt', 'car', 'phone']],
    ['title' => 'Verify Details', 'desc' => 'We fetch your bill or plan details instantly for you to review.', 'icon' => 'receipt'],
    ['title' => 'Confirm & Done', 'desc' => 'Confirm the request — your reference is saved and tracked automatically.', 'icon' => 'check-circle'],
];
@endphp

<section id="how-it-works" class="bg-surface px-4 py-20 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <h2 class="font-display text-3xl text-ink sm:text-4xl">How it works</h2>
            <p class="mt-4 text-lg text-ink-muted">Four simple steps from sign up to a saved request.</p>
        </div>

        <div class="relative mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($steps as $index => $step)
                <div class="relative">
                    <div
                        class="card group relative flex h-full flex-col items-center overflow-hidden p-8 text-center transition-all duration-300 hover:-translate-y-1 hover:border-primary-200 hover:shadow-xl"
                        data-reveal
                        style="--reveal-delay: {{ $index * 120 }}ms"
                    >
                        <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-primary-400/0 blur-2xl transition-colors duration-500 group-hover:bg-primary-400/10"></div>

                        <div class="relative flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/25 transition-transform duration-300 ease-out group-hover:-rotate-3 group-hover:scale-110">
                            @if (isset($step['icons']))
                                <div class="flex flex-col items-center gap-1">
                                    <x-icon :name="$step['icons'][0]" class="h-3.5 w-3.5" />
                                    <div class="flex gap-1.5">
                                        <x-icon :name="$step['icons'][1]" class="h-3.5 w-3.5" />
                                        <x-icon :name="$step['icons'][2]" class="h-3.5 w-3.5" />
                                    </div>
                                </div>
                            @else
                                <x-icon :name="$step['icon']" class="h-7 w-7" />
                            @endif
                            <span class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-accent-500 text-xs font-bold text-white ring-4 ring-surface">{{ $index + 1 }}</span>
                        </div>
                        <h3 class="relative mt-5 font-display text-lg text-ink">{{ $step['title'] }}</h3>
                        <p class="relative mt-2 text-sm leading-relaxed text-ink-muted">{{ $step['desc'] }}</p>
                    </div>

                    @unless ($loop->last)
                        <div class="pointer-events-none absolute -right-3 top-16 z-10 hidden -translate-y-1/2 lg:flex">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full border border-border bg-surface text-ink-subtle shadow-sm">
                                <x-icon name="chevron-right" class="h-4 w-4" />
                            </span>
                        </div>
                    @endunless
                </div>
            @endforeach
        </div>
    </div>
</section>
