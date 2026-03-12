<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KoleksiPribadi;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    public function index()
    {
        $this->authorizePengguna();

        $koleksis = KoleksiPribadi::with(['buku.kategori'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(9);

        return view('favorit.index', compact('koleksis'));
    }

    public function store(Buku $buku)
    {
        $this->authorizePengguna();

        KoleksiPribadi::firstOrCreate([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
        ]);

        return redirect()
            ->route('buku.show', $buku)
            ->with('success', 'Buku berhasil ditambahkan ke favorit.');
    }

    public function destroy(Buku $buku)
    {
        $this->authorizePengguna();

        KoleksiPribadi::where('user_id', Auth::id())
            ->where('buku_id', $buku->id)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Buku berhasil dihapus dari favorit.');
    }

    private function authorizePengguna(): void
    {
        if (!Auth::check() || Auth::user()->level !== 'pengguna') {
            abort(403, 'Akses Ditolak.');
        }
    }
}