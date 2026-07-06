@php
$banners = [
    [
        'title' => 'Refer & Earn Rewards',
        'desc' => 'Invite friends to NovaPay and unlock exclusive perks together.',
        'icon' => 'sparkles',
        'classes' => 'from-primary-600 to-primary-700',
    ],
    [
        'title' => 'Now Supporting More Providers',
        'desc' => 'BESCOM, Torrent Power and 5 more electricity boards just added.',
        'icon' => 'bolt',
        'classes' => 'from-accent-500 to-accent-600',
    ],
    [
        'title' => '10+ Fastag Issuer Banks',
        'desc' => 'Check balance and recharge Fastag from any major bank, instantly.',
        'icon' => 'car',
        'classes' => 'from-emerald-500 to-emerald-600',
    ],
];
@endphp

<div
    x-data="{
        active: 0,
        total: {{ count($banners) }},
        timer: null,
        start() {
            this.timer = setInterval(() => this.next(), 5000);
        },
        next() {
            this.active = (this.active + 1) % this.total;
        },
        goTo(index) {
            this.active = index;
            clearInterval(this.timer);
            this.start();
        },
    }"
    x-init="start()"
    class="relative overflow-hidden rounded-2xl shadow-lg"
>
    @foreach ($banners as $index => $banner)
        <div
            x-show="active === {{ $index }}"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-300 absolute inset-0"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="bg-gradient-to-br {{ $banner['classes'] }} flex items-center gap-4 p-6 text-white sm:p-8"
        >
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15">
                <x-icon :name="$banner['icon']" class="h-6 w-6" />
            </span>
            <div>
                <h3 class="font-display text-lg">{{ $banner['title'] }}</h3>
                <p class="mt-1 text-sm text-white/85">{{ $banner['desc'] }}</p>
            </div>
        </div>
    @endforeach

    <div class="absolute bottom-3 right-4 flex gap-1.5">
        @foreach ($banners as $index => $banner)
            <button
                type="button"
                @click="goTo({{ $index }})"
                class="h-1.5 rounded-full bg-white/50 transition-all"
                :class="active === {{ $index }} ? 'w-6 bg-white' : 'w-1.5'"
                aria-label="Go to slide {{ $index + 1 }}"
            ></button>
        @endforeach
    </div>
</div>
