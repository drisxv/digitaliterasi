<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function index()
    {
        $this->authorizePengguna();

        $ulasans = UlasanBuku::with('buku.kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('ulasan.index', compact('ulasans'));
    }

    public function store(Request $request, Buku $buku)
    {
        $this->authorizePengguna();

        $hasBorrowed = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $buku->id)
            ->exists();

        abort_unless($hasBorrowed, 403, 'Anda hanya dapat mengulas buku yang pernah dipinjam.');

        $data = $request->validate([
            'ulasan' => ['required', 'string'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ]);

        UlasanBuku::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'buku_id' => $buku->id,
            ],
            $data
        );

        return redirect()
            ->route('buku.show', $buku)
            ->with('success', 'Ulasan buku berhasil disimpan.');
    }

    private function authorizePengguna(): void
    {
        if (!Auth::check() || Auth::user()->level !== 'pengguna') {
            abort(403, 'Akses Ditolak.');
        }
    }
}
