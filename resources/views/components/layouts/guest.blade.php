@props(['title' => null])

<x-layouts.base :title="$title">
    <div class="relative overflow-hidden">
        <div class="pointer-events-none absolute -top-32 left-1/2 -z-10 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-primary-400/20 blur-3xl dark:bg-primary-500/10"></div>

        <header class="sticky top-0 z-40 border-b border-border/60 bg-surface/80 backdrop-blur-lg">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30">
                        <x-icon name="sparkles" class="h-5 w-5" />
                    </span>
                    <span class="font-display text-xl tracking-tight text-ink">{{ config('app.name') }}</span>
                </a>

                <div class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('landing') }}#services" class="text-sm font-medium text-ink-muted hover:text-ink">Services</a>
                    <a href="{{ route('landing') }}#how-it-works" class="text-sm font-medium text-ink-muted hover:text-ink">How it Works</a>
                    <a href="{{ route('landing') }}#faq" class="text-sm font-medium text-ink-muted hover:text-ink">FAQ</a>
                    <a href="{{ route('landing') }}#contact" class="text-sm font-medium text-ink-muted hover:text-ink">Contact</a>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        x-data
                        @click="
                            document.documentElement.classList.toggle('dark');
                            localStorage.setItem('novapay-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                        "
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-border text-ink-muted transition hover:bg-surface-muted"
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
                </div>
            </nav>
        </header>

        <main>
            {{ $slot }}
        </main>

        @includeWhen(!request()->routeIs('login', 'register'), 'landing.partials.footer')
    </div>
</x-layouts.base>
