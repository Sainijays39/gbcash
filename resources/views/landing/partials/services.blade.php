<section id="services" class="relative overflow-hidden px-4 py-20 sm:px-6 lg:px-8">
    <div class="pointer-events-none absolute left-1/2 top-10 -z-10 h-[26rem] w-[50rem] -translate-x-1/2 rounded-full bg-primary-400/10 blur-3xl"></div>

    <div class="mx-auto max-w-6xl">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <h2 class="font-display text-3xl text-ink sm:text-4xl">Everything you pay for, in one place</h2>
            <p class="mt-4 text-lg text-ink-muted">Three essential services, designed to feel effortless. Try it below — it's the real thing.</p>
        </div>

        <div
            x-data="{
                tab: 'electricity',
                tabs: ['electricity', 'fastag', 'recharge'],
                next() { this.tab = this.tabs[(this.tabs.indexOf(this.tab) + 1) % this.tabs.length]; },
            }"
            x-init="setInterval(() => next(), 5000)"
            class="mt-14"
            data-reveal
            style="--reveal-delay:120ms"
        >
            <!-- Segmented tab control -->
            <div class="mx-auto flex max-w-xl items-center gap-1 rounded-2xl border border-border bg-surface-muted p-1.5 shadow-sm">
                <button
                    type="button"
                    @click="tab = 'electricity'"
                    :class="tab === 'electricity' ? 'bg-surface text-ink shadow-sm' : 'text-ink-muted hover:text-ink'"
                    class="flex flex-1 items-center justify-center gap-1.5 rounded-xl px-2 py-2.5 text-xs font-semibold transition-all duration-200 sm:gap-2 sm:px-4 sm:text-sm"
                >
                    <x-icon name="bolt" class="h-4 w-4 shrink-0" /> <span class="truncate">Electricity</span>
                </button>
                <button
                    type="button"
                    @click="tab = 'fastag'"
                    :class="tab === 'fastag' ? 'bg-surface text-ink shadow-sm' : 'text-ink-muted hover:text-ink'"
                    class="flex flex-1 items-center justify-center gap-1.5 rounded-xl px-2 py-2.5 text-xs font-semibold transition-all duration-200 sm:gap-2 sm:px-4 sm:text-sm"
                >
                    <x-icon name="car" class="h-4 w-4 shrink-0" /> <span class="truncate">Fastag</span>
                </button>
                <button
                    type="button"
                    @click="tab = 'recharge'"
                    :class="tab === 'recharge' ? 'bg-surface text-ink shadow-sm' : 'text-ink-muted hover:text-ink'"
                    class="flex flex-1 items-center justify-center gap-1.5 rounded-xl px-2 py-2.5 text-xs font-semibold transition-all duration-200 sm:gap-2 sm:px-4 sm:text-sm"
                >
                    <x-icon name="phone" class="h-4 w-4 shrink-0" /> <span class="truncate">Recharge</span>
                </button>
            </div>

            <!-- Live demo panel -->
            <div class="relative mt-8 overflow-hidden rounded-3xl border border-border bg-surface shadow-glass-lg">
                <div class="pointer-events-none absolute -top-16 right-0 h-56 w-56 rounded-full bg-accent-400/10 blur-3xl"></div>

                <!-- Electricity -->
                <div
                    x-show="tab === 'electricity'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 gap-8 p-6 sm:p-10 lg:grid-cols-2 lg:items-center"
                >
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-accent-100 px-3 py-1 text-xs font-semibold text-accent-700 dark:bg-accent-500/15 dark:text-accent-400">
                            <x-icon name="bolt" class="h-3.5 w-3.5" /> Electricity Bill
                        </div>
                        <h3 class="mt-4 font-display text-2xl text-ink">Instant bill lookup, every provider</h3>
                        <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                            Look up your bill instantly across every major provider and pay in a few taps —
                            no logging into the discom portal, no remembering due dates.
                        </p>
                        <a href="{{ route('register') }}" class="group mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600">
                            Get started
                            <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" />
                        </a>
                    </div>

                    <div class="rounded-2xl border border-border bg-surface-muted p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-wide text-ink-subtle">MSEDCL &middot; 400821193</p>
                            <span class="flex items-center gap-1.5 rounded-full bg-danger/10 px-2.5 py-1 text-xs font-semibold text-danger">
                                <x-icon name="clock" class="h-3 w-3" /> Due in 3 days
                            </span>
                        </div>
                        <div class="mt-5 flex items-end justify-between">
                            <div>
                                <p class="text-xs text-ink-muted">Amount Due</p>
                                <p class="mt-1 font-display text-3xl text-ink">&#8377;1,842</p>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-medium text-success">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-success opacity-75"></span>
                                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-success"></span>
                                </span>
                                Live rate
                            </div>
                        </div>
                        <button type="button" class="btn-primary mt-6 w-full" tabindex="-1">
                            Pay &#8377;1,842
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <!-- Fastag -->
                <div
                    x-show="tab === 'fastag'"
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 gap-8 p-6 sm:p-10 lg:grid-cols-2 lg:items-center"
                >
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-primary-100 px-3 py-1 text-xs font-semibold text-primary-700 dark:bg-primary-500/15 dark:text-primary-300">
                            <x-icon name="car" class="h-3.5 w-3.5" /> Fastag Recharge
                        </div>
                        <h3 class="mt-4 font-display text-2xl text-ink">Top up by vehicle number</h3>
                        <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                            Top up any issuer's Fastag by vehicle number — check the live balance first,
                            so you never pay more than you need to.
                        </p>
                        <a href="{{ route('register') }}" class="group mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600">
                            Get started
                            <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" />
                        </a>
                    </div>

                    <div class="rounded-2xl border border-border bg-surface-muted p-5">
                        <div class="flex items-center justify-between rounded-xl border border-primary-300 bg-surface px-4 py-3 font-mono text-sm font-semibold tracking-widest text-ink ring-4 ring-primary-500/10">
                            MH12&nbsp;AB&nbsp;1234
                            <x-icon name="search" class="h-4 w-4 text-primary-500" />
                        </div>
                        <div class="mt-4 flex items-center justify-between rounded-xl bg-surface px-4 py-3">
                            <span class="text-sm text-ink-muted">Current Balance</span>
                            <span class="font-display text-lg text-ink">&#8377;342.50</span>
                        </div>
                        <div class="mt-4 flex gap-1.5">
                            <span class="cursor-pointer rounded-full bg-primary-100 px-2.5 py-1 text-xs font-semibold text-primary-700 transition-colors hover:bg-primary-200 dark:bg-primary-500/15 dark:text-primary-300">&#8377;300</span>
                            <span class="scale-105 cursor-pointer rounded-full bg-primary-600 px-2.5 py-1 text-xs font-semibold text-white shadow-sm ring-2 ring-primary-400/40">&#8377;500</span>
                            <span class="cursor-pointer rounded-full bg-primary-100 px-2.5 py-1 text-xs font-semibold text-primary-700 transition-colors hover:bg-primary-200 dark:bg-primary-500/15 dark:text-primary-300">&#8377;1000</span>
                        </div>
                        <button type="button" class="btn-primary mt-5 w-full" tabindex="-1">
                            Pay Now &middot; &#8377;500
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <!-- Mobile Recharge -->
                <div
                    x-show="tab === 'recharge'"
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 gap-8 p-6 sm:p-10 lg:grid-cols-2 lg:items-center"
                >
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                            <x-icon name="phone" class="h-3.5 w-3.5" /> Mobile Recharge
                        </div>
                        <h3 class="mt-4 font-display text-2xl text-ink">Live plans, every operator</h3>
                        <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                            Browse live plans from Jio, Airtel, Vi and BSNL side by side, and recharge in
                            seconds — no more guessing which plan is best.
                        </p>
                        <a href="{{ route('register') }}" class="group mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600">
                            Get started
                            <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" />
                        </a>
                    </div>

                    <div class="rounded-2xl border border-border bg-surface-muted p-5">
                        <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                            <span>+91 98xxx xx210</span>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Jio</span>
                        </div>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center justify-between rounded-xl border-2 border-primary-500 bg-primary-50 px-4 py-3 dark:bg-primary-500/10">
                                <div>
                                    <p class="text-sm font-semibold text-ink">&#8377;239 &middot; 28 days</p>
                                    <p class="text-xs text-ink-muted">2GB/day &middot; Unlimited calls</p>
                                </div>
                                <x-icon name="check-circle" class="h-5 w-5 text-primary-600" />
                            </div>
                            <div class="flex items-center justify-between rounded-xl border border-border px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-ink">&#8377;399 &middot; 56 days</p>
                                    <p class="text-xs text-ink-muted">2.5GB/day &middot; Unlimited calls</p>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-primary mt-5 w-full" tabindex="-1">
                            Recharge &#8377;239
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
