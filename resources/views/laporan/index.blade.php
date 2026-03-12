@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Laporan Peminjaman</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">Akses Admin Dan Petugas</p>
        </div>

        <div class="flex-shrink-0">
            <a href="{{ route('laporan.pdf', request()->only(['search', 'status'])) }}" class="inline-block border-2 border-black px-6 py-2 text-sm font-bold uppercase tracking-wider hover:bg-black hover:text-white transition-all rounded-none text-center w-full">
                <i class="fa-solid fa-file-pdf mr-2 text-xs"></i> Generate Laporan
            </a>
        </div>
    </div>

    <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_220px_140px] gap-3 mb-8">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam, email, judul buku..." class="w-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm">
        </div>

        <select name="status" class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm appearance-none cursor-pointer">
            <option value="">Semua Status</option>
            @foreach(['dipinjam', 'dikembalikan', 'telat mengembalikan'] as $statusOption)
            <option value="{{ $statusOption }}" @selected(request('status') === $statusOption)>{{ ucfirst($statusOption) }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-black text-white border border-black px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
            Tampilkan
        </button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b-2 border-black bg-gray-50">
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Peminjam</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Buku</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Tgl Pinjam</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Tgl Kembali</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pinjamans as $pinjaman)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-5 px-4">
                        <span class="block font-bold text-sm uppercase leading-tight">{{ $pinjaman->user->nama_lengkap }}</span>
                        <span class="text-[10px] text-gray-400 italic">{{ '@' . $pinjaman->user->username }} • {{ $pinjaman->user->email }}</span>
                    </td>
                    <td class="py-5 px-4">
                        <span class="block font-bold text-sm uppercase leading-tight">{{ $pinjaman->buku->judul }}</span>
                        <span class="text-[10px] text-gray-400 italic">{{ $pinjaman->buku->kategori->nama_kategori ?? 'Umum' }}</span>
                    </td>
                    <td class="py-5 px-4 text-sm font-mono text-gray-600">{{ $pinjaman->tanggal_peminjaman->format('d M Y') }}</td>
                    <td class="py-5 px-4 text-sm font-mono text-gray-600">{{ $pinjaman->tanggal_pengembalian?->format('d M Y') ?? '-' }}</td>
                    <td class="py-5 px-4">
                        <span class="inline-block border border-gray-300 px-3 py-1 text-[9px] font-bold uppercase tracking-tight bg-white {{ $pinjaman->status_peminjaman === 'dikembalikan' ? 'text-green-700' : ($pinjaman->status_peminjaman === 'telat mengembalikan' ? 'text-red-500' : 'text-gray-700') }}">
                            {{ $pinjaman->status_peminjaman }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest italic">Data laporan tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $pinjamans->links() }}
    </div>
</div>
@endsection