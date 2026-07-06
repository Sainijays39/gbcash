@props(['icon', 'title', 'desc', 'href', 'classes'])

<a href="{{ $href }}" class="card group flex flex-col p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
    <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $classes }}">
        <x-icon :name="$icon" class="h-6 w-6" />
    </div>
    <h3 class="mt-5 font-display text-lg text-ink">{{ $title }}</h3>
    <p class="mt-1.5 flex-1 text-sm leading-relaxed text-ink-muted">{{ $desc }}</p>
    <span class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-primary-600 group-hover:gap-2 transition-all">
        Continue <x-icon name="arrow-right" class="h-4 w-4" />
    </span>
</a>
