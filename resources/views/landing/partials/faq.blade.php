@php
$faqs = [
    ['q' => 'Is there a wallet or stored balance?', 'a' => 'No. NovaPay does not maintain a wallet or store your money. Each request is a standalone bill or recharge lookup.'],
    ['q' => 'How do I sign in without a password?', 'a' => 'Enter your registered mobile number and we\'ll send a one-time password (OTP) to verify it\'s you.'],
    ['q' => 'Can I track my past requests?', 'a' => 'Yes — every request gets a unique reference ID visible in your Transactions page, searchable anytime.'],
    ['q' => 'Which electricity providers are supported?', 'a' => 'We support all major providers including MSEDCL, Adani Electricity, Tata Power, Torrent Power, BESCOM and more.'],
    ['q' => 'Is my data safe?', 'a' => 'We only store the minimum information needed to process your request, protected behind authenticated sessions.'],
];
@endphp

<section id="faq" class="bg-surface px-4 py-20 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl">
        <div class="text-center" data-reveal>
            <h2 class="font-display text-3xl text-ink sm:text-4xl">Frequently asked questions</h2>
            <p class="mt-4 text-lg text-ink-muted">Everything you need to know before you get started.</p>
        </div>

        <div class="mt-12 space-y-3">
            @foreach ($faqs as $index => $faq)
                <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }" class="card overflow-hidden" data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex w-full items-center justify-between gap-4 p-5 text-left"
                    >
                        <span class="font-semibold text-ink">{{ $faq['q'] }}</span>
                        <x-icon name="chevron-down" class="h-5 w-5 shrink-0 text-ink-subtle transition-transform duration-200" x-bind:class="open && 'rotate-180'" />
                    </button>
                    <div
                        x-show="open"
                        x-collapse
                        x-cloak
                        class="px-5 pb-5 text-sm leading-relaxed text-ink-muted"
                    >
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
