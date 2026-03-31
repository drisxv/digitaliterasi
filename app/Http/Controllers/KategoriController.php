<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /** Menampilkan daftar kategori buku dengan pencarian dan jumlah buku terkait. */
    public function index(Request $request){
        $this->authorizeRole();

        $search = trim((string) $request->string('search'));

        $kategoris = Kategori::withCount('bukus')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nama_kategori', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kategoribuku.index', compact('kategoris'));
    }

    /** Menampilkan detail kategori beserta sebagian daftar buku di dalamnya. */
    public function show(Kategori $kategori)
    {
        $this->authorizeRole();

        $kategori->load(['bukus' => function ($query) {
            $query->latest()->limit(6);
        }]);
        $kategori->loadCount('bukus');

        return view('kategoribuku.show', compact('kategori'));
    }

    /** Menampilkan form tambah kategori buku. */
    public function create()
    {
        $this->authorizeRole();

        return view('kategoribuku.create');
    }

    /** Menyimpan kategori buku baru ke database. */
    public function store(Request $request)
    {
        $this->authorizeRole();

        $kategori = Kategori::create($this->validateKategori($request));

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    /** Menampilkan form edit untuk kategori buku yang dipilih. */
    public function edit(Kategori $kategori)
    {
        $this->authorizeRole();

        return view('kategoribuku.edit', compact('kategori'));
    }

    /** Memperbarui data kategori buku yang dipilih. */
    public function update(Request $request, Kategori $kategori)
    {
        $this->authorizeRole();

        $kategori->update($this->validateKategori($request, $kategori));

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori buku berhasil diperbarui.');
    }

    /** Menghapus kategori jika belum dipakai oleh data buku mana pun. */
    public function destroy(Kategori $kategori)
    {
        $this->authorizeRole();

        if ($kategori->bukus()->exists()) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih dipakai oleh data buku.');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori buku berhasil dihapus.');
    }

    /** Memastikan hanya admin atau petugas yang dapat mengelola kategori. */
    private function authorizeRole(): void
    {
        if (!Auth::check() || !in_array(Auth::user()->level, ['admin', 'petugas'])) {
            abort(403, 'Akses Ditolak.');
        }
    }

    /** Memvalidasi input kategori dan menjaga nama kategori tetap unik. */
    private function validateKategori(Request $request, ?Kategori $kategori = null): array
    {
        return $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'nama_kategori')->ignore($kategori?->id),
            ],
        ]);
    }
}