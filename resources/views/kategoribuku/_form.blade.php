{{--
    Partial form kategori.

    Kegunaan:
    - Input `nama_kategori` untuk create/edit kategori.

    Dipakai oleh:
    - `kategoribuku.create` dan `kategoribuku.edit`

    Data:
    - $kategori (opsional): Kategori yang sedang diedit
--}}
<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Nama Kategori</label>
        <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Contoh: Novel Sejarah">
    </div>
</div>