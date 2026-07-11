{{--
    Cinematic scroll-jacked hero, ported from a GSAP ScrollTrigger design to plain
    Alpine.js + CSS `position: sticky`. The tall spacer below gives the sticky inner
    section room to "pin" for several viewport-heights while `progress` (0-1, driven by
    scroll position) fans out into every phase: intro type, the card rising up and
    expanding to fullscreen, the phone mockup flying in with live mouse-tilt, the
    progress-ring/counter filling in, badges popping in, then the reverse — card pulling
    back into a framed shape around a closing CTA before sliding off-screen.

    `position: sticky` (not `fixed`) is the right primitive here: it stays pinned to the
    viewport edge for as long as its containing block (this spacer) still has room, then
    releases and scrolls away normally — exactly the "pin, animate, release" behavior we
    want. It requires every ancestor between here and the document's scroll root to have
    `overflow: visible` (a non-obvious CSS requirement — even `overflow-x: hidden` alone
    breaks it, since the spec makes the browser implicitly treat the other axis as
    `auto` once one axis is non-visible). The guest layout's wrapper divs stay
    overflow-free for this reason; horizontal clipping of decorative blur elements is
    instead handled on `<body>`, which is already the actual scrolling root.
--}}
<div
    x-data="cinematicHero(12400)"
    x-init="init()"
    class="relative"
    :style="`height: ${reducedMotion ? '100vh' : '450vh'}`"
>
    <section
        class="sticky top-0 flex h-screen w-screen items-center justify-center overflow-hidden bg-surface font-sans text-ink"
        style="perspective: 1500px"
    >
        <div class="hero-film-grain" aria-hidden="true"></div>
        <div class="hero-bg-grid pointer-events-none absolute inset-0 z-0 opacity-50" aria-hidden="true"></div>

        <!-- BACKGROUND LAYER: Intro taglines -->
        <div :style="heroTextStyle" class="absolute z-10 flex w-screen flex-col items-center justify-center px-4 text-center will-change-transform">
            <h1 class="mb-2 text-5xl font-bold tracking-tight text-ink md:text-7xl lg:text-[6rem]">Pay every bill,</h1>
            <h1 class="hero-text-silver-matte text-5xl font-extrabold tracking-tighter md:text-7xl lg:text-[6rem]">without the wait.</h1>
        </div>

        <!-- BACKGROUND LAYER 2: Closing CTA -->
        <div :style="ctaStyle" class="absolute z-10 flex w-screen flex-col items-center justify-center px-4 text-center will-change-transform">
            <h2 class="hero-text-silver-matte mb-6 text-4xl font-bold tracking-tight md:text-6xl lg:text-7xl">
                Ready to get started?
            </h2>
            <p class="mx-auto mb-12 max-w-xl text-lg font-light leading-relaxed text-ink-muted md:text-xl">
                Join thousands of users managing electricity, Fastag and mobile recharge in one clean,
                modern dashboard.
            </p>
            <div class="flex flex-col gap-6 sm:flex-row">
                <a href="{{ route('register') }}" class="btn-modern-light flex items-center justify-center gap-3 rounded-[1.25rem] px-8 py-4 group">
                    <x-icon name="sparkles" class="h-6 w-6 transition-transform group-hover:scale-105" />
                    <div class="text-left">
                        <div class="mb-[-2px] text-[10px] font-bold uppercase tracking-wider text-neutral-500">Create your account</div>
                        <div class="text-xl font-bold leading-none tracking-tight">Get Started Free</div>
                    </div>
                </a>
                <a href="{{ route('login') }}" class="btn-modern-dark flex items-center justify-center gap-3 rounded-[1.25rem] px-8 py-4 group">
                    <x-icon name="arrow-right" class="h-6 w-6 transition-transform group-hover:scale-105" />
                    <div class="text-left">
                        <div class="mb-[-2px] text-[10px] font-bold uppercase tracking-wider text-neutral-400">Already registered</div>
                        <div class="text-xl font-bold leading-none tracking-tight">Sign In</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- FOREGROUND LAYER: The physical deep-blue card -->
        <div class="pointer-events-none absolute inset-0 z-20 flex items-center justify-center" style="perspective: 1500px">
            <div
                @mousemove="onCardMouseMove"
                :style="cardStyle"
                class="hero-premium-depth-card pointer-events-auto relative flex items-center justify-center overflow-hidden will-change-[width,height,transform]"
            >
                <div class="hero-card-sheen" aria-hidden="true"></div>

                <div class="relative mx-auto flex h-full w-full max-w-7xl flex-col items-center justify-evenly px-4 py-6 lg:grid lg:grid-cols-3 lg:items-center lg:gap-8 lg:px-12 lg:py-0">
                    <!-- Brand name -->
                    <div :style="rightTextStyle" class="z-20 order-1 flex w-full justify-center lg:order-3 lg:justify-end">
                        <h2 class="hero-text-card-silver-matte text-5xl font-black uppercase tracking-tighter md:text-6xl lg:text-7xl">
                            BharatPaye
                        </h2>
                    </div>

                    <!-- iPhone mockup -->
                    <div class="relative z-10 order-2 flex h-[380px] w-full items-center justify-center lg:order-2 lg:h-[600px]" style="perspective: 1000px">
                        <div :style="mockupStyle" class="relative flex h-full w-full scale-[0.65] items-center justify-center will-change-transform md:scale-[0.85] lg:scale-100">
                            <div class="hero-iphone-bezel relative flex h-[580px] w-[280px] flex-col rounded-[3rem]" style="transform-style: preserve-3d">
                                <div class="hero-hardware-btn absolute -left-[3px] top-[120px] z-0 h-[25px] w-[3px] rounded-l-md" aria-hidden="true"></div>
                                <div class="hero-hardware-btn absolute -left-[3px] top-[160px] z-0 h-[45px] w-[3px] rounded-l-md" aria-hidden="true"></div>
                                <div class="hero-hardware-btn absolute -left-[3px] top-[220px] z-0 h-[45px] w-[3px] rounded-l-md" aria-hidden="true"></div>
                                <div class="hero-hardware-btn absolute -right-[3px] top-[170px] z-0 h-[70px] w-[3px] scale-x-[-1] rounded-r-md" aria-hidden="true"></div>

                                <div class="absolute inset-[7px] z-10 overflow-hidden rounded-[2.5rem] bg-[#050914] text-white shadow-[inset_0_0_15px_rgba(0,0,0,1)]">
                                    <div class="hero-screen-glare pointer-events-none absolute inset-0 z-40" aria-hidden="true"></div>

                                    <div class="absolute left-1/2 top-[5px] z-50 flex h-[28px] w-[100px] -translate-x-1/2 items-center justify-end rounded-full bg-black px-3 shadow-[inset_0_-1px_2px_rgba(255,255,255,0.1)]">
                                        <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                                    </div>

                                    <div class="relative flex h-full w-full flex-col px-5 pb-8 pt-12">
                                        <div :style="badgeStyle" class="mb-8 flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span class="mb-1 text-[10px] font-bold uppercase tracking-widest text-neutral-400">Today</span>
                                                <span class="text-xl font-bold tracking-tight text-white drop-shadow-md">Dashboard</span>
                                            </div>
                                            <div class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/5 text-sm font-bold text-neutral-200 shadow-lg shadow-black/50">AS</div>
                                        </div>

                                        <div :style="badgeStyle" class="relative mx-auto mb-8 flex h-44 w-44 items-center justify-center drop-shadow-[0_15px_25px_rgba(0,0,0,0.8)]">
                                            <svg class="absolute inset-0 h-full w-full" aria-hidden="true">
                                                <circle cx="88" cy="88" r="64" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="12" />
                                                <circle class="hero-progress-ring" cx="88" cy="88" r="64" fill="none" stroke="#3B82F6" stroke-width="12" stroke-dasharray="402" :stroke-dashoffset="ringOffset" />
                                            </svg>
                                            <div class="z-10 flex flex-col items-center text-center">
                                                <span class="text-4xl font-extrabold tracking-tighter text-white" x-text="counterValue"></span>
                                                <span class="mt-0.5 text-[8px] font-bold uppercase tracking-[0.1em] text-blue-200/50">Bills Paid</span>
                                            </div>
                                        </div>

                                        <div :style="badgeStyle" class="space-y-3">
                                            <div class="hero-widget-depth flex items-center rounded-2xl p-3">
                                                <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl border border-blue-400/20 bg-gradient-to-br from-blue-500/20 to-blue-600/5 shadow-inner">
                                                    <x-icon name="bolt" class="h-4 w-4 text-blue-400 drop-shadow-md" />
                                                </div>
                                                <div class="flex-1">
                                                    <div class="mb-2 h-2 w-20 rounded-full bg-neutral-300 shadow-inner"></div>
                                                    <div class="h-1.5 w-12 rounded-full bg-neutral-600 shadow-inner"></div>
                                                </div>
                                            </div>
                                            <div class="hero-widget-depth flex items-center rounded-2xl p-3">
                                                <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl border border-emerald-400/20 bg-gradient-to-br from-emerald-500/20 to-emerald-600/5 shadow-inner">
                                                    <x-icon name="check" class="h-4 w-4 text-emerald-400 drop-shadow-md" />
                                                </div>
                                                <div class="flex-1">
                                                    <div class="mb-2 h-2 w-16 rounded-full bg-neutral-300 shadow-inner"></div>
                                                    <div class="h-1.5 w-24 rounded-full bg-neutral-600 shadow-inner"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="absolute bottom-2 left-1/2 h-1 w-[120px] -translate-x-1/2 rounded-full bg-white/20 shadow-[0_1px_2px_rgba(0,0,0,0.5)]"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating badges -->
                            <div :style="badgeStyle" class="hero-floating-badge absolute left-[-15px] top-6 z-30 flex items-center gap-3 rounded-xl p-3 lg:left-[-80px] lg:top-12 lg:gap-4 lg:rounded-2xl lg:p-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full border border-accent-400/30 bg-gradient-to-b from-accent-500/20 to-accent-900/10 shadow-inner lg:h-10 lg:w-10">
                                    <x-icon name="bolt" class="h-4 w-4 text-accent-400 lg:h-5 lg:w-5" />
                                </div>
                                <div>
                                    <p class="text-xs font-bold tracking-tight text-white lg:text-sm">Bill Paid</p>
                                    <p class="text-[10px] font-medium text-blue-200/50 lg:text-xs">Just now</p>
                                </div>
                            </div>

                            <div :style="badgeStyle" class="hero-floating-badge absolute bottom-12 right-[-15px] z-30 flex items-center gap-3 rounded-xl p-3 lg:bottom-20 lg:right-[-80px] lg:gap-4 lg:rounded-2xl lg:p-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full border border-indigo-400/30 bg-gradient-to-b from-indigo-500/20 to-indigo-900/10 shadow-inner lg:h-10 lg:w-10">
                                    <x-icon name="car" class="h-4 w-4 text-indigo-300 lg:h-5 lg:w-5" />
                                </div>
                                <div>
                                    <p class="text-xs font-bold tracking-tight text-white lg:text-sm">Fastag Topped Up</p>
                                    <p class="text-[10px] font-medium text-blue-200/50 lg:text-xs">&#8377;500 added</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descriptive text -->
                    <div :style="leftTextStyle" class="z-20 order-3 flex w-full flex-col justify-center px-4 text-center lg:order-1 lg:px-0 lg:text-left">
                        <h3 class="mb-0 text-2xl font-bold tracking-tight text-white md:text-3xl lg:mb-5 lg:text-4xl">
                            Payments, simplified.
                        </h3>
                        <p class="mx-auto hidden max-w-sm text-sm font-normal leading-relaxed text-blue-100/70 md:block md:text-base lg:mx-0 lg:max-w-none lg:text-lg">
                            <span class="font-semibold text-white">BharatPaye</span> gives you real-time electricity
                            bill lookups, instant Fastag balance checks, and live mobile recharge plans — all from
                            one calm, unified dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
