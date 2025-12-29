<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Perpustakaan' ?> - Sistem Selamat Datang Di Layanan Buku Tamu Digital Perpustakaan Provinsi Jawa Tengah</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231e40af'><path d='M4 2h16c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2m0 2v16h16V4H4m2 2h12v2H6V6m0 3h12v2H6V9m0 3h12v2H6v-2z'/></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Animated Background */
        body.bg-animated {
            background: linear-gradient(135deg, #C8E9F8 0%, #B3D9F2 25%, #D9B8F0 50%, #F0C8F0 75%, #FFE6CC 100%);
            background-size: 200% 200%;
            animation: backgroundShift 25s ease infinite;
            position: relative;
            z-index: 0;
        }

        body.bg-animated::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 10%, rgba(255,255,255,0.18) 0%, transparent 50%);
            animation: moveBackground 20s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        /* Animated Blobs */
        .blob-background {
            position: fixed;
            z-index: -1;
            opacity: 0.25;
            border-radius: 50%;
            filter: blur(100px);
            mix-blend-mode: screen;
            animation: blobAnimation 15s ease-in-out infinite;
        }

        .blob-1 {
            top: -20%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #88D8FF, #5FCDE0);
            animation-duration: 20s;
            animation-delay: 0s;
        }

        .blob-2 {
            top: 20%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #D9A8FF, #C68FFF);
            animation-duration: 22s;
            animation-delay: -5s;
        }

        .blob-3 {
            bottom: -15%;
            left: 10%;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, #FFBBDD, #FF99CC);
            animation-duration: 24s;
            animation-delay: -10s;
        }

        @keyframes backgroundShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-50%, -50%); }
        }

        @keyframes blobAnimation {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -80px) scale(1.2); }
            50% { transform: translate(-40px, 60px) scale(0.9); }
            75% { transform: translate(80px, 40px) scale(1.1); }
        }
    </style>
</head>
<body class="bg-animated min-h-screen">
    <!-- Background Blobs -->
    <div class="blob-background blob-1"></div>
    <div class="blob-background blob-2"></div>
    <div class="blob-background blob-3"></div>

    <div class="container mx-auto px-4 py-8 relative z-10">
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
                <p>&copy; <?= date('Y') ?> Sistem Selamat Datang Di Layanan Buku Tamu Digital Perpustakaan Provinsi Jawa Tengah</p>
            </div>
        </div>
    </div>
</body>
</html>