<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="text-center">
    <div class="bg-green-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
        <i class="fas fa-check-circle text-green-600 text-3xl"></i>
    </div>
    
    <h1 class="text-2xl font-bold text-green-600 mb-4">Terima Kasih! 🎉</h1>
    
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
        <p class="text-green-700 text-lg mb-2">
            <i class="fas fa-thumbs-up mr-2"></i>
            Data Anda telah berhasil tersimpan
        </p>
        <p class="text-green-600 text-sm">
            Terima kasih atas partisipasi Anda dalam meningkatkan layanan perpustakaan
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <i class="fas fa-clock text-blue-600 mb-2 text-lg"></i>
            <p class="text-blue-700 font-medium">Data Tersimpan</p>
            <p class="text-blue-600"><?= date('d/m/Y H:i:s') ?></p>
        </div>
        
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <i class="fas fa-chart-line text-purple-600 mb-2 text-lg"></i>
            <p class="text-purple-700 font-medium">Membantu Analisis</p>
            <p class="text-purple-600">Data akan digunakan untuk meningkatkan layanan</p>
        </div>
    </div>
    
    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
        <p class="text-gray-600 text-sm">
            <i class="fas fa-heart text-red-500 mr-1"></i>
            Selamat menikmati fasilitas perpustakaan
        </p>
    </div>

    <div class="mt-8">
        <a href="/welcome" class="inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Halaman Welcome
        </a>
    </div>
</div>
<?= $this->endSection() ?>