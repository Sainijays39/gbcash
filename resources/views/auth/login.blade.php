<x-layouts.guest title="Sign In">
    <div
        x-data="{
            step: 'mobile',
            mobile: @js(session('registered_mobile', old('mobile'))),
            otp: '',
            remember: false,
            loading: false,
            error: '',
            demoOtp: '',
            resendCooldown: 0,
            requestOtp() {
                this.error = '';
                if (!/^[6-9]\d{9}$/.test(this.mobile)) {
                    this.error = 'Enter a valid 10-digit mobile number.';
                    return;
                }
                this.loading = true;
                window.apiFetch('{{ route('login.otp.request') }}', {
                    method: 'POST',
                    body: JSON.stringify({ mobile: this.mobile }),
                }).then((data) => {
                    this.step = 'otp';
                    this.demoOtp = data.demo_otp ?? '';
                    this.startCooldown();
                    $store.toast.push(data.message ?? 'OTP sent successfully.');
                }).catch((err) => {
                    this.error = err.data?.message ?? 'Something went wrong. Please try again.';
                }).finally(() => this.loading = false);
            },
            verifyOtp() {
                this.error = '';
                if (this.otp.length !== 6) {
                    this.error = 'Enter the 6-digit OTP.';
                    return;
                }
                this.loading = true;
                window.apiFetch('{{ route('login.otp.verify') }}', {
                    method: 'POST',
                    body: JSON.stringify({ mobile: this.mobile, otp: this.otp, remember: this.remember }),
                }).then((data) => {
                    window.location.href = data.redirect;
                }).catch((err) => {
                    this.error = err.data?.message ?? 'Invalid OTP. Please try again.';
                }).finally(() => this.loading = false);
            },
            startCooldown() {
                this.resendCooldown = 30;
                const interval = setInterval(() => {
                    this.resendCooldown--;
                    if (this.resendCooldown <= 0) clearInterval(interval);
                }, 1000);
            },
        }"
        class="mx-auto flex min-h-[calc(100dvh-73px)] max-w-md flex-col justify-center px-4 py-12 sm:px-6"
    >
        <div class="mb-8 text-center">
            <h1 class="font-display text-3xl text-ink">Welcome back</h1>
            <p class="mt-2 text-sm text-ink-muted" x-show="step === 'mobile'">Enter your mobile number to receive an OTP.</p>
            <p class="mt-2 text-sm text-ink-muted" x-show="step === 'otp'" x-cloak>
                Enter the 6-digit code sent to <span class="font-semibold text-ink" x-text="'+91 ' + mobile"></span>
            </p>
        </div>

        <div class="card glass-panel p-6 sm:p-8">
            @if (session('status'))
                <div class="mb-5 rounded-xl bg-success/10 px-4 py-3 text-sm font-medium text-success">{{ session('status') }}</div>
            @endif

            <template x-if="demoOtp">
                <div class="mb-5 flex items-center gap-2 rounded-xl border border-dashed border-accent-400 bg-accent-50 px-4 py-3 text-sm font-medium text-accent-700 dark:bg-accent-500/10 dark:text-accent-300">
                    <x-icon name="shield-check" class="h-5 w-5 shrink-0" />
                    <span>Demo mode — use OTP <span class="font-mono font-bold" x-text="demoOtp"></span></span>
                </div>
            </template>

            <div x-show="error" x-cloak class="mb-5 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger" x-text="error"></div>

            <!-- Step 1: Mobile -->
            <form x-show="step === 'mobile'" @submit.prevent="requestOtp" class="space-y-5">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Mobile Number</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-ink-muted">+91</span>
                        <input
                            type="tel" inputmode="numeric" maxlength="10" x-model="mobile" autofocus
                            class="input-field pl-12" placeholder="98765 43210"
                        >
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full" :disabled="loading">
                    <span x-show="!loading">Send OTP</span>
                    <span x-show="loading" x-cloak>Sending...</span>
                </button>
            </form>

            <!-- Step 2: OTP -->
            <form x-show="step === 'otp'" x-cloak @submit.prevent="verifyOtp" class="space-y-5">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">One-Time Password</label>
                    <input
                        type="text" inputmode="numeric" maxlength="6" x-model="otp"
                        class="input-field text-center font-mono text-xl tracking-[0.5em]" placeholder="------"
                    >
                </div>

                <label class="flex items-center gap-2 text-sm text-ink-muted">
                    <input type="checkbox" x-model="remember" class="h-4 w-4 rounded border-border text-primary-600 focus:ring-primary-500">
                    Remember me on this device
                </label>

                <button type="submit" class="btn-primary w-full" :disabled="loading">
                    <span x-show="!loading">Verify & Sign In</span>
                    <span x-show="loading" x-cloak>Verifying...</span>
                </button>

                <div class="flex items-center justify-between text-sm">
                    <button type="button" @click="step = 'mobile'; otp = ''; error = ''" class="font-medium text-ink-muted hover:text-ink">
                        &larr; Change number
                    </button>
                    <button type="button" @click="requestOtp()" :disabled="resendCooldown > 0"
                        class="font-medium text-primary-600 hover:underline disabled:cursor-not-allowed disabled:text-ink-subtle disabled:no-underline">
                        <span x-show="resendCooldown > 0" x-text="'Resend in ' + resendCooldown + 's'"></span>
                        <span x-show="resendCooldown <= 0">Resend OTP</span>
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-ink-muted">
            New to {{ config('app.name') }}?
            <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:underline">Create an account</a>
        </p>
    </div>
</x-layouts.guest>
