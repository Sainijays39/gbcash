<x-layouts.app title="Fastag Recharge">
    <div
        x-data="{
            step: 'form',
            vehicleNumber: '',
            issuerBank: '',
            amount: '',
            details: null,
            loading: false,
            paying: false,
            error: '',
            showComingSoon: false,

            quickAmounts: [100, 300, 500, 1000],

            fetchDetails() {
                this.error = '';
                if (!/^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,3}[0-9]{1,4}$/.test(this.vehicleNumber.replace(/\s/g, ''))) {
                    this.error = 'Enter a valid vehicle number, e.g. MH12AB1234.';
                    return;
                }
                if (!this.issuerBank) {
                    this.error = 'Please select the Fastag issuer bank.';
                    return;
                }
                this.loading = true;
                window.apiFetch('{{ route('fastag.fetch-details') }}', {
                    method: 'POST',
                    body: JSON.stringify({ vehicle_number: this.vehicleNumber, issuer_bank: this.issuerBank }),
                }).then((data) => {
                    this.details = data.details;
                    this.step = 'summary';
                }).catch((err) => {
                    this.error = err.data?.message ?? 'Could not fetch Fastag details. Please try again.';
                }).finally(() => this.loading = false);
            },

            payNow() {
                this.error = '';
                const value = Number(this.amount);
                if (!value || value < 50) {
                    this.error = 'Enter a recharge amount of at least ₹50.';
                    return;
                }
                this.paying = true;
                window.apiFetch('{{ route('fastag.recharge') }}', {
                    method: 'POST',
                    body: JSON.stringify({ vehicle_number: this.vehicleNumber, issuer_bank: this.issuerBank, amount: value }),
                }).then(() => {
                    this.showComingSoon = true;
                    $store.toast.push('Recharge request saved successfully.');
                }).catch((err) => {
                    $store.toast.push(err.data?.message ?? 'Something went wrong.', 'error');
                }).finally(() => this.paying = false);
            },

            reset() {
                this.step = 'form';
                this.details = null;
                this.vehicleNumber = '';
                this.issuerBank = '';
                this.amount = '';
                this.error = '';
            },
        }"
        class="mx-auto max-w-2xl"
    >
        <div class="mb-6">
            <h1 class="font-display text-2xl text-ink">Fastag Recharge</h1>
            <p class="mt-1 text-sm text-ink-muted">Check your Fastag balance and top up instantly.</p>
        </div>

        <div class="mb-6 flex items-center gap-2 text-xs font-medium text-ink-subtle">
            <span :class="step === 'form' ? 'text-primary-600' : 'text-success'" class="flex items-center gap-1">
                <x-icon name="check-circle" class="h-4 w-4" x-show="step !== 'form'" />
                <span x-show="step === 'form'">1.</span>
                Vehicle &amp; Bank
            </span>
            <x-icon name="chevron-right" class="h-3 w-3" />
            <span :class="step === 'summary' ? 'text-primary-600' : ''">2. Recharge</span>
        </div>

        <div class="card p-6 sm:p-8">
            <div x-show="error" x-cloak class="mb-5 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger" x-text="error"></div>

            <!-- Step: Form -->
            <div x-show="step === 'form'" class="space-y-5">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Vehicle Number <span class="text-danger">*</span></label>
                    <input
                        type="text" x-model="vehicleNumber" maxlength="13"
                        @input="vehicleNumber = vehicleNumber.toUpperCase()"
                        class="input-field font-mono tracking-widest" placeholder="MH12AB1234"
                    >
                </div>

                <x-ui.searchable-select
                    label="Issuer Bank"
                    :required="true"
                    placeholder="Select Fastag issuer bank"
                    :options="$banks"
                    x-on:select-change.window="if ($event.detail.name === 'issuer_bank') issuerBank = $event.detail.value"
                />

                <button type="button" @click="fetchDetails" class="btn-primary w-full" :disabled="loading">
                    <span x-show="!loading">Check Fastag Details</span>
                    <span x-show="loading" x-cloak>Checking...</span>
                </button>
            </div>

            <!-- Step: Summary + Recharge -->
            <div x-show="step === 'summary'" x-cloak>
                <template x-if="details">
                    <div>
                        <div class="rounded-2xl border border-border bg-surface-muted p-5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-display text-lg text-ink" x-text="details.customer_name"></p>
                                    <p class="font-mono text-xs text-ink-muted" x-text="details.vehicle_number + ' · ' + details.issuer_bank_label"></p>
                                </div>
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold"
                                    :class="details.status === 'Active' ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger'"
                                    x-text="details.status"
                                ></span>
                            </div>

                            <div class="mt-4 flex items-center justify-between rounded-xl bg-surface px-4 py-3">
                                <span class="text-sm text-ink-muted">Current Balance</span>
                                <span class="font-display text-lg text-ink" x-text="'₹' + Number(details.current_balance).toFixed(2)"></span>
                            </div>

                            <div class="mt-4">
                                <label class="mb-1.5 block text-sm font-medium text-ink">Recharge Amount <span class="text-danger">*</span></label>
                                <input
                                    type="number" x-model="amount" min="50" max="50000"
                                    class="input-field" placeholder="Enter amount"
                                >
                                <div class="mt-2 flex gap-2">
                                    <template x-for="value in quickAmounts" :key="value">
                                        <button
                                            type="button"
                                            @click="amount = value"
                                            class="rounded-full px-3 py-1 text-xs font-semibold transition-colors"
                                            :class="Number(amount) === value ? 'bg-primary-600 text-white' : 'bg-primary-100 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300'"
                                            x-text="'₹' + value"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-col gap-2 sm:flex-row">
                            <button type="button" @click="reset()" class="btn-secondary flex-1 justify-center">
                                <x-icon name="chevron-down" class="h-4 w-4 rotate-90" />
                                Change Details
                            </button>
                            <button type="button" @click="payNow()" class="btn-primary flex-1 justify-center" :disabled="paying">
                                <span x-show="!paying">Pay Now</span>
                                <span x-show="paying" x-cloak>Processing...</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <x-ui.coming-soon-modal />
    </div>
</x-layouts.app>
