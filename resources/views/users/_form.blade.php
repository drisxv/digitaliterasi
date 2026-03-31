{{--
        Partial form pengguna (dipakai create & edit).

        Kegunaan:
        - Input identitas user (nama, username, email, alamat) + level.
        - Password:
            - Saat create: wajib diisi.
            - Saat edit: bisa dikosongkan agar tidak mengubah password.

        Dipakai oleh:
        - `users.create` dan `users.edit`

        Data:
        - $user (opsional): User yang diedit
--}}
@php($user = $user ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Nama pengguna">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Username login">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="email@example.com">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Level</label>
        <select name="level" class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm appearance-none cursor-pointer">
            @foreach(['admin' => 'Admin', 'petugas' => 'Petugas', 'pengguna' => 'Pengguna'] as $value => $label)
            <option value="{{ $value }}" @selected(old('level', $user->level ?? 'pengguna') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Alamat</label>
        <textarea name="alamat" rows="4" class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Alamat pengguna">{{ old('alamat', $user->alamat ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Password {{ $user ? '(Kosongkan jika tidak diubah)' : '' }}</label>
        <input type="password" name="password" {{ $user ? '' : 'required' }} class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Minimal sesuai aturan aplikasi">
    </div>

    <div>
        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-600 mb-2">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" {{ $user ? '' : 'required' }} class="w-full border border-gray-300 bg-gray-50 py-3 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none text-sm" placeholder="Ulangi password">
    </div>
</div>