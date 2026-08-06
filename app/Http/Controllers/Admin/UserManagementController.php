<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserPasswordResetRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $users = User::query()
            ->with('role')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = true;
        $role = Role::findOrFail($data['role_id']);
        $data['role'] = $role->slug;

        $user = User::create($data);

        ActivityLogger::logModelChange('users.create', "Menambahkan akun {$user->email}", $user);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = (bool) $data['is_active'];
        $role = Role::findOrFail($data['role_id']);
        $data['role'] = $role->slug;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('profile', 'public');
        }

        $before = $user->replicate();
        $user->update($data);

        ActivityLogger::log('users.update', "Memperbarui akun {$user->email}", null, $before->toArray(), $user->fresh()->toArray());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function resetPassword(UserPasswordResetRequest $request, User $user): RedirectResponse
    {
        $payload = $request->validated();

        if (empty($payload['password']) && empty($payload['generate_password'])) {
            return back()->withErrors(['password' => 'Masukkan password baru atau pilih opsi generate.']);
        }

        $newPassword = $payload['password'] ?? null;
        if (! $newPassword && ! empty($payload['generate_password'])) {
            $newPassword = Str::random(12);
        }

        $before = ['updated_at' => $user->updated_at];
        $user->update(['password' => $newPassword]);

        ActivityLogger::log('users.reset_password', "Reset password akun {$user->email}", null, $before, ['updated_at' => $user->fresh()->updated_at]);

        return back()->with([
            'success' => 'Password baru berhasil disetel.',
            'generated_password' => ! empty($payload['generate_password']) ? $newPassword : null,
        ]);
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['status' => 'Anda tidak dapat menonaktifkan akun sendiri.']);
        }

        $before = ['is_active' => $user->is_active];
        $user->update(['is_active' => ! $user->is_active]);

        $statusLabel = $user->is_active ? 'mengaktifkan' : 'menonaktifkan';
        ActivityLogger::log('users.toggle_status', ucfirst($statusLabel) . " akun {$user->email}", null, $before, ['is_active' => $user->is_active]);

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['delete' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $payload = $user->toArray();
        $email = $user->email;
        $user->delete();

        ActivityLogger::log('users.delete', "Menghapus akun {$email}", null, $payload, null);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
