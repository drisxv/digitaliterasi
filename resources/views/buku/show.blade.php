{{--
        Halaman detail buku.

        Kegunaan:
        - Menampilkan detail buku (cover, metadata, sinopsis, kategori).
        - Menampilkan daftar ulasan pembaca dan rata-rata rating.
        - Aksi berdasarkan level:
            - `pengguna`: pinjam/kembalikan, toggle favorit, baca isi (jika punya pinjaman aktif).
            - `admin/petugas`: edit dan hapus buku.

        Route: `buku.show`
        Data yang umum dipakai:
        - $buku: model Buku (+ relasi kategori, isiBuku, ulasans)
        - $averageRating: angka rata-rata rating
        - $canReadIsi: bool (izin baca isi)
        - $activeLoan: Peminjaman aktif (opsional)
        - $hasBorrowed: bool (pernah meminjam)
        - $isFavorite: bool (sudah difavoritkan)
        - $userReview: ulasan user terhadap buku (opsional)
--}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 border border-black bg-white px-5 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
        </a>
    </div>

    <div class="bg-white border border-gray-300 p-8 md:p-10">
        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_360px] gap-8">
            <div class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-[280px_minmax(0,1fr)] gap-8">
                    <div>
                        <div class="aspect-[3/4] bg-gray-100 border border-gray-300 flex items-center justify-center relative overflow-hidden">
                            @if($buku->cover)
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul }}" class="absolute inset-0 h-full w-full object-cover">
                            @else
                            <i class="fa-solid fa-book text-gray-200 text-8xl"></i>
                            @endif
                        </div>

                        <div class="mt-6 border-t border-gray-100 pt-6">
                            <div class="flex flex-wrap items-start gap-3">
                                @if(auth()->user()->level == 'pengguna')
                                    @if($canReadIsi)
                                    <a href="{{ route('buku.isi.show', $buku->isiBuku) }}" class="bg-black text-white px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none text-center flex-1 min-w-[160px]">
                                        Baca Isi Buku
                                    </a>
                                    @if($isFavorite)
                                    <form action="{{ route('buku.favorit.destroy', $buku) }}" method="POST" class="flex-1 min-w-[160px]">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full border border-black px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all rounded-none">
                                            Hapus Favorit
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('buku.favorit.store', $buku) }}" method="POST" class="flex-1 min-w-[160px]">
                                        @csrf
                                        <button type="submit" class="w-full border border-black px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all rounded-none">
                                            Jadikan Favorit
                                        </button>
                                    </form>
                                    @endif
                                    <form id="return-book-form" action="{{ route('peminjaman.return', $activeLoan) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="w-full border border-black px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all rounded-none"
                                            data-confirm-trigger
                                            data-confirm-form="return-book-form"
                                            data-confirm-title="Kembalikan Buku"
                                            data-confirm-message="Buku {{ $buku->judul }} akan dikembalikan dan status peminjaman akan diperbarui. Lanjutkan?"
                                            data-confirm-button="Ya, kembalikan buku">
                                            Kembalikan Buku
                                        </button>
                                    </form>
                                    @elseif($buku->isiBuku)
                                    <form id="favorite-toggle-form" action="{{ $isFavorite ? route('buku.favorit.destroy', $buku) : route('buku.favorit.store', $buku) }}" method="POST" class="hidden">
                                        @csrf
                                        @if($isFavorite)
                                        @method('DELETE')
                                        @endif
                                    </form>
                                    <form id="borrow-book-form" action="{{ route('buku.pinjam', $buku) }}" method="POST" class="w-full border border-gray-200 bg-gray-50 p-4 space-y-4">
                                        @csrf
                                        <div>
                                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Pinjam Buku</p>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Tanggal Pengembalian</label>
                                            <input type="date" name="tanggal_pengembalian" min="{{ now()->toDateString() }}" value="{{ old('tanggal_pengembalian', now()->addDays(7)->toDateString()) }}" class="w-full border border-gray-300 bg-white py-3 px-4 focus:outline-none focus:border-black rounded-none text-sm">
                                        </div>
                                        <div class="flex flex-wrap gap-3">
                                            <button type="button" class="bg-black text-white px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none flex-1 min-w-[160px]"
                                                data-confirm-trigger
                                                data-confirm-form="borrow-book-form"
                                                data-confirm-title="Pinjam Buku"
                                                data-confirm-message="Buku {{ $buku->judul }} akan dipinjam sesuai tanggal pengembalian yang Anda pilih. Lanjutkan?"
                                                data-confirm-button="Ya, pinjam buku">
                                                {{ $hasBorrowed ? 'Pinjam Lagi' : 'Pinjam Buku' }}
                                            </button>
                                            <button type="submit" form="favorite-toggle-form" class="border border-black px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all rounded-none flex-1 min-w-[160px]">
                                                {{ $isFavorite ? 'Hapus Favorit' : 'Jadikan Favorit' }}
                                            </button>
                                        </div>
                                    </form>
                                    @endif
                                    @if($activeLoan)
                                    <div class="w-full text-xs uppercase tracking-widest text-gray-500 border-t border-gray-100 pt-4">
                                        Batas pengembalian: <span class="font-black text-black">{{ $activeLoan->tanggal_pengembalian ? $activeLoan->tanggal_pengembalian->format('d M Y') : 'Belum diatur' }}</span>
                                    </div>
                                    @endif
                                @else
                                    <a href="{{ route('buku.edit', $buku) }}" class="bg-black text-white px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none text-center flex-1 min-w-[160px]">
                                        Edit Data
                                    </a>
                                    <button type="button" class="border border-red-200 text-red-400 px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white hover:border-red-600 transition-all rounded-none flex-1 min-w-[160px]"
                                        data-delete-trigger
                                        data-delete-action="{{ route('buku.destroy', $buku) }}"
                                        data-delete-title="Hapus Buku"
                                        data-delete-message="Buku {{ $buku->judul }} akan dihapus permanen beserta isi dan relasi turunannya."
                                        data-delete-confirm="Ya, hapus buku">
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-6">
                            <h1 class="text-3xl font-black uppercase tracking-tighter leading-none mb-3">{{ $buku->judul }}</h1>
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 block mb-2">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                            <p class="text-gray-500 italic">{{ $buku->penulis }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-6">
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Penerbit</p>
                                <p class="text-sm font-bold uppercase">{{ $buku->penerbit }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">ID Koleksi</p>
                                <p class="text-sm font-mono italic">{{ ($buku->id) }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Tahun Terbit</p>
                                <p class="text-sm font-mono italic">{{ $buku->tahun_terbit }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Rating</p>
                                <p class="text-sm font-bold uppercase">{{ $averageRating > 0 ? $averageRating . ' / 5' : 'Belum ada ulasan' }}</p>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-100 pt-6">
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-3">Sinopsis</p>
                            <p class="text-sm leading-7 text-gray-700 whitespace-pre-line">{{ $buku->sinopsis }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="border border-gray-200 bg-gray-50 p-6 h-fit">
                <div class="flex items-center justify-between gap-3 pb-4 border-b border-gray-200">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Ulasan</p>
                        <h2 class="mt-2 text-xl font-black uppercase tracking-tight">Pembaca</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-black">{{ $averageRating > 0 ? $averageRating : '-' }}</p>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400">Rata-rata</p>
                    </div>
                </div>

                <div class="mt-6 space-y-4 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($buku->ulasans as $ulasan)
                    <div class="border border-gray-200 bg-white p-4">
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest">{{ $ulasan->user->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $ulasan->created_at->format('d M Y') }}</p>
                            </div>
                            <span class="border border-gray-300 px-2 py-1 text-[10px] font-black uppercase tracking-widest">{{ $ulasan->rating }}/5</span>
                        </div>
                        <p class="text-sm leading-7 text-gray-600 whitespace-pre-line">{{ $ulasan->ulasan }}</p>
                    </div>
                    @empty
                    <div class="border border-dashed border-gray-300 p-6 text-sm text-gray-500">
                        Belum ada ulasan untuk buku ini.
                    </div>
                    @endforelse
                </div>

                @if(auth()->user()->level === 'pengguna' && $hasBorrowed)
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-3">Tulis Ulasan</p>
                    <form action="{{ route('buku.ulasan.store', $buku) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Rating</label>
                            <select name="rating" class="w-full border border-gray-300 bg-white py-3 px-4 focus:outline-none focus:border-black rounded-none text-sm">
                                @for($rating = 5; $rating >= 1; $rating--)
                                <option value="{{ $rating }}" @selected((int) old('rating', $userReview->rating ?? 5) === $rating)>{{ $rating }} / 5</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Ulasan</label>
                            <textarea name="ulasan" rows="6" class="w-full border border-gray-300 bg-white py-3 px-4 focus:outline-none focus:border-black rounded-none text-sm leading-7" placeholder="Tulis pendapat Anda tentang buku ini">{{ old('ulasan', $userReview->ulasan ?? '') }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-black text-white px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
                            Simpan Ulasan
                        </button>
                    </form>
                </div>
                @endif
            </aside>
        </div>
    </div>
</div>
@endsection