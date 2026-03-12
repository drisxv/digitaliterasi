<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Grayscale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-black font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6 py-12">
        <div class="max-w-2xl w-full bg-white border border-gray-300 p-8 md:p-12">
            
            <div class="mb-10">
                <h1 class="text-2xl font-bold uppercase tracking-tight">Buat Akun</h1>
                <p class="text-sm text-gray-500">Silahkan isi formulir pendaftaran</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="Nama Lengkap">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="email@contoh.com">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Username</label>
                        <input type="text" name="username" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="Username">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2"
                        class="w-full border border-gray-300 bg-gray-50 py-2.5 px-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                        placeholder="Alamat lengkap..."></textarea>
                </div>

                <button type="submit" 
                    class="w-full bg-black text-white font-bold py-3 uppercase tracking-wider text-sm hover:bg-gray-800 transition-colors rounded-none mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-gray-500 uppercase tracking-widest font-medium">
                Sudah punya akun? 
                <a href="/login" class="text-black font-bold hover:underline">Login</a>
            </div>
        </div>
    </div>
</body>
</html>