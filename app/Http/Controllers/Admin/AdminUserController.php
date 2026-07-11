<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $users) {}

    public function index(Request $request): View
    {
        return view('admin.users.index', [
            'users' => $this->users->search($request->string('search')->toString() ?: null),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'states' => config('states'),
        ]);
    }

    public function update(AdminUserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->users->update($user, $request->validated());

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        $user->update([
            'status' => $user->status === UserStatus::Active ? UserStatus::Blocked : UserStatus::Active,
        ]);

        return back()->with('status', $user->status === UserStatus::Blocked ? 'User blocked.' : 'User unblocked.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }
}
