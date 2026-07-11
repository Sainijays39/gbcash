<x-layouts.app title="Profile">
    <div class="mx-auto max-w-2xl space-y-6">
        <div>
            <h1 class="font-display text-2xl text-ink">Profile</h1>
            <p class="mt-1 text-sm text-ink-muted">Manage your personal details and account security.</p>
        </div>

        @if (session('status'))
            <div class="rounded-xl bg-success/10 px-4 py-3 text-sm font-medium text-success">{{ session('status') }}</div>
        @endif

        <!-- Personal Details -->
        <div class="card p-6 sm:p-8">
            <div class="flex items-center gap-4">
                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-500/20 dark:text-primary-300">
                    <x-icon name="user" class="h-7 w-7" />
                </span>
                <div>
                    <p class="font-display text-lg text-ink">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-ink-muted">+91 {{ auth()->user()->mobile }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="input-field">
                    @error('name') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                </div>

                <x-ui.searchable-select
                    name="state"
                    label="State"
                    :required="true"
                    placeholder="Select your state"
                    :selected="old('state', auth()->user()->state)"
                    :options="collect($states)->map(fn ($s) => ['value' => $s, 'label' => $s])->values()"
                />
                @error('state') <p class="-mt-3 text-sm text-danger">{{ $message }}</p> @enderror

                <button type="submit" class="btn-primary">Save Changes</button>
            </form>
        </div>

        <!-- Change Email -->
        <div class="card p-6 sm:p-8">
            <h2 class="text-lg font-semibold text-ink">Change Email</h2>
            <p class="mt-1 text-sm text-ink-muted">Current: {{ auth()->user()->email }}</p>

            <form method="POST" action="{{ route('profile.update-email') }}" class="mt-5 flex flex-col gap-3 sm:flex-row">
                @csrf
                @method('PATCH')

                <input type="email" name="email" placeholder="new@email.com" required class="input-field flex-1">
                <button type="submit" class="btn-secondary shrink-0">Update Email</button>
            </form>
            @error('email') <p class="mt-2 text-sm text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Change Mobile (OTP-verified) -->
        <div
            x-data="{
                step: 'form',
                mobile: '',
                otp: '',
                loading: false,
                error: '',
                demoOtp: '',

                requestOtp() {
                    this.error = '';
                    if (!/^[6-9]\d{9}$/.test(this.mobile)) {
                        this.error = 'Enter a valid 10-digit mobile number.';
                        return;
                    }
                    this.loading = true;
                    window.apiFetch('{{ route('profile.mobile.request-otp') }}', {
                        method: 'POST',
                        body: JSON.stringify({ mobile: this.mobile }),
                    }).then((data) => {
                        this.demoOtp = data.demo_otp ?? '';
                        this.step = 'otp';
                        $store.toast.push(data.message ?? 'OTP sent.');
                    }).catch((err) => {
                        this.error = err.data?.message ?? 'Could not send OTP. Please try again.';
                    }).finally(() => this.loading = false);
                },

                confirmMobile() {
                    this.error = '';
                    if (this.otp.length !== 6) {
                        this.error = 'Enter the 6-digit OTP.';
                        return;
                    }
                    this.loading = true;
                    window.apiFetch('{{ route('profile.update-mobile') }}', {
                        method: 'PATCH',
                        body: JSON.stringify({ mobile: this.mobile, otp: this.otp }),
                    }).then((data) => {
                        $store.toast.push(data.message ?? 'Mobile number updated.');
                        setTimeout(() => window.location.reload(), 1000);
                    }).catch((err) => {
                        this.error = err.data?.message ?? 'Something went wrong.';
                    }).finally(() => this.loading = false);
                },
            }"
            class="card p-6 sm:p-8"
        >
            <h2 class="text-lg font-semibold text-ink">Change Mobile Number</h2>
            <p class="mt-1 text-sm text-ink-muted">Current: +91 {{ auth()->user()->mobile }}</p>

            <div x-show="error" x-cloak class="mt-4 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger" x-text="error"></div>

            <template x-if="demoOtp && step === 'otp'">
                <div class="mt-4 flex items-center gap-2 rounded-xl border border-dashed border-accent-400 bg-accent-50 px-4 py-3 text-sm font-medium text-accent-700 dark:bg-accent-500/10 dark:text-accent-300">
                    <x-icon name="shield-check" class="h-5 w-5 shrink-0" />
                    <span>Demo mode — use OTP <span class="font-mono font-bold" x-text="demoOtp"></span></span>
                </div>
            </template>

            <div x-show="step === 'form'" class="mt-5 flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-ink-muted">+91</span>
                    <input type="tel" inputmode="numeric" maxlength="10" x-model="mobile" placeholder="New mobile number" class="input-field pl-12">
                </div>
                <button type="button" @click="requestOtp" class="btn-secondary shrink-0" :disabled="loading">
                    <span x-show="!loading">Send OTP</span>
                    <span x-show="loading" x-cloak>Sending...</span>
                </button>
            </div>

            <div x-show="step === 'otp'" x-cloak class="mt-5 flex flex-col gap-3 sm:flex-row">
                <input type="text" inputmode="numeric" maxlength="6" x-model="otp" placeholder="Enter OTP" class="input-field font-mono tracking-widest sm:max-w-[160px]">
                <button type="button" @click="confirmMobile" class="btn-primary shrink-0" :disabled="loading">
                    <span x-show="!loading">Confirm</span>
                    <span x-show="loading" x-cloak>Verifying...</span>
                </button>
                <button type="button" @click="step = 'form'; otp = ''" class="text-sm font-medium text-ink-muted hover:text-ink">
                    Change number
                </button>
            </div>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-secondary w-full justify-center !text-danger">
                <x-icon name="logout" class="h-4 w-4" />
                Logout
            </button>
        </form>
    </div>
</x-layouts.app>
