<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: A4;
            margin: 20mm;
            margin-bottom: 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 10px;
            color: #2c3e50;
            line-height: 1.4;
            background: white;
        }
        
        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1e40af;
        }
        
        .header-icon {
            font-size: 28px;
            margin-bottom: 8px;
        }
        
        .header h1 {
            font-size: 18px;
            color: #1e40af;
            font-weight: bold;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        
        .header h2 {
            font-size: 13px;
            color: #2563eb;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .header-meta {
            font-size: 9px;
            color: #666;
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 5px;
        }
        
        /* SECTION */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            border-left: 4px solid #1e40af;
            padding-left: 10px;
        }
        
        .section-header h3 {
            font-size: 11px;
            color: #1e40af;
            font-weight: bold;
            margin: 0;
        }
        
        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        th {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #1e40af;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        td {
            padding: 9px 8px;
            border: 1px solid #e5e7eb;
            font-size: 9px;
        }
        
        tbody tr {
            transition: background-color 0.2s;
        }
        
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        tbody tr:hover {
            background-color: #f0f6ff;
        }
        
        /* SUMMARY TABLE */
        .summary-table {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .summary-table td:first-child {
            font-weight: 600;
            background-color: #f8fafc;
        }
        
        .summary-table td:last-child {
            text-align: center;
            font-weight: 700;
            color: #1e40af;
            background-color: #f0f6ff;
        }
        
        .summary-table tr:last-child td {
            background-color: #dbeafe;
            font-size: 10px;
        }
        
        /* STAT GRID */
        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #f0f6ff 0%, #e0eeff 100%);
            border: 1px solid #1e40af;
            border-radius: 5px;
            padding: 12px;
            text-align: center;
        }
        
        .stat-label {
            font-size: 8px;
            color: #666;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
        }
        
        /* FOOTER */
        .footer {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 2px solid #e5e7eb;
            font-size: 8px;
            color: #999;
            text-align: center;
        }
        
        .footer p {
            margin: 3px 0;
        }
        
        /* PAGE BREAK */
        .page-break {
            page-break-before: always;
            margin-top: 0;
            padding-top: 20px;
        }
        
        /* UTILITIES */
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .mt-10 {
            margin-top: 10px;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>STATISTIK LENGKAP PENGUNJUNG</h1>
        <h2>PERPUSTAKAAN PROVINSI JAWA TENGAH</h2>
        <div class="header-meta">
            <span>Laporan: <?= $date ?></span>
            <span>Total Data: <?= $feedbackStats['total'] + $guestBookStats['total'] ?> Entri</span>
        </div>
    </div>

    <!-- RINGKASAN TOTAL -->
    <div class="section">
        <div class="section-header">
            <h3>RINGKASAN TOTAL</h3>
        </div>
        
        <div class="stat-grid">
            <div class="stat-box">
                <div class="stat-label">Kritik & Saran</div>
                <div class="stat-value"><?= $feedbackStats['total'] ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Buku Tamu</div>
                <div class="stat-value"><?= $guestBookStats['total'] ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pengunjung Laki-laki</div>
                <div class="stat-value" style="color: #3b82f6;"><?= $visitorStats['laki_laki'] ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pengunjung Perempuan</div>
                <div class="stat-value" style="color: #ec4899;"><?= $visitorStats['perempuan'] ?></div>
            </div>
        </div>
        
        <table class="summary-table">
            <tr>
                <td style="font-size: 11px;">TOTAL PENGUNJUNG KESELURUHAN</td>
                <td style="font-size: 14px;"><?= $visitorStats['total'] ?> Orang</td>
            </tr>
        </table>
    </div>

    <!-- STATISTIK BULANAN -->
    <div class="section mb-10">
        <div class="section-header">
            <h3>STATISTIK PENGUNJUNG PER BULAN (LIFETIME)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Bulan</th>
                    <th style="width: 15%; text-align: center;">Tahun</th>
                    <th style="width: 18%; text-align: center;">Laki-laki</th>
                    <th style="width: 18%; text-align: center;">Perempuan</th>
                    <th style="width: 19%; text-align: center;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $totalLaki = 0;
                $totalPerempuan = 0;
                $currentYear = null;
                
                foreach ($monthlyVisitorStats as $stat):
                    $totalLaki += $stat['laki_laki'];
                    $totalPerempuan += $stat['perempuan'];
                    
                    // Add year separator if year changes
                    if ($currentYear !== null && $currentYear != $stat['year']): ?>
                        <tr style="background-color: #e5e7eb; font-weight: bold;">
                            <td colspan="2">SUBTOTAL TAHUN <?= $currentYear ?></td>
                            <td class="text-center" id="subtotalLaki_<?= $currentYear ?>" style="display:none;">0</td>
                            <td class="text-center" id="subtotalPerempuan_<?= $currentYear ?>" style="display:none;">0</td>
                            <td class="text-center" id="subtotalTotal_<?= $currentYear ?>" style="display:none;">0</td>
                        </tr>
                    <?php endif;
                    $currentYear = $stat['year'];
                ?>
                <tr>
                    <td><?= $monthNames[$stat['month'] - 1] ?></td>
                    <td class="text-center"><?= $stat['year'] ?></td>
                    <td class="text-center"><?= $stat['laki_laki'] ?></td>
                    <td class="text-center"><?= $stat['perempuan'] ?></td>
                    <td class="text-center font-bold"><?= $stat['laki_laki'] + $stat['perempuan'] ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="background-color: #dbeafe; font-weight: bold;">
                    <td colspan="2">TOTAL KESELURUHAN (LIFETIME)</td>
                    <td class="text-center"><?= $totalLaki ?></td>
                    <td class="text-center"><?= $totalPerempuan ?></td>
                    <td class="text-center"><?= $totalLaki + $totalPerempuan ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- STATISTIK TAHUNAN -->
    <div class="section mb-10">
        <div class="section-header">
            <h3>STATISTIK PENGUNJUNG PER TAHUN (LIFETIME)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Tahun</th>
                    <th style="width: 20%; text-align: center;">Laki-laki</th>
                    <th style="width: 20%; text-align: center;">Perempuan</th>
                    <th style="width: 20%; text-align: center;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotalLaki = 0;
                $grandTotalPerempuan = 0;
                foreach ($yearlyVisitorStats as $stat): 
                    $grandTotalLaki += $stat['laki_laki'];
                    $grandTotalPerempuan += $stat['perempuan'];
                ?>
                <tr>
                    <td><?= $stat['year'] ?></td>
                    <td class="text-center"><?= $stat['laki_laki'] ?></td>
                    <td class="text-center"><?= $stat['perempuan'] ?></td>
                    <td class="text-center font-bold"><?= $stat['laki_laki'] + $stat['perempuan'] ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="background-color: #dbeafe; font-weight: bold;">
                    <td>TOTAL KESELURUHAN</td>
                    <td class="text-center"><?= $grandTotalLaki ?></td>
                    <td class="text-center"><?= $grandTotalPerempuan ?></td>
                    <td class="text-center"><?= $grandTotalLaki + $grandTotalPerempuan ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- DAFTAR KRITIK & SARAN -->
    <div class="page-break section">
        <div class="section-header">
            <h3>DAFTAR KRITIK & SARAN (<?= count($allFeedback) ?> Entri)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 35%;">Pesan</th>
                    <th style="width: 15%;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($allFeedback as $feedback): 
                    $data = is_string($feedback['form_data']) ? json_decode($feedback['form_data'], true) : $feedback['form_data'];
                    $pesan = $data['pesan'] ?? '-';
                    $pesanTrimmed = strlen($pesan) > 50 ? substr($pesan, 0, 50) . '...' : $pesan;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['nama_lengkap'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($data['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($pesanTrimmed) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($feedback['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- DAFTAR BUKU TAMU -->
    <div class="page-break section">
        <div class="section-header">
            <h3>DAFTAR BUKU TAMU (<?= count($allGuestBook) ?> Entri)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 18%;">Nama</th>
                    <th style="width: 18%;">Instansi</th>
                    <th style="width: 8%; text-align: center;">L</th>
                    <th style="width: 8%; text-align: center;">P</th>
                    <th style="width: 20%; text-align: center;">Status</th>
                    <th style="width: 14%; text-align: center;">Tgl Kunjung</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $statusDiterima = 0;
                $statusDitolak = 0;
                $statusMenunggu = 0;
                
                foreach ($allGuestBook as $guestBook): 
                    $data = is_string($guestBook['form_data']) ? json_decode($guestBook['form_data'], true) : $guestBook['form_data'];
                    $status = $guestBook['status_balasan'] ?? 'menunggu';
                    
                    if ($status == 'diterima') {
                        $statusText = '[DITERIMA]';
                        $statusDiterima++;
                    } elseif ($status == 'ditolak') {
                        $statusText = '[DITOLAK]';
                        $statusDitolak++;
                    } else {
                        $statusText = '[MENUNGGU]';
                        $statusMenunggu++;
                    }
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['nama_lengkap'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($data['asal_instansi'] ?? '-') ?></td>
                    <td class="text-center"><?= intval($data['jumlah_laki_laki'] ?? 0) ?></td>
                    <td class="text-center"><?= intval($data['jumlah_perempuan'] ?? 0) ?></td>
                    <td class="text-center">
                        <?php if ($statusText == '[DITERIMA]'): ?>
                            <span style="color: #10b981; font-weight: bold;"><?= $statusText ?></span>
                        <?php elseif ($statusText == '[DITOLAK]'): ?>
                            <span style="color: #ef4444; font-weight: bold;"><?= $statusText ?></span>
                        <?php else: ?>
                            <span style="color: #f59e0b; font-weight: bold;"><?= $statusText ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($guestBook['tanggal_kunjungan'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="background-color: #dbeafe; font-weight: bold;">
                    <td colspan="5" style="text-align: right;">SUMMARY STATUS:</td>
                    <td class="text-center">[D]<?= $statusDiterima ?> | [T]<?= $statusDitolak ?> | [M]<?= $statusMenunggu ?></td>
                    <td class="text-center"><?= count($allGuestBook) ?> Total</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis dari Sistem Layanan Pengunjung Perpustakaan Provinsi Jawa Tengah</p>
        <p>© <?= date('Y') ?> - Semua Hak Dilindungi | Generated: <?= date('d/m/Y H:i:s') ?></p>
    </div>
</body>
</html>
