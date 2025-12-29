# DOKUMENTASI PROJECT - SISTEM LAYANAN PENGUNJUNG PERPUSTAKAAN

## 📋 DESKRIPSI PROJECT

### Overview
Sistem Layanan Pengunjung Perpustakaan adalah aplikasi web berbasis CodeIgniter 4 yang dirancang untuk mengelola dan merekam kunjungan pengunjung perpustakaan secara digital. Sistem ini menggantikan buku tamu fisik dengan solusi digital yang lebih efisien, terintegrasi dengan teknologi QR Code untuk memudahkan akses pengunjung.

### Tujuan Project
- **Digitalisasi Pencatatan**: Mengubah sistem pencatatan manual menjadi digital
- **Efisiensi Data**: Mempermudah admin dalam mengelola dan menganalisis data pengunjung
- **Aksesibilitas**: Memudahkan pengunjung mengisi form melalui scan QR Code
- **Feedback Management**: Mengumpulkan kritik dan saran untuk peningkatan layanan perpustakaan

### Target Pengguna
1. **Admin Perpustakaan**: Mengelola data pengunjung, melihat statistik, generate QR Code
2. **Pengunjung Perpustakaan**: Mengisi buku tamu dan memberikan kritik/saran

### Lingkungan Deployment
- **Development**: Localhost (localhost:8080)
- **Production**: LAN Perpustakaan (WiFi lokal dengan IP statis)
- **Database**: MySQL 8.4.3 pada port 3307
- **PHP**: Version 8.3.16
- **Framework**: CodeIgniter 4.6.3

---

## 🎯 FITUR UTAMA

### 1. **Autentikasi Admin**
- Login dengan username dan password
- Session management dengan filter adminauth
- Logout functionality
- **Kredensial Default**: 
  - Username: `admin`
  - Password: `adminperpusdajateng`

### 2. **Dashboard Admin**
- **Statistik Real-time**:
  - Total Kritik & Saran
  - Total Buku Tamu
  - Data harian (daily count)
- **Recent Entries**: 5 data terakhir dari feedback dan guest book
- **Chart Data API**: Endpoint untuk visualisasi data (belum diimplementasi di frontend)

### 3. **QR Code Management**
- **Generate QR Code**:
  - Membuat token unik untuk setiap QR
  - Hanya 1 QR aktif dalam satu waktu
  - QR lama otomatis dinonaktifkan saat generate baru
  - QR berukuran 80x80px di admin page
- **Print QR**:
  - Tampilan print-friendly dengan QR 256x256px
  - Instruksi cara penggunaan
  - Informasi token dan timestamp
- **Download PDF**:
  - QR Code dalam format PDF A4
  - Size: 300x300px
  - Layout profesional dengan border
  - Instruksi lengkap untuk pengunjung
  - URL manual untuk akses tanpa QR

### 4. **Form Dinamis (Form Builder)**
- **Dynamic Field Configuration**:
  - Tipe field: text, textarea, email, number, date, select, file
  - Pengaturan required/optional per field
  - Sort order untuk urutan tampilan
  - Active/inactive toggle
- **Form Types**:
  - Feedback (Kritik & Saran)
  - Guest Book (Buku Tamu)
- **CRUD Operations**: Create, Read, Update, Delete form fields
- **Drag & Drop Reorder**: Update urutan field dengan AJAX

### 5. **Formulir Pengunjung**
- **Kritik & Saran**:
  - Field dinamis sesuai konfigurasi admin
  - Support file upload (optional)
  - Validasi real-time
  - Redirect ke thank you page setelah submit
- **Buku Tamu**:
  - Field dinamis + dropdown keperluan
  - Support file upload (optional)
  - Validasi real-time
  - Capture IP address dan user agent

### 6. **File Upload System**
- **Security Features**:
  - Maximum file size: 20MB
  - Allowed extensions: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, RTF, ODS, ODP, JPG, PNG, GIF, ZIP, RAR, 7Z
  - MIME type validation menggunakan finfo
  - Random filename generation (timestamp + random string)
  - Directory traversal protection
- **Storage**: `writable/uploads/` directory
- **Metadata Tracking**:
  - Original filename
  - Saved filename
  - Extension
  - File size
  - MIME type
  - Upload timestamp

### 7. **Data Management**
- **Feedback Management**:
  - List view dengan pagination
  - Detail view dengan semua field
  - Download uploaded files
  - Delete functionality
  - JSON storage untuk flexible schema
- **Guest Book Management**:
  - List view dengan pagination
  - Detail view dengan semua field
  - Download uploaded files
  - Delete functionality
  - JSON storage untuk flexible schema

### 8. **Keperluan Management**
- CRUD operations untuk master data keperluan kunjungan
- Contoh: Membaca, Meminjam Buku, Mencari Referensi, dll
- Active/inactive status

### 9. **Riwayat/History (Placeholder)**
- Menu untuk tracking historical data
- Belum diimplementasi fully

---

## 🏗️ ARSITEKTUR SISTEM

### Database Schema
```
admins
├── id (PK)
├── username (UNIQUE)
├── password (hashed)
├── nama_lengkap
├── email
└── timestamps

qr_tokens
├── id (PK)
├── token (UNIQUE)
├── is_active
├── created_by (FK -> admins.id)
└── timestamps

feedback
├── id (PK)
├── form_data (JSON)
├── ip_address
├── user_agent
└── timestamps

guest_book
├── id (PK)
├── form_data (JSON)
├── ip_address
├── user_agent
└── timestamps

form_fields
├── id (PK)
├── form_type (enum: feedback, guest_book)
├── field_name
├── field_label
├── field_type (enum: text, textarea, select, file, email, number, date)
├── is_required
├── field_options (TEXT)
├── sort_order
├── is_active
└── timestamps

keperluan
├── id (PK)
├── nama_keperluan
├── deskripsi
├── is_active
└── timestamps
```

### MVC Structure
```
Controllers/
├── FormController.php         -> Public forms
└── Admin/
    ├── AuthController.php      -> Login/Logout
    ├── DashboardController.php -> Stats & overview
    ├── QrController.php        -> QR generation & PDF
    ├── FeedbackController.php  -> Feedback CRUD
    ├── GuestBookController.php -> Guest book CRUD
    ├── FormBuilderController.php -> Dynamic form config
    ├── KeperluanController.php -> Keperluan master data
    ├── FileController.php      -> Secure file download
    └── RiwayatController.php   -> History (placeholder)

Models/
├── AdminModel.php              -> Admin authentication
├── QrTokenModel.php            -> QR token management
├── FeedbackModel.php           -> Feedback data + statistics
├── GuestBookModel.php          -> Guest book data + statistics
├── FormFieldModel.php          -> Dynamic form configuration
└── KeperluanModel.php          -> Keperluan master data

Views/
├── layouts/
│   ├── admin.php               -> Admin template (sidebar, navbar)
│   └── public.php              -> Public template (minimal)
├── admin/                      -> Admin panel views
└── public/                     -> Public-facing views
```

### Routing
```
/                              -> Redirect to /admin/login
/welcome                       -> Landing page (pilih form)
/form/feedback                 -> Feedback form
/form/guest-book               -> Guest book form
/thank-you                     -> Success page

/admin/login                   -> Admin login
/admin/logout                  -> Admin logout
/admin/dashboard               -> Dashboard (protected)
/admin/generate-qr             -> QR management
/admin/feedback                -> Feedback list
/admin/guest-book              -> Guest book list
/admin/form-builder            -> Form configuration
/admin/keperluan               -> Keperluan management
/qr/{token}                    -> QR image (PNG)
```

---

## 🔐 SECURITY FEATURES

1. **Authentication & Authorization**:
   - Session-based authentication
   - AdminAuthFilter untuk protect routes
   - Password hashing dengan bcrypt

2. **File Upload Security**:
   - Extension whitelist
   - MIME type validation
   - File size limitation (20MB)
   - Random filename generation
   - Directory traversal protection

3. **Database Security**:
   - Prepared statements (CodeIgniter Query Builder)
   - JSON encoding untuk user input
   - Foreign key constraints

4. **Input Validation**:
   - Server-side validation
   - HTML escaping dengan esc()
   - XSS protection via CodeIgniter

---

## 📦 DEPENDENCIES

### Composer Packages
```json
{
  "endroid/qr-code": "^6.0",        // QR Code generation
  "dompdf/dompdf": "^3.1",          // PDF generation
  "phpoffice/phpspreadsheet": "^5.1" // Excel export (future)
}
```

### Frontend
- **Tailwind CSS**: Utility-first CSS framework (via CDN)
- **Font Awesome**: Icon library (via CDN)
- **Vanilla JavaScript**: Form interactions, AJAX

---

## 🚀 DEPLOYMENT GUIDE

### Requirements
- PHP 8.1+
- MySQL 8.0+
- Composer
- PHP Extensions: intl, mbstring, json, mysqlnd, gd

### Installation Steps
1. Clone repository
2. `composer install`
3. Copy `.env` dan configure database
4. `php spark migrate`
5. `php spark db:seed AdminSeeder`
6. `php spark db:seed KeperluanSeeder`
7. `php spark db:seed FormFieldsSeeder`

### Development
```bash
php spark serve
```
Akses: http://localhost:8080

### Production (LAN)
```bash
php spark serve --host=0.0.0.0 --port=8080
```
Akses: http://{IP_ADDRESS}:8080

**PENTING**: Update `base_url()` di `.env` dengan IP LAN untuk QR Code URL

---

## 📊 DATA FLOW

### Form Submission Flow
```
Pengunjung -> Scan QR -> /welcome -> Pilih Form ->
Isi Data + Upload File (Optional) -> Validate ->
Save to DB (JSON + Files) -> /thank-you
```

### Admin View Flow
```
Admin -> Login -> Dashboard (Stats) ->
Menu (Feedback/Guest Book) -> List View ->
Detail View -> Download Files
```

### QR Generation Flow
```
Admin -> Generate QR -> Deactivate Old Tokens ->
Create New Token -> Store in DB -> Display QR ->
Print/Download PDF
```

---

## 🎨 UI/UX FEATURES

### Admin Panel
- **Sidebar Navigation**: Fixed sidebar dengan menu icons
- **Responsive Design**: Mobile-friendly admin panel
- **Color Scheme**: Blue & Gray professional theme
- **Toast Notifications**: Flash messages untuk success/error
- **Modal Dialogs**: Konfirmasi delete

### Public Forms
- **Clean Layout**: Centered form dengan max-width
- **Validation Feedback**: Error messages in red box
- **Progress Indication**: Redirect ke thank you page
- **Mobile Optimized**: Touch-friendly form controls

---

## 📈 STATISTICS & REPORTING

### Dashboard Metrics
- Total Feedback (all time)
- Total Guest Book (all time)
- Daily Feedback Count
- Daily Guest Book Count

### Available Data
- IP Address tracking
- User Agent tracking
- Timestamp (created_at, updated_at)
- Form field data (dynamic JSON)
- File metadata (jika ada upload)

### Future Enhancement Potential
- Chart.js integration untuk visualisasi
- Date range filtering
- Export to Excel/PDF
- Advanced analytics (most common feedback, peak hours, etc.)

---

## 🔧 CONFIGURATION

### Environment Variables (.env)
```ini
CI_ENVIRONMENT = production

database.default.hostname = localhost
database.default.database = tamu_pengujung_db
database.default.username = root
database.default.password = 
database.default.port = 3307
```

### Key Configurations
- **Session Driver**: FileHandler (writable/session/)
- **Upload Directory**: writable/uploads/
- **Max Upload Size**: 20MB
- **Timezone**: UTC+00:00 (adjust as needed)

---

## 📝 CHANGELOG

### Version 1.0.0 (Current)
- ✅ Autentikasi admin dengan session
- ✅ Dashboard dengan statistik real-time
- ✅ QR Code generation dengan endroid/qr-code v6
- ✅ PDF export untuk print QR
- ✅ Dynamic form builder
- ✅ File upload dengan security validation
- ✅ Feedback & Guest Book management
- ✅ Secure file download
- ✅ Responsive admin panel
- ✅ Mobile-friendly public forms

---

**Dibuat untuk**: Perpustakaan Provinsi (Project Magang)  
**Developer**: Yafi Rizky  
**Framework**: CodeIgniter 4.6.3  
**Tanggal**: November 2025  
**Status**: Production Ready (dengan catatan - lihat ANALISA_KELEMAHAN.md)
