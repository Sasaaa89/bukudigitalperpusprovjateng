# Dokumentasi: Statistik Gender Pengunjung Real-Time

## Deskripsi Fitur

Sistem dashboard admin kini dilengkapi dengan fitur **statistik gender pengunjung real-time** yang menampilkan data pengunjung laki-laki dan perempuan per bulan dan per tahun dengan pembaruan otomatis.

## Fitur Utama

### 1. **Statistik Gender Card**
   - Menampilkan total pengunjung laki-laki dalam card di bagian atas dashboard
   - Menampilkan total pengunjung perempuan dalam card di bagian atas dashboard
   - Data diperbarui secara real-time tanpa reload halaman

### 2. **Grafik Per Bulan (Lifetime)**
   - Menampilkan statistik pengunjung laki-laki dan perempuan untuk setiap bulan
   - Format: Line chart dengan dual axis
   - Mencakup data dari semua tahun yang tersedia
   - Label: "Bulan Tahun" (contoh: "Januari 2024", "Februari 2024")

### 3. **Grafik Per Tahun**
   - Menampilkan statistik pengunjung laki-laki dan perempuan untuk setiap tahun
   - Format: Bar chart untuk perbandingan visual yang jelas
   - Otomatis menampilkan semua tahun yang ada data-nya

### 4. **Grafik Harian (Daily Visitor)**
   - Menampilkan breakdown harian pengunjung laki-laki vs perempuan
   - Format: Bar chart dengan dual axis
   - Membantu monitoring traffic harian

### 5. **Auto-Refresh Real-Time**
   - Dashboard secara otomatis mengambil data terbaru setiap **30 detik**
   - Update dilakukan melalui AJAX tanpa perlu reload halaman
   - Chart diperbarui dengan smooth animation-free update
   - Tidak mengganggu user experience

## Konfigurasi

### Mengubah Interval Refresh

Ubah nilai `REFRESH_INTERVAL` di file view dashboard (`app/Views/admin/dashboard/index.php`):

```javascript
// Default: 30000 ms (30 detik)
const REFRESH_INTERVAL = 30000; // dalam milliseconds

// Contoh untuk 60 detik:
// const REFRESH_INTERVAL = 60000;

// Contoh untuk 15 detik:
// const REFRESH_INTERVAL = 15000;
```

### Menonaktifkan Auto-Refresh

Tambahkan tombol toggle untuk disable/enable auto-refresh:

```javascript
// Toggle auto-refresh
autoRefreshEnabled = false; // Disable
autoRefreshEnabled = true;  // Enable
```

## API Endpoint

### GET `/admin/dashboard/get-gender-statistics`

**Deskripsi**: Mengambil data statistik gender terbaru dalam format JSON

**Response**:
```json
{
  "success": true,
  "timestamp": "2024-12-24 14:30:45",
  "visitorStats": {
    "laki_laki": 150,
    "perempuan": 120,
    "total": 270
  },
  "dailyVisitorStats": [
    {
      "date": "2024-12-24",
      "laki_laki": 10,
      "perempuan": 8
    }
  ],
  "monthlyVisitorStats": [
    {
      "year": "2024",
      "month": 1,
      "laki_laki": 45,
      "perempuan": 38
    }
  ],
  "yearlyVisitorStats": [
    {
      "year": "2024",
      "laki_laki": 150,
      "perempuan": 120
    }
  ],
  "feedbackStats": { ... },
  "guestBookStats": { ... }
}
```

## Data Source

Statistik menggunakan data dari tabel `guest_book` dengan field:
- `jumlah_laki_laki` - Disimpan dalam JSON field `form_data`
- `jumlah_perempuan` - Disimpan dalam JSON field `form_data`
- `created_at` - Timestamp penciptaan record

## Modifikasi yang Dilakukan

### 1. DashboardController
- Menambahkan method `getGenderStatistics()` untuk API endpoint
- Method ini mengembalikan JSON dengan semua statistik yang diperlukan

### 2. Dashboard View
- Menambahkan atribut `data-stat` pada card statistik untuk update real-time
- Menambahkan function `updateGenderStatisticsRealtime()` untuk AJAX polling
- Menambahkan function `updateAllCharts()` untuk update semua chart
- Menambahkan function `setupAutoRefresh()` untuk setup interval
- Mengubah variable dari `const` menjadi `let` untuk memungkinkan update

### 3. Routes
- Menambahkan route baru: `/admin/dashboard/get-gender-statistics`

## Teknologi yang Digunakan

- **Backend**: PHP CodeIgniter 4
- **Frontend**: Vanilla JavaScript dengan Fetch API
- **Chart Library**: Chart.js (sudah ada di project)
- **Update Method**: AJAX Polling (30 detik interval)

## Performa

- **Network Impact**: Minimal (request JSON ringan ~2KB per request)
- **Server Load**: Minimal (simple database query)
- **Browser Performance**: Baik (update tidak memblokir UI)
- **Memory Usage**: Stabil (chart update in-place tanpa recreation)

## Troubleshooting

### Chart tidak terupdate?
1. Pastikan browser console tidak ada error
2. Verifikasi endpoint `/admin/dashboard/get-gender-statistics` dapat diakses
3. Check network tab di browser DevTools

### Terlalu banyak request ke server?
- Tingkatkan `REFRESH_INTERVAL` (contoh: 60000 untuk 60 detik)

### Data tidak konsisten?
- Pastikan form submission mengirimkan `jumlah_laki_laki` dan `jumlah_perempuan` dalam form_data
- Check database structure di tabel `guest_book`

## Kontribusi & Development

Untuk menambah fitur atau modifikasi statistik:

1. Update method `getGenderStatistics()` di `DashboardController` jika perlu data tambahan
2. Update function `updateAllCharts()` di view jika ada chart baru
3. Sesuaikan styling dengan Tailwind CSS yang sudah ada

---

**Created**: 24 December 2024  
**Version**: 1.0  
**Status**: Production Ready
