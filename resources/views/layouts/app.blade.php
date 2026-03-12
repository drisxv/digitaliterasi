<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitaliterasi - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        /* Menghilangkan scrollbar tapi fungsi scroll tetap ada jika menu kepanjangan */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Custom Transition untuk Sidebar Mobile */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        /* Overlay Style */
        #sidebar-overlay {
            display: none;
            background-color: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(2px);
        }

        #sidebar-overlay.active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100 text-black font-sans antialiased overflow-hidden">

    <div class="lg:hidden bg-white border-b border-gray-300 p-4 flex justify-between items-center sticky top-0 z-50">
        <h1 class="text-lg font-black uppercase tracking-tighter">Digitaliterasi</h1>
        <button id="open-sidebar" class="text-black p-2 border border-black">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 z-30 lg:hidden"></div>

    <div id="delete-modal" class="fixed inset-0 z-[60] hidden items-center justify-center px-4">
        <div data-modal-close class="absolute inset-0 bg-slate-200/35 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md border border-gray-300 bg-white p-8 shadow-2xl">
            <div class="mb-6">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-2">Konfirmasi Aksi</p>
                <h2 id="delete-modal-title" class="text-2xl font-black uppercase tracking-tight">Hapus Data</h2>
                <p id="delete-modal-message" class="mt-3 text-sm leading-7 text-gray-600">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>

            <form id="delete-modal-form" method="POST" class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                @csrf
                @method('DELETE')
                <button type="button" data-modal-close class="border border-gray-300 px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-600 hover:border-black hover:text-black transition-all rounded-none">
                    Batal
                </button>
                <button id="delete-modal-submit" type="submit" class="bg-black text-white px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <div id="action-modal" class="fixed inset-0 z-[60] hidden items-center justify-center px-4">
        <div data-action-modal-close class="absolute inset-0 bg-slate-200/35 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-md border border-gray-300 bg-white p-8 shadow-2xl">
            <div class="mb-6">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-2">Konfirmasi Aksi</p>
                <h2 id="action-modal-title" class="text-2xl font-black uppercase tracking-tight">Lanjutkan Aksi</h2>
                <p id="action-modal-message" class="mt-3 text-sm leading-7 text-gray-600">Pastikan data yang Anda masukkan sudah benar.</p>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                <button type="button" data-action-modal-close class="border border-gray-300 px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-600 hover:border-black hover:text-black transition-all rounded-none">
                    Batal
                </button>
                <button id="action-modal-submit" type="button" class="bg-black text-white px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all rounded-none">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-300 flex flex-col -translate-x-full lg:translate-x-0 lg:static lg:inset-0">

            <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                <h1 class="text-xl font-black uppercase tracking-tighter leading-none">
                    Digitaliterasi
                </h1>
                <button id="close-sidebar" class="lg:hidden text-gray-400 hover:text-black">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <nav class="flex-grow p-6 space-y-1.5 overflow-y-auto no-scrollbar">
                @php $level = auth()->user()->level; @endphp

                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 pl-4">Menu Utama</p>

                @if($level == 'admin' || $level == 'petugas')
                <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('kategori.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-layer-group w-5"></i> Kategori Buku
                </a>
                <a href="{{ route('buku.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('buku.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-book w-5"></i> Daftar Buku
                </a>
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('laporan.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-file-contract w-5"></i> Laporan
                </a>
                @endif

                @if($level == 'admin')
                <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('user.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-users w-5"></i> Kelola Pengguna
                </a>
                @endif

                @if($level == 'pengguna')
                <a href="{{ route('buku.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('buku.*') && !request()->routeIs('buku.isi.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-book-open w-5"></i> Daftar Buku
                </a>
                <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('peminjaman.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left w-5"></i> Peminjaman
                </a>
                <a href="{{ route('favorit.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('favorit.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-bookmark w-5"></i> Favorit
                </a>
                <a href="{{ route('ulasan.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all border border-transparent {{ request()->routeIs('ulasan.*') ? 'bg-black text-white' : '' }}">
                    <i class="fa-solid fa-quote-left w-5"></i> Ulasan Saya
                </a>
                @endif
            </nav>

            <div class="p-6 border-t border-gray-200">
                <div class="mb-4 px-4 py-2 border border-gray-200 bg-gray-50">
                    <p class="text-[10px] font-black uppercase text-black truncate">{{ auth()->user()->nama_lengkap }}</p>
                    <p class="text-[9px] text-gray-500 uppercase tracking-tighter italic">{{ $level }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-xs font-black uppercase tracking-widest border border-black hover:bg-black hover:text-white transition-all">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-grow flex flex-col h-full overflow-hidden">
            <section class="flex-grow overflow-y-auto p-6 md:p-12 no-scrollbar">
                @if(session('success'))
                <div class="max-w-6xl mx-auto mb-6 border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="max-w-6xl mx-auto mb-6 border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="max-w-6xl mx-auto mb-6 border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <p class="font-bold uppercase tracking-wider text-xs mb-2">Validasi gagal</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');
        const deleteModal = document.getElementById('delete-modal');
        const deleteModalForm = document.getElementById('delete-modal-form');
        const deleteModalTitle = document.getElementById('delete-modal-title');
        const deleteModalMessage = document.getElementById('delete-modal-message');
        const deleteModalSubmit = document.getElementById('delete-modal-submit');
        const actionModal = document.getElementById('action-modal');
        const actionModalTitle = document.getElementById('action-modal-title');
        const actionModalMessage = document.getElementById('action-modal-message');
        const actionModalSubmit = document.getElementById('action-modal-submit');
        let pendingActionForm = null;

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('active');
        }

        function openDeleteModal(trigger) {
            deleteModalForm.action = trigger.dataset.deleteAction;
            deleteModalTitle.textContent = trigger.dataset.deleteTitle || 'Hapus Data';
            deleteModalMessage.textContent = trigger.dataset.deleteMessage || 'Data yang dihapus tidak dapat dikembalikan.';
            deleteModalSubmit.textContent = trigger.dataset.deleteConfirm || 'Ya, Hapus';
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('flex');
            deleteModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function openActionModal(trigger) {
            pendingActionForm = document.getElementById(trigger.dataset.confirmForm);

            if (!pendingActionForm) {
                return;
            }

            actionModalTitle.textContent = trigger.dataset.confirmTitle || 'Lanjutkan Aksi';
            actionModalMessage.textContent = trigger.dataset.confirmMessage || 'Pastikan data yang Anda masukkan sudah benar.';
            actionModalSubmit.textContent = trigger.dataset.confirmButton || 'Ya, Lanjutkan';
            actionModal.classList.remove('hidden');
            actionModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeActionModal() {
            actionModal.classList.remove('flex');
            actionModal.classList.add('hidden');
            pendingActionForm = null;
            document.body.classList.remove('overflow-hidden');
        }

        openBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        document.addEventListener('click', (event) => {
            const trigger = event.target.closest('[data-delete-trigger]');
            const actionTrigger = event.target.closest('[data-confirm-trigger]');

            if (trigger) {
                openDeleteModal(trigger);
                return;
            }

            if (actionTrigger) {
                openActionModal(actionTrigger);
                return;
            }

            if (event.target.matches('[data-modal-close]') || event.target === deleteModal) {
                closeDeleteModal();
            }

            if (event.target.matches('[data-action-modal-close]') || event.target === actionModal) {
                closeActionModal();
            }
        });

        actionModalSubmit.addEventListener('click', () => {
            if (!pendingActionForm) {
                closeActionModal();
                return;
            }

            pendingActionForm.requestSubmit();
            closeActionModal();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                closeDeleteModal();
            }

            if (event.key === 'Escape' && !actionModal.classList.contains('hidden')) {
                closeActionModal();
            }
        });

        // Menutup sidebar jika layar di-resize ke ukuran desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) { // breakpoint lg tailwind
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>

</html>