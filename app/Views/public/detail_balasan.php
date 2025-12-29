<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <a href="/search-guest-book?nama=<?= urlencode($formData['nama_lengkap'] ?? '') ?>" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Surat
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Detail Surat Kunjungan -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
            <h3 class="text-xl font-bold">Detail Surat Kunjungan</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-semibold"><?= esc($formData['nama_lengkap'] ?? '-') ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Telepon</label>
                    <p class="text-gray-900 font-semibold"><?= esc($formData['no_telepon'] ?? '-') ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Asal Instansi</label>
                    <p class="text-gray-900 font-semibold"><?= esc($formData['asal_instansi'] ?? '-') ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Keperluan</label>
                    <p class="text-gray-900 font-semibold"><?= esc($formData['keperluan'] ?? '-') ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Kunjungan</label>
                    <p class="text-gray-900 font-semibold">
                        <?= $guestBook['tanggal_kunjungan'] ? date('d/m/Y', strtotime($guestBook['tanggal_kunjungan'])) : '-' ?>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pengajuan</label>
                    <p class="text-gray-900 font-semibold">
                        <?= $guestBook['tanggal_pengajuan'] ? date('d/m/Y', strtotime($guestBook['tanggal_pengajuan'])) : '-' ?>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Laki-laki</label>
                    <p class="text-gray-900 font-semibold">
                        <?= esc($formData['jumlah_laki_laki'] ?? '0') ?>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Perempuan</label>
                    <p class="text-gray-900 font-semibold">
                        <?= esc($formData['jumlah_perempuan'] ?? '0') ?>
                    </p>
                </div>

                <?php if (!empty($formData['keterangan'])): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Keterangan</label>
                        <p class="text-gray-900"><?= esc($formData['keterangan']) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($guestBook['file_kunjungan'])): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">File Surat Kunjungan</label>
                        <a href="/uploads/<?= esc($guestBook['file_kunjungan']) ?>" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900">
                            <i class="fas fa-download mr-2"></i>Download File
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Detail Balasan -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-800 text-white p-6">
            <h3 class="text-xl font-bold">Balasan dari Admin</h3>
        </div>
        <div class="p-6">
            <?php if (!empty($guestBook['status_balasan'])): ?>
                <div class="space-y-6">
                    <!-- Status Badge -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full <?= $guestBook['status_balasan'] == 'diterima' ? 'bg-green-100' : 'bg-red-100' ?> mb-4">
                            <i class="fas <?= $guestBook['status_balasan'] == 'diterima' ? 'fa-check' : 'fa-times' ?> text-3xl <?= $guestBook['status_balasan'] == 'diterima' ? 'text-green-600' : 'text-red-600' ?>"></i>
                        </div>
                        <h4 class="text-2xl font-bold <?= $guestBook['status_balasan'] == 'diterima' ? 'text-green-600' : 'text-red-600' ?>">
                            <?= ucfirst($guestBook['status_balasan']) ?>
                        </h4>
                    </div>

                    <!-- Tanggal Balasan -->
                    <div class="border-t border-gray-200 pt-4">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Balasan</label>
                        <p class="text-gray-900 font-semibold">
                            <?= date('d/m/Y H:i', strtotime($guestBook['tanggal_balasan'])) ?>
                        </p>
                    </div>

                    <!-- Catatan Balasan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Catatan dari Admin</label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-800 whitespace-pre-wrap">
                                <?= esc($guestBook['catatan_balasan'] ?? '-') ?>
                            </p>
                        </div>
                    </div>

                    <!-- File Balasan -->
                    <?php if (!empty($guestBook['file_balasan'])): ?>
                        <div class="border-t border-gray-200 pt-4">
                            <label class="block text-sm font-medium text-gray-600 mb-2">File Surat Balasan</label>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 rounded-lg p-3">
                                        <i class="fas fa-file-download text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Surat Balasan</p>
                                        <p class="text-xs text-gray-600">Format: <?= strtoupper(pathinfo($guestBook['file_balasan'], PATHINFO_EXTENSION)) ?></p>
                                    </div>
                                </div>
                                <a href="/uploads/balasan_surat/<?= esc($guestBook['file_balasan']) ?>" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    <i class="fas fa-download mr-2"></i>Download
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="bg-yellow-50 rounded-lg p-6 inline-block">
                        <div class="text-6xl mb-4 text-yellow-600">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h4 class="text-xl font-bold text-yellow-800 mb-2">Menunggu Balasan</h4>
                        <p class="text-yellow-700 text-sm max-w-xs">
                            Surat Anda masih dalam proses. Admin akan memberikan balasan secepatnya. Silakan kembali mengecek status nanti.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
