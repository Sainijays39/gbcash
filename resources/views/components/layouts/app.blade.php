@props(['title' => null])

@php
$navItems = [
    ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
    ['route' => 'electricity.index', 'icon' => 'bolt', 'label' => 'Electricity Bill'],
    ['route' => 'fastag.index', 'icon' => 'car', 'label' => 'Fastag Recharge'],
    ['route' => 'recharge.index', 'icon' => 'phone', 'label' => 'Mobile Recharge'],
    ['route' => 'transactions.index', 'icon' => 'receipt', 'label' => 'Transactions'],
    ['route' => 'profile.index', 'icon' => 'user', 'label' => 'Profile'],
];

$bottomNavItems = [
    ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Home'],
    ['route' => 'services.index', 'icon' => 'grid', 'label' => 'Services'],
    ['route' => 'transactions.index', 'icon' => 'receipt', 'label' => 'Transactions'],
    ['route' => 'profile.index', 'icon' => 'user', 'label' => 'Profile'],
];
@endphp

<x-layouts.base :title="$title">
    <div class="flex min-h-dvh">
        <!-- Desktop Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-border bg-surface lg:flex">
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 px-6 py-5">
                <span class="relative flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 ease-out group-hover:-rotate-6 group-hover:scale-105">
                    <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent"></span>
                    <x-logo-mark class="relative h-5 w-5" />
                </span>
                <span class="font-display text-xl tracking-tight text-ink">{{ config('app.name') }}</span>
            </a>

            <nav class="flex-1 space-y-1 px-4 py-4">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs($item['route']) || request()->routeIs(str($item['route'])->before('.').'.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'text-ink-muted hover:bg-surface-muted hover:text-ink' }}"
                    >
                        <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0" />
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-border p-4">
                <div class="flex items-center gap-3 rounded-xl bg-surface-muted p-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-500/20 dark:text-primary-300">
                        <x-icon name="user" class="h-4 w-4" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-ink">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-ink-muted">+91 {{ auth()->user()->mobile }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-danger hover:bg-danger/10">
                        <x-icon name="logout" class="h-5 w-5" />
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main column -->
        <div class="flex min-h-dvh flex-1 flex-col lg:pl-64">
            <!-- Top bar -->
            <header class="sticky top-0 z-20 flex items-center justify-between border-b border-border bg-surface/80 px-4 py-4 backdrop-blur-lg sm:px-6">
                <div class="flex items-center gap-2 lg:hidden">
                    <span class="relative flex h-8 w-8 items-center justify-center overflow-hidden rounded-lg bg-gradient-to-br from-primary-600 to-accent-500 text-white">
                        <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent"></span>
                        <x-logo-mark class="relative h-4 w-4" />
                    </span>
                    <span class="font-display text-lg text-ink">{{ config('app.name') }}</span>
                </div>

                <h1 class="hidden text-lg font-semibold text-ink lg:block">{{ $title ?? 'Dashboard' }}</h1>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        x-data
                        @click="
                            document.documentElement.classList.toggle('dark');
                            localStorage.setItem('bharatpayee-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                        "
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-border text-ink-muted transition hover:bg-surface-muted"
                        aria-label="Toggle dark mode"
                    >
                        <x-icon name="moon" class="h-5 w-5 dark:hidden" />
                        <x-icon name="sun" class="hidden h-5 w-5 dark:block" />
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                        @csrf
                        <button type="submit" class="flex h-10 w-10 items-center justify-center rounded-xl border border-border text-danger transition hover:bg-danger/10" aria-label="Logout">
                            <x-icon name="logout" class="h-5 w-5" />
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 pb-24 sm:px-6 lg:pb-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed inset-x-0 bottom-0 z-40 border-t border-border bg-surface/95 backdrop-blur-lg lg:hidden">
        <div class="grid grid-cols-4">
            @foreach ($bottomNavItems as $item)
                @php
                    $active = request()->routeIs($item['route']) || request()->routeIs(str($item['route'])->before('.').'.*');
                @endphp
                <a
                    href="{{ route($item['route']) }}"
                    class="flex flex-col items-center gap-1 py-3 text-xs font-medium {{ $active ? 'text-primary-600' : 'text-ink-subtle' }}"
                >
                    <x-icon :name="$item['icon']" class="h-5 w-5" />
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
        <div class="h-safe-bottom bg-surface"></div>
    </nav>
</x-layouts.base>
