@props([
    'name' => null,
    'options' => [],
    'placeholder' => 'Select an option',
    'selected' => null,
    'label' => null,
    'required' => false,
])

<div
    x-data="{
        open: false,
        query: '',
        options: {{ Illuminate\Support\Js::from($options) }},
        selectedValue: @js($selected),
        get filtered() {
            if (!this.query) return this.options;
            const q = this.query.toLowerCase();
            return this.options.filter((o) => o.label.toLowerCase().includes(q));
        },
        get selectedLabel() {
            const found = this.options.find((o) => o.value === this.selectedValue);
            return found ? found.label : '';
        },
        select(option) {
            this.selectedValue = option.value;
            this.open = false;
            this.query = '';
            $dispatch('select-change', { name: @js($name), value: option.value, label: option.label });
        },
    }"
    @click.outside="open = false"
    class="relative"
>
    @if ($label)
        <label class="mb-1.5 block text-sm font-medium text-ink">{{ $label }}@if($required)<span class="text-danger"> *</span>@endif</label>
    @endif

    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="selectedValue">
    @endif

    <button
        type="button"
        @click="open = !open"
        class="input-field flex items-center justify-between text-left"
        :class="{ 'ring-4 ring-primary-500/15 border-primary-500': open }"
    >
        <span x-text="selectedLabel || @js($placeholder)" :class="!selectedLabel && 'text-ink-subtle'"></span>
        <x-icon name="chevron-down" class="h-4 w-4 shrink-0 text-ink-subtle transition-transform" x-bind:class="open && 'rotate-180'" />
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="glass-panel absolute z-30 mt-2 w-full overflow-hidden rounded-xl"
    >
        <div class="border-b border-border p-2">
            <div class="relative">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-subtle" />
                <input
                    type="text"
                    x-model="query"
                    @click.stop
                    placeholder="Search..."
                    class="w-full rounded-lg border border-border bg-surface py-2 pl-9 pr-3 text-sm text-ink focus:border-primary-500 focus:outline-none"
                >
            </div>
        </div>
        <ul class="max-h-56 overflow-y-auto py-1">
            <template x-for="option in filtered" :key="option.value">
                <li>
                    <button
                        type="button"
                        @click="select(option)"
                        class="flex w-full items-center justify-between px-4 py-2.5 text-left text-sm text-ink hover:bg-surface-muted"
                        :class="selectedValue === option.value && 'bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300'"
                    >
                        <span x-text="option.label"></span>
                        <x-icon name="check" class="h-4 w-4" x-show="selectedValue === option.value" />
                    </button>
                </li>
            </template>
            <li x-show="filtered.length === 0" class="px-4 py-3 text-sm text-ink-subtle">No results found</li>
        </ul>
    </div>
</div>
