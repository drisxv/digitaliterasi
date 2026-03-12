@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Buku Favorit</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">Koleksi Pribadi</p>
        </div>

        <div class="max-w-xl text-sm leading-7 text-gray-500">
            Daftar buku yang sudah Anda simpan ke favorit untuk akses cepat.
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($koleksis as $koleksi)
        <div class="border border-gray-300 bg-white p-5 hover:border-black transition-colors flex flex-col h-full">
            <a href="{{ route('buku.show', $koleksi->buku) }}" class="mb-4 block aspect-[3/4] bg-gray-100 border border-gray-200 overflow-hidden">
                @if($koleksi->buku->cover)
                <img src="{{ asset('storage/' . $koleksi->buku->cover) }}" alt="Cover {{ $koleksi->buku->judul }}" class="h-full w-full object-cover">
                @else
                <div class="h-full w-full flex items-center justify-center text-gray-200">
                    <i class="fa-solid fa-book text-7xl"></i>
                </div>
                @endif
            </a>
            <div class="flex justify-between items-start mb-4">
                <span class="text-[9px] font-bold uppercase tracking-tighter bg-gray-100 px-2 py-1 border border-gray-200">
                    {{ $koleksi->buku->kategori->nama_kategori ?? 'Umum' }}
                </span>
                <span class="text-[10px] font-mono text-gray-400">{{ $koleksi->created_at->format('d M Y') }}</span>
            </div>
            <h3 class="font-bold text-sm uppercase mb-1 leading-tight">{{ $koleksi->buku->judul }}</h3>
            <p class="text-xs text-gray-500 italic mb-4">{{ $koleksi->buku->penulis }}</p>
            <p class="text-xs text-gray-600 leading-6 mb-4">{{ \Illuminate\Support\Str::limit($koleksi->buku->sinopsis, 110) }}</p>
            <div class="mt-auto pt-4 border-t border-gray-50 flex gap-2">
                <a href="{{ route('buku.show', $koleksi->buku) }}" class="flex-grow bg-black text-white text-[10px] font-bold uppercase py-2 hover:bg-gray-800 transition-colors text-center">Detail</a>
                <form action="{{ route('buku.favorit.destroy', $koleksi->buku) }}" method="POST" class="flex-grow">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full border border-black text-[10px] font-bold uppercase py-2 hover:bg-black hover:text-white transition-colors text-center">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center border border-dashed border-gray-300">
            <p class="text-xs text-gray-400 uppercase tracking-widest italic">Belum ada buku favorit.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $koleksis->links() }}
    </div>
</div>
@endsection