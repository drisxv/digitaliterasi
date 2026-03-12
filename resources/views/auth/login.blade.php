<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grayscale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-black font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full bg-white border border-gray-300 p-8">
            
            <div class="mb-8">
                <h1 class="text-2xl font-bold uppercase tracking-tight">Login</h1>
                <p class="text-sm text-gray-500">Masuk dengan username anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" name="username" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="Username">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" required
                            class="w-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 focus:outline-none focus:border-black focus:bg-white transition-colors rounded-none"
                            placeholder="Password">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-black text-white font-bold py-3 uppercase tracking-wider text-sm hover:bg-gray-800 transition-colors rounded-none">
                    Masuk
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center text-xs text-gray-500 uppercase tracking-widest">
                Belum punya akun? 
                <a href="/register" class="text-black font-bold hover:underline">Daftar</a>
            </div>
        </div>
    </div>
</body>
</html>