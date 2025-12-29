<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <a href="/admin/guest-book" class="text-blue-600 hover:text-blue-900">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Surat Kunjungan -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                <h3 class="text-xl font-bold">Surat Kunjungan dari Pengunjung</h3>
            </div>
            <div class="p-6">
                <?php 
                $data = is_string($guestBook['form_data']) ? json_decode($guestBook['form_data'], true) : $guestBook['form_data'];
                ?>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <p class="text-gray-900 font-semibold"><?= esc($data['nama_lengkap'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <p class="text-gray-900 font-semibold"><?= esc($data['nomor_telepon'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asal Instansi</label>
                        <p class="text-gray-900 font-semibold"><?= esc($data['asal_instansi'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                        <p class="text-gray-900 font-semibold"><?= esc($data['keperluan'] ?? '-') ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan</label>
                        <p class="text-gray-900 font-semibold"><?= $guestBook['tanggal_kunjungan'] ? date('d/m/Y', strtotime($guestBook['tanggal_kunjungan'])) : '-' ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan</label>
                        <p class="text-gray-900 font-semibold"><?= $guestBook['tanggal_pengajuan'] ? date('d/m/Y', strtotime($guestBook['tanggal_pengajuan'])) : '-' ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Laki-laki</label>
                        <p class="text-gray-900 font-semibold"><?= esc($data['jumlah_laki_laki'] ?? '0') ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Perempuan</label>
                        <p class="text-gray-900 font-semibold"><?= esc($data['jumlah_perempuan'] ?? '0') ?></p>
                    </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <p class="text-gray-900"><?= esc($data['keterangan'] ?? '-') ?></p>
                </div>

                <?php if (!empty($guestBook['file_kunjungan'])): ?>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Surat Kunjungan</label>
                        <a href="/uploads/<?= esc($guestBook['file_kunjungan']) ?>" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900">
                            <i class="fas fa-download mr-2"></i>Download File
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Form Balasan Surat -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-800 text-white p-6">
                <h3 class="text-xl font-bold">Balas Surat</h3>
            </div>
            <div class="p-6">
                <?php if (session()->has('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($guestBook['status_balasan'])): ?>
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                        <p class="font-semibold mb-2">Balasan Sudah Ada</p>
                        <p class="text-sm mb-2"><strong>Status:</strong> <?= ucfirst($guestBook['status_balasan']) ?></p>
                        <p class="text-sm mb-2"><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($guestBook['tanggal_balasan'])) ?></p>
                    </div>
                <?php endif; ?>

                <form action="/admin/guest-book/save-reply/<?= $guestBook['id'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label for="status_balasan" class="block text-sm font-medium text-gray-700 mb-2">Status Balasan *</label>
                        <select name="status_balasan" id="status_balasan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="diterima" <?= $guestBook['status_balasan'] === 'diterima' ? 'selected' : '' ?>>Diterima</option>
                            <option value="ditolak" <?= $guestBook['status_balasan'] === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="catatan_balasan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Balasan *</label>
                        <textarea name="catatan_balasan" id="catatan_balasan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan catatan atau alasan balasan..." required><?= old('catatan_balasan', $guestBook['catatan_balasan'] ?? '') ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter</p>
                    </div>

                    <div class="mb-6">
                        <label for="file_balasan" class="block text-sm font-medium text-gray-700 mb-2">
                            File Surat Balasan 
                            <?php if (!empty($guestBook['file_balasan'])): ?>
                                <span class="text-green-600 text-xs">(File saat ini: ada, upload ulang untuk menggantinya)</span>
                            <?php else: ?>
                                <span class="text-red-600">*</span>
                            <?php endif; ?>
                        </label>
                        <input type="file" name="file_balasan" id="file_balasan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" accept=".pdf,.doc,.docx" <?= empty($guestBook['file_balasan']) ? 'required' : '' ?>>
                        <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, atau DOCX (Maks 5 MB)</p>
                    </div>

                    <?php if (!empty($guestBook['file_balasan'])): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Saat Ini</label>
                            <a href="/uploads/balasan_surat/<?= esc($guestBook['file_balasan']) ?>" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900 text-sm">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-medium">
                            <i class="fas fa-save mr-2"></i>Simpan Balasan
                        </button>
                        <a href="/admin/guest-book" class="flex-1 bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 font-medium text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
