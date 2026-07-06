<section class="relative overflow-hidden px-4 py-20 sm:px-6 lg:px-8">
    <div class="pointer-events-none absolute left-1/2 top-0 -z-10 h-[30rem] w-[60rem] -translate-x-1/2 rounded-full bg-primary-400/10 blur-3xl"></div>

    <div class="mx-auto max-w-6xl">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <div class="inline-flex items-center gap-2 rounded-full border border-border bg-surface px-4 py-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300">
                <x-icon name="car" class="h-3.5 w-3.5" />
                Fastag Recharge, on the big screen
            </div>
            <h2 class="mt-6 font-display text-3xl text-ink sm:text-4xl">One dashboard, every device</h2>
            <p class="mt-4 text-lg text-ink-muted">
                Look up any vehicle's Fastag balance and top it up in seconds — the same clean flow
                on desktop as it is on mobile.
            </p>
        </div>

        <div class="perspective-container relative mt-16" data-reveal style="--reveal-delay:150ms">
            <div class="pointer-events-none absolute -left-10 top-10 -z-10 h-56 w-56 rounded-full bg-accent-400/20 blur-3xl glow-pulse"></div>
            <div class="pointer-events-none absolute -right-10 bottom-0 -z-10 h-56 w-56 rounded-full bg-primary-400/20 blur-3xl glow-pulse" style="animation-delay:1.2s"></div>

            <!-- Floating badges -->
            <div class="pointer-events-none absolute -left-4 top-8 z-10 hidden float-medium sm:block lg:-left-10" style="animation-delay:.3s">
                <div class="glass-panel flex items-center gap-2 rounded-2xl px-4 py-3 shadow-glass-lg">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-success/10 text-success">
                        <x-icon name="check-circle" class="h-4 w-4" />
                    </span>
                    <span class="text-xs font-semibold text-ink">Instant balance check</span>
                </div>
            </div>
            <div class="pointer-events-none absolute -right-4 bottom-10 z-10 hidden float-slower sm:block lg:-right-10" style="animation-delay:.6s">
                <div class="glass-panel flex items-center gap-2 rounded-2xl px-4 py-3 shadow-glass-lg">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-500/20 dark:text-primary-300">
                        <x-icon name="building-office" class="h-4 w-4" />
                    </span>
                    <span class="text-xs font-semibold text-ink">10+ issuer banks</span>
                </div>
            </div>

            <!-- Desktop / browser mockup -->
            <div
                x-data="tiltCard(5)"
                @mousemove="onMouseMove"
                @mouseleave="onMouseLeave"
                :style="tiltStyle"
                class="mx-auto max-w-4xl transition-transform duration-300 ease-out will-change-transform"
            >
                <div class="overflow-hidden rounded-2xl border border-border bg-surface shadow-glass-lg">
                    <!-- Browser chrome -->
                    <div class="flex items-center gap-2 border-b border-border bg-surface-muted px-4 py-3">
                        <span class="h-3 w-3 rounded-full bg-rose-400"></span>
                        <span class="h-3 w-3 rounded-full bg-accent-400"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                        <div class="ml-3 flex-1 truncate rounded-md bg-surface px-3 py-1 text-xs text-ink-subtle">
                            novapay.app/fastag
                        </div>
                    </div>

                    <!-- Fastag Recharge demo screen -->
                    <div class="grid grid-cols-1 gap-6 p-6 sm:p-10 lg:grid-cols-5">
                        <div class="lg:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-ink-subtle">Step 1 &middot; Vehicle Details</p>
                            <div class="mt-3 space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-ink">Vehicle Number</label>
                                    <div class="rounded-xl border border-primary-300 bg-surface px-4 py-3 font-mono text-sm font-semibold tracking-widest text-ink ring-4 ring-primary-500/10">
                                        MH12&nbsp;AB&nbsp;1234
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-ink">Issuer Bank</label>
                                    <div class="flex items-center justify-between rounded-xl border border-border bg-surface px-4 py-3 text-sm text-ink">
                                        ICICI FASTag
                                        <x-icon name="chevron-down" class="h-4 w-4 text-ink-subtle" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-ink-subtle">Step 2 &middot; Confirm &amp; Pay</p>

                            <div class="mt-3 rounded-2xl border border-border bg-surface-muted p-5">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-display text-lg text-ink">Rohan Mehta</p>
                                        <p class="text-xs text-ink-muted">MH12 AB 1234 &middot; ICICI FASTag</p>
                                    </div>
                                    <span class="rounded-full bg-success/10 px-3 py-1 text-xs font-semibold text-success">Active</span>
                                </div>

                                <div class="mt-4 flex items-center justify-between rounded-xl bg-surface px-4 py-3">
                                    <span class="text-sm text-ink-muted">Current Balance</span>
                                    <span class="font-display text-lg text-ink">&#8377;342.50</span>
                                </div>

                                <div class="mt-4">
                                    <label class="mb-1.5 block text-sm font-medium text-ink">Recharge Amount</label>
                                    <div class="flex items-center justify-between rounded-xl border border-primary-300 bg-surface px-4 py-3 ring-4 ring-primary-500/10">
                                        <span class="font-display text-xl text-ink">&#8377;500</span>
                                        <div class="flex gap-1.5">
                                            <span class="rounded-full bg-primary-100 px-2.5 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-500/15 dark:text-primary-300">300</span>
                                            <span class="rounded-full bg-primary-600 px-2.5 py-1 text-xs font-semibold text-white">500</span>
                                            <span class="rounded-full bg-primary-100 px-2.5 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-500/15 dark:text-primary-300">1000</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-primary mt-5 w-full" tabindex="-1">
                                    Pay Now &middot; &#8377;500
                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
