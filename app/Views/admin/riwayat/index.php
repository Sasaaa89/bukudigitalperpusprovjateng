<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Riwayat Pengunjung</h2>
    <div class="text-sm text-gray-600">
        Total: <?= count($riwayat) ?> entri
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Form</label>
            <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="all" <?= $currentType === 'all' ? 'selected' : '' ?>>Semua</option>
                <option value="feedback" <?= $currentType === 'feedback' ? 'selected' : '' ?>>Kritik & Saran</option>
                <option value="guest_book" <?= $currentType === 'guest_book' ? 'selected' : '' ?>>Buku Tamu</option>
            </select>
        </div>
        
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" value="<?= $startDate ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input type="date" id="end_date" name="end_date" value="<?= $endDate ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($riwayat)): ?>
                    <?php foreach ($riwayat as $index => $item): ?>
                        <?php 
                        $data = is_string($item['data']) ? json_decode($item['data'], true) : $item['data'];
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $index + 1 ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?= $item['type'] === 'feedback' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= $item['type_label'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= esc($data['nama_lengkap'] ?? 'Tidak ada nama') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php if ($item['type'] === 'feedback'): ?>
                                        <?php if (isset($data['kritik_saran'])): ?>
                                            <?= esc(substr($data['kritik_saran'], 0, 100)) ?><?= strlen($data['kritik_saran']) > 100 ? '...' : '' ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (isset($data['keperluan'])): ?>
                                            <span class="text-blue-600"><?= esc($data['keperluan']) ?></span>
                                            <?php if (isset($data['asal_instansi'])): ?>
                                                - <?= esc($data['asal_instansi']) ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if ($item['type'] === 'feedback'): ?>
                                    <a href="/admin/feedback/view/<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                <?php else: ?>
                                    <a href="/admin/guest-book/view/<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <?php if ($currentType !== 'all' || $startDate || $endDate): ?>
                                Tidak ada data yang sesuai dengan filter
                            <?php else: ?>
                                Belum ada riwayat pengunjung
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Summary Statistics -->
<?php if (!empty($riwayat)): ?>
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-comments text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kritik & Saran</p>
                    <p class="text-xl font-bold text-gray-900">
                        <?= count(array_filter($riwayat, function($item) { return $item['type'] === 'feedback'; })) ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-book-open text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Buku Tamu</p>
                    <p class="text-xl font-bold text-gray-900">
                        <?= count(array_filter($riwayat, function($item) { return $item['type'] === 'guest_book'; })) ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-chart-line text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Entri</p>
                    <p class="text-xl font-bold text-gray-900"><?= count($riwayat) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>