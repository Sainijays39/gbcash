@props(['class' => 'h-5 w-5'])

{{-- Custom NovaPay monogram: an "N" letterform with a spark accent nodding to "Nova" --}}
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" {{ $attributes->merge(['class' => $class]) }} aria-hidden="true">
    <path d="M6.25 17.5V6.5L14.5 17.5V6.5" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
    <circle cx="18" cy="7" r="1.6" fill="currentColor" />
</svg>
