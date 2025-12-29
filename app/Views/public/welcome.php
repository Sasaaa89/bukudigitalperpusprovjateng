<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="text-center mb-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang Di</h1>
    <h2 class="text-2xl font-semibold text-blue-600 mb-8">Layanan Pengunjung Perpustakaan<br><span class="text-lg">Provinsi Jawa Tengah</span></h2>
    
    <p class="text-gray-600 mb-8">Silahkan pilih jenis layanan yang Anda butuhkan:</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kritik & Saran -->
        <a href="/form/feedback<?= isset($token) ? '?token='.$token : '' ?>" 
           class="group bg-gradient-to-br from-blue-500 to-blue-600 text-white p-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
            <div class="text-center">
                <div class="bg-white bg-opacity-20 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-200">
                    <i class="fas fa-comments text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Kritik & Saran</h3>
                <p class="text-blue-100">Berikan masukan untuk meningkatkan layanan perpustakaan</p>
            </div>
        </a>
        
        <!-- Buku Tamu -->
        <a href="/form/guest-book<?= isset($token) ? '?token='.$token : '' ?>" 
           class="group bg-gradient-to-br from-green-500 to-green-600 text-white p-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
            <div class="text-center">
                <div class="bg-white bg-opacity-20 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-200">
                    <i class="fas fa-book-open text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Buku Tamu</h3>
                <p class="text-green-100">Daftarkan kunjungan Anda ke perpustakaan</p>
            </div>
        </a>
    </div>
    
    <div class="mt-8 p-4 bg-blue-50 rounded-lg">
        <div class="flex items-center justify-center text-blue-700">
            <i class="fas fa-info-circle mr-2"></i>
            <span class="text-sm">Pilih salah satu layanan di atas untuk melanjutkan</span>
        </div>
    </div>
</div>

<!-- Divider -->
<div class="my-12">
    <div class="flex items-center">
        <div class="flex-1 border-t-2 border-gray-300"></div>
        <span class="px-4 text-gray-500 font-medium">atau</span>
        <div class="flex-1 border-t-2 border-gray-300"></div>
    </div>
</div>

<!-- Section: Cek Status Surat Kunjungan -->
<div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-8 shadow-md">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Cek Status Surat Kunjungan Anda</h3>
        <p class="text-gray-600">Masukkan nama Anda untuk melihat status surat kunjungan yang telah diajukan</p>
    </div>

    <form action="/search-guest-book" method="GET" class="max-w-md mx-auto">
        <div class="flex gap-2">
            <input 
                type="text" 
                name="nama" 
                placeholder="Masukkan nama Anda..." 
                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required>
            <button 
                type="submit" 
                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-medium">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </div>
        <p class="text-xs text-gray-500 mt-2 text-center">Nama lengkap yang Anda gunakan saat mengajukan surat kunjungan</p>
    </form>
</div>

<?= $this->endSection() ?>
