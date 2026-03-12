@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Ulasan Saya</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">Riwayat Ulasan Pengguna</p>
        </div>

        <div class="max-w-xl text-sm leading-7 text-gray-500">
            Semua ulasan yang sudah Anda buat akan muncul di halaman ini.
        </div>
    </div>

    <div class="space-y-4">
        @forelse($ulasans as $ulasan)
        <div class="border border-gray-200 bg-gray-50 p-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                <div>
                    <a href="{{ route('buku.show', $ulasan->buku) }}" class="text-lg font-black uppercase tracking-tight hover:underline">{{ $ulasan->buku->judul }}</a>
                    <p class="mt-1 text-[10px] uppercase tracking-[0.2em] text-gray-400">{{ $ulasan->buku->kategori->nama_kategori ?? 'Umum' }}</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-sm font-black uppercase">{{ $ulasan->rating }}/5</p>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400">{{ $ulasan->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <p class="text-sm leading-7 text-gray-700 whitespace-pre-line">{{ $ulasan->ulasan }}</p>
        </div>
        @empty
        <div class="py-20 text-center border border-dashed border-gray-300">
            <p class="text-xs text-gray-400 uppercase tracking-widest italic">Belum ada ulasan yang dibuat.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $ulasans->links() }}
    </div>
</div>
@endsection