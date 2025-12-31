<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> - Sistem Layanan Buku Tamu Digital Perpustakaan Provinsi Jawa Tengah</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231e40af'><path d='M4 2h16c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2m0 2v16h16V4H4m2 2h12v2H6V6m0 3h12v2H6V9m0 3h12v2H6v-2z'/></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-blue-800 text-white w-64 min-h-screen p-4 transition-all duration-300">
            <div class="flex items-center mb-8">
                <i class="fas fa-book-open text-2xl mr-3"></i>
                <h1 class="text-xl font-bold">Perpustakaan</h1>
            </div>
            
            <nav class="space-y-2">
                <a href="/admin/dashboard" class="flex items-center p-3 rounded hover:bg-blue-700 <?= uri_string() == 'admin/dashboard' ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="/admin/feedback" class="flex items-center p-3 rounded hover:bg-blue-700 <?= strpos(uri_string(), 'admin/feedback') === 0 ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-comments mr-3"></i>
                    Kritik & Saran
                </a>
                <a href="/admin/guest-book" class="flex items-center p-3 rounded hover:bg-blue-700 <?= strpos(uri_string(), 'admin/guest-book') === 0 ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-book-open mr-3"></i>
                    Buku Tamu
                </a>
                <a href="/admin/keperluan" class="flex items-center p-3 rounded hover:bg-blue-700 <?= strpos(uri_string(), 'admin/keperluan') === 0 ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-list mr-3"></i>
                    Keperluan
                </a>
                <a href="/admin/form-builder" class="flex items-center p-3 rounded hover:bg-blue-700 <?= strpos(uri_string(), 'admin/form-builder') === 0 ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-tools mr-3"></i>
                    Form Builder
                </a>
                <a href="/admin/riwayat" class="flex items-center p-3 rounded hover:bg-blue-700 <?= strpos(uri_string(), 'admin/riwayat') === 0 ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-history mr-3"></i>
                    Riwayat
                </a>
                <a href="/admin/generate-qr" class="flex items-center p-3 rounded hover:bg-blue-700 <?= strpos(uri_string(), 'admin/generate-qr') === 0 ? 'bg-blue-700' : '' ?>">
                    <i class="fas fa-qrcode mr-3"></i>
                    Generate QR
                </a>
                <a href="/admin/logout" class="flex items-center p-3 rounded hover:bg-red-700">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm p-4">
                <div class="flex justify-between items-center">
                    <button id="sidebarToggle" class="lg:hidden text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800"><?= $title ?? 'Dashboard' ?></h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Selamat datang, <?= session()->get('admin_nama') ?></span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-6 overflow-y-auto">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });

        // Make sidebar responsive
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 1024) {
                sidebar.classList.add('absolute', 'z-50', '-translate-x-full');
            } else {
                sidebar.classList.remove('absolute', 'z-50', '-translate-x-full');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Call on load
    </script>
</body>
</html>