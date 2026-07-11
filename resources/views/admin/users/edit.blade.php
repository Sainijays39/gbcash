<x-layouts.admin title="Edit User">
    <div class="mx-auto max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="flex h-9 w-9 items-center justify-center rounded-xl border border-border text-ink-muted hover:bg-surface-muted">
                <x-icon name="arrow-right" class="h-4 w-4 rotate-180" />
            </a>
            <div>
                <h1 class="font-display text-2xl text-ink">Edit User</h1>
                <p class="mt-1 text-sm text-ink-muted">Update {{ $user->name }}'s account details.</p>
            </div>
        </div>

        <div class="card p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-field">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input-field">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Mobile Number</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-ink-muted">+91</span>
                        <input type="tel" inputmode="numeric" maxlength="10" name="mobile" value="{{ old('mobile', $user->mobile) }}" required class="input-field pl-12">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">State</label>
                    <select name="state" required class="input-field">
                        @foreach ($states as $state)
                            <option value="{{ $state }}" @selected(old('state', $user->state) === $state)>{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-primary w-full sm:w-auto">Save Changes</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
