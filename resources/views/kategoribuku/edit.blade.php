@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-gray-300 p-8">
    <div class="mb-8 pb-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold uppercase tracking-tight">Edit Kategori</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest">Perbarui Kategori Buku</p>
        </div>
        <a href="{{ route('kategori.show', $kategori) }}" class="text-xs font-bold uppercase border-b border-black">Batal</a>
    </div>

    <form action="{{ route('kategori.update', $kategori) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        @include('kategoribuku._form', ['kategori' => $kategori])

        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="submit" class="bg-black text-white px-10 py-3 text-xs font-black uppercase tracking-[0.2em] border border-black hover:bg-gray-800 transition-all rounded-none">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection