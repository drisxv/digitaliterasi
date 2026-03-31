{{--
    Halaman daftar peminjaman user.

    Kegunaan:
    - Menampilkan riwayat peminjaman buku milik user login.
    - Klik item membuka `buku.show`.
    - Jika status masih `dipinjam` dan buku punya isi, user bisa baca isi dan kembalikan.

    Route: `peminjaman.index`
    Akses: `pengguna`.
    Data:
    - $pinjamans: paginator Peminjaman (umumnya load relasi buku, kategori, isiBuku)
--}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Peminjaman Buku</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">Daftar Bacaan Pengguna</p>
        </div>

        <div class="max-w-xl text-sm leading-7 text-gray-500">
            Klik salah satu data untuk membuka detail buku. Isi buku hanya tersedia selama status peminjaman masih aktif.
        </div>
    </div>

    <div class="border border-gray-200">
        @forelse($pinjamans as $pinjaman)
        <div class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 px-6 py-5">
                <a href="{{ route('buku.show', $pinjaman->buku) }}" class="flex-grow min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm font-black uppercase tracking-widest leading-tight">{{ $pinjaman->buku->judul }}</p>
                            <p class="mt-1 text-xs text-gray-500 italic">{{ $pinjaman->buku->penulis }} • {{ $pinjaman->buku->kategori->nama_kategori ?? 'Umum' }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-left md:text-right">
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Pinjam</p>
                                <p class="text-xs font-mono text-gray-700">{{ $pinjaman->tanggal_peminjaman->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Kembali</p>
                                <p class="text-xs font-mono text-gray-700">{{ $pinjaman->tanggal_pengembalian?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Status</p>
                                <p class="text-[10px] font-black uppercase tracking-widest {{ $pinjaman->status_peminjaman === 'dipinjam' ? 'text-black' : ($pinjaman->status_peminjaman === 'dikembalikan' ? 'text-green-600' : 'text-red-500') }}">{{ $pinjaman->status_peminjaman }}</p>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="flex items-center gap-2 shrink-0">
                    @if($pinjaman->status_peminjaman === 'dipinjam' && $pinjaman->buku->isiBuku)
                    <a href="{{ route('buku.isi.show', $pinjaman->buku->isiBuku) }}" class="border border-black px-4 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all text-center">
                        Baca Isi
                    </a>
                    <form action="{{ route('peminjaman.return', $pinjaman) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-black text-white px-4 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition-all">
                            Kembalikan
                        </button>
                    </form>
                    @else
                    <span class="border border-gray-300 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-400">Selesai</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center border border-dashed border-gray-300 m-6">
            <p class="text-xs text-gray-400 uppercase tracking-widest italic">Belum ada riwayat peminjaman.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $pinjamans->links() }}
    </div>
</div>
@endsection