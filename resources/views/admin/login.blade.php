<x-layouts.guest title="Admin Sign In">
    <div class="mx-auto flex min-h-[calc(100dvh-73px)] max-w-md flex-col justify-center px-4 py-12 sm:px-6">
        <div class="mb-8 text-center">
            <span class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-600 to-accent-500 text-white shadow-lg shadow-primary-500/30">
                <x-icon name="shield-check" class="h-6 w-6" />
            </span>
            <h1 class="font-display text-3xl text-ink">Admin Sign In</h1>
            <p class="mt-2 text-sm text-ink-muted">Restricted access — authorised personnel only.</p>
        </div>

        <div class="card glass-panel p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-danger/10 px-4 py-3 text-sm font-medium text-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="input-field" placeholder="admin@bharatpaye.in">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-ink">Password</label>
                    <input type="password" name="password" required class="input-field" placeholder="••••••••">
                </div>

                <label class="flex items-center gap-2 text-sm text-ink-muted">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-border text-primary-600 focus:ring-primary-500">
                    Remember me
                </label>

                <button type="submit" class="btn-primary w-full">Sign In</button>
            </form>
        </div>
    </div>
</x-layouts.guest>
