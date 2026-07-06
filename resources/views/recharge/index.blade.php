@php
$operatorClasses = [
    'jio' => 'border-primary-500 bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300',
    'airtel' => 'border-danger bg-danger/10 text-danger',
    'vi' => 'border-accent-500 bg-accent-50 text-accent-700 dark:bg-accent-500/15 dark:text-accent-300',
    'bsnl' => 'border-success bg-success/10 text-success',
];
@endphp

<x-layouts.app title="Mobile Recharge">
    <div
        x-data="{
            step: 'form',
            mobile: '',
            operator: '',
            plans: [],
            selectedPlan: null,
            loading: false,
            paying: false,
            error: '',
            showComingSoon: false,

            fetchPlans() {
                this.error = '';
                if (!/^[6-9]\d{9}$/.test(this.mobile)) {
                    this.error = 'Enter a valid 10-digit mobile number.';
                    return;
                }
                if (!this.operator) {
                    this.error = 'Please select an operator.';
                    return;
                }
                this.loading = true;
                window.apiFetch('{{ route('recharge.plans') }}', {
                    method: 'POST',
                    body: JSON.stringify({ mobile: this.mobile, operator: this.operator }),
                }).then((data) => {
                    this.plans = data.plans;
                    this.step = 'plans';
                }).catch((err) => {
                    this.error = err.data?.message ?? 'Could not fetch plans. Please try again.';
                }).finally(() => this.loading = false);
            },

            choosePlan(plan) {
                this.selectedPlan = plan;
                this.step = 'confirm';
            },

            payNow() {
                this.paying = true;
                window.apiFetch('{{ route('recharge.pay') }}', {
                    method: 'POST',
                    body: JSON.stringify({ mobile: this.mobile, operator: this.operator, plan_id: this.selectedPlan.id }),
                }).then(() => {
                    this.showComingSoon = true;
                    $store.toast.push('Recharge request saved successfully.');
                }).catch((err) => {
                    $store.toast.push(err.data?.message ?? 'Something went wrong.', 'error');
                }).finally(() => this.paying = false);
            },

            reset() {
                this.step = 'form';
                this.plans = [];
                this.selectedPlan = null;
                this.mobile = '';
                this.operator = '';
                this.error = '';
            },
        }"
        class="mx-auto max-w-2xl"
    >
        <div class="mb-6">
            <h1 class="font-display text-2xl text-ink">Mobile Recharge</h1>
            <p class="mt-1 text-sm text-ink-muted">Browse live plans and recharge any prepaid number.</p>
        </div>

        <div class="mb-6 flex flex-wrap items-center gap-2 text-xs font-medium text-ink-subtle">
            <span :class="step === 'form' ? 'text-primary-600' : 'text-success'" class="flex items-center gap-1">
                <x-icon name="check-circle" class="h-4 w-4" x-show="step !== 'form'" />
                <span x-show="step === 'form'">1.</span> Number &amp; Operator
            </span>
            <x-icon name="chevron-right" class="h-3 w-3" />
            <span :class="step === 'plans' ? 'text-primary-600' : (step === 'confirm' ? 'text-success' : '')" class="flex items-center gap-1">
                <x-icon name="check-circle" class="h-4 w-4" x-show="step === 'confirm'" />
                2. Choose Plan
            </span>
            <x-icon name="chevron-right" class="h-3 w-3" />
            <span :class="step === 'confirm' ? 'text-primary-600' : ''">3. Confirm</span>
        </div>

        <div x-show="error" x-cloak class="mb-5 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger" x-text="error"></div>

        <!-- Step: Form -->
        <div x-show="step === 'form'" class="card space-y-5 p-6 sm:p-8">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-ink">Mobile Number <span class="text-danger">*</span></label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-ink-muted">+91</span>
                    <input type="tel" inputmode="numeric" maxlength="10" x-model="mobile" class="input-field pl-12" placeholder="98765 43210">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-ink">Operator <span class="text-danger">*</span></label>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach ($operators as $operator)
                        <button
                            type="button"
                            @click="operator = '{{ $operator['value'] }}'"
                            class="rounded-xl border-2 px-4 py-3 text-sm font-semibold transition-all"
                            :class="operator === '{{ $operator['value'] }}' ? '{{ $operatorClasses[$operator['value']] }}' : 'border-border text-ink-muted hover:border-primary-300'"
                        >
                            {{ $operator['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <button type="button" @click="fetchPlans" class="btn-primary w-full" :disabled="loading">
                <span x-show="!loading">View Plans</span>
                <span x-show="loading" x-cloak>Loading plans...</span>
            </button>
        </div>

        <!-- Step: Plans -->
        <div x-show="step === 'plans'" x-cloak>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <template x-for="plan in plans" :key="plan.id">
                    <button
                        type="button"
                        @click="choosePlan(plan)"
                        class="card group flex flex-col items-start p-5 text-left transition-all duration-200 hover:-translate-y-1 hover:border-primary-400 hover:shadow-xl"
                    >
                        <div class="flex w-full items-center justify-between">
                            <p class="font-display text-2xl text-ink" x-text="'₹' + plan.price"></p>
                            <x-icon name="phone" class="h-5 w-5 text-primary-500 opacity-0 transition-opacity group-hover:opacity-100" />
                        </div>
                        <p class="mt-2 text-sm font-semibold text-ink" x-text="plan.data_per_day"></p>
                        <p class="mt-1 text-xs text-ink-muted" x-text="plan.validity_days + ' Days Validity'"></p>
                        <ul class="mt-3 space-y-1 text-xs text-ink-muted">
                            <template x-for="benefit in plan.benefits" :key="benefit">
                                <li class="flex items-center gap-1.5">
                                    <x-icon name="check" class="h-3 w-3 text-success" />
                                    <span x-text="benefit"></span>
                                </li>
                            </template>
                        </ul>
                    </button>
                </template>
            </div>

            <button type="button" @click="step = 'form'" class="btn-secondary mt-5 w-full justify-center">
                <x-icon name="chevron-down" class="h-4 w-4 rotate-90" />
                Back
            </button>
        </div>

        <!-- Step: Confirm -->
        <div x-show="step === 'confirm'" x-cloak>
            <template x-if="selectedPlan">
                <div class="card p-6 sm:p-8">
                    <div class="rounded-2xl border border-border bg-surface-muted p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-display text-lg text-ink" x-text="'+91 ' + mobile"></p>
                                <p class="text-xs uppercase tracking-wide text-ink-muted" x-text="operator"></p>
                            </div>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                                <x-icon name="phone" class="h-5 w-5" />
                            </span>
                        </div>

                        <dl class="mt-5 space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <dt class="text-ink-muted">Plan</dt>
                                <dd class="font-medium text-ink" x-text="selectedPlan.data_per_day"></dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-ink-muted">Validity</dt>
                                <dd class="font-medium text-ink" x-text="selectedPlan.validity_days + ' Days'"></dd>
                            </div>
                            <div>
                                <dt class="text-ink-muted">Benefits</dt>
                                <dd class="mt-1.5 space-y-1">
                                    <template x-for="benefit in selectedPlan.benefits" :key="benefit">
                                        <div class="flex items-center gap-1.5 text-ink">
                                            <x-icon name="check" class="h-3.5 w-3.5 text-success" />
                                            <span x-text="benefit"></span>
                                        </div>
                                    </template>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-5 rounded-xl bg-gradient-to-br from-primary-600 to-primary-700 p-4 text-white">
                            <p class="text-xs text-primary-100">Amount Payable</p>
                            <p class="mt-1 font-display text-2xl" x-text="'₹' + selectedPlan.price"></p>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col gap-2 sm:flex-row">
                        <button type="button" @click="step = 'plans'" class="btn-secondary flex-1 justify-center">
                            <x-icon name="chevron-down" class="h-4 w-4 rotate-90" />
                            Change Plan
                        </button>
                        <button type="button" @click="payNow()" class="btn-primary flex-1 justify-center" :disabled="paying">
                            <span x-show="!paying">Pay Now</span>
                            <span x-show="paying" x-cloak>Processing...</span>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <x-ui.coming-soon-modal />
    </div>
</x-layouts.app>
