<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/admin/feedback" class="text-blue-600 hover:text-blue-800 mr-4">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Detail Kritik & Saran</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <?php 
        $data = is_string($feedback['form_data']) ? json_decode($feedback['form_data'], true) : $feedback['form_data'];
        ?>
        
        <!-- Header Info -->
        <div class="border-b border-gray-200 pb-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tanggal Kirim</h3>
                    <p class="text-lg text-gray-900"><?= date('d/m/Y H:i:s', strtotime($feedback['created_at'])) ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">IP Address</h3>
                    <p class="text-lg text-gray-900"><?= esc($feedback['ip_address']) ?></p>
                </div>
            </div>
        </div>

        <!-- Form Data -->
        <div class="space-y-6">
            <?php foreach ($data as $key => $value): ?>
                <?php if (!empty($value)): ?>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">
                            <?php
                            // Convert field names to readable labels
                            $labels = [
                                'nama_lengkap' => 'Nama Lengkap',
                                'email' => 'Email',
                                'kritik_saran' => 'Kritik & Saran',
                                'rating' => 'Rating Layanan',
                                'pesan' => 'Pesan',
                                'nomor_telepon' => 'Nomor Telepon',
                                'lampiran' => 'File Lampiran',
                                'dokumen' => 'Dokumen',
                                'file' => 'File'
                            ];
                            echo $labels[$key] ?? ucwords(str_replace('_', ' ', $key));
                            ?>
                        </h3>
                        
                        <?php if (is_array($value) && isset($value['saved_name'])): ?>
                            <!-- File upload display -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-100 rounded-lg p-3">
                                            <i class="fas fa-file text-blue-600 text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900"><?= esc($value['original_name']) ?></p>
                                            <p class="text-sm text-gray-600">
                                                <?= esc($value['extension']) ?> • 
                                                <?= number_format($value['file_size'] / 1024, 2) ?> KB •
                                                <?= $value['upload_date'] ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('admin/download-file/' . urlencode($value['saved_name'])) ?>" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200"
                                       download>
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        <?php elseif (is_array($value)): ?>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <pre class="text-sm text-gray-700"><?= esc(json_encode($value, JSON_PRETTY_PRINT)) ?></pre>
                            </div>
                        <?php elseif (strlen($value) > 100): ?>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap"><?= esc($value) ?></p>
                            </div>
                        <?php else: ?>
                            <p class="text-lg text-gray-900"><?= esc($value) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
            <a href="/admin/feedback" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
            
            <a href="/admin/feedback/delete/<?= $feedback['id'] ?>" 
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                <i class="fas fa-trash mr-2"></i>Hapus Data
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>