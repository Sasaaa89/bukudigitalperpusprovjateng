# TEST FORM SUBMISSION - DEBUGGING CHECKLIST

## CRITICAL: Server HARUS RESTART!

Server terakhir start: **1:57 PM** (sebelum fix file views)
Fix views: **2:05 PM** (setelah server start)

**Server TIDAK AKAN LOAD file baru sampai di-restart!**

## Step-by-Step Testing:

### 1. RESTART SERVER (WAJIB!)
```powershell
# Stop server yang running (tekan Ctrl+C di terminal php spark serve)
# ATAU kill process:
Stop-Process -Name php -Force

# Clear cache
Remove-Item "writable\cache\*" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item "writable\session\*" -Force -ErrorAction SilentlyContinue

# Start server baru
php spark serve
```

### 2. Test Form Feedback
1. Buka browser: `http://localhost:8080/welcome`
2. Klik "Kritik & Saran"
3. Isi form:
   - Nama Lengkap: Test User
   - Email: (kosongkan, optional)
   - Kritik & Saran: Ini adalah test kritik saran
   - Rating Layanan: Sangat Baik
4. Klik "Kirim Kritik & Saran"
5. EXPECTED: Redirect ke `/thank-you` dengan pesan sukses

### 3. Test Form Guest Book
1. Buka browser: `http://localhost:8080/welcome`
2. Klik "Buku Tamu"
3. Isi form:
   - Nama Lengkap: Test Tamu
   - Asal Instansi: Test Instansi
   - Keperluan: Membaca Buku
   - Nomor Telepon: (kosongkan, optional)
   - Pesan: (kosongkan, optional)
4. Klik "Kirim Buku Tamu"
5. EXPECTED: Redirect ke `/thank-you` dengan pesan sukses

### 4. Verify Database
```powershell
mysql -u root -h localhost -P 3307 -e "SELECT id, JSON_EXTRACT(form_data, '$.nama_lengkap') as nama, created_at FROM feedback ORDER BY id DESC LIMIT 3;" tamu_pengujung_db

mysql -u root -h localhost -P 3307 -e "SELECT id, JSON_EXTRACT(form_data, '$.nama_lengkap') as nama, created_at FROM guest_book ORDER BY id DESC LIMIT 3;" tamu_pengujung_db
```

### 5. Check Admin Dashboard
1. Login: `http://localhost:8080/admin/login`
   - Username: admin
   - Password: adminperpusdajateng
2. Klik menu "Kritik & Saran"
   - EXPECTED: Data test muncul
3. Klik menu "Buku Tamu"
   - EXPECTED: Data test muncul

### 6. Check Error Logs (jika masih error)
```powershell
Get-Content "writable\logs\log-2025-11-27.log" | Select-String -Pattern "CRITICAL|ERROR" -Context 5 | Select-Object -Last 10
```

## Known Issues Fixed:

✅ Undefined variable `$token` - FIXED dengan `isset($token) ? $token : ''`
✅ Routes.php lowercase HTTP methods - FIXED ke uppercase
✅ File upload blocking submission - FIXED jadi optional

## What to Look For:

### If form reloads without message:
- Validation failing silently
- Check validation rules in FormController
- Check error display in views

### If "Undefined variable" error:
- Server BELUM di-restart
- File views lama masih ter-cache

### If database empty after submit:
- Model insert() gagal
- Check log untuk database error
- Check migration apakah tabel ada

### If redirect tapi no message:
- Flash message tidak ter-set
- Session handler issue

## Debug Mode (Optional):

Tambahkan di FormController sebelum insert:
```php
// Debug: cek data sebelum insert
log_message('debug', 'Form Data: ' . json_encode($formData));
log_message('debug', 'Insert Data: ' . json_encode($data));

if ($this->feedbackModel->insert($data)) {
    log_message('debug', 'Insert SUCCESS - ID: ' . $this->feedbackModel->getInsertID());
    return redirect()->to('/thank-you')->with('success', 'Terima kasih atas kritik dan saran Anda!');
} else {
    log_message('error', 'Insert FAILED: ' . json_encode($this->feedbackModel->errors()));
    return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
}
```

## Emergency Rollback:

Jika masih tidak bisa, cek:
1. Permission folder `writable/uploads`
2. Database connection settings
3. Session configuration
4. PHP memory limit
