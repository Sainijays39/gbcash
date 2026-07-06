@props(['text', 'duration' => 0])

<svg
    x-data="{
        hovered: false,
        cx: '50%',
        cy: '50%',
        onMove(event) {
            const rect = $el.getBoundingClientRect();
            this.cx = ((event.clientX - rect.left) / rect.width) * 100 + '%';
            this.cy = ((event.clientY - rect.top) / rect.height) * 100 + '%';
        },
    }"
    @mouseenter="hovered = true"
    @mouseleave="hovered = false"
    @mousemove="onMove"
    viewBox="0 0 300 100"
    xmlns="http://www.w3.org/2000/svg"
    {{ $attributes->merge(['class' => 'select-none uppercase cursor-pointer']) }}
>
    <defs>
        <linearGradient id="textHoverGradient" gradientUnits="userSpaceOnUse" cx="50%" cy="50%" r="25%">
            <stop offset="0%" stop-color="#fbbf24" />
            <stop offset="25%" stop-color="#ef4444" />
            <stop offset="50%" stop-color="#22d3ee" />
            <stop offset="75%" stop-color="#a78bfa" />
            <stop offset="100%" stop-color="#7c3aed" />
        </linearGradient>

        <radialGradient
            id="textHoverRevealMask"
            gradientUnits="userSpaceOnUse"
            r="20%"
            :cx="cx"
            :cy="cy"
            style="transition: cx {{ $duration }}s ease-out, cy {{ $duration }}s ease-out"
        >
            <stop offset="0%" stop-color="white" />
            <stop offset="100%" stop-color="black" />
        </radialGradient>

        <mask id="textHoverMask">
            <rect x="0" y="0" width="100%" height="100%" fill="url(#textHoverRevealMask)" />
        </mask>
    </defs>

    <!-- Ghost outline, visible on hover -->
    <text
        x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" stroke-width="0.3"
        class="fill-transparent stroke-slate-300 font-display text-7xl font-bold dark:stroke-slate-700"
        :style="`opacity: ${hovered ? 0.7 : 0}; transition: opacity 0.4s ease-out`"
    >{{ $text }}</text>

    <!-- One-time hand-drawn reveal on load -->
    <text
        x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" stroke-width="0.3"
        class="text-hover-draw fill-transparent stroke-primary-500 font-display text-7xl font-bold dark:stroke-primary-400"
    >{{ $text }}</text>

    <!-- Cursor-revealed gradient text -->
    <text
        x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" stroke="url(#textHoverGradient)" stroke-width="0.3"
        mask="url(#textHoverMask)"
        class="fill-transparent font-display text-7xl font-bold"
        :style="`opacity: ${hovered ? 1 : 0}; transition: opacity 0.4s ease-out`"
    >{{ $text }}</text>
</svg>
