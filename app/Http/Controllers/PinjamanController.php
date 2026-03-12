<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\IsiBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function index()
    {
        $this->authorizePengguna();

        $pinjamans = Peminjaman::with(['buku.kategori', 'buku.isiBuku'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('pinjamans'));
    }

    public function store(Request $request, Buku $buku)
    {
        $this->authorizePengguna();

        $data = $request->validate([
            'tanggal_pengembalian' => ['required', 'date', 'after_or_equal:today'],
        ]);

        if (!$buku->isiBuku) {
            return redirect()
                ->route('buku.show', $buku)
                ->with('error', 'Buku ini belum memiliki isi yang dapat dibaca.');
        }

        $existingLoan = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $buku->id)
            ->where('status_peminjaman', 'dipinjam')
            ->exists();

        if ($existingLoan) {
            return redirect()
                ->route('buku.show', $buku)
                ->with('success', 'Buku ini sudah ada di daftar bacaan Anda.');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'tanggal_peminjaman' => now()->toDateString(),
            'tanggal_pengembalian' => $data['tanggal_pengembalian'],
            'status_peminjaman' => 'dipinjam',
        ]);

        return redirect()
            ->route('buku.show', $buku)
            ->with('success', 'Buku berhasil dipinjam dan siap dibaca.');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        $this->authorizePengguna();

        abort_unless((int) $peminjaman->user_id === (int) Auth::id(), 403, 'Akses Ditolak.');

        if ($peminjaman->status_peminjaman !== 'dipinjam') {
            return redirect()
                ->route('peminjaman.index')
                ->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $status = $peminjaman->tanggal_pengembalian && now()->startOfDay()->gt($peminjaman->tanggal_pengembalian)
            ? 'telat mengembalikan'
            : 'dikembalikan';

        $peminjaman->update([
            'status_peminjaman' => $status,
        ]);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', $status === 'dikembalikan'
                ? 'Buku berhasil dikembalikan.'
                : 'Buku dikembalikan dengan status telat mengembalikan.');
    }

    public function showIsi(IsiBuku $isiBuku)
    {
        $this->authorizePengguna();

        $buku = $isiBuku->buku()->with(['kategori', 'isiBuku'])->firstOrFail();

        $hasActiveLoan = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $buku->id)
            ->where('status_peminjaman', 'dipinjam')
            ->exists();

        abort_unless($hasActiveLoan, 403, 'Anda belum meminjam buku ini.');

        return view('buku.isi.show', compact('buku'));
    }

    private function authorizePengguna(): void
    {
        if (!Auth::check() || Auth::user()->level !== 'pengguna') {
            abort(403, 'Akses Ditolak.');
        }
    }
}
