<section class="relative overflow-hidden px-4 pb-24 pt-16 sm:px-6 sm:pt-24 lg:px-8">
    <div class="pointer-events-none absolute -top-40 left-1/4 -z-10 h-96 w-96 rounded-full bg-primary-400/25 blur-3xl glow-pulse"></div>
    <div class="pointer-events-none absolute -top-20 right-0 -z-10 h-72 w-72 rounded-full bg-accent-400/20 blur-3xl glow-pulse" style="animation-delay:1.5s"></div>

    <!-- Header -->
    <div class="mx-auto max-w-3xl text-center" data-reveal>
        <div class="inline-flex items-center gap-2 rounded-full border border-border bg-surface px-4 py-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300">
            <x-icon name="sparkles" class="h-3.5 w-3.5" />
            Bills, Fastag &amp; Recharge — unified
        </div>

        <h1 class="mt-6 font-display text-4xl leading-[1.1] text-ink sm:text-5xl lg:text-6xl">
            Pay your bills with a
            <span class="bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">calmer</span>
            kind of fintech.
        </h1>

        <p class="mx-auto mt-6 max-w-lg text-lg leading-relaxed text-ink-muted">
            Electricity, Fastag and mobile recharge — one clean dashboard, real-time bill lookups,
            and a beautifully simple checkout. No clutter, no confusion.
        </p>

        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a href="{{ route('register') }}" class="btn-primary justify-center">
                Get Started Free
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
            <a href="{{ route('landing') }}#how-it-works" class="btn-secondary justify-center">
                See How It Works
            </a>
        </div>

        <div class="mt-10 flex items-center justify-center gap-8">
            <div>
                <p class="font-display text-2xl text-ink">50K+</p>
                <p class="text-sm text-ink-muted">Happy users</p>
            </div>
            <div class="h-8 w-px bg-border"></div>
            <div>
                <p class="font-display text-2xl text-ink">3</p>
                <p class="text-sm text-ink-muted">Core services</p>
            </div>
            <div class="h-8 w-px bg-border"></div>
            <div>
                <p class="font-display text-2xl text-ink">24/7</p>
                <p class="text-sm text-ink-muted">Availability</p>
            </div>
        </div>
    </div>

    <!-- Scroll-driven 3D screen -->
    <div class="relative mx-auto mt-16 max-w-5xl sm:mt-20" style="perspective:1200px; --reveal-delay:150ms" x-data="scrollCard()" x-init="init()" data-reveal>
        <div class="pointer-events-none absolute -bottom-10 -left-10 -z-10 h-40 w-40 rounded-full bg-accent-400/30 blur-3xl glow-pulse"></div>
        <div class="pointer-events-none absolute -right-6 -top-6 -z-10 h-32 w-32 rounded-full bg-primary-400/30 blur-3xl glow-pulse" style="animation-delay:1s"></div>

        <!-- Floating parallax chips -->
        <div class="pointer-events-none absolute -left-6 top-6 hidden float-slow lg:block" style="animation-delay:.2s">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-border bg-surface shadow-glass-lg">
                <x-icon name="bolt" class="h-6 w-6 text-accent-500" />
            </div>
        </div>
        <div class="pointer-events-none absolute -right-6 top-1/3 hidden float-slower lg:block" style="animation-delay:.8s">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-border bg-surface shadow-glass-lg">
                <x-icon name="car" class="h-5 w-5 text-primary-500" />
            </div>
        </div>
        <div class="pointer-events-none absolute -left-4 bottom-6 hidden float-medium lg:block" style="animation-delay:.4s">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-border bg-surface shadow-glass-lg">
                <x-icon name="phone" class="h-5 w-5 text-success" />
            </div>
        </div>

        <!-- 3D tilting screen bezel -->
        <div
            :style="cardStyle"
            class="mx-auto w-full rounded-[2rem] border-4 border-slate-700 bg-slate-900 p-2 shadow-2xl will-change-transform sm:rounded-[2.5rem] sm:p-4"
        >
            <div class="h-full w-full overflow-hidden rounded-2xl bg-surface">
                <!-- Browser chrome -->
                <div class="flex items-center gap-2 border-b border-border bg-surface-muted px-4 py-3">
                    <span class="h-3 w-3 rounded-full bg-rose-400"></span>
                    <span class="h-3 w-3 rounded-full bg-accent-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    <div class="ml-3 flex-1 truncate rounded-md bg-surface px-3 py-1 text-xs text-ink-subtle">
                        novapay.app/dashboard
                    </div>
                </div>

                <!-- Dashboard preview -->
                <div class="p-5 sm:p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-ink-muted">Welcome back</p>
                            <p class="mt-0.5 font-display text-xl text-ink sm:text-2xl">Aarav Sharma</p>
                        </div>
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-500/20 dark:text-primary-300">
                            <x-icon name="user" class="h-5 w-5" />
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-3 sm:gap-4">
                        <div class="rounded-2xl border border-border bg-surface-muted p-4 text-center sm:p-5">
                            <x-icon name="bolt" class="mx-auto h-6 w-6 text-accent-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium text-ink-muted sm:text-sm">Electricity</p>
                        </div>
                        <div class="rounded-2xl border border-border bg-surface-muted p-4 text-center sm:p-5">
                            <x-icon name="car" class="mx-auto h-6 w-6 text-primary-500 sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium text-ink-muted sm:text-sm">Fastag</p>
                        </div>
                        <div class="rounded-2xl border border-border bg-surface-muted p-4 text-center sm:p-5">
                            <x-icon name="phone" class="mx-auto h-6 w-6 text-success sm:h-7 sm:w-7" />
                            <p class="mt-2 text-xs font-medium text-ink-muted sm:text-sm">Recharge</p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:mt-6 sm:grid-cols-5">
                        <div class="rounded-2xl bg-gradient-to-br from-primary-600 to-primary-700 p-5 text-white shadow-lg sm:col-span-3">
                            <div class="flex items-center justify-between text-xs text-primary-100">
                                <span>Electricity Bill</span>
                                <span class="rounded-full bg-white/15 px-2 py-0.5">Pending</span>
                            </div>
                            <p class="mt-3 font-display text-2xl sm:text-3xl">&#8377;1,842.00</p>
                            <p class="mt-1 text-xs text-primary-100">Due 12 Aug &middot; MSEDCL</p>
                        </div>
                        <div class="hidden rounded-2xl border border-border bg-surface-muted p-5 sm:col-span-2 sm:block">
                            <p class="text-xs font-medium text-ink-muted">This Month</p>
                            <p class="mt-2 font-display text-2xl text-ink">&#8377;2,641</p>
                            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-success">
                                <x-icon name="check-circle" class="h-3.5 w-3.5" />
                                3 requests saved
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
