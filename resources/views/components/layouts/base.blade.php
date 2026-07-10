@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' · '.config('app.name') : config('app.name') }}</title>

    <script>
        (function () {
            const stored = localStorage.getItem('bharatpayee-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh overflow-x-hidden bg-surface-muted font-sans text-ink">
    {{ $slot }}

    <div
        x-data
        class="pointer-events-none fixed inset-x-0 bottom-4 z-100 flex flex-col items-center gap-2 px-4 sm:bottom-6 sm:items-end sm:px-6"
    >
        <template x-for="toast in $store.toast.items" :key="toast.id">
            <div
                x-show="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4"
                x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="glass-panel pointer-events-auto flex w-full max-w-sm items-center gap-3 rounded-2xl px-4 py-3 shadow-lg sm:w-auto"
            >
                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full"
                    :class="toast.type === 'error' ? 'bg-danger/10 text-danger' : 'bg-success/10 text-success'"
                >
                    <x-icon :name="'check-circle'" class="h-5 w-5" x-show="toast.type !== 'error'" />
                    <x-icon :name="'x-circle'" class="h-5 w-5" x-show="toast.type === 'error'" />
                </span>
                <p class="text-sm font-medium text-ink" x-text="toast.message"></p>
                <button type="button" class="ml-2 text-ink-subtle hover:text-ink" @click="$store.toast.remove(toast.id)">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        </template>
    </div>
</body>
</html>
