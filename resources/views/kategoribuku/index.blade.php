{{--
    Halaman daftar kategori buku.

    Kegunaan:
    - Menampilkan list kategori + pencarian `search`.
    - Menampilkan jumlah buku per kategori (`bukus_count`).
    - Aksi: detail, edit, hapus (dengan modal konfirmasi global).

    Route: `kategori.index`
    Data:
    - $kategoris: paginator Kategori (umumnya sudah withCount('bukus'))
--}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Kategori Buku</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">Struktur Koleksi</p>
        </div>

        <div class="flex-grow max-w-2xl">
            <form action="{{ route('kategori.index') }}" method="GET" class="flex">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama kategori..."
                        class="w-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm">
                </div>
                <button type="submit"
                    class="bg-black text-white border border-black px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
                    Cari
                </button>
            </form>
        </div>

        <div class="flex-shrink-0">
            <a href="{{ route('kategori.create') }}" class="inline-block border-2 border-black px-6 py-2 text-sm font-bold uppercase tracking-wider hover:bg-black hover:text-white transition-all rounded-none text-center w-full">
                <i class="fa-solid fa-plus mr-2 text-xs"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b-2 border-black bg-gray-50">
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Kategori</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Jumlah Buku</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600 italic">Dibuat</th>
                    <th class="text-right py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kategoris as $kategori)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-5 px-4">
                        <a href="{{ route('kategori.show', $kategori) }}" class="block font-bold text-sm uppercase leading-tight hover:underline">{{ $kategori->nama_kategori }}</a>
                        <span class="text-[10px] text-gray-400 font-medium italic capitalize">ID Kategori #{{ str_pad($kategori->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="py-5 px-4 text-sm text-gray-600 font-medium">{{ $kategori->bukus_count }} buku</td>
                    <td class="py-5 px-4 text-sm font-mono text-gray-400">{{ $kategori->created_at->format('d M Y') }}</td>
                    <td class="py-5 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('kategori.show', $kategori) }}" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Detail">
                                <i class="fa-solid fa-eye text-[10px]"></i>
                            </a>
                            <a href="{{ route('kategori.edit', $kategori) }}" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Edit">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </a>
                            <button type="button" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Hapus"
                                data-delete-trigger
                                data-delete-action="{{ route('kategori.destroy', $kategori) }}"
                                data-delete-title="Hapus Kategori"
                                data-delete-message="Kategori {{ $kategori->nama_kategori }} akan dihapus jika tidak dipakai oleh data buku."
                                data-delete-confirm="Ya, hapus kategori">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest italic">Data kategori tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection