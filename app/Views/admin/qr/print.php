<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code - Sistem Layanan Buku Tamu Digital Perpustakaan Provinsi Jawa Tengah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .print-area { 
                width: 100%; 
                height: 100vh; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Print Controls -->
    <div class="no-print bg-white shadow-sm p-4 mb-6">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Print QR Code</h1>
            <div class="space-x-4">
                <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <a href="/admin/generate-qr" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Print Area -->
    <div class="print-area">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Header -->
            <div class="mb-6">
                <div class="bg-blue-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Perpustakaan</h1>
                <p class="text-gray-600">Sistem Layanan Buku Tamu Digital</p>
            </div>

            <!-- QR Code -->
            <div class="mb-6">
                <div class="bg-gray-100 p-6 rounded-lg">
                    <img src="<?= base_url('qr/' . $token) ?>" alt="QR Code" class="w-64 h-64 mx-auto">
                </div>
            </div>

            <!-- Instructions -->
            <div class="text-left">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Cara Menggunakan:</h3>
                <ol class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">1</span>
                        Scan QR Code dengan kamera HP
                    </li>
                    <li class="flex items-start">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">2</span>
                        Pilih jenis layanan yang diinginkan
                    </li>
                    <li class="flex items-start">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">3</span>
                        Isi form yang tersedia
                    </li>
                    <li class="flex items-start">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">4</span>
                        Klik tombol "Kirim"
                    </li>
                </ol>
            </div>

            <!-- Footer -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    Token: <?= substr($token, 0, 8) ?>...<?= substr($token, -8) ?>
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Dicetak pada: <?= date('d/m/Y H:i:s') ?>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>