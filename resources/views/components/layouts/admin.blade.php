@props(['title' => null])

@php
$navItems = [
    ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'chart-bar', 'label' => 'Dashboard'],
    ['route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'icon' => 'users', 'label' => 'Users'],
    ['route' => 'admin.transactions.index', 'pattern' => 'admin.transactions.*', 'icon' => 'receipt', 'label' => 'Transactions'],
];
@endphp

<x-layouts.base :title="$title ? $title.' · Admin' : 'Admin'">
    <div class="flex min-h-dvh">
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-border bg-surface lg:flex">
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2 px-6 py-5">
                <span class="relative flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30">
                    <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent"></span>
                    <x-logo-mark class="relative h-5 w-5" />
                </span>
                <span class="font-display text-xl tracking-tight text-ink">{{ config('app.name') }}</span>
            </a>
            <p class="px-6 text-xs font-semibold uppercase tracking-wide text-ink-subtle">Admin Panel</p>

            <nav class="flex-1 space-y-1 px-4 py-4">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs($item['pattern']) ? 'bg-primary-50 text-primary-700' : 'text-ink-muted hover:bg-surface-muted hover:text-ink' }}"
                    >
                        <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0" />
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-border p-4">
                <div class="flex items-center gap-3 rounded-xl bg-surface-muted p-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-700">
                        <x-icon name="shield-check" class="h-4 w-4" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-ink">{{ auth('admin')->user()->name }}</p>
                        <p class="truncate text-xs text-ink-muted">{{ auth('admin')->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-danger hover:bg-danger/10">
                        <x-icon name="logout" class="h-5 w-5" />
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-dvh flex-1 flex-col lg:pl-64">
            <header class="sticky top-0 z-20 flex items-center justify-between border-b border-border bg-surface/80 px-4 py-4 backdrop-blur-lg sm:px-6">
                <div class="flex items-center gap-2 lg:hidden">
                    <span class="relative flex h-8 w-8 items-center justify-center overflow-hidden rounded-lg bg-gradient-to-br from-primary-600 to-accent-500 text-white">
                        <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent"></span>
                        <x-logo-mark class="relative h-4 w-4" />
                    </span>
                    <span class="font-display text-lg text-ink">Admin</span>
                </div>

                <h1 class="hidden text-lg font-semibold text-ink lg:block">{{ $title ?? 'Dashboard' }}</h1>

                <form method="POST" action="{{ route('admin.logout') }}" class="lg:hidden">
                    @csrf
                    <button type="submit" class="flex h-10 w-10 items-center justify-center rounded-xl border border-border text-danger transition hover:bg-danger/10" aria-label="Logout">
                        <x-icon name="logout" class="h-5 w-5" />
                    </button>
                </form>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6">
                @if (session('status'))
                    <div class="mb-5 rounded-xl bg-success/10 px-4 py-3 text-sm font-medium text-success">{{ session('status') }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed inset-x-0 bottom-0 z-40 border-t border-border bg-surface/95 backdrop-blur-lg lg:hidden">
        <div class="grid grid-cols-3">
            @foreach ($navItems as $item)
                @php
                    $active = request()->routeIs($item['pattern']);
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
