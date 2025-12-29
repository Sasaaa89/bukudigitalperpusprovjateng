<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Buku Tamu</h2>
    <div class="text-sm text-gray-600">
        Total: <?= count($guestBook) ?> entri
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instansi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Balasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($guestBook)): ?>
                    <?php foreach ($guestBook as $index => $item): ?>
                        <?php 
                        $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $index + 1 ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= esc($data['nama_lengkap'] ?? 'Tidak ada nama') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= esc($data['asal_instansi'] ?? '-') ?>
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
                                <a href="/admin/guest-book/view/<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <?php if (empty($item['status_balasan'])): ?>
                                    <a href="/admin/guest-book/reply/<?= $item['id'] ?>" class="text-green-600 hover:text-green-900 mr-3">
                                        <i class="fas fa-reply"></i> Balas
                                    </a>
                                <?php else: ?>
                                    <a href="/admin/guest-book/reply/<?= $item['id'] ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="/admin/guest-book/delete-reply/<?= $item['id'] ?>" 
                                       class="text-orange-600 hover:text-orange-900 mr-3"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus balasan ini?')">
                                        <i class="fas fa-trash"></i> Hapus Balasan
                                    </a>
                                <?php endif; ?>
                                <a href="/admin/guest-book/delete/<?= $item['id'] ?>" 
                                   class="text-red-600 hover:text-red-900"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data buku tamu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>