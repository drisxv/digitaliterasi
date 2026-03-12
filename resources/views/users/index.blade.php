@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white border border-gray-300 p-8">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-100">
        <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold uppercase tracking-tight">Kelola Pengguna</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] font-medium">Akses Admin</p>
        </div>

        <div class="flex-grow max-w-2xl">
            <form action="{{ route('user.index') }}" method="GET" class="flex">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, username, email, level..."
                        class="w-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm">
                </div>
                <button type="submit" class="bg-black text-white border border-black px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
                    Cari
                </button>
            </form>
        </div>

        <div class="flex-shrink-0">
            <a href="{{ route('user.create') }}" class="inline-block border-2 border-black px-6 py-2 text-sm font-bold uppercase tracking-wider hover:bg-black hover:text-white transition-all rounded-none text-center w-full">
                <i class="fa-solid fa-plus mr-2 text-xs"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b-2 border-black bg-gray-50">
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Pengguna</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Kontak</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Level</th>
                    <th class="text-left py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600 italic">Dibuat</th>
                    <th class="text-right py-4 px-4 text-xs font-bold uppercase tracking-widest text-gray-600">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-5 px-4">
                        <span class="block font-bold text-sm uppercase leading-tight">{{ $user->nama_lengkap }}</span>
                        <span class="text-[10px] text-gray-400 font-medium italic">{{ '@' . $user->username }}</span>
                    </td>
                    <td class="py-5 px-4 text-sm text-gray-600 font-medium">
                        <span class="block">{{ $user->email }}</span>
                        <span class="text-[10px] text-gray-400">{{ $user->alamat ?: 'Alamat belum diisi' }}</span>
                    </td>
                    <td class="py-5 px-4">
                        <span class="inline-block border border-gray-300 px-3 py-1 text-[9px] font-bold uppercase tracking-tight bg-white text-gray-600">
                            {{ $user->level }}
                        </span>
                    </td>
                    <td class="py-5 px-4 text-sm font-mono text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="py-5 px-4 text-right">
                        @if((int) $user->id === (int) auth()->id())
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Akun Anda</span>
                        @else
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('user.edit', $user) }}" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Edit">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </a>
                            <button type="button" class="p-2 border border-gray-200 text-gray-400 hover:border-black hover:text-black transition-all" title="Hapus"
                                data-delete-trigger
                                data-delete-action="{{ route('user.destroy', $user) }}"
                                data-delete-title="Hapus Pengguna"
                                data-delete-message="Pengguna {{ $user->nama_lengkap }} akan dihapus permanen."
                                data-delete-confirm="Ya, hapus pengguna">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                            </button>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest italic">Data pengguna tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex flex-col md:flex-row items-center justify-center pt-6 border-t border-gray-100 gap-4">
        {{ $users->links() }}
    </div>
</div>
@endsection