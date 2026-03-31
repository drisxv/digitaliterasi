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

    /** Menampilkan daftar pengguna dengan fitur pencarian untuk admin. */
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

    /** Menampilkan form tambah pengguna baru. */
    public function create()
    {
        $this->authorizeAdmin();

        return view('users.create');
    }

    /** Menyimpan data pengguna baru yang dibuat oleh admin. */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        User::create($this->validateStore($request));

        return redirect()
            ->route('user.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /** Menampilkan form edit untuk pengguna selain admin yang sedang login. */
    public function edit(User $user)
    {
        $this->authorizeAdmin();
        $this->preventSelfMutation($user);

        return view('users.edit', compact('user'));
    }

    /** Memperbarui data pengguna dan password bila diisi. */
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

    /** Menghapus data pengguna selain akun admin yang sedang login. */
    public function destroy(User $user)
    {
        $this->authorizeAdmin();
        $this->preventSelfMutation($user);

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /** Memastikan hanya admin yang dapat mengakses manajemen pengguna. */
    private function authorizeAdmin(): void
    {
        if (!Auth::check() || Auth::user()->level !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }
    }

    /** Mencegah admin mengubah atau menghapus akun miliknya sendiri. */
    private function preventSelfMutation(User $user): void
    {
        if ((int) $user->id === (int) Auth::id()) {
            abort(403, 'Admin tidak dapat mengubah data miliknya sendiri.');
        }
    }

    /** Memvalidasi data saat admin membuat pengguna baru. */
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

    /** Memvalidasi data saat admin memperbarui pengguna yang sudah ada. */
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
