@php
$features = [
    ['icon' => 'shield-check', 'title' => 'Secure Sessions', 'desc' => 'OTP-based sign-in with protected sessions — no passwords to leak or forget.'],
    ['icon' => 'clock', 'title' => 'Instant Lookups', 'desc' => 'Bill and plan details fetched in real time, right inside the flow.'],
    ['icon' => 'chart-bar', 'title' => 'Clear History', 'desc' => 'Every request is tracked with a reference ID you can search anytime.'],
    ['icon' => 'sparkles', 'title' => 'Modern Interface', 'desc' => 'A calm, glass-inspired design that works beautifully on any device.'],
];
@endphp

<section id="features" class="px-4 py-20 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
            <div data-reveal>
                <h2 class="font-display text-3xl text-ink sm:text-4xl">Built for clarity, not clutter</h2>
                <p class="mt-4 max-w-lg text-lg text-ink-muted">
                    Every screen is designed around one job — help you finish the payment task at hand,
                    quickly and with confidence.
                </p>

                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    @foreach ($features as $feature)
                        <div class="flex gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-100 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400">
                                <x-icon :name="$feature['icon']" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-semibold text-ink">{{ $feature['title'] }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-ink-muted">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="glass-panel rounded-3xl p-8 shadow-glass-lg" data-reveal style="--reveal-delay:150ms">
                <div class="flex items-center justify-between">
                    <p class="font-display text-lg text-ink">This Month</p>
                    <span class="rounded-full bg-success/10 px-3 py-1 text-xs font-semibold text-success">+18% saved time</span>
                </div>
                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between rounded-xl border border-border bg-surface p-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-accent-100 text-accent-600 dark:bg-accent-500/15 dark:text-accent-400"><x-icon name="bolt" class="h-4 w-4" /></span>
                            <span class="text-sm font-medium text-ink">Electricity Bill</span>
                        </div>
                        <span class="text-sm font-semibold text-ink">&#8377;1,842</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-border bg-surface p-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-100 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400"><x-icon name="car" class="h-4 w-4" /></span>
                            <span class="text-sm font-medium text-ink">Fastag Recharge</span>
                        </div>
                        <span class="text-sm font-semibold text-ink">&#8377;500</span>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-border bg-surface p-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400"><x-icon name="phone" class="h-4 w-4" /></span>
                            <span class="text-sm font-medium text-ink">Mobile Recharge</span>
                        </div>
                        <span class="text-sm font-semibold text-ink">&#8377;299</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
