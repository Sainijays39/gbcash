<x-layouts.app title="Electricity Bill">
    <div
        x-data="{
            step: 'form',
            provider: '',
            consumerNumber: '',
            bill: null,
            loading: false,
            paying: false,
            error: '',
            showComingSoon: false,
            paymentReference: null,

            fetchBill() {
                this.error = '';
                if (!this.provider) {
                    this.error = 'Please select your electricity provider.';
                    return;
                }
                if (!this.consumerNumber || this.consumerNumber.length < 4) {
                    this.error = 'Enter a valid consumer number.';
                    return;
                }
                this.loading = true;
                window.apiFetch('{{ route('electricity.fetch-bill') }}', {
                    method: 'POST',
                    body: JSON.stringify({ provider: this.provider, consumer_number: this.consumerNumber }),
                }).then((data) => {
                    this.bill = data.bill;
                    this.step = 'summary';
                }).catch((err) => {
                    this.error = err.data?.message ?? 'Could not fetch bill details. Please try again.';
                }).finally(() => this.loading = false);
            },

            payNow() {
                this.paying = true;
                window.apiFetch('{{ route('electricity.pay') }}', {
                    method: 'POST',
                    body: JSON.stringify({ provider: this.provider, consumer_number: this.consumerNumber }),
                }).then(() => {
                    this.paymentReference = null;
                    this.showComingSoon = true;
                    $store.toast.push('Request saved successfully.');
                }).catch((err) => {
                    $store.toast.push(err.data?.message ?? 'Something went wrong.', 'error');
                }).finally(() => this.paying = false);
            },

            reset() {
                this.step = 'form';
                this.bill = null;
                this.provider = '';
                this.consumerNumber = '';
                this.error = '';
            },
        }"
        class="mx-auto max-w-2xl"
    >
        <div class="mb-6">
            <h1 class="font-display text-2xl text-ink">Electricity Bill</h1>
            <p class="mt-1 text-sm text-ink-muted">Look up and pay your electricity bill in a few steps.</p>
        </div>

        <!-- Step indicator -->
        <div class="mb-6 flex items-center gap-2 text-xs font-medium text-ink-subtle">
            <span :class="step === 'form' ? 'text-primary-600' : 'text-success'" class="flex items-center gap-1">
                <x-icon name="check-circle" class="h-4 w-4" x-show="step !== 'form'" />
                <span x-show="step === 'form'">1.</span>
                Provider &amp; Consumer No.
            </span>
            <x-icon name="chevron-right" class="h-3 w-3" />
            <span :class="step === 'summary' ? 'text-primary-600' : ''">2. Bill Summary</span>
        </div>

        <div class="card p-6 sm:p-8">
            <div x-show="error" x-cloak class="mb-5 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger" x-text="error"></div>

            <!-- Step: Form -->
            <div x-show="step === 'form'" class="space-y-5">
                <x-ui.searchable-select
                    label="Electricity Provider"
                    :required="true"
                    placeholder="Select your provider"
                    :options="$providers"
                    x-on:select-change.window="if ($event.detail.name === 'provider') provider = $event.detail.value"
                />

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Consumer Number <span class="text-danger">*</span></label>
                    <input
                        type="text" x-model="consumerNumber" maxlength="20"
                        class="input-field" placeholder="e.g. CN123456789"
                    >
                </div>

                <button type="button" @click="fetchBill" class="btn-primary w-full" :disabled="loading">
                    <span x-show="!loading">Fetch Bill Details</span>
                    <span x-show="loading" x-cloak>Fetching...</span>
                </button>
            </div>

            <!-- Step: Summary -->
            <div x-show="step === 'summary'" x-cloak>
                <template x-if="bill">
                    <div>
                        <div class="rounded-2xl border border-border bg-surface-muted p-5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-display text-lg text-ink" x-text="bill.customer_name"></p>
                                    <p class="text-xs text-ink-muted" x-text="bill.provider_label"></p>
                                </div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-accent-100 text-accent-600 dark:bg-accent-500/15 dark:text-accent-400">
                                    <x-icon name="bolt" class="h-5 w-5" />
                                </span>
                            </div>

                            <dl class="mt-5 space-y-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <dt class="text-ink-muted">Consumer Number</dt>
                                    <dd class="font-mono font-medium text-ink" x-text="bill.consumer_number"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-ink-muted">Bill Number</dt>
                                    <dd class="font-mono font-medium text-ink" x-text="bill.bill_number"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-ink-muted">Bill Date</dt>
                                    <dd class="font-medium text-ink" x-text="bill.bill_date"></dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-ink-muted">Due Date</dt>
                                    <dd class="font-medium text-danger" x-text="bill.due_date"></dd>
                                </div>
                            </dl>

                            <div class="mt-5 rounded-xl bg-gradient-to-br from-primary-600 to-primary-700 p-4 text-white">
                                <p class="text-xs text-primary-100">Amount Payable</p>
                                <p class="mt-1 font-display text-2xl" x-text="'₹' + Number(bill.bill_amount).toFixed(2)"></p>
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
