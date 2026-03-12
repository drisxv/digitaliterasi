@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Koleksi Buku</h1>
        </div>

        <div class="flex-grow max-w-2xl">
            <form action="{{ route('buku.index') }}" method="GET" class="flex">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan judul, penulis..."
                        class="w-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm">
                </div>
                <button type="submit"
                    class="bg-black text-white border border-black px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
                    Cari
                </button>
            </form>
        </div>

        @if(auth()->user()->level != 'pengguna')
        <div class="flex-shrink-0">
            <a href="{{ route('buku.create') }}" class="inline-block border-2 border-black px-6 py-2 text-sm font-bold uppercase tracking-wider hover:bg-black hover:text-white transition-all rounded-none text-center w-full">
                <i class="fa-solid fa-plus mr-2 text-xs"></i> Tambah Buku
            </a>
        </div>
        @endif
    </div>

    @if(auth()->user()->level == 'pengguna')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($bukus as $buku)
        <div class="border border-gray-300 bg-white p-5 hover:border-black transition-colors flex flex-col h-full">
            <a href="{{ route('buku.show', $buku) }}" class="mb-4 block aspect-[3/4] bg-gray-100 border border-gray-200 overflow-hidden">
                @if($buku->cover)
                <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul }}" class="h-full w-full object-cover">
                @else
                <div class="h-full w-full flex items-center justify-center text-gray-200">
                    <i class="fa-solid fa-book text-7xl"></i>
                </div>
                @endif
            </a>
            <div class="flex justify-between items-start mb-4">
                <span class="text-[9px] font-bold uppercase tracking-tighter bg-gray-100 px-2 py-1 border border-gray-200">
                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                </span>
                <span class="text-[10px] font-mono text-gray-400">{{ $buku->tahun_terbit }}</span>
            </div>
            <h3 class="font-bold text-sm uppercase mb-1 leading-tight">{{ $buku->judul }}</h3>
            <p class="text-xs text-gray-500 italic mb-4">{{ $buku->penulis }}</p>
            <p class="text-xs text-gray-600 leading-6 mb-4">{{ \Illuminate\Support\Str::limit($buku->sinopsis, 120) }}</p>
        </div>
        @empty
        <div class="col-span-full py-20 text-center border border-dashed border-gray-300">
            <p class="text-xs text-gray-400 uppercase tracking-widest italic">Belum ada koleksi buku.</p>
        </div>
        @endforelse
    </div>

    @else
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b-2 border-black bg-gray-50">
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Judul</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Penulis</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600 italic">Tahun</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Kategori</th>
                    <th class="text-right py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bukus as $buku)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-5 px-4">
                        <a href="{{ route('buku.show', $buku) }}" class="block font-bold text-sm uppercase leading-tight hover:underline">{{ $buku->judul }}</a>
                        <span class="text-[10px] text-gray-400 font-medium italic capitalize">{{ $buku->penerbit }}</span>
                    </td>
                    <td class="py-5 px-4 text-sm text-gray-600 font-medium">{{ $buku->penulis }}</td>
                    <td class="py-5 px-4 text-sm font-mono text-gray-400">{{ $buku->tahun_terbit }}</td>
                    <td class="py-5 px-4">
                        <span class="inline-block border border-gray-300 px-3 py-1 text-[9px] font-bold uppercase tracking-tight bg-white text-gray-600">
                            {{ $buku->kategori->nama_kategori ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="py-5 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('buku.show', $buku) }}" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Detail">
                                <i class="fa-solid fa-eye text-[10px]"></i>
                            </a>
                            <a href="{{ route('buku.edit', $buku) }}" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Edit">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </a>
                            <button type="button" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Hapus"
                                data-delete-trigger
                                data-delete-action="{{ route('buku.destroy', $buku) }}"
                                data-delete-title="Hapus Buku"
                                data-delete-message="Buku {{ $buku->judul }} akan dihapus permanen beserta isi yang terhubung."
                                data-delete-confirm="Ya, hapus buku">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest italic">Data tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $bukus->links() }}
    </div>
</div>
@endsection