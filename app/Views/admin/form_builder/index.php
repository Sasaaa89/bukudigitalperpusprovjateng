<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Form Builder</h2>
        <p class="text-gray-600">Kelola field form dinamis untuk Kritik & Saran dan Buku Tamu</p>
    </div>
    <a href="/admin/form-builder/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
        <i class="fas fa-plus mr-2"></i>Tambah Field
    </a>
</div>

<!-- Form Type Tabs -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8 px-6">
            <a href="/admin/form-builder?type=feedback" 
               class="py-4 px-1 border-b-2 font-medium text-sm <?= $currentType === 'feedback' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
                <i class="fas fa-comments mr-2"></i>Kritik & Saran
            </a>
            <a href="/admin/form-builder?type=guest_book" 
               class="py-4 px-1 border-b-2 font-medium text-sm <?= $currentType === 'guest_book' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
                <i class="fas fa-book-open mr-2"></i>Buku Tamu
            </a>
        </nav>
    </div>
</div>

<!-- Fields List -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">
            Field Form <?= $currentType === 'feedback' ? 'Kritik & Saran' : 'Buku Tamu' ?>
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Field</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wajib</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="fieldsTable">
                <?php if (!empty($fields)): ?>
                    <?php foreach ($fields as $field): ?>
                        <tr class="hover:bg-gray-50" data-field-id="<?= $field['id'] ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-900"><?= $field['sort_order'] ?></span>
                                    <div class="ml-2 cursor-move text-gray-400">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($field['field_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= esc($field['field_label']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?= ucfirst($field['field_type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($field['is_required']): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Wajib</span>
                                <?php else: ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Opsional</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($field['is_active']): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                <?php else: ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/admin/form-builder/edit/<?= $field['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="/admin/form-builder/delete/<?= $field['id'] ?>" 
                                   class="text-red-600 hover:text-red-900"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus field ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada field untuk form <?= $currentType === 'feedback' ? 'Kritik & Saran' : 'Buku Tamu' ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Simple drag and drop for reordering (basic implementation)
document.addEventListener('DOMContentLoaded', function() {
    // This is a simplified version - in production, you'd use a library like SortableJS
    console.log('Form Builder loaded');
});
</script>
<?= $this->endSection() ?>