{{--
    Halaman baca isi buku.

    Kegunaan:
    - Menampilkan isi lengkap buku (konten dari relasi `isiBuku`).
    - Disediakan untuk user yang punya pinjaman aktif (dicek di controller/middleware).

    Route: `buku.isi.show`
    Data:
    - $buku: Buku yang sedang dibaca (wajib punya relasi isiBuku)
--}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 border border-black bg-white px-5 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
        </a>
        <a href="{{ route('buku.show', $buku) }}" class="text-xs font-black uppercase tracking-widest border-b border-black hover:text-gray-500 hover:border-gray-500 transition-all">
            Lihat Detail Buku
        </a>
    </div>

    <div class="bg-white border border-gray-300 p-8 md:p-10">
        <div class="pb-6 border-b border-gray-100">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 block mb-2">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
            <h1 class="text-3xl font-black uppercase tracking-tighter leading-none mb-3">{{ $buku->judul }}</h1>
            <p class="text-gray-500 italic">{{ $buku->penulis }}</p>
        </div>

        <div class="pt-6">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-4">Isi Lengkap Buku</p>
            <div class="border border-gray-200 bg-gray-50 p-6 text-sm leading-8 text-gray-700 whitespace-pre-line min-h-[420px]">{{ $buku->isiBuku->isi }}</div>
        </div>
    </div>
</div>
@endsection