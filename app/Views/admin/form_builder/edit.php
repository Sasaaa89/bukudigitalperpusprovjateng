<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/admin/form-builder?type=<?= $field['form_type'] ?>" class="text-blue-600 hover:text-blue-800 mr-4">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Field Form</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Form</label>
                <input type="text" value="<?= $field['form_type'] === 'feedback' ? 'Kritik & Saran' : 'Buku Tamu' ?>" disabled
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                <p class="text-xs text-gray-500 mt-1">Tipe form tidak dapat diubah</p>
            </div>

            <div>
                <label for="field_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Field *</label>
                <input type="text" id="field_name" name="field_name" required
                       value="<?= esc($field['field_name']) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="contoh: nama_lengkap, email, pesan">
                <p class="text-xs text-gray-500 mt-1">Gunakan format snake_case (huruf kecil dengan underscore)</p>
            </div>

            <div>
                <label for="field_label" class="block text-sm font-medium text-gray-700 mb-2">Label Field *</label>
                <input type="text" id="field_label" name="field_label" required
                       value="<?= esc($field['field_label']) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="contoh: Nama Lengkap, Email, Pesan">
            </div>

            <div>
                <label for="field_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Field *</label>
                <select id="field_type" name="field_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Tipe Field</option>
                    <option value="text" <?= $field['field_type'] === 'text' ? 'selected' : '' ?>>Text</option>
                    <option value="textarea" <?= $field['field_type'] === 'textarea' ? 'selected' : '' ?>>Textarea</option>
                    <option value="select" <?= $field['field_type'] === 'select' ? 'selected' : '' ?>>Select/Dropdown</option>
                    <option value="file" <?= $field['field_type'] === 'file' ? 'selected' : '' ?>>File Upload</option>
                    <option value="email" <?= $field['field_type'] === 'email' ? 'selected' : '' ?>>Email</option>
                    <option value="number" <?= $field['field_type'] === 'number' ? 'selected' : '' ?>>Number</option>
                    <option value="date" <?= $field['field_type'] === 'date' ? 'selected' : '' ?>>Date</option>
                </select>
            </div>

            <div id="optionsContainer" style="display: <?= $field['field_type'] === 'select' ? 'block' : 'none' ?>;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Select</label>
                <div id="optionsList" class="space-y-2">
                    <?php
                    $options = [];
                    if ($field['field_options'] === 'keperluan_table') {
                        $options = ['keperluan_table'];
                    } elseif ($field['field_options']) {
                        $options = json_decode($field['field_options'], true) ?: [];
                    }
                    
                    if (empty($options)) {
                        $options = [''];
                    }
                    ?>
                    
                    <?php foreach ($options as $option): ?>
                        <div class="flex items-center space-x-2">
                            <input type="text" name="field_options[]" 
                                   value="<?= esc($option) ?>"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Masukkan opsi">
                            <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addOption()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-plus mr-1"></i>Tambah Opsi
                </button>
                <p class="text-xs text-gray-500 mt-1">Untuk field keperluan, gunakan "keperluan_table" sebagai opsi khusus</p>
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" id="sort_order" name="sort_order" min="0" 
                       value="<?= $field['sort_order'] ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="0">
                <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin atas posisinya</p>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_required" value="1" <?= $field['is_required'] ? 'checked' : '' ?>
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Wajib Diisi</span>
                </label>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" <?= $field['is_active'] ? 'checked' : '' ?>
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="/admin/form-builder?type=<?= $field['form_type'] ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('field_type').addEventListener('change', function() {
    const optionsContainer = document.getElementById('optionsContainer');
    if (this.value === 'select') {
        optionsContainer.style.display = 'block';
    } else {
        optionsContainer.style.display = 'none';
    }
});

function addOption() {
    const optionsList = document.getElementById('optionsList');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
        <input type="text" name="field_options[]" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               placeholder="Masukkan opsi">
        <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    optionsList.appendChild(div);
}

function removeOption(button) {
    button.parentElement.remove();
}
</script>
<?= $this->endSection() ?>