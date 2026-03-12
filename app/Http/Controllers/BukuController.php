<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\IsiBuku;
use App\Models\Kategori;
use App\Models\KoleksiPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->string('search'));

        $bukus = Buku::with('kategori')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($kategoriQuery) use ($search) {
                            $kategoriQuery->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(Auth::user()?->level === 'pengguna' ? 9 : 10)
            ->withQueryString();

        return view('buku.index', compact('bukus'));
    }

    public function show(Buku $buku)
    {
        $buku->load([
            'kategori',
            'isiBuku',
            'ulasans.user',
        ]);

        $user = Auth::user();
        $hasBorrowed = false;
        $canReadIsi = false;
        $userReview = null;
        $activeLoan = null;
        $isFavorite = false;

        if ($user) {
            $hasBorrowed = $buku->peminjaman()
                ->where('user_id', $user->id)
                ->exists();

            $activeLoan = $buku->peminjaman()
                ->where('user_id', $user->id)
                ->where('status_peminjaman', 'dipinjam')
                ->latest()
                ->first();

            $canReadIsi = $user->level !== 'pengguna' || $activeLoan !== null;

            $userReview = $buku->ulasans->firstWhere('user_id', $user->id);

            if ($user->level === 'pengguna') {
                $isFavorite = KoleksiPribadi::where('user_id', $user->id)
                    ->where('buku_id', $buku->id)
                    ->exists();
            }
        }

        $averageRating = round((float) $buku->ulasans->avg('rating'), 1);

        return view('buku.show', compact('buku', 'hasBorrowed', 'canReadIsi', 'userReview', 'averageRating', 'activeLoan', 'isFavorite'));
    }

    public function create()
    {
        $this->authorizeRole();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole();

        $data = $this->validateBuku($request);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku = DB::transaction(function () use ($data) {
            $buku = Buku::create(Arr::except($data, ['isi']));

            $buku->isiBuku()->create([
                'id_unik' => $this->generateUniqueIsiId(),
                'isi' => $data['isi'],
            ]);

            return $buku;
        });

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $this->authorizeRole();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $this->authorizeRole();

        $data = $this->validateBuku($request);

        if ($request->hasFile('cover')) {

            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        DB::transaction(function () use ($buku, $data) {
            $buku->update(Arr::except($data, ['isi']));

            if ($buku->isiBuku) {
                $buku->isiBuku()->update([
                    'isi' => $data['isi'],
                ]);

                return;
            }

            $buku->isiBuku()->create([
                'id_unik' => $this->generateUniqueIsiId(),
                'isi' => $data['isi'],
            ]);
        });

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $this->authorizeRole();

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    private function authorizeRole()
    {
        if (!Auth::check() || !in_array(Auth::user()->level, ['admin', 'petugas'])) {
            abort(403, 'Akses Ditolak.');
        }
    }

    private function validateBuku(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'between:1000,' . (date('Y') + 1)],
            'sinopsis' => ['required', 'string'],
            'isi' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'kategori_id' => ['nullable', 'exists:kategori,id'],
        ]);
    }

    private function generateUniqueIsiId(): int
    {
        for ($attempt = 0; $attempt < 50; $attempt++) {
            $idUnik = random_int(1000, 9999);

            if (!IsiBuku::where('id_unik', $idUnik)->exists()) {
                return $idUnik;
            }
        }

        abort(500, 'Gagal membuat ID unik isi buku.');
    }
}
