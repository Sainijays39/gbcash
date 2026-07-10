@props(['title' => null])

<x-layouts.base :title="$title">
    <div class="relative overflow-hidden">
        <div class="pointer-events-none absolute -top-32 left-1/2 -z-10 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-primary-400/20 blur-3xl dark:bg-primary-500/10"></div>

        <header
            x-data="navbar()"
            @keydown.escape.window="close()"
            @resize.window="if (window.innerWidth >= 768) close()"
            :class="scrolled ? 'shadow-glass bg-surface/95' : 'bg-surface/80'"
            class="sticky top-0 z-40 border-b border-border/60 backdrop-blur-lg transition-all duration-300"
        >
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 transition-all duration-300 sm:px-6 lg:px-8" :class="scrolled ? 'lg:py-3' : 'lg:py-4'">
                <a href="{{ route('landing') }}" class="group flex items-center gap-2">
                    <span class="relative flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 ease-out group-hover:-rotate-6 group-hover:scale-105">
                        <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent"></span>
                        <x-logo-mark class="relative h-5 w-5" />
                    </span>
                    <span class="font-display text-xl tracking-tight text-ink">{{ config('app.name') }}</span>
                </a>

                <div class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('landing') }}#services" data-nav-link="services" class="nav-link">Services</a>
                    <a href="{{ route('landing') }}#how-it-works" data-nav-link="how-it-works" class="nav-link">How it Works</a>
                    <a href="{{ route('landing') }}#faq" data-nav-link="faq" class="nav-link">FAQ</a>
                    <a href="{{ route('landing') }}#contact" data-nav-link="contact" class="nav-link">Contact</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <button
                        type="button"
                        @click="
                            document.documentElement.classList.toggle('dark');
                            localStorage.setItem('novapay-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                        "
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-border text-ink-muted transition hover:bg-surface-muted"
                        aria-label="Toggle dark mode"
                    >
                        <x-icon name="moon" class="h-5 w-5 dark:hidden" />
                        <x-icon name="sun" class="hidden h-5 w-5 dark:block" />
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary !px-4 !py-2.5">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden text-sm font-semibold text-ink hover:text-primary-600 sm:block">Sign in</a>
                        <a href="{{ route('register') }}" class="btn-primary !px-4 !py-2.5">Get Started</a>
                    @endauth

                    <button
                        type="button"
                        @click="toggle()"
                        :aria-expanded="open.toString()"
                        aria-label="Toggle menu"
                        class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-border text-ink-muted transition hover:bg-surface-muted md:hidden"
                    >
                        <x-icon name="menu" class="h-5 w-5" x-show="!open" />
                        <x-icon name="x" class="h-5 w-5" x-show="open" x-cloak />
                    </button>
                </div>
            </nav>

            <div x-show="open" x-collapse x-cloak class="border-t border-border/60 bg-surface/95 backdrop-blur-lg md:hidden">
                <div class="space-y-1 px-4 py-4 sm:px-6">
                    <a href="{{ route('landing') }}#services" data-nav-link="services" @click="close()" class="mobile-nav-link">
                        <x-icon name="grid" class="h-4 w-4" /> Services
                    </a>
                    <a href="{{ route('landing') }}#how-it-works" data-nav-link="how-it-works" @click="close()" class="mobile-nav-link">
                        <x-icon name="clock" class="h-4 w-4" /> How it Works
                    </a>
                    <a href="{{ route('landing') }}#faq" data-nav-link="faq" @click="close()" class="mobile-nav-link">
                        <x-icon name="question-mark-circle" class="h-4 w-4" /> FAQ
                    </a>
                    <a href="{{ route('landing') }}#contact" data-nav-link="contact" @click="close()" class="mobile-nav-link">
                        <x-icon name="phone" class="h-4 w-4" /> Contact
                    </a>

                    @guest
                        <div class="mt-2 border-t border-border/60 pt-3">
                            <a href="{{ route('login') }}" @click="close()" class="mobile-nav-link">
                                <x-icon name="user" class="h-4 w-4" /> Sign in
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        @includeWhen(!request()->routeIs('login', 'register'), 'landing.partials.footer')
    </div>
</x-layouts.base>
