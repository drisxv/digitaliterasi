@php($buku = $buku ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Judul Buku</label>
        <input type="text" name="judul" value="{{ old('judul', $buku->judul ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Contoh: Laskar Pelangi">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Penulis</label>
        <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Nama Penulis">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Penerbit</label>
        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Nama Penerbit">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" min="1000" max="{{ date('Y') + 1 }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="YYYY">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Kategori</label>
        <select name="kategori_id" class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm appearance-none cursor-pointer">
            <option value="">Pilih Kategori</option>
            @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}" @selected((string) old('kategori_id', $buku->kategori_id ?? '') === (string) $kategori->id)>{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Cover</label>
        <input type="file" name="cover" accept="image/png,image/jpeg,image/jpg,image/webp" class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm file:mr-4 file:border-0 file:bg-black file:px-4 file:py-2 file:text-xs file:font-bold file:uppercase file:tracking-wider file:text-white">
        @if(!empty($buku?->cover))
        <div class="mt-4 border border-gray-200 p-3 bg-gray-50 inline-block">
            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul }}" class="h-32 w-24 object-cover border border-gray-200">
        </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Sinopsis</label>
        <textarea name="sinopsis" rows="7" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Masukkan sinopsis buku">{{ old('sinopsis', $buku->sinopsis ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2 border border-gray-200 bg-gray-50 p-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600">Isi Buku</label>
                <p class="mt-2 text-xs text-gray-500">Isi buku akan memiliki ID unik acak 4 digit dan hanya dapat dibaca pengguna yang sudah meminjam.</p>
            </div>

            @if($buku?->isiBuku)
            <div class="border border-gray-300 bg-white px-4 py-3 text-center">
                <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400">ID Unik Isi</p>
                <p class="mt-1 text-sm font-mono font-bold text-black">{{ str_pad($buku->isiBuku->id_unik, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            @endif
        </div>

        <textarea name="isi" rows="16" required class="w-full border border-gray-300 bg-white py-3 px-4 focus:outline-none focus:border-black transition-colors rounded-none text-sm leading-7" placeholder="Masukkan isi lengkap buku">{{ old('isi', $buku?->isiBuku?->isi ?? '') }}</textarea>
    </div>
</div>