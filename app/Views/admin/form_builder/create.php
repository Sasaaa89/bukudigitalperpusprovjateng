<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/admin/form-builder" class="text-blue-600 hover:text-blue-800 mr-4">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Field Form</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" class="space-y-6">
            <div>
                <label for="form_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Form *</label>
                <select id="form_type" name="form_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Tipe Form</option>
                    <option value="feedback">Kritik & Saran</option>
                    <option value="guest_book">Buku Tamu</option>
                </select>
            </div>

            <div>
                <label for="field_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Field *</label>
                <input type="text" id="field_name" name="field_name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="contoh: nama_lengkap, email, pesan">
                <p class="text-xs text-gray-500 mt-1">Gunakan format snake_case (huruf kecil dengan underscore)</p>
            </div>

            <div>
                <label for="field_label" class="block text-sm font-medium text-gray-700 mb-2">Label Field *</label>
                <input type="text" id="field_label" name="field_label" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="contoh: Nama Lengkap, Email, Pesan">
            </div>

            <div>
                <label for="field_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Field *</label>
                <select id="field_type" name="field_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Tipe Field</option>
                    <option value="text">Text</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select/Dropdown</option>
                    <option value="file">File Upload</option>
                    <option value="email">Email</option>
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                </select>
            </div>

            <div id="optionsContainer" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Select</label>
                <div id="optionsList" class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <input type="text" name="field_options[]" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan opsi">
                        <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addOption()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-plus mr-1"></i>Tambah Opsi
                </button>
                <p class="text-xs text-gray-500 mt-1">Untuk field keperluan, gunakan "keperluan_table" sebagai opsi khusus</p>
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" id="sort_order" name="sort_order" min="0" value="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="0">
                <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin atas posisinya</p>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_required" value="1"
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Wajib Diisi</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="/admin/form-builder" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan
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