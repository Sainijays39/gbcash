<footer id="contact" class="border-t border-border bg-surface">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30">
                        <x-icon name="sparkles" class="h-5 w-5" />
                    </span>
                    <span class="font-display text-xl tracking-tight text-ink">{{ config('app.name') }}</span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-ink-muted">
                    A modern payments portal for everyday bills — electricity, Fastag and mobile recharge, all
                    in one beautifully simple place.
                </p>
                <div class="mt-5 flex items-center gap-2 text-sm text-ink-muted">
                    <x-icon name="shield-check" class="h-4 w-4 text-success" />
                    Secure by design · No wallet, no stored payment data
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-subtle">Services</h3>
                <ul class="mt-4 space-y-3 text-sm text-ink-muted">
                    <li><a href="{{ route('landing') }}#services" class="hover:text-primary-600">Electricity Bill</a></li>
                    <li><a href="{{ route('landing') }}#services" class="hover:text-primary-600">Fastag Recharge</a></li>
                    <li><a href="{{ route('landing') }}#services" class="hover:text-primary-600">Mobile Recharge</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-subtle">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-ink-muted">
                    <li class="flex items-center gap-2"><x-icon name="phone" class="h-4 w-4" /> +91 1800-123-4567</li>
                    <li class="flex items-center gap-2"><x-icon name="receipt" class="h-4 w-4" /> support@novapay.app</li>
                    <li class="flex items-center gap-2"><x-icon name="building-office" class="h-4 w-4" /> Mumbai, India</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-border pt-8 text-sm text-ink-subtle sm:flex-row">
            <p>&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-ink">Privacy Policy</a>
                <a href="#" class="hover:text-ink">Terms of Service</a>
            </div>
        </div>
    </div>

    <!-- Brand wordmark moment -->
    <div class="relative flex h-56 items-center justify-center overflow-hidden bg-slate-950 sm:h-72">
        <div
            class="pointer-events-none absolute inset-0 z-0"
            style="background: radial-gradient(125% 125% at 50% 10%, #0f0f1166 50%, #7c3aed33 100%)"
        ></div>
        <x-ui.text-hover-effect text="NovaPay" :duration="0.15" class="relative z-10 h-full w-full max-w-4xl" />
    </div>
</footer>
