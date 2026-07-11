<x-layouts.admin title="Users">
    <div class="mx-auto max-w-6xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-2xl text-ink">Users</h1>
                <p class="mt-1 text-sm text-ink-muted">{{ number_format($users->total()) }} registered users.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.users.index') }}" class="card mb-5 p-4">
            <div class="relative sm:w-80">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-subtle" />
                <input
                    type="text" name="search" value="{{ $search }}"
                    placeholder="Search by name, email or mobile..."
                    class="w-full rounded-lg border border-border bg-surface py-2 pl-9 pr-3 text-sm text-ink focus:border-primary-500 focus:outline-none"
                >
            </div>
        </form>

        <div class="card overflow-hidden">
            @if ($users->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-surface-muted text-ink-subtle">
                        <x-icon name="users" class="h-7 w-7" />
                    </span>
                    <p class="mt-4 text-sm font-medium text-ink">No users found</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-border bg-surface-muted text-xs uppercase tracking-wide text-ink-subtle">
                            <tr>
                                <th class="px-5 py-3 font-medium">Name</th>
                                <th class="px-5 py-3 font-medium">Email</th>
                                <th class="px-5 py-3 font-medium">Mobile</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                                <th class="px-5 py-3 font-medium">Joined</th>
                                <th class="px-5 py-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($users as $user)
                                <tr class="hover:bg-surface-muted/60">
                                    <td class="px-5 py-4 font-medium text-ink">{{ $user->name }}</td>
                                    <td class="px-5 py-4 text-ink-muted">{{ $user->email }}</td>
                                    <td class="px-5 py-4 text-ink-muted">+91 {{ $user->mobile }}</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $user->status->value === 'active' ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">
                                            {{ $user->status->value }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-ink-muted">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium text-ink-muted transition hover:bg-surface-muted hover:text-ink">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.toggle-block', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium transition {{ $user->status->value === 'active' ? 'text-danger hover:bg-danger/10' : 'text-success hover:bg-success/10' }}">
                                                    {{ $user->status->value === 'active' ? 'Block' : 'Unblock' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user permanently? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium text-danger transition hover:bg-danger/10">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-border px-5 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
