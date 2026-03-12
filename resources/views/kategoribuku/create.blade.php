@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-gray-300 p-8">
    <div class="mb-8 pb-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold uppercase tracking-tight">Tambah Kategori</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest">Input Kategori Buku</p>
        </div>
        <a href="{{ route('kategori.index') }}" class="text-xs font-bold uppercase border-b border-black hover:text-gray-400 hover:border-gray-400 transition-all">Kembali</a>
    </div>

    <form action="{{ route('kategori.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('kategoribuku._form')

        <div class="pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-black text-white px-10 py-3 text-xs font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition-all rounded-none">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection