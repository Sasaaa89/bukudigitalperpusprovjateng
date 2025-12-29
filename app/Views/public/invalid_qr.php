<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="text-center">
    <div class="bg-red-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
        <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
    </div>
    
    <h1 class="text-2xl font-bold text-red-600 mb-4">QR Code Tidak Valid</h1>
    
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
        <p class="text-red-700 mb-4">
            <i class="fas fa-times-circle mr-2"></i>
            QR Code yang Anda scan tidak valid atau sudah diganti dengan yang baru.
        </p>
        
        <div class="text-left text-sm text-red-600">
            <p class="font-semibold mb-2">Kemungkinan penyebab:</p>
            <ul class="list-disc list-inside space-y-1">
                <li>QR Code sudah kadaluarsa</li>
                <li>Admin telah membuat QR Code baru</li>
                <li>Link yang digunakan tidak benar</li>
            </ul>
        </div>
    </div>
    
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="font-semibold text-blue-800 mb-3">Solusi:</h3>
        <div class="text-left text-sm text-blue-700 space-y-2">
            <p><i class="fas fa-qrcode mr-2"></i>Gunakan QR Code terbaru yang tersedia di perpustakaan</p>
            <p><i class="fas fa-user-friends mr-2"></i>Hubungi petugas perpustakaan untuk bantuan</p>
            <p><i class="fas fa-sync-alt mr-2"></i>Minta admin untuk generate QR Code baru jika diperlukan</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>