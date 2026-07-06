<x-layouts.guest title="Create Account">
    <div class="mx-auto flex min-h-[calc(100dvh-73px)] max-w-md flex-col justify-center px-4 py-12 sm:px-6">
        <div class="mb-8 text-center">
            <h1 class="font-display text-3xl text-ink">Create your account</h1>
            <p class="mt-2 text-sm text-ink-muted">Sign up in seconds — no passwords, just your mobile number.</p>
        </div>

        <div class="card glass-panel p-6 sm:p-8">
            <form method="POST" action="{{ route('register.store') }}" class="space-y-5" novalidate>
                @csrf

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-ink">Full Name <span class="text-danger">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="input-field" placeholder="Aarav Sharma">
                    @error('name') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mobile" class="mb-1.5 block text-sm font-medium text-ink">Mobile Number <span class="text-danger">*</span></label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-ink-muted">+91</span>
                        <input id="mobile" name="mobile" type="tel" inputmode="numeric" maxlength="10" value="{{ old('mobile') }}" required
                            class="input-field pl-12" placeholder="98765 43210">
                    </div>
                    @error('mobile') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-ink">Email <span class="text-danger">*</span></label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="input-field" placeholder="you@example.com">
                    @error('email') <p class="mt-1.5 text-sm text-danger">{{ $message }}</p> @enderror
                </div>

                <x-ui.searchable-select
                    name="state"
                    label="State"
                    :required="true"
                    placeholder="Select your state"
                    :selected="old('state')"
                    :options="collect(config('states'))->map(fn ($s) => ['value' => $s, 'label' => $s])->values()"
                />
                @error('state') <p class="-mt-3 text-sm text-danger">{{ $message }}</p> @enderror

                <label class="flex items-start gap-3 text-sm text-ink-muted">
                    <input type="checkbox" name="accept_terms" value="1" @checked(old('accept_terms'))
                        class="mt-0.5 h-4 w-4 rounded border-border text-primary-600 focus:ring-primary-500">
                    <span>I agree to the <a href="#" class="font-medium text-primary-600 hover:underline">Terms of Service</a> and <a href="#" class="font-medium text-primary-600 hover:underline">Privacy Policy</a>.</span>
                </label>
                @error('accept_terms') <p class="text-sm text-danger">{{ $message }}</p> @enderror

                <button type="submit" class="btn-primary w-full">
                    Create Account
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-ink-muted">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:underline">Sign in</a>
        </p>
    </div>
</x-layouts.guest>
