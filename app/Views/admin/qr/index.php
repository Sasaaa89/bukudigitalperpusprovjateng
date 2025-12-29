<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Generate QR Code</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- QR Code Generator -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">QR Code Aktif</h3>
            
            <?php if ($activeToken): ?>
                <div class="text-center">
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <div class="mx-auto bg-white border-2 border-gray-300 rounded-lg p-4 inline-block">
                            <!-- Real QR Code Image -->
                            <img src="<?= base_url('qr/' . $activeToken['token']) ?>" 
                                 alt="QR Code" 
                                 class="w-80 h-80 mx-auto">
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-2">Token: <?= substr($activeToken['token'], 0, 16) ?>...</p>
                    <p class="text-xs text-gray-500 mb-4 break-all px-4">URL: <?= $qrUrl ?></p>
                    
                    <div class="space-y-3">
                        <a href="/admin/generate-qr/download-pdf" 
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 inline-block">
                            <i class="fas fa-download mr-2"></i>Download PDF (Print-Ready)
                        </a>
                        
                        <a href="/admin/generate-qr/print" target="_blank" 
                           class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 inline-block">
                            <i class="fas fa-print mr-2"></i>Print QR Code
                        </a>
                        
                        <form method="POST" action="/admin/generate-qr/generate" class="w-full">
                            <button type="submit" 
                                    onclick="return confirm('QR Code lama akan menjadi tidak valid. Lanjutkan?')"
                                    class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition duration-200">
                                <i class="fas fa-sync-alt mr-2"></i>Generate QR Code Baru
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <div class="bg-gray-100 p-8 rounded-lg mb-4">
                        <i class="fas fa-qrcode text-gray-400 text-6xl"></i>
                        <p class="text-gray-600 mt-4">Belum ada QR Code aktif</p>
                    </div>
                    
                    <form method="POST" action="/admin/generate-qr/generate">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Generate QR Code Pertama
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Instructions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Petunjuk Penggunaan</h3>
            
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 rounded-full p-2 mt-1">
                        <span class="text-blue-600 font-bold text-sm">1</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Generate QR Code</h4>
                        <p class="text-sm text-gray-600">Klik tombol "Generate QR Code" untuk membuat QR code baru. QR code lama akan otomatis menjadi tidak valid.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 rounded-full p-2 mt-1">
                        <span class="text-blue-600 font-bold text-sm">2</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Print QR Code</h4>
                        <p class="text-sm text-gray-600">Klik tombol "Print QR Code" untuk mencetak QR code dalam format yang siap dipasang di area publik.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 rounded-full p-2 mt-1">
                        <span class="text-blue-600 font-bold text-sm">3</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Pasang QR Code</h4>
                        <p class="text-sm text-gray-600">Tempelkan QR code yang sudah dicetak di tempat yang mudah dijangkau pengunjung perpustakaan.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 rounded-full p-2 mt-1">
                        <span class="text-blue-600 font-bold text-sm">4</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Monitoring</h4>
                        <p class="text-sm text-gray-600">Pantau aktivitas pengunjung melalui dashboard admin dan lihat data yang masuk secara real-time.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start space-x-2">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>
                    <div>
                        <h4 class="font-medium text-yellow-800">Penting!</h4>
                        <p class="text-sm text-yellow-700">Setiap kali generate QR code baru, QR code lama akan menjadi tidak valid. Pastikan untuk mengganti QR code yang terpasang dengan yang baru.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>