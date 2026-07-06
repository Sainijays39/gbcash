@props(['status'])

@php
$value = $status instanceof \App\Enums\RequestStatus ? $status->value : (string) $status;

$classes = match ($value) {
    'success' => 'bg-success/10 text-success',
    'failed' => 'bg-danger/10 text-danger',
    default => 'bg-accent-100 text-accent-700 dark:bg-accent-500/15 dark:text-accent-400',
};

$icon = match ($value) {
    'success' => 'check-circle',
    'failed' => 'x-circle',
    default => 'clock',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold capitalize $classes"]) }}>
    <x-icon :name="$icon" class="h-3.5 w-3.5" />
    {{ $value }}
</span>
