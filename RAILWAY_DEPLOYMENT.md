# Panduan Deployment ke Railway

## Langkah-Langkah Deployment

### 1. Buat Akun Railway
1. Kunjungi https://railway.app
2. Daftar menggunakan GitHub (Sasaaa89)
3. Verify email

### 2. Buat Proyek Railway
1. Klik "New Project"
2. Pilih "Deploy from GitHub"
3. Authorize Railway untuk akses repository
4. Pilih repository: `bukudigitalperpusprojateng`
5. Railway akan mendeteksi CodeIgniter 4

### 3. Setup Database MySQL
1. Di Railway Dashboard, klik "Add Service"
2. Pilih "MySQL"
3. Konfigurasi:
   - Database Name: `tamu_pengunjung_db`
   - Biarkan hostname, user, password dari Railway generate otomatis

### 4. Configure Environment Variables
Tambahkan di Railway Dashboard:

```
CI_ENVIRONMENT=production
APP_NAME=Perpustakaan Pengunjung
APP_URL=https://your-railway-domain.railway.app
ENCRYPTION_KEY=your-random-32-char-encryption-key

DATABASE_URL=mysql_host_dari_railway
DB_NAME=tamu_pengunjung_db
DB_USERNAME=root
DB_PASSWORD=password_dari_railway
```

### 5. Jalankan Migrations
Setelah deployment berhasil:

```bash
railway exec php spark migrate
```

### 6. Seed Database (Opsional)
```bash
railway exec php spark db:seed KeperluanSeeder
railway exec php spark db:seed AdminSeeder
railway exec php spark db:seed FormFieldsSeeder
```

### 7. Verifikasi Deployment
1. Buka URL yang diberikan Railway
2. Test login admin panel
3. Test form submission
4. Test QR code scanning (akan berisi public URL)

## Important Notes

- QR Code akan otomatis menggunakan public URL Railway
- Real-time statistics polling akan bekerja dengan periode 10 detik
- Database akan persist dengan Railway's MySQL addon
- Semua file uploads akan disimpan di `/writable/uploads`

## Troubleshooting

### Error: "Database connection failed"
- Pastikan environment variables sudah benar
- Check Railway logs: `railway logs`

### Error: "Permission denied on writable folder"
- Railway akan auto-create writable folder dengan permission yang tepat

### QR Code tidak muncul
- Check environment variable `APP_URL` sudah sesuai dengan domain Railway

## Rollback
Jika ada masalah, Railway menyimpan versi sebelumnya. Cukup klik "Redeploy" dari previous version.
