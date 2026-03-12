@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('kategori.index') }}" class="inline-flex items-center gap-2 border border-black bg-white px-5 py-3 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white transition-all">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
        </a>
    </div>

    <div class="bg-white border border-gray-300 p-8 md:p-12">
        <div class="flex flex-col md:flex-row gap-10">
            <div class="w-full md:w-1/3 flex-shrink-0">
                <div class="aspect-[3/4] bg-gray-100 border border-gray-300 flex items-center justify-center relative overflow-hidden">
                    <i class="fa-solid fa-layer-group text-gray-200 text-8xl"></i>
                    <div class="absolute bottom-0 left-0 w-full bg-black/5 p-4 text-center">
                        <span class="text-[10px] font-bold uppercase tracking-widest">{{ $kategori->bukus_count }} Buku</span>
                    </div>
                </div>
            </div>

            <div class="flex-grow">
                <div class="mb-6">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 block mb-2">Kategori Buku</span>
                    <h1 class="text-3xl font-black uppercase tracking-tighter leading-none mb-2">{{ $kategori->nama_kategori }}</h1>
                    <p class="text-gray-500 italic">Kelompok koleksi perpustakaan digital</p>
                </div>

                <div class="grid grid-cols-2 gap-y-4 border-t border-gray-100 pt-6">
                    <div>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Jumlah Buku</p>
                        <p class="text-sm font-bold uppercase">{{ $kategori->bukus_count }} Koleksi</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">ID Kategori</p>
                        <p class="text-sm font-mono italic">#KT-{{ str_pad($kategori->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6">
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-3">Buku Terkait</p>
                    @if($kategori->bukus->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($kategori->bukus as $buku)
                        <a href="{{ route('buku.show', $buku) }}" class="flex items-center justify-between border border-gray-200 px-4 py-3 hover:border-black transition-colors">
                            <div>
                                <p class="text-sm font-bold uppercase leading-tight">{{ $buku->judul }}</p>
                                <p class="text-[10px] text-gray-400 italic">{{ $buku->penulis }}</p>
                            </div>
                            <span class="text-[10px] font-mono text-gray-400">{{ $buku->tahun_terbit }}</span>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-500">Belum ada buku yang menggunakan kategori ini.</p>
                    @endif
                </div>

                <div class="mt-10 flex flex-wrap gap-3">
                    <a href="{{ route('kategori.edit', $kategori) }}" class="bg-black text-white px-8 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none text-center">
                        Edit Data
                    </a>
                    <button type="button" class="border border-red-200 text-red-400 px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white hover:border-red-600 transition-all rounded-none"
                        data-delete-trigger
                        data-delete-action="{{ route('kategori.destroy', $kategori) }}"
                        data-delete-title="Hapus Kategori"
                        data-delete-message="Kategori {{ $kategori->nama_kategori }} akan dihapus jika tidak dipakai oleh data buku."
                        data-delete-confirm="Ya, hapus kategori">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection