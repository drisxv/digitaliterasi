<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $search = trim((string) $request->string('search'));

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('level', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        User::create($this->validateStore($request));

        return redirect()
            ->route('user.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->authorizeAdmin();
        $this->preventSelfMutation($user);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();
        $this->preventSelfMutation($user);

        $data = $this->validateUpdate($request, $user);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        unset($data['password_confirmation']);

        $user->update($data);

        return redirect()
            ->route('user.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeAdmin();
        $this->preventSelfMutation($user);

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    private function authorizeAdmin(): void
    {
        if (!Auth::check() || Auth::user()->level !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }
    }

    private function preventSelfMutation(User $user): void
    {
        if ((int) $user->id === (int) Auth::id()) {
            abort(403, 'Admin tidak dapat mengubah data miliknya sendiri.');
        }
    }

    private function validateStore(Request $request): array
    {
        return $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'alamat' => ['nullable', 'string'],
            'level' => ['required', Rule::in(['admin', 'petugas', 'pengguna'])],
            'password' => $this->passwordRules(),
        ]);
    }

    private function validateUpdate(Request $request, User $user): array
    {
        return $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'alamat' => ['nullable', 'string'],
            'level' => ['required', Rule::in(['admin', 'petugas', 'pengguna'])],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
        ]);
    }
}
