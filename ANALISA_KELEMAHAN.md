# ANALISA KELEMAHAN & POTENSI BUG PROJECT

## 🚨 CRITICAL ISSUES (Harus Diperbaiki Sebelum Production)

### 1. **Form Submission Tidak Ada CSRF Protection**
**Lokasi**: `app/Views/public/feedback_form.php`, `app/Views/public/guest_book_form.php`

**Masalah**:
```php
<form method="POST" enctype="multipart/form-data">
    <!-- TIDAK ADA <?= csrf_field() ?> -->
```

**Dampak**:
- Vulnerable terhadap CSRF attack
- Form bisa di-submit dari external site
- Data bisa dimanipulasi oleh attacker

**Solusi**:
```php
<form method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <!-- rest of form -->
</form>
```

**Konfigurasi di `app/Config/Filters.php`**:
```php
public array $globals = [
    'before' => [
        'csrf',  // <- ENABLE INI
    ],
];
```

---

### 2. **Password Admin Lemah & Tidak Ada Reset Password**
**Lokasi**: `app/Database/Seeds/AdminSeeder.php`

**Masalah**:
```php
'password' => password_hash('adminperpusdajateng', PASSWORD_DEFAULT)
```

**Dampak**:
- Password default terlalu lemah
- Mudah ditebak (admin/adminperpusdajateng)
- Tidak ada fitur change password
- Tidak ada forgot password
- **WAJIB** diganti sebelum production

**Solusi Immediate**:
1. Ganti password di database dengan hash password yang kuat
2. Berikan password kompleks ke admin perpustakaan

**Solusi Long-term**:
- Tambah fitur change password di profile admin
- Minimum password length: 8 karakter
- Require alphanumeric + special char
- Password expiry policy

---

### 3. **Error Handling Tidak Informatif**
**Lokasi**: `app/Controllers/FormController.php`

**Masalah**:
```php
if ($this->feedbackModel->insert($data)) {
    return redirect()->to('/thank-you');
}
return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
// ^ Pesan error generic, tidak ada logging
```

**Dampak**:
- Admin tidak tahu kenapa form gagal submit
- Debug sulit karena no error details
- User hanya dapat pesan "Terjadi kesalahan"

**Solusi**:
```php
if ($this->feedbackModel->insert($data)) {
    log_message('info', 'Feedback submitted: ' . json_encode($formData));
    return redirect()->to('/thank-you');
}

// Log error detail
$error = $this->feedbackModel->errors();
log_message('error', 'Feedback insert failed: ' . json_encode($error));
return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan hubungi admin.');
```

---

### 4. **File Upload Tanpa Virus Scanning**
**Lokasi**: `app/Controllers/FormController.php` -> `handleFileUpload()`

**Masalah**:
- Hanya validasi MIME type dan extension
- TIDAK ada antivirus scanning
- File langsung disimpan ke server

**Dampak**:
- Bisa upload file berisi malware
- Server bisa terinfeksi
- Bisa jadi attack vector

**Solusi**:
```php
// Opsi 1: ClamAV integration
$clam = new ClamAV();
if (!$clam->scanFile($filePath)) {
    unlink($filePath);
    return ['success' => false, 'message' => 'File terdeteksi virus'];
}

// Opsi 2: VirusTotal API (untuk file < 32MB)
// Opsi 3: Disable file upload sama sekali (jika tidak critical)
```

**Rekomendasi**: Disable file upload jika tidak wajib, atau implement ClamAV scanning

---

### 5. **SQL Injection Potential di Dynamic Query**
**Lokasi**: `app/Models/FeedbackModel.php`, `GuestBookModel.php` -> `getStatistics()`

**Masalah**:
```php
public function getStatistics($startDate = null, $endDate = null)
{
    // Jika $startDate dan $endDate dari user input tanpa sanitasi
    $this->where('created_at >=', $startDate)  // Potential SQL injection
         ->where('created_at <=', $endDate);
}
```

**Dampak**:
- Jika parameter tidak di-escape, vulnerable to SQL injection
- CodeIgniter Query Builder seharusnya protect, tapi tetap risky

**Solusi**:
```php
public function getStatistics($startDate = null, $endDate = null)
{
    // Validate dan sanitize date input
    if ($startDate && !strtotime($startDate)) {
        $startDate = date('Y-m-d', strtotime('-30 days'));
    }
    if ($endDate && !strtotime($endDate)) {
        $endDate = date('Y-m-d');
    }
    
    // Use binding
    $this->where('created_at >=', $startDate)
         ->where('created_at <=', $endDate);
}
```

---

## ⚠️ HIGH PRIORITY ISSUES

### 6. **Session Fixation Vulnerability**
**Lokasi**: `app/Controllers/Admin/AuthController.php`

**Masalah**:
```php
public function login()
{
    // ... validate credentials ...
    session()->set([...]);  // <- Tidak regenerate session ID
    return redirect()->to('/admin/dashboard');
}
```

**Dampak**:
- Session ID bisa dicuri sebelum login
- Attacker bisa hijack session admin

**Solusi**:
```php
if ($admin) {
    session()->regenerate();  // <- TAMBAH INI
    session()->set([...]);
}
```

---

### 7. **File Download Path Traversal (Sudah Ada Protection Tapi Bisa Lebih Kuat)**
**Lokasi**: `app/Controllers/Admin/FileController.php`

**Masalah Potensial**:
```php
$filePath = WRITEPATH . 'uploads/' . $filename;
$realPath = realpath($filePath);

if (strpos($realPath, realpath(WRITEPATH . 'uploads')) !== 0) {
    // protection OK tapi bisa tambah check
}
```

**Improvement**:
```php
// Tambah whitelist filename pattern
if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $filename)) {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
}

// Tambah file existence check sebelum realpath
if (!file_exists($filePath)) {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
}
```

---

### 8. **No Rate Limiting pada Form Submission**
**Lokasi**: `app/Controllers/FormController.php`

**Masalah**:
- Tidak ada rate limiting
- Bisa spam submit form

**Dampak**:
- Database flooding
- Server overload
- Invalid data pollution

**Solusi**:
```php
// Opsi 1: Session-based throttle
if (session()->get('last_submit_time')) {
    $elapsed = time() - session()->get('last_submit_time');
    if ($elapsed < 60) {  // 1 menit cooldown
        return redirect()->back()->with('error', 'Tunggu 1 menit sebelum submit lagi');
    }
}
session()->set('last_submit_time', time());

// Opsi 2: IP-based throttle dengan cache
$cache = \Config\Services::cache();
$key = 'submit_' . $this->request->getIPAddress();
if ($cache->get($key)) {
    return redirect()->back()->with('error', 'Terlalu banyak request');
}
$cache->save($key, true, 60);  // 60 seconds
```

---

### 9. **JSON Storage Tanpa Schema Validation**
**Lokasi**: `app/Models/FeedbackModel.php`, `GuestBookModel.php`

**Masalah**:
```php
'form_data' => json_encode($formData)  // Tidak ada validation schema
```

**Dampak**:
- Data bisa inconsistent
- Hard to query
- Migration sulit kalau mau restructure

**Solusi**:
```php
// Validate structure sebelum save
$requiredKeys = ['nama', 'email', 'pesan'];
foreach ($requiredKeys as $key) {
    if (!isset($formData[$key])) {
        throw new \Exception("Missing required field: {$key}");
    }
}

// Atau gunakan JSON Schema validation
$validator = new JsonSchema\Validator();
$validator->validate($formData, $schema);
if (!$validator->isValid()) {
    // handle error
}
```

---

### 10. **File Upload Directory Permissions**
**Lokasi**: `writable/uploads/`

**Masalah Potensial**:
- Jika permissions 777, file PHP bisa dieksekusi
- Uploaded shell script bisa dijalankan

**Solusi**:
```bash
# Set correct permissions
chmod 755 writable/uploads/
chmod 644 writable/uploads/*

# Add .htaccess di uploads/
<Files *>
    Order Allow,Deny
    Deny from all
</Files>

<FilesMatch "\.(jpg|jpeg|png|gif|pdf|doc|docx)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>
```

**Di Controller**:
```php
// Disable PHP execution
if (pathinfo($filename, PATHINFO_EXTENSION) === 'php') {
    return ['success' => false, 'message' => 'PHP files not allowed'];
}
```

---

## ⚡ MEDIUM PRIORITY ISSUES

### 11. **QR Token Tidak Ada Expiration**
**Lokasi**: `app/Models/QrTokenModel.php`

**Masalah**:
- Token aktif selamanya
- Tidak ada auto-expire
- Security risk jika token leaked

**Solusi**:
```php
// Tambah column di migration
$this->forge->addColumn('qr_tokens', [
    'expires_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
]);

// Di QrTokenModel
public function generateNewToken($adminId)
{
    // ... deactivate old ...
    return $this->insert([
        'token' => bin2hex(random_bytes(16)),
        'is_active' => 1,
        'created_by' => $adminId,
        'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),  // <- Expire 30 hari
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}

// Validasi di FormController
public function index()
{
    $token = $this->request->getGet('token');
    $qrToken = $this->qrTokenModel
        ->where('token', $token)
        ->where('is_active', 1)
        ->where('expires_at >', date('Y-m-d H:i:s'))  // <- Check expiry
        ->first();
        
    if (!$qrToken) {
        return view('public/invalid_qr');
    }
}
```

---

### 12. **No Pagination Limit di List Views**
**Lokasi**: `app/Controllers/Admin/FeedbackController.php`, `GuestBookController.php`

**Masalah**:
```php
public function index()
{
    $feedback = $this->feedbackModel->findAll();  // Load SEMUA data!
    // ...
}
```

**Dampak**:
- Jika data ribuan, page lambat
- Memory overflow potential
- Poor UX

**Solusi**:
```php
public function index()
{
    $perPage = 20;
    $feedback = $this->feedbackModel->paginate($perPage);
    $pager = $this->feedbackModel->pager;
    
    return view('admin/feedback/index', [
        'feedback' => $feedback,
        'pager' => $pager,
    ]);
}

// Di view
<?= $pager->links() ?>
```

---

### 13. **No Soft Delete**
**Lokasi**: All Models

**Masalah**:
- Delete permanent
- Data tidak bisa di-restore
- No audit trail untuk deleted data

**Solusi**:
```php
// Di Model
use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    
    // Tambah column di migration
    $this->forge->addColumn('feedback', [
        'deleted_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ]);
}
```

---

### 14. **No Input Sanitization untuk XSS**
**Lokasi**: All form handling

**Masalah**:
```php
$formData[$fieldName] = $this->request->getPost($fieldName);
// ^ Langsung save tanpa sanitization
```

**Dampak**:
- XSS attack via stored input
- Jika di-display tanpa escape, execute malicious script

**Solusi**:
```php
// Di Controller
$formData[$fieldName] = esc($this->request->getPost($fieldName));

// Di View (SELALU)
<?= esc($data['nama']) ?>  // <- jangan lupa esc()
```

---

### 15. **Dashboard Statistics Query Tidak Optimal**
**Lokasi**: `app/Models/FeedbackModel.php`, `GuestBookModel.php`

**Masalah**:
```php
public function getStatistics()
{
    $total = $this->countAll();  // OK
    $daily = $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults();  // TIDAK OK
    // ^ Function DATE() di WHERE tidak bisa pakai index
}
```

**Dampak**:
- Slow query jika data banyak
- Full table scan

**Solusi**:
```php
public function getStatistics()
{
    $total = $this->countAll();
    
    // Gunakan range query yang bisa pakai index
    $startOfDay = date('Y-m-d 00:00:00');
    $endOfDay = date('Y-m-d 23:59:59');
    $daily = $this->where('created_at >=', $startOfDay)
                  ->where('created_at <=', $endOfDay)
                  ->countAllResults();
    
    return [
        'total' => $total,
        'daily' => $daily,
    ];
}
```

---

## 💡 LOW PRIORITY / NICE TO HAVE

### 16. **No Data Backup Strategy**
**Masalah**: Tidak ada automated backup

**Solusi**:
- Cron job untuk daily backup
- Export database ke cloud storage
- Point-in-time recovery

---

### 17. **No Email Notification**
**Masalah**: Admin tidak dapat notifikasi feedback baru

**Solusi**:
- Send email ke admin saat feedback masuk
- Configure `app/Config/Email.php`

---

### 18. **No Data Export Feature**
**Masalah**: Admin tidak bisa export data ke Excel/CSV

**Solusi**:
```php
// Sudah install phpspreadsheet, tinggal implement
public function export()
{
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    // ... populate data ...
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    // ... download ...
}
```

---

### 19. **No Search & Filter di List View**
**Masalah**: Susah cari data tertentu

**Solusi**:
- Tambah search box
- Filter by date range
- Filter by keperluan (untuk guest book)

---

### 20. **No Audit Log untuk Admin Actions**
**Masalah**: Tidak ada tracking admin activity

**Solusi**:
```php
// Create audit_logs table
// Log setiap action: login, generate QR, delete data, etc.
```

---

## 🔍 CODE QUALITY ISSUES

### 21. **Inconsistent Naming Convention**
```php
// Di Models
protected $table = 'feedback';  // singular
protected $table = 'guest_book';  // underscore

// Di Routes
$routes->get('guest-book', ...);  // dash
$routes->get('form-builder', ...);  // dash
$routes->get('generate-qr', ...);  // dash
```

**Rekomendasi**: Gunakan convention yang konsisten (snake_case untuk DB, kebab-case untuk URL)

---

### 22. **No Unit Tests**
**Masalah**: Tidak ada automated testing

**Dampak**:
- Regression bugs tidak terdeteksi
- Refactoring risky

**Solusi**:
- Implement PHPUnit tests untuk critical functions
- Test coverage minimal 70%

---

### 23. **Magic Numbers & Hardcoded Values**
```php
'size' => 300,  // QR size - should be config
20 * 1024 * 1024  // File size - should be constant
```

**Solusi**:
```php
// Di Config
class Upload
{
    public $maxSize = 20 * 1024 * 1024;
    public $allowedTypes = ['pdf', 'doc', 'docx', ...];
}

// Di Config/QrCode
class QrCode
{
    public $defaultSize = 300;
    public $printSize = 256;
}
```

---

### 24. **No Environment-Specific Configuration**
**Masalah**: Config hardcoded untuk localhost

**Solusi**:
```php
// Di .env
app.baseURL = 'http://localhost:8080'
app.qrBaseURL = 'http://localhost:8080'

// Production .env
app.baseURL = 'http://10.79.36.207:8080'
app.qrBaseURL = 'http://10.79.36.207:8080'

// Di Controller
$qrUrl = env('app.qrBaseURL') . '/welcome?token=' . $token;
```

---

### 25. **No API Rate Limiting untuk Chart Data**
**Lokasi**: `app/Controllers/Admin/DashboardController.php` -> `getChartData()`

**Masalah**: Endpoint bisa di-spam

**Solusi**: Implement throttle middleware

---

## 📊 PERFORMANCE ISSUES

### 26. **No Caching untuk Static Data**
**Masalah**: 
- Keperluan list di-query setiap request
- Form fields di-query setiap page load

**Solusi**:
```php
$cache = \Config\Services::cache();
$keperluan = $cache->remember('keperluan_list', 3600, function() {
    return $this->keperluanModel->where('is_active', 1)->findAll();
});
```

---

### 27. **N+1 Query Problem Potential**
**Lokasi**: Dashboard recent entries

**Masalah**: Jika ada relasi, bisa jadi N+1

**Solusi**: Eager loading jika ada relasi

---

### 28. **No Database Indexing Strategy**
**Masalah**: Tidak ada index selain PK

**Solusi**:
```php
// Tambah index untuk frequent queries
$this->forge->addKey('created_at');  // untuk date filtering
$this->forge->addKey('is_active');   // untuk status filtering
$this->forge->addKey(['form_type', 'is_active']);  // composite index
```

---

## 🎯 BUSINESS LOGIC ISSUES

### 29. **No Duplicate Submission Prevention**
**Masalah**: User bisa submit form yang sama berkali-kali

**Solusi**:
- Check duplicate berdasarkan IP + timestamp (dalam 5 menit)
- Atau require email unique per day

---

### 30. **No Data Retention Policy**
**Masalah**: Data tersimpan selamanya

**Solusi**:
- Auto-delete data lebih dari 1 tahun
- Archive old data
- GDPR compliance (jika applicable)

---

## 📋 SUMMARY PRIORITAS

### 🔴 CRITICAL (Fix Immediately)
1. CSRF Protection ⭐⭐⭐⭐⭐
2. Admin Password ⭐⭐⭐⭐⭐
3. Error Handling & Logging ⭐⭐⭐⭐
4. File Upload Virus Scanning ⭐⭐⭐⭐
5. SQL Injection Prevention ⭐⭐⭐⭐

### 🟠 HIGH (Fix Before Production)
6. Session Fixation ⭐⭐⭐
7. Path Traversal Enhancement ⭐⭐⭐
8. Rate Limiting ⭐⭐⭐
9. JSON Schema Validation ⭐⭐⭐
10. Upload Directory Security ⭐⭐⭐

### 🟡 MEDIUM (Fix dalam 1-2 Minggu)
11. QR Token Expiration ⭐⭐
12. Pagination ⭐⭐
13. Soft Delete ⭐⭐
14. XSS Sanitization ⭐⭐
15. Query Optimization ⭐⭐

### 🟢 LOW (Enhancement)
16-30: Nice to have features

---

**REKOMENDASI AKHIR**:
1. **Jangan deploy ke production sebelum fix CRITICAL issues**
2. **Conduct security audit dengan tools (OWASP ZAP, SonarQube)**
3. **Implement logging & monitoring**
4. **Setup automated backup**
5. **Create deployment checklist**

**Estimasi Waktu Perbaikan**:
- Critical Issues: 2-3 hari kerja
- High Priority: 3-5 hari kerja
- Medium Priority: 1-2 minggu

**Total**: ~3-4 minggu untuk production-ready yang aman.
