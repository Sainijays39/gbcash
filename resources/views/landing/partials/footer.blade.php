@php
$marqueeItems = ['Electricity Bills', 'Fastag Recharge', 'Mobile Recharge', 'OTP-Only Login', 'No Wallet, No Lock-in', 'Instant Bill Lookup'];
@endphp

{{--
    "Curtain reveal" footer: `position: sticky` (not `fixed`) is what makes it dock at
    the bottom of the viewport as it scrolls into view — see the hero partial for the
    full explanation of why `sticky` is correct here and `fixed` (even inside a
    transformed ancestor) is not.

    The wrapper's height must equal the footer's own height (h-screen) exactly. Any
    taller and the extra wrapper space has no content in it — since the footer is
    shorter than the wrapper, it leaves a blank gap of the wrapper's own (transparent)
    background visible once you've scrolled past it, at the very end of the page.
--}}
<div
    x-data="cinematicFooterReveal()"
    x-init="init()"
    class="relative h-screen w-full"
>
    <footer id="contact" class="cinematic-footer sticky bottom-0 flex h-screen w-full flex-col justify-between overflow-hidden bg-slate-950 text-white">
        <!-- Ambient aurora + grid -->
        <div class="footer-aurora footer-breathe pointer-events-none absolute left-1/2 top-1/2 z-0 h-[60vh] w-[80vw] -translate-x-1/2 -translate-y-1/2 rounded-[50%] blur-[80px]"></div>
        <div class="footer-bg-grid pointer-events-none absolute inset-0 z-0"></div>

        <!-- Giant background wordmark -->
        <div :style="giantTextStyle" class="pointer-events-none absolute inset-x-0 bottom-[-4vh] z-0 flex justify-center will-change-transform">
            <x-ui.text-hover-effect text="BharatPaye" :duration="0.15" class="pointer-events-auto h-[26vh] w-full max-w-6xl opacity-90 sm:h-[32vh]" />
        </div>

        <!-- Diagonal marquee -->
        <div class="absolute left-0 top-12 z-10 w-full -rotate-2 scale-110 overflow-hidden border-y border-white/10 bg-slate-950/60 py-4 shadow-2xl backdrop-blur-md">
            <div class="footer-marquee-track flex w-max text-xs font-bold uppercase tracking-[0.3em] text-white/60 md:text-sm">
                @for ($i = 0; $i < 2; $i++)
                    <div class="flex items-center space-x-12 px-6">
                        @foreach ($marqueeItems as $item)
                            <span>{{ $item }}</span>
                            <span class="text-primary-400/60">&#10022;</span>
                        @endforeach
                    </div>
                @endfor
            </div>
        </div>

        <!-- Main center content -->
        <div :style="contentStyle" class="relative z-10 mx-auto mt-20 flex w-full max-w-5xl flex-1 flex-col items-center justify-center px-6 will-change-transform">
            <h2 class="footer-text-glow mb-12 text-center text-5xl font-black tracking-tighter md:text-8xl">
                Ready to simplify<br class="hidden sm:block"> your bills?
            </h2>

            <div class="flex w-full flex-col items-center gap-6">
                <div class="flex w-full flex-wrap justify-center gap-4">
                    <a
                        href="{{ route('register') }}"
                        x-data="magneticButton(0.3)"
                        @mousemove="onMouseMove"
                        @mouseleave="onMouseLeave"
                        :style="magneticStyle"
                        class="footer-glass-pill group flex items-center gap-3 rounded-full px-10 py-5 text-sm font-bold text-white transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] md:text-base"
                    >
                        <x-icon name="sparkles" class="h-5 w-5 text-white/60 transition-colors group-hover:text-white" />
                        Get Started Free
                    </a>

                    <a
                        href="{{ route('login') }}"
                        x-data="magneticButton(0.3)"
                        @mousemove="onMouseMove"
                        @mouseleave="onMouseLeave"
                        :style="magneticStyle"
                        class="footer-glass-pill group flex items-center gap-3 rounded-full px-10 py-5 text-sm font-bold text-white transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] md:text-base"
                    >
                        <x-icon name="arrow-right" class="h-5 w-5 text-white/60 transition-colors group-hover:text-white" />
                        Sign In
                    </a>
                </div>

                <div class="mt-2 flex w-full flex-wrap justify-center gap-3 md:gap-6">
                    @foreach ([
                        ['label' => 'Services', 'href' => route('landing').'#services'],
                        ['label' => 'Support', 'href' => 'mailto:support@bharatpaye.in'],
                        ['label' => 'Privacy Policy', 'href' => '#'],
                        ['label' => 'Terms of Service', 'href' => '#'],
                    ] as $link)
                        <a
                            href="{{ $link['href'] }}"
                            x-data="magneticButton(0.25)"
                            @mousemove="onMouseMove"
                            @mouseleave="onMouseLeave"
                            :style="magneticStyle"
                            class="footer-glass-pill rounded-full px-6 py-3 text-xs font-medium text-white/60 transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:text-white md:text-sm"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="relative z-20 flex w-full flex-col items-center justify-between gap-6 px-6 pb-8 md:flex-row md:px-12">
            <div class="order-2 text-[10px] font-semibold uppercase tracking-widest text-white/50 md:order-1 md:text-xs">
                &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
            </div>

            

            <button
                type="button"
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                x-data="magneticButton(0.3)"
                @mousemove="onMouseMove"
                @mouseleave="onMouseLeave"
                :style="magneticStyle"
                class="footer-glass-pill group order-3 flex h-12 w-12 items-center justify-center rounded-full text-white/60 transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:text-white"
                aria-label="Back to top"
            >
                <x-icon name="chevron-down" class="h-5 w-5 rotate-180 transition-transform duration-300 group-hover:-translate-y-1.5" />
            </button>
        </div>
    </footer>
</div>
