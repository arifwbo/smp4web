<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserPasswordResetRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
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
        return view('admin.users.create');
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = true;

        $user = User::create($data);

        ActivityLogger::log('users.create', "Menambahkan akun {$user->email}");

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = (bool) $data['is_active'];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('profile', 'public');
        }

        $user->update($data);

        ActivityLogger::log('users.update', "Memperbarui akun {$user->email}");

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

        $user->update(['password' => $newPassword]);

        ActivityLogger::log('users.reset_password', "Reset password akun {$user->email}");

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

        $user->update(['is_active' => ! $user->is_active]);

        $statusLabel = $user->is_active ? 'mengaktifkan' : 'menonaktifkan';
        ActivityLogger::log('users.toggle_status', ucfirst($statusLabel) . " akun {$user->email}");

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

        $email = $user->email;
        $user->delete();

        ActivityLogger::log('users.delete', "Menghapus akun {$email}");

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
