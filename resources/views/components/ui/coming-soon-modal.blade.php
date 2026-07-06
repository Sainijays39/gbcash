@props(['show' => 'showComingSoon', 'reference' => 'paymentReference'])

<div
    x-show="{{ $show }}"
    x-cloak
    class="fixed inset-0 z-100 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
>
    <div
        x-show="{{ $show }}"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
        @click="{{ $show }} = false"
    ></div>

    <div
        x-show="{{ $show }}"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="glass-panel relative w-full max-w-sm rounded-2xl p-6 text-center shadow-glass-lg sm:p-8"
    >
        <button
            type="button"
            @click="{{ $show }} = false"
            class="absolute right-4 top-4 text-ink-subtle hover:text-ink"
            aria-label="Close"
        >
            <x-icon name="x" class="h-5 w-5" />
        </button>

        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-accent-100 text-accent-600 dark:bg-accent-500/15 dark:text-accent-400">
            <x-icon name="clock" class="h-8 w-8" />
        </span>

        <h3 class="mt-5 font-display text-xl text-ink">This service will start soon.</h3>
        <p class="mt-2 text-sm leading-relaxed text-ink-muted">
            Your request has been saved and is pending. We'll notify you the moment payments go live.
        </p>

        <template x-if="{{ $reference }}">
            <div class="mt-4 rounded-xl bg-surface-muted px-4 py-3">
                <p class="text-xs text-ink-muted">Reference ID</p>
                <p class="mt-0.5 font-mono text-sm font-semibold text-ink" x-text="{{ $reference }}"></p>
            </div>
        </template>

        <div class="mt-6 flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('transactions.index') }}" class="btn-secondary flex-1 justify-center">
                View Transactions
            </a>
            <button type="button" @click="{{ $show }} = false" class="btn-primary flex-1 justify-center">
                Done
            </button>
        </div>
    </div>
</div>
