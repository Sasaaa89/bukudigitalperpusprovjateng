# 🏢 LAN Deployment Guide - "Set and Forget" Strategy

## 📋 Deployment Context

**Project Type:** Magang - Sistem Layanan Pengunjung Perpustakaan  
**Environment:** Internal LAN (No Internet Access)  
**Maintenance:** Zero maintenance after deployment  
**Users:** Internal staff + Library visitors (trusted network)  

---

## 🎯 Priorities for LAN-Only Deployment

### ✅ MUST HAVE (Critical for "Set and Forget")
1. **Robust error handling** - No technical errors shown to users
2. **Data validation** - Prevent corrupt data entry
3. **Automatic cleanup** - Session files, old tokens, temp files
4. **Soft deletes** - Recover from accidental deletions
5. **Database backup automation** - Daily auto-backup
6. **Hierarchical keperluan** - Manage 50+ items easily
7. **Comprehensive logging** - Debug issues after deployment
8. **Database indexes** - Performance stays good with data growth

### ❌ NOT NEEDED (External Security)
1. ~~CSRF protection~~ - Trusted internal network
2. ~~Rate limiting~~ - Limited known users
3. ~~Brute force protection~~ - Physical access controlled
4. ~~Advanced file malware scanning~~ - Trusted users only
5. ~~DDoS protection~~ - No external access
6. ~~API security~~ - No external APIs

---

## 🚀 Implementation Checklist

### Phase 1: Bulletproof Core (Week 1) - CRITICAL
**Goal:** System tidak crash walau ada error

- [ ] **Error Handling Framework**
  ```php
  // Wrap all critical operations in try-catch
  // Log errors, show friendly messages
  // Never expose technical details to users
  ```
  - Add global exception handler
  - Wrap database operations
  - Wrap file operations
  - Test: Submit invalid data, upload corrupt file
  - **Time: 4 hours**

- [ ] **Enhanced Data Validation**
  ```php
  // Type-specific validation for each field
  // Email format, phone format, length limits
  // Prevent SQL injection via input cleaning
  ```
  - Create validation rules builder
  - Add format validation (email, phone, etc)
  - Add length limits
  - Test: Try to break forms with weird input
  - **Time: 3 hours**

- [ ] **Database Transactions**
  ```php
  // All multi-step operations use transactions
  // Auto-rollback on error
  // Data integrity guaranteed
  ```
  - Wrap form submissions in transactions
  - Add rollback on failure
  - Test: Simulate database errors
  - **Time: 2 hours**

- [ ] **Soft Deletes Everywhere**
  ```php
  // Enable soft deletes on all models
  // deleted_at column on all tables
  // Admin can restore deleted items
  ```
  - Migration: Add deleted_at columns
  - Enable in all models
  - Add "Restore" UI
  - Test: Delete & restore data
  - **Time: 4 hours**

**Phase 1 Total: 13 hours (2 working days)**

---

### Phase 2: Self-Maintenance (Week 2) - CRITICAL
**Goal:** System cleans up after itself automatically

- [ ] **Automatic Session Cleanup**
  ```php
  // Cron job atau scheduled task
  // Delete session files older than 24 hours
  // Prevent writable/session/ from filling up
  ```
  - Create cleanup command
  - Windows Task Scheduler setup
  - Test: Let system run for days
  - **Time: 2 hours**

- [ ] **QR Token Expiration**
  ```php
  // Auto-deactivate tokens older than 30 days
  // Keep database clean
  // Prevent token table from growing infinitely
  ```
  - Add expiration check
  - Cleanup command for old tokens
  - Schedule daily
  - **Time: 2 hours**

- [ ] **File Upload Cleanup**
  ```php
  // Delete uploaded files from deleted submissions
  // Organize by date (Y/m/d folders)
  // Automatic archive after 1 year
  ```
  - Create file cleanup service
  - Check for orphaned files
  - Archive old files
  - **Time: 3 hours**

- [ ] **Database Auto-Backup**
  ```php
  // Daily backup at 2 AM
  // Keep last 30 days
  // Auto-delete older backups
  // Store in writable/backups/
  ```
  - Create backup command
  - mysqldump automation
  - Retention policy (30 days)
  - Test: Verify backup can restore
  - **Time: 3 hours**

**Phase 2 Total: 10 hours (1.5 working days)**

---

### Phase 3: Hierarchical Keperluan (Week 2) - HIGH
**Goal:** Manage 50+ keperluan items easily

- [ ] **Database Schema Update**
  ```sql
  ALTER TABLE keperluan ADD parent_id INT NULL;
  ALTER TABLE keperluan ADD level INT DEFAULT 0;
  ALTER TABLE keperluan ADD sort_order INT DEFAULT 0;
  ```
  - Create migration
  - Add foreign key constraints
  - Migrate existing data
  - **Time: 2 hours**

- [ ] **Model Enhancement**
  ```php
  // getHierarchy() method
  // getChildren() method
  // Check usage before delete
  ```
  - Update KeperluanModel
  - Add tree-building logic
  - Test: Create parent-child relationships
  - **Time: 3 hours**

- [ ] **Admin UI - Tree View**
  ```html
  <!-- Drag-and-drop reordering -->
  <!-- Collapsible parent categories -->
  <!-- Visual hierarchy -->
  ```
  - Create hierarchical view
  - Add Sortable.js for drag-drop
  - Test: Reorder categories
  - **Time: 4 hours**

- [ ] **Frontend - Grouped Dropdown**
  ```html
  <optgroup label="Buku Tamu">
    <option>Kedatangan Perusahaan</option>
  </optgroup>
  ```
  - Update form rendering
  - Filter by form type
  - Test: Select from grouped options
  - **Time: 2 hours**

**Phase 3 Total: 11 hours (1.5 working days)**

---

### Phase 4: Performance & UX (Week 3) - MEDIUM
**Goal:** System stays fast & users tidak bingung

- [ ] **Database Indexing**
  ```sql
  CREATE INDEX idx_created_at ON feedback(created_at);
  CREATE INDEX idx_ip_address ON feedback(ip_address);
  ```
  - Create index migration
  - Run on all main tables
  - Test: Query performance before/after
  - **Time: 1 hour**

- [ ] **Pagination**
  ```php
  // 20 items per page
  // Admin list views don't load 10,000 rows
  ```
  - Add to all list controllers
  - Update views with pager
  - Test: Navigate pages
  - **Time: 3 hours**

- [ ] **Dashboard Caching**
  ```php
  // Cache stats for 1 hour
  // Reduce database load
  ```
  - Add cache layer
  - Invalidate on new submission
  - Test: Dashboard load time
  - **Time: 2 hours**

- [ ] **Loading Indicators**
  ```javascript
  // Disable submit button on click
  // Show "Mengirim..." spinner
  // Prevent double-submit
  ```
  - Add JavaScript
  - Add spinner CSS
  - Test: Submit forms
  - **Time: 2 hours**

- [ ] **Field Help Text**
  ```sql
  ALTER TABLE form_fields ADD help_text TEXT;
  ALTER TABLE form_fields ADD placeholder VARCHAR(255);
  ```
  - Migration
  - Update form builder
  - Update form rendering
  - **Time: 2 hours**

- [ ] **Better Error Messages**
  ```php
  // Specific messages instead of generic
  // "Email tidak valid" vs "Terjadi kesalahan"
  ```
  - Update validation messages
  - Update user-facing errors
  - Test: Trigger various errors
  - **Time: 2 hours**

**Phase 4 Total: 12 hours (1.5 working days)**

---

### Phase 5: Admin Training & Documentation (Week 3) - HIGH
**Goal:** Staff dapat manage system sendiri

- [ ] **Admin User Guide (PDF)**
  - Login & navigation
  - Generate QR codes
  - View submissions
  - Manage keperluan
  - Export data
  - Basic troubleshooting
  - **Time: 4 hours**

- [ ] **Common Issues Guide**
  - "Form tidak muncul" → Check QR token active
  - "Dashboard lambat" → Run cleanup command
  - "Data hilang" → Check soft deletes, restore
  - "Upload gagal" → Check file size/type
  - **Time: 2 hours**

- [ ] **Backup & Restore Guide**
  - Where backups stored
  - How to restore manually
  - Emergency recovery steps
  - **Time: 2 hours**

**Phase 5 Total: 8 hours (1 working day)**

---

## 📊 Total Implementation Timeline

| Phase | Focus | Hours | Days |
|-------|-------|-------|------|
| Phase 1 | Bulletproof Core | 13 | 2 |
| Phase 2 | Self-Maintenance | 10 | 1.5 |
| Phase 3 | Hierarchical Keperluan | 11 | 1.5 |
| Phase 4 | Performance & UX | 12 | 1.5 |
| Phase 5 | Training & Docs | 8 | 1 |
| **TOTAL** | **Ready for LAN** | **54 hours** | **~7 days** |

---

## 🔧 Server Setup for LAN

### Windows Server Configuration

#### 1. Install Required Software
```powershell
# Install PHP 8.3
# Download from: https://windows.php.net/download/

# Install MySQL 8.4
# Download from: https://dev.mysql.com/downloads/mysql/

# Install Composer
# Download from: https://getcomposer.org/
```

#### 2. Configure PHP
```ini
; php.ini settings
upload_max_filesize = 20M
post_max_size = 25M
max_execution_time = 300
memory_limit = 256M
date.timezone = Asia/Jakarta

; Enable extensions
extension=mysqli
extension=pdo_mysql
extension=gd
extension=intl
extension=mbstring
extension=zip
```

#### 3. Setup MySQL
```sql
-- Create database
CREATE DATABASE tamu_pengujung_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Create user (change password!)
CREATE USER 'perpus_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON tamu_pengujung_db.* TO 'perpus_user'@'localhost';
FLUSH PRIVILEGES;
```

#### 4. Configure .env
```env
# Database
database.default.hostname = localhost
database.default.database = tamu_pengujung_db
database.default.username = perpus_user
database.default.password = StrongPassword123!
database.default.DBDriver = MySQLi
database.default.port = 3306

# App
CI_ENVIRONMENT = production

# Session
app.sessionDriver = files
app.sessionSavePath = writable/session

# Base URL (ganti dengan IP LAN server)
app.baseURL = http://192.168.1.100/
```

#### 5. Run Migrations
```powershell
cd D:\path\to\pengunjung-perpustakaan
php spark migrate
php spark db:seed AdminSeeder
php spark db:seed FormFieldsSeeder
php spark db:seed KeperluanSeeder
```

#### 6. Setup Windows Task Scheduler
```powershell
# Daily Backup at 2 AM
schtasks /create /tn "Perpus Backup" /tr "D:\path\to\php.exe D:\path\to\spark backup:database" /sc daily /st 02:00

# Cleanup Old Sessions (Every 6 hours)
schtasks /create /tn "Perpus Cleanup Sessions" /tr "D:\path\to\php.exe D:\path\to\spark cleanup:sessions" /sc daily /mo 6

# Cleanup Old QR Tokens (Daily at 3 AM)
schtasks /create /tn "Perpus Cleanup Tokens" /tr "D:\path\to\php.exe D:\path\to\spark cleanup:tokens" /sc daily /st 03:00
```

#### 7. Setup IIS (Production Web Server)
```powershell
# Install IIS
Install-WindowsFeature -name Web-Server -IncludeManagementTools

# Create website
New-WebSite -Name "Perpustakaan" -Port 80 -PhysicalPath "D:\path\to\pengunjung-perpustakaan\public"

# Configure URL Rewrite
# Install URL Rewrite module
# Import web.config rules
```

---

## 🛡️ Security Notes for LAN

### What's Safe to Skip (Internal Network Only)

1. **HTTPS/SSL** - Not critical for internal LAN
   - LAN traffic already secured by physical network
   - Can use HTTP without concern
   - Optional: Use if AD/LDAP integration needed

2. **CSRF Tokens** - Not needed for trusted network
   - All users are internal staff/visitors
   - Physical access controlled
   - Session-based auth sufficient

3. **Rate Limiting** - Not needed for limited users
   - Maximum ~100 concurrent users (perpustakaan visitors)
   - Network bandwidth managed by router
   - No bot/spam attacks possible

4. **Advanced File Scanning** - Basic validation enough
   - Trusted users only
   - No email/external file sources
   - MIME + extension check sufficient

### What's STILL Important (Even in LAN)

1. **Password Hashing** - YES, still use bcrypt
2. **SQL Injection Prevention** - YES, always use prepared statements
3. **XSS Prevention** - YES, always escape output
4. **File Upload Validation** - YES, check size/type
5. **Session Management** - YES, proper timeout & cleanup
6. **Access Control** - YES, admin vs public routes

---

## 📝 Automated Maintenance Commands

Create these Spark commands for automated tasks:

### 1. Database Backup
```php
// app/Commands/BackupDatabase.php
php spark backup:database
// Creates: writable/backups/backup_YYYY-MM-DD_HHMMSS.sql
// Keeps last 30 days only
```

### 2. Session Cleanup
```php
// app/Commands/CleanupSessions.php
php spark cleanup:sessions
// Deletes session files older than 24 hours
```

### 3. QR Token Cleanup
```php
// app/Commands/CleanupTokens.php
php spark cleanup:tokens
// Deactivates tokens older than 30 days
```

### 4. File Cleanup
```php
// app/Commands/CleanupFiles.php
php spark cleanup:files
// Deletes orphaned upload files
// Archives files older than 1 year
```

### 5. System Health Check
```php
// app/Commands/HealthCheck.php
php spark system:health
// Checks:
// - Database connection
// - Disk space
// - File permissions
// - Last backup date
// - Session folder size
```

---

## 🚨 Emergency Recovery Guide

### Database Corrupted
```powershell
# 1. Stop web server
iisreset /stop

# 2. Restore from backup
mysql -u root -p tamu_pengujung_db < writable/backups/backup_2025-11-27_020000.sql

# 3. Start web server
iisreset /start
```

### System Not Responding
```powershell
# 1. Check disk space
Get-PSDrive

# 2. Clear session files
Remove-Item "writable\session\*" -Force

# 3. Clear cache
Remove-Item "writable\cache\*" -Force -Recurse

# 4. Restart services
Restart-Service W3SVC
Restart-Service MySQL
```

### Admin Forgot Password
```powershell
# Reset admin password via command line
php spark admin:reset-password admin NewPassword123!
```

---

## ✅ Pre-Deployment Checklist

### Configuration
- [ ] .env configured with production database
- [ ] baseURL set to LAN IP address
- [ ] CI_ENVIRONMENT = production
- [ ] File permissions set (writable/ folders)
- [ ] Database created & migrated
- [ ] Admin account created
- [ ] Sample data seeded (keperluan, form_fields)

### Automated Tasks
- [ ] Daily backup scheduled (2 AM)
- [ ] Session cleanup scheduled (every 6 hours)
- [ ] Token cleanup scheduled (daily 3 AM)
- [ ] Health check scheduled (daily 4 AM)

### Testing
- [ ] QR code generation works
- [ ] Forms submit successfully
- [ ] Admin login works
- [ ] Dashboard loads
- [ ] File upload works
- [ ] Data export works (Excel)
- [ ] Soft delete & restore works
- [ ] Error pages show friendly messages

### Documentation
- [ ] Admin user guide created
- [ ] Troubleshooting guide created
- [ ] Backup/restore guide created
- [ ] Contact info for emergency

### Training
- [ ] Admin staff trained
- [ ] Backup procedure demonstrated
- [ ] Common issues reviewed
- [ ] Emergency contacts exchanged

---

## 📞 Handover to Perpustakaan Staff

### What Staff Need to Know

1. **Daily Operations** (No maintenance needed!)
   - System auto-cleans itself
   - Backups run automatically
   - Just use normally

2. **Monthly Tasks** (Optional)
   - Check disk space: `Get-PSDrive`
   - Verify last backup exists
   - Review submission data for issues

3. **Emergency Contacts**
   - IT Department: [Phone]
   - Database Admin: [Phone]
   - Your Contact (for urgent only): [Phone]

4. **Common Questions**
   - Q: Dashboard lambat?  
     A: Run `php spark cleanup:sessions`
   
   - Q: QR code expired?  
     A: Generate new QR di admin panel
   
   - Q: Butuh export data?  
     A: Dashboard > Export > Pilih range tanggal
   
   - Q: Data terhapus by mistake?  
     A: Admin panel > Trash > Restore

---

## 🎓 Success Criteria

System ready for "Set and Forget" jika:

✅ **Reliability**
- Forms submit tanpa error 100% of time
- Database tidak pernah corrupt
- System auto-recover dari minor issues

✅ **Maintainability**
- Zero manual intervention needed
- Automatic backups working
- Automatic cleanup working
- Logs tersedia untuk debugging

✅ **Usability**
- Staff dapat manage tanpa technical knowledge
- Error messages jelas & actionable
- Documentation lengkap & mudah dipahami

✅ **Performance**
- Dashboard load < 2 seconds
- Form submit < 1 second
- Works dengan 100+ concurrent users
- Performance consistent setelah 1 tahun data

✅ **Data Integrity**
- Tidak ada data loss
- Soft delete works
- Restore works
- Validation prevents corrupt data

---

## 🎯 Post-Deployment Monitoring (First Month Only)

Week 1: Daily checks
- Error logs: Cek 1x per hari
- Form submissions: Verify data masuk dengan benar
- Performance: Dashboard load time

Week 2-4: Weekly checks
- Backup verification: Restore 1 backup untuk test
- Disk space: Ensure tidak penuh
- User feedback: Ada issues yang dilaporkan?

After Month 1: **Zero maintenance required!**
- System runs autonomously
- Staff handle via admin panel
- Only contact IT if major issue

---

## 💡 Final Notes

Dengan implementasi di atas, sistem ini akan:

1. ✅ **Reliable** - Tidak crash walau ada error
2. ✅ **Self-maintaining** - Cleanup otomatis
3. ✅ **User-friendly** - Staff dapat manage sendiri
4. ✅ **Performant** - Tetap cepat dengan banyak data
5. ✅ **Recoverable** - Backup & soft delete
6. ✅ **Scalable** - Handle growth tanpa issue

**Total effort:** ~7 hari kerja full-time (54 jam)

Setelah itu, Anda dapat handover dengan tenang karena sistem **tidak butuh maintenance** dan staff dapat handle sendiri dengan dokumentasi yang disediakan.
