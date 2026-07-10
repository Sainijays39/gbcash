<footer id="contact" class="relative overflow-hidden border-t border-border bg-surface">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-primary-500/60 to-transparent"></div>
    <div class="pointer-events-none absolute -top-24 left-0 -z-10 h-72 w-72 rounded-full bg-primary-400/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -top-10 right-0 -z-10 h-64 w-64 rounded-full bg-accent-400/10 blur-3xl"></div>

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-reveal>
        <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <a href="{{ route('landing') }}" class="group flex items-center gap-2">
                    <span class="relative flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30 transition-transform duration-300 ease-out group-hover:-rotate-6 group-hover:scale-105">
                        <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent"></span>
                        <x-logo-mark class="relative h-5 w-5" />
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

                <div class="mt-6 flex items-center gap-3">
                    <a href="#" aria-label="Twitter / X" class="group flex h-9 w-9 items-center justify-center rounded-full border border-border bg-surface text-ink-muted transition-all duration-200 hover:-translate-y-0.5 hover:border-primary-500/40 hover:text-primary-600 hover:shadow-glass">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Facebook" class="group flex h-9 w-9 items-center justify-center rounded-full border border-border bg-surface text-ink-muted transition-all duration-200 hover:-translate-y-0.5 hover:border-primary-500/40 hover:text-primary-600 hover:shadow-glass">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M13.5 21.75v-8.1h2.72l.41-3.15h-3.13V8.49c0-.91.25-1.53 1.56-1.53h1.67V4.14c-.29-.04-1.28-.12-2.43-.12-2.4 0-4.05 1.47-4.05 4.16v2.32H7.5v3.15h2.79v8.1z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="group flex h-9 w-9 items-center justify-center rounded-full border border-border bg-surface text-ink-muted transition-all duration-200 hover:-translate-y-0.5 hover:border-primary-500/40 hover:text-primary-600 hover:shadow-glass">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 2.25c-2.7 0-3.04.01-4.1.06-1.06.05-1.79.22-2.42.47-.66.26-1.22.6-1.77 1.16-.56.55-.9 1.11-1.16 1.77-.25.63-.42 1.36-.47 2.42-.05 1.06-.06 1.4-.06 4.1s.01 3.04.06 4.1c.05 1.06.22 1.79.47 2.42.26.66.6 1.22 1.16 1.77.55.56 1.11.9 1.77 1.16.63.25 1.36.42 2.42.47 1.06.05 1.4.06 4.1.06s3.04-.01 4.1-.06c1.06-.05 1.79-.22 2.42-.47a4.78 4.78 0 001.77-1.16c.56-.55.9-1.11 1.16-1.77.25-.63.42-1.36.47-2.42.05-1.06.06-1.4.06-4.1s-.01-3.04-.06-4.1c-.05-1.06-.22-1.79-.47-2.42a4.78 4.78 0 00-1.16-1.77 4.78 4.78 0 00-1.77-1.16c-.63-.25-1.36-.42-2.42-.47-1.06-.05-1.4-.06-4.1-.06zm0 2.16c2.65 0 2.97.01 4.01.06.97.04 1.5.2 1.85.34.46.18.79.4 1.14.75.35.35.57.68.75 1.14.14.36.3.88.34 1.85.05 1.04.06 1.36.06 4.01s-.01 2.97-.06 4.01c-.04.97-.2 1.5-.34 1.85-.18.46-.4.79-.75 1.14-.35.35-.68.57-1.14.75-.36.14-.88.3-1.85.34-1.04.05-1.36.06-4.01.06s-2.97-.01-4.01-.06c-.97-.04-1.5-.2-1.85-.34a3.06 3.06 0 01-1.14-.75 3.06 3.06 0 01-.75-1.14c-.14-.36-.3-.88-.34-1.85-.05-1.04-.06-1.36-.06-4.01s.01-2.97.06-4.01c.04-.97.2-1.5.34-1.85.18-.46.4-.79.75-1.14.35-.35.68-.57 1.14-.75.36-.14.88-.3 1.85-.34 1.04-.05 1.36-.06 4.01-.06zm0 3.68a3.91 3.91 0 100 7.82 3.91 3.91 0 000-7.82zm0 6.45a2.54 2.54 0 110-5.08 2.54 2.54 0 010 5.08zm4.98-6.6a.91.91 0 11-1.83 0 .91.91 0 011.83 0z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="group flex h-9 w-9 items-center justify-center rounded-full border border-border bg-surface text-ink-muted transition-all duration-200 hover:-translate-y-0.5 hover:border-primary-500/40 hover:text-primary-600 hover:shadow-glass">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M6.94 8.25H3.56v12h3.38zm.24-3.9a1.96 1.96 0 10-3.92 0 1.96 1.96 0 003.92 0zM20.44 20.25h.01v-6.4c0-3.14-.68-5.55-4.34-5.55-1.76 0-2.94 1-3.43 1.94h-.05V8.25H9.4c.05 1 0 12 0 12h3.38v-6.7c0-.35.03-.71.13-.97.29-.71.94-1.45 2.05-1.45 1.44 0 2.02 1.1 2.02 2.71v6.41z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-subtle">Services</h3>
                <ul class="mt-4 space-y-3 text-sm text-ink-muted">
                    <li>
                        <a href="{{ route('landing') }}#services" class="group inline-flex items-center gap-1.5 transition-colors hover:text-primary-600">
                            <x-icon name="bolt" class="h-3.5 w-3.5 text-ink-subtle transition-colors group-hover:text-accent-500" />
                            Electricity Bill
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing') }}#services" class="group inline-flex items-center gap-1.5 transition-colors hover:text-primary-600">
                            <x-icon name="car" class="h-3.5 w-3.5 text-ink-subtle transition-colors group-hover:text-primary-500" />
                            Fastag Recharge
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing') }}#services" class="group inline-flex items-center gap-1.5 transition-colors hover:text-primary-600">
                            <x-icon name="phone" class="h-3.5 w-3.5 text-ink-subtle transition-colors group-hover:text-success" />
                            Mobile Recharge
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-subtle">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-ink-muted">
                    <li>
                        <a href="tel:+911800123456" class="flex items-center gap-2 transition-colors hover:text-primary-600">
                            <x-icon name="phone" class="h-4 w-4" /> +91 1800-123-4567
                        </a>
                    </li>
                    <li>
                        <a href="mailto:support@novapay.app" class="flex items-center gap-2 transition-colors hover:text-primary-600">
                            <x-icon name="receipt" class="h-4 w-4" /> support@novapay.app
                        </a>
                    </li>
                    <li class="flex items-center gap-2"><x-icon name="building-office" class="h-4 w-4" /> Mumbai, India</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-border pt-8 text-sm text-ink-subtle sm:flex-row">
            <p>&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="transition-colors hover:text-ink">Privacy Policy</a>
                <a href="#" class="transition-colors hover:text-ink">Terms of Service</a>
            </div>
            <button
                type="button"
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                aria-label="Back to top"
                class="flex h-9 w-9 items-center justify-center rounded-full border border-border bg-surface text-ink-muted transition-all duration-200 hover:-translate-y-0.5 hover:border-primary-500/40 hover:text-primary-600 hover:shadow-glass"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>
            </button>
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
