<section class="relative overflow-hidden px-4 pb-20 pt-16 sm:px-6 sm:pb-28 sm:pt-24 lg:px-8">
    <div class="pointer-events-none absolute -top-40 left-1/4 -z-10 h-96 w-96 rounded-full bg-primary-400/25 blur-3xl glow-pulse"></div>
    <div class="pointer-events-none absolute -top-20 right-0 -z-10 h-72 w-72 rounded-full bg-accent-400/20 blur-3xl glow-pulse" style="animation-delay:1.5s"></div>

    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
            <div data-reveal>
                <div class="inline-flex items-center gap-2 rounded-full border border-border bg-surface px-4 py-1.5 text-xs font-semibold text-primary-700 dark:text-primary-300">
                    <x-icon name="sparkles" class="h-3.5 w-3.5" />
                    Bills, Fastag &amp; Recharge — unified
                </div>

                <h1 class="mt-6 font-display text-4xl leading-[1.1] text-ink sm:text-5xl lg:text-6xl">
                    Pay your bills with a
                    <span class="bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">calmer</span>
                    kind of fintech.
                </h1>

                <p class="mt-6 max-w-lg text-lg leading-relaxed text-ink-muted">
                    Electricity, Fastag and mobile recharge — one clean dashboard, real-time bill lookups,
                    and a beautifully simple checkout. No clutter, no confusion.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('register') }}" class="btn-primary justify-center">
                        Get Started Free
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('landing') }}#how-it-works" class="btn-secondary justify-center">
                        See How It Works
                    </a>
                </div>

                <div class="mt-10 flex items-center gap-8">
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

            <!-- 3D floating phone mockup -->
            <div class="perspective-container relative" data-reveal style="--reveal-delay:150ms">
                <div class="pointer-events-none absolute -bottom-10 -left-10 -z-10 h-40 w-40 rounded-full bg-accent-400/30 blur-3xl glow-pulse"></div>
                <div class="pointer-events-none absolute -right-6 -top-6 -z-10 h-32 w-32 rounded-full bg-primary-400/30 blur-3xl glow-pulse" style="animation-delay:1s"></div>

                <!-- Floating parallax chips (orbit around the phone) -->
                <div class="pointer-events-none absolute -left-6 top-10 hidden float-slow sm:block" style="animation-delay:.2s">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-border bg-surface shadow-glass-lg">
                        <x-icon name="bolt" class="h-6 w-6 text-accent-500" />
                    </div>
                </div>
                <div class="pointer-events-none absolute -right-4 top-1/3 hidden float-slower sm:block" style="animation-delay:.8s">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-border bg-surface shadow-glass-lg">
                        <x-icon name="car" class="h-5 w-5 text-primary-500" />
                    </div>
                </div>
                <div class="pointer-events-none absolute -left-2 bottom-8 hidden float-medium sm:block" style="animation-delay:.4s">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-border bg-surface shadow-glass-lg">
                        <x-icon name="phone" class="h-5 w-5 text-success" />
                    </div>
                </div>

                <!-- Idle bob wrapper (own transform layer) -->
                <div class="float-slow relative mx-auto max-w-sm">
                    <!-- Ghost screens stacked behind, suggesting a 3D deck of app screens -->
                    <div class="pointer-events-none absolute inset-0 -z-10 origin-bottom rotate-6 scale-[0.92] rounded-[2.5rem] border border-border/50 bg-surface/40 opacity-60 blur-[1px]" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute inset-0 -z-20 origin-bottom -rotate-6 scale-[0.85] rounded-[2.5rem] border border-border/40 bg-surface/30 opacity-40 blur-[2px]" aria-hidden="true"></div>

                    <!-- Mouse-tilt wrapper (own transform layer, composes with the bob above) -->
                    <div
                        x-data="tiltCard(9)"
                        @mousemove="onMouseMove"
                        @mouseleave="onMouseLeave"
                        :style="tiltStyle"
                        class="relative transition-transform duration-300 ease-out will-change-transform"
                    >
                        <!-- Phone bezel -->
                        <div class="glass-panel relative rounded-[2.5rem] p-3 shadow-glass-lg">
                            <div class="rounded-[2rem] border border-border/60 bg-surface p-5">
                                <div class="mx-auto mb-4 h-1.5 w-16 rounded-full bg-border"></div>

                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-ink-muted">Welcome back</p>
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-500/20 dark:text-primary-300">
                                        <x-icon name="user" class="h-4 w-4" />
                                    </span>
                                </div>
                                <p class="mt-1 font-display text-xl text-ink">Aarav Sharma</p>

                                <div class="mt-6 grid grid-cols-3 gap-3">
                                    <div class="rounded-2xl border border-border bg-surface-muted p-4 text-center">
                                        <x-icon name="bolt" class="mx-auto h-6 w-6 text-accent-500" />
                                        <p class="mt-2 text-xs font-medium text-ink-muted">Electricity</p>
                                    </div>
                                    <div class="rounded-2xl border border-border bg-surface-muted p-4 text-center">
                                        <x-icon name="car" class="mx-auto h-6 w-6 text-primary-500" />
                                        <p class="mt-2 text-xs font-medium text-ink-muted">Fastag</p>
                                    </div>
                                    <div class="rounded-2xl border border-border bg-surface-muted p-4 text-center">
                                        <x-icon name="phone" class="mx-auto h-6 w-6 text-success" />
                                        <p class="mt-2 text-xs font-medium text-ink-muted">Recharge</p>
                                    </div>
                                </div>

                                <div class="mt-5 rounded-2xl bg-gradient-to-br from-primary-600 to-primary-700 p-5 text-white shadow-lg">
                                    <div class="flex items-center justify-between text-xs text-primary-100">
                                        <span>Electricity Bill</span>
                                        <span class="rounded-full bg-white/15 px-2 py-0.5">Pending</span>
                                    </div>
                                    <p class="mt-3 font-display text-2xl">&#8377;1,842.00</p>
                                    <p class="mt-1 text-xs text-primary-100">Due 12 Aug &middot; MSEDCL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
