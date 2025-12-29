<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="relative mb-16">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 rounded-2xl opacity-10"></div>
    <div class="relative text-center py-12">
        <div class="mb-6">
            <i class="fas fa-book-reader text-6xl text-blue-600 mb-4 inline-block"></i>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 mb-3">Selamat Datang</h1>
        <h2 class="text-2xl font-semibold text-blue-600 mb-2">Layanan Pengunjung Perpustakaan</h2>
        <p class="text-lg text-gray-600 mb-6">Provinsi Jawa Tengah</p>
        <div class="h-1 w-20 bg-gradient-to-r from-blue-600 to-cyan-500 mx-auto rounded-full"></div>
    </div>
</div>

<!-- Main Services Section -->
<div class="mb-16">
    <div class="text-center mb-10">
        <h3 class="text-3xl font-bold text-gray-800 mb-3">Pilih Layanan</h3>
        <p class="text-gray-600 text-lg">Silahkan pilih jenis layanan yang Anda butuhkan</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Kritik & Saran Card -->
        <a href="/form/feedback<?= isset($token) ? '?token='.$token : '' ?>" 
           class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700 transform group-hover:scale-105 transition-transform duration-300"></div>
            <div class="relative p-10 text-white z-10">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-20 rounded-full group-hover:bg-opacity-30 transition-all duration-300 transform group-hover:scale-110">
                        <i class="fas fa-comments text-5xl"></i>
                    </div>
                </div>
                <h4 class="text-2xl font-bold mb-3">Kritik & Saran</h4>
                <p class="text-blue-100 text-lg mb-6">Berikan masukan Anda untuk meningkatkan kualitas layanan perpustakaan</p>
                <div class="flex items-center text-white font-semibold">
                    <span>Mulai Sekarang</span>
                    <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </a>
        
        <!-- Buku Tamu Card -->
        <a href="/form/guest-book<?= isset($token) ? '?token='.$token : '' ?>" 
           class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-700 transform group-hover:scale-105 transition-transform duration-300"></div>
            <div class="relative p-10 text-white z-10">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-20 rounded-full group-hover:bg-opacity-30 transition-all duration-300 transform group-hover:scale-110">
                        <i class="fas fa-book-open text-5xl"></i>
                    </div>
                </div>
                <h4 class="text-2xl font-bold mb-3">Buku Tamu</h4>
                <p class="text-green-100 text-lg mb-6">Daftarkan kunjungan Anda dan informasi pengunjung perpustakaan</p>
                <div class="flex items-center text-white font-semibold">
                    <span>Mulai Sekarang</span>
                    <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Info Banner -->
    <div class="mt-10 p-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-600 rounded-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-2xl text-blue-600 mt-1"></i>
            </div>
            <div class="ml-4">
                <h5 class="text-lg font-bold text-gray-800 mb-1">Informasi Penting</h5>
                <p class="text-gray-700">Kedua layanan di atas dapat Anda gunakan untuk mengirimkan kritik, saran, dan data kunjungan Anda. Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan.</p>
            </div>
        </div>
    </div>
</div>

<!-- Divider -->
<div class="my-12">
    <div class="flex items-center gap-4">
        <div class="flex-1 border-t-2 border-gray-300"></div>
        <div class="px-4">
            <div class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-full text-sm font-bold">
                ATAU
            </div>
        </div>
        <div class="flex-1 border-t-2 border-gray-300"></div>
    </div>
</div>

<!-- Tracking Section -->
<div class="rounded-2xl overflow-hidden shadow-lg">
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-8 text-white">
        <div class="flex items-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-search text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-2xl font-bold">Lacak Status Surat Kunjungan</h3>
                <p class="text-purple-100 mt-1">Periksa status surat kunjungan yang telah Anda ajukan</p>
            </div>
        </div>
    </div>
    
    <div class="p-10 bg-white">
        <form action="/search-guest-book" method="GET" class="max-w-lg mx-auto">
            <div class="space-y-4">
                <div class="relative">
                    <input 
                        type="text" 
                        name="nama" 
                        placeholder="Masukkan nama lengkap Anda..." 
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200 transition-all duration-300 text-lg"
                        required>
                    <i class="fas fa-user absolute right-4 top-4 text-gray-400 text-xl"></i>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-bold text-lg flex items-center justify-center">
                    <i class="fas fa-search mr-3"></i>Cari Status Surat Kunjungan
                </button>
            </div>
            <p class="text-sm text-gray-600 mt-4 text-center">
                <i class="fas fa-info-circle mr-2"></i>
                Gunakan nama lengkap yang sama saat Anda mengajukan surat kunjungan
            </p>
        </form>
    </div>
</div>

<!-- Features Grid -->
<div class="mt-16">
    <h3 class="text-3xl font-bold text-gray-800 mb-10 text-center">Keunggulan Layanan Kami</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Feature 1 -->
        <div class="group p-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-600 hover:shadow-lg transition-all duration-300">
            <div class="text-4xl text-blue-600 mb-4">
                <i class="fas fa-bolt"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-800 mb-2">Cepat & Mudah</h4>
            <p class="text-gray-700">Proses pendaftaran yang singkat dan sederhana tanpa ribet</p>
        </div>

        <!-- Feature 2 -->
        <div class="group p-8 bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl border-l-4 border-green-600 hover:shadow-lg transition-all duration-300">
            <div class="text-4xl text-green-600 mb-4">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-800 mb-2">Aman & Terpercaya</h4>
            <p class="text-gray-700">Data Anda dijaga dengan sistem keamanan terbaik</p>
        </div>

        <!-- Feature 3 -->
        <div class="group p-8 bg-gradient-to-br from-purple-50 to-pink-100 rounded-xl border-l-4 border-purple-600 hover:shadow-lg transition-all duration-300">
            <div class="text-4xl text-purple-600 mb-4">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-800 mb-2">Responsif</h4>
            <p class="text-gray-700">Dapat diakses dari berbagai perangkat kapan saja</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
