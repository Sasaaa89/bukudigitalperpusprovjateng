<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Rating Layanan</h1>
        <p class="text-gray-600">Berikan rating untuk layanan perpustakaan</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/form/feedback" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="token" value="<?= isset($token) ? $token : '' ?>">
        
        <?php if (!empty($fields)): ?>
            <?php foreach ($fields as $field): ?>
                <div>
                    <label for="<?= $field['field_name'] ?>" class="block text-sm font-medium text-gray-700 mb-2">
                        <?= esc($field['field_label']) ?>
                        <?php if ($field['is_required']): ?>
                            <span class="text-red-500">*</span>
                        <?php endif; ?>
                    </label>
                    
                    <?php if ($field['field_type'] === 'text'): ?>
                        <input type="text" 
                               id="<?= $field['field_name'] ?>" 
                               name="<?= $field['field_name'] ?>" 
                               <?= $field['is_required'] ? 'required' : '' ?>
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan <?= strtolower($field['field_label']) ?>">
                    
                    <?php elseif ($field['field_type'] === 'email'): ?>
                        <input type="email" 
                               id="<?= $field['field_name'] ?>" 
                               name="<?= $field['field_name'] ?>" 
                               <?= $field['is_required'] ? 'required' : '' ?>
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan <?= strtolower($field['field_label']) ?>">
                    
                    <?php elseif ($field['field_type'] === 'number'): ?>
                        <input type="number" 
                               id="<?= $field['field_name'] ?>" 
                               name="<?= $field['field_name'] ?>" 
                               <?= $field['is_required'] ? 'required' : '' ?>
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan <?= strtolower($field['field_label']) ?>">
                    
                    <?php elseif ($field['field_type'] === 'date'): ?>
                        <input type="date" 
                               id="<?= $field['field_name'] ?>" 
                               name="<?= $field['field_name'] ?>" 
                               <?= $field['is_required'] ? 'required' : '' ?>
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    
                    <?php elseif ($field['field_type'] === 'textarea'): ?>
                        <textarea id="<?= $field['field_name'] ?>" 
                                  name="<?= $field['field_name'] ?>" 
                                  rows="4"
                                  <?= $field['is_required'] ? 'required' : '' ?>
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Masukkan <?= strtolower($field['field_label']) ?>"></textarea>
                    
                    <?php elseif ($field['field_type'] === 'select'): ?>
                        <select id="<?= $field['field_name'] ?>" 
                                name="<?= $field['field_name'] ?>" 
                                <?= $field['is_required'] ? 'required' : '' ?>
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih <?= strtolower($field['field_label']) ?></option>
                            
                            <?php if ($field['field_options'] === 'keperluan_table'): ?>
                                <?php foreach ($keperluan as $item): ?>
                                    <option value="<?= esc($item['nama_keperluan']) ?>"><?= esc($item['nama_keperluan']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php 
                                $options = json_decode($field['field_options'], true) ?: [];
                                foreach ($options as $option): 
                                ?>
                                    <option value="<?= esc($option) ?>"><?= esc($option) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    
                    <?php elseif ($field['field_type'] === 'file'): ?>
                        <div class="relative">
                            <input type="file" 
                                   id="<?= $field['field_name'] ?>" 
                                   name="<?= $field['field_name'] ?>" 
                                   <?= $field['is_required'] ? 'required' : '' ?>
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.rtf,.odt,.ods,.odp,.jpg,.jpeg,.png,.gif,.bmp,.svg,.webp,.zip,.rar,.7z"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, PNG, ZIP (Max: 20MB)
                            </p>
                        </div>
                    
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-8">
                <i class="fas fa-exclamation-circle text-yellow-500 text-4xl mb-4"></i>
                <p class="text-gray-600">Form belum dikonfigurasi. Silakan hubungi administrator.</p>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($fields)): ?>
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="<?= isset($token) && $token ? '/form?token='.$token : '/welcome' ?>" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Rating
                </button>
            </div>
        <?php endif; ?>
    </form>
</div>
<?= $this->endSection() ?>