<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Perpustakaan' ?> - Sistem Selamat Datang Di Layanan Pengunjung Perpustakaan Provinsi Jawa Tengah</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231e40af'><path d='M4 2h16c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2m0 2v16h16V4H4m2 2h12v2H6V6m0 3h12v2H6V9m0 3h12v2H6v-2z'/></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-white rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-blue-600 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Perpustakaan</h1>
                <p class="text-gray-600">Sistem Layanan Pengunjung</p>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-lg shadow-lg p-6">
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
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-gray-500 text-sm">
                <p>&copy; <?= date('Y') ?> Sistem Selamat Datang Di Layanan Pengunjung Perpustakaan Provinsi Jawa Tengah</p>
            </div>
        </div>
    </div>
</body>
</html>