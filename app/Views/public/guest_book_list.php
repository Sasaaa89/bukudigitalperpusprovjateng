<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <a href="/welcome" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-8 mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Status Surat Kunjungan Anda</h2>

    <!-- Search Form -->
    <form action="/search-guest-book" method="GET" class="mb-8">
        <div class="flex gap-2 max-w-md">
            <input 
                type="text" 
                name="nama" 
                value="<?= esc($searchNama) ?>"
                placeholder="Masukkan nama Anda..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required>
            <button 
                type="submit" 
                class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </div>
    </form>

    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i><?= esc($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($guestBooks)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Balasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($guestBooks as $index => $item): ?>
                        <?php 
                        $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $index + 1 ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?= esc($data['keperluan'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php if (!empty($item['status_balasan'])): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $item['status_balasan'] == 'diterima' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= ucfirst($item['status_balasan']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Balasan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if (!empty($item['status_balasan'])): ?>
                                    <a href="/guest-book/detail-balasan/<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye mr-1"></i>Lihat Balasan
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-700">
                <i class="fas fa-info-circle mr-2"></i>
                Total <?= count($guestBooks) ?> surat kunjungan ditemukan
            </p>
        </div>
    <?php elseif ($searchNama): ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
            <p class="font-semibold mb-2">Tidak Ada Data</p>
            <p class="text-sm">Silakan masukkan nama yang sesuai atau <?= anchor('/welcome', 'buat surat kunjungan baru') ?></p>
        </div>
    <?php else: ?>
        <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded-lg text-center">
            <p class="text-sm">Masukkan nama Anda di atas untuk melihat status surat kunjungan</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
