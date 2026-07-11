@props(['class' => 'h-5 w-5'])

{{-- Custom BharatPaye monogram: a "B" letterform with a spark accent --}}
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" {{ $attributes->merge(['class' => $class]) }} aria-hidden="true">
    <path
        d="M6.5 6.5V17.5M6.5 6.5H11C12.5 6.5 13.5 7.5 13.5 9C13.5 10.5 12.5 11.5 11 11.5H6.5M6.5 11.5H12C13.7 11.5 15 12.7 15 14.3C15 16 13.7 17.5 12 17.5H6.5"
        stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"
    />
    <circle cx="18.5" cy="7" r="1.6" fill="currentColor" />
</svg>
