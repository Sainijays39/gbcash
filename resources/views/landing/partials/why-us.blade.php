@php
$reasons = [
    ['title' => 'No Hidden Fees', 'desc' => 'Transparent pricing on every request — what you see is what you pay.'],
    ['title' => 'Zero Wallet Lock-in', 'desc' => 'We never hold your money. Pay directly, request by request.'],
    ['title' => 'Always-On Support', 'desc' => 'Our team is a message away, day or night.'],
];
@endphp

<section class="bg-gradient-to-br from-primary-700 via-primary-600 to-primary-800 px-4 py-20 text-white sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
            <div data-reveal>
                <h2 class="font-display text-3xl sm:text-4xl">Why choose {{ config('app.name') }}</h2>
                <p class="mt-4 max-w-lg text-lg text-primary-100">
                    We built this for people who just want their bills handled — without the noise
                    of a full banking app.
                </p>
                <a href="{{ route('register') }}" class="btn-primary mt-8 inline-flex !bg-white !text-primary-700 shadow-none hover:!brightness-95">
                    Create Free Account
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @foreach ($reasons as $index => $reason)
                    <div class="flex items-start gap-4 rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur-sm" data-reveal style="--reveal-delay: {{ $index * 120 }}ms">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/15">
                            <x-icon name="check" class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="font-semibold">{{ $reason['title'] }}</h3>
                            <p class="mt-1 text-sm text-primary-100">{{ $reason['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
