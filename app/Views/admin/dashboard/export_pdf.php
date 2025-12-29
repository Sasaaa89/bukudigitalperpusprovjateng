<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: A4;
            margin: 25mm 20mm;
            margin-footer: 10mm;
            margin-header: 10mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            font-size: 10px;
            color: #1f2937;
            line-height: 1.5;
            background: #ffffff;
        }
        
        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1e40af;
            position: relative;
        }
        
        .header-top {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            gap: 12px;
        }
        
        .header-icon {
            font-size: 32px;
            color: #1e40af;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e0eeff 0%, #f0f6ff 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header-text h1 {
            font-size: 18px;
            color: #1e40af;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.2;
        }
        
        .header-text h2 {
            font-size: 12px;
            color: #2563eb;
            font-weight: 600;
            margin: 3px 0 0 0;
            letter-spacing: 0.3px;
        }
        
        .header-meta {
            font-size: 8.5px;
            color: #4b5563;
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
        }
        
        .header-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }
        
        /* ===== SECTION ===== */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-left: 5px solid #1e40af;
            padding-left: 12px;
            background: linear-gradient(90deg, rgba(30,64,175,0.03) 0%, transparent 100%);
            padding: 8px 0 8px 12px;
        }
        
        .section-header h3 {
            font-size: 11px;
            color: #1e40af;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        
        /* ===== STAT GRID ===== */
        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #f0f6ff 0%, #e8f0ff 100%);
            border: 2px solid #1e40af;
            border-radius: 6px;
            padding: 14px 12px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .stat-label {
            font-size: 8px;
            color: #475569;
            margin-bottom: 7px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: #1e40af;
            line-height: 1;
        }
        
        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 4px;
            overflow: hidden;
        }
        
        th {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 11px 8px;
            text-align: left;
            font-weight: 600;
            border: none;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
            color: #374151;
        }
        
        tbody tr {
            transition: background-color 0.2s;
        }
        
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        /* ===== SUMMARY TABLE ===== */
        .summary-table {
            max-width: 600px;
            margin: 0 auto 20px;
        }
        
        .summary-table td:first-child {
            font-weight: 600;
            background-color: #f0f6ff;
            border-right: 2px solid #1e40af;
        }
        
        .summary-table td:last-child {
            text-align: center;
            font-weight: 700;
            color: #1e40af;
            background-color: #f0f6ff;
            font-size: 11px;
        }
        
        .summary-table tr:last-child td {
            background-color: #dbeafe;
            border-top: 2px solid #1e40af;
            padding: 12px 8px;
            font-size: 10px;
            font-weight: 600;
        }
        
        /* ===== SUBTOTAL ROW ===== */
        .subtotal-row td {
            background-color: #e0eeff !important;
            font-weight: 600 !important;
            color: #1e40af !important;
            padding: 10px 8px !important;
            font-size: 9px !important;
        }
        
        .total-row td {
            background-color: #dbeafe !important;
            font-weight: 700 !important;
            color: #1e40af !important;
            padding: 11px 8px !important;
            font-size: 9px !important;
            border-top: 2px solid #1e40af !important;
        }
        
        /* ===== PAGE BREAK ===== */
        .page-break {
            page-break-before: always;
            margin-top: 0;
            padding-top: 25px;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #1e40af;
            font-size: 8px;
            color: #6b7280;
            text-align: center;
        }
        
        .footer p {
            margin: 3px 0;
            line-height: 1.4;
        }
        
        .footer-line {
            color: #d1d5db;
            margin: 8px 0 8px 0;
        }
        
        /* ===== UTILITIES ===== */
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .status-diterima {
            color: #059669;
            font-weight: 600;
        }
        
        .status-ditolak {
            color: #dc2626;
            font-weight: 600;
        }
        
        .status-menunggu {
            color: #d97706;
            font-weight: 600;
        }
        
        .divider {
            border-bottom: 2px dashed #e5e7eb;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <!-- ===== HEADER ===== -->
    <div class="header">
        <div class="header-top">
            <div class="header-icon">📚</div>
            <div class="header-text">
                <h1>STATISTIK LENGKAP PENGUNJUNG</h1>
                <h2>Perpustakaan Provinsi Jawa Tengah</h2>
            </div>
        </div>
        <div class="header-meta">
            <span>📅 Laporan: <?= $date ?></span>
            <span>📊 Total Data: <?= $feedbackStats['total'] + $guestBookStats['total'] ?> Entri</span>
        </div>
    </div>

    <!-- ===== RINGKASAN TOTAL ===== -->
    <div class="section">
        <div class="section-header">
            <h3>📈 Ringkasan Total</h3>
        </div>
        
        <div class="stat-grid">
            <div class="stat-box">
                <div class="stat-label">💬 Kritik & Saran</div>
                <div class="stat-value"><?= $feedbackStats['total'] ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">📖 Buku Tamu</div>
                <div class="stat-value"><?= $guestBookStats['total'] ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">👨 Pengunjung Laki-laki</div>
                <div class="stat-value" style="color: #3b82f6;"><?= $visitorStats['laki_laki'] ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">👩 Pengunjung Perempuan</div>
                <div class="stat-value" style="color: #ec4899;"><?= $visitorStats['perempuan'] ?></div>
            </div>
        </div>
        
        <table class="summary-table">
            <tr>
                <td style="padding: 12px 10px; font-size: 10px;">👥 TOTAL PENGUNJUNG KESELURUHAN</td>
                <td style="padding: 12px 10px; font-size: 12px;"><?= $visitorStats['total'] ?> Orang</td>
            </tr>
        </table>
    </div>

    <!-- ===== STATISTIK BULANAN ===== -->
    <div class="section">
        <div class="section-header">
            <h3>📅 Statistik Pengunjung Per Bulan (Lifetime)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Bulan</th>
                    <th style="width: 12%; text-align: center;">Tahun</th>
                    <th style="width: 15%; text-align: center;">👨 Laki-laki</th>
                    <th style="width: 15%; text-align: center;">👩 Perempuan</th>
                    <th style="width: 15%; text-align: center;">👥 Total</th>
                    <th style="width: 13%; text-align: center;">%</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $totalLaki = 0;
                $totalPerempuan = 0;
                $grandTotalBulan = 0;
                
                foreach ($monthlyVisitorStats as $stat) {
                    $grandTotalBulan += $stat['laki_laki'] + $stat['perempuan'];
                }
                
                $currentYear = null;
                
                foreach ($monthlyVisitorStats as $stat):
                    $totalLaki += $stat['laki_laki'];
                    $totalPerempuan += $stat['perempuan'];
                    $bulanTotal = $stat['laki_laki'] + $stat['perempuan'];
                    $persentase = $grandTotalBulan > 0 ? round(($bulanTotal / $grandTotalBulan) * 100, 1) : 0;
                ?>
                <tr>
                    <td><?= $monthNames[$stat['month'] - 1] ?></td>
                    <td class="text-center"><?= $stat['year'] ?></td>
                    <td class="text-center"><?= $stat['laki_laki'] ?></td>
                    <td class="text-center"><?= $stat['perempuan'] ?></td>
                    <td class="text-center font-bold"><?= $bulanTotal ?></td>
                    <td class="text-center"><?= $persentase ?>%</td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2">📊 TOTAL KESELURUHAN (LIFETIME)</td>
                    <td class="text-center"><?= $totalLaki ?></td>
                    <td class="text-center"><?= $totalPerempuan ?></td>
                    <td class="text-center"><?= $totalLaki + $totalPerempuan ?></td>
                    <td class="text-center">100%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ===== STATISTIK TAHUNAN ===== -->
    <div class="section">
        <div class="section-header">
            <h3>🗓️ Statistik Pengunjung Per Tahun (Lifetime)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 35%;">Tahun</th>
                    <th style="width: 20%; text-align: center;">👨 Laki-laki</th>
                    <th style="width: 20%; text-align: center;">👩 Perempuan</th>
                    <th style="width: 15%; text-align: center;">👥 Total</th>
                    <th style="width: 10%; text-align: center;">%</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotalLaki = 0;
                $grandTotalPerempuan = 0;
                $grandTotalTahun = 0;
                
                foreach ($yearlyVisitorStats as $stat) {
                    $grandTotalTahun += $stat['laki_laki'] + $stat['perempuan'];
                }
                
                foreach ($yearlyVisitorStats as $stat): 
                    $grandTotalLaki += $stat['laki_laki'];
                    $grandTotalPerempuan += $stat['perempuan'];
                    $tahunanTotal = $stat['laki_laki'] + $stat['perempuan'];
                    $persentaseTahun = $grandTotalTahun > 0 ? round(($tahunanTotal / $grandTotalTahun) * 100, 1) : 0;
                ?>
                <tr>
                    <td><?= $stat['year'] ?></td>
                    <td class="text-center"><?= $stat['laki_laki'] ?></td>
                    <td class="text-center"><?= $stat['perempuan'] ?></td>
                    <td class="text-center font-bold"><?= $tahunanTotal ?></td>
                    <td class="text-center"><?= $persentaseTahun ?>%</td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td>📊 TOTAL KESELURUHAN</td>
                    <td class="text-center"><?= $grandTotalLaki ?></td>
                    <td class="text-center"><?= $grandTotalPerempuan ?></td>
                    <td class="text-center"><?= $grandTotalLaki + $grandTotalPerempuan ?></td>
                    <td class="text-center">100%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ===== DAFTAR KRITIK & SARAN ===== -->
    <div class="page-break section">
        <div class="section-header">
            <h3>💬 Daftar Kritik & Saran (<?= count($allFeedback) ?> Entri)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 18%;">Nama</th>
                    <th style="width: 22%;">Email</th>
                    <th style="width: 38%;">Pesan</th>
                    <th style="width: 17%;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (!empty($allFeedback)) {
                    foreach ($allFeedback as $feedback): 
                        $data = is_string($feedback['form_data']) ? json_decode($feedback['form_data'], true) : $feedback['form_data'];
                        $pesan = $data['pesan'] ?? '-';
                        $pesanTrimmed = strlen($pesan) > 45 ? substr($pesan, 0, 45) . '...' : $pesan;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['nama_lengkap'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($data['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($pesanTrimmed) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($feedback['created_at'])) ?></td>
                </tr>
                <?php endforeach;
                } else {
                ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding: 15px 8px; color: #9ca3af;">Tidak ada data kritik & saran</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- ===== DAFTAR BUKU TAMU ===== -->
    <div class="page-break section">
        <div class="section-header">
            <h3>📖 Daftar Buku Tamu (<?= count($allGuestBook) ?> Entri)</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 16%;">Nama</th>
                    <th style="width: 17%;">Instansi</th>
                    <th style="width: 8%; text-align: center;">👨</th>
                    <th style="width: 8%; text-align: center;">👩</th>
                    <th style="width: 19%; text-align: center;">Status</th>
                    <th style="width: 14%; text-align: center;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $statusDiterima = 0;
                $statusDitolak = 0;
                $statusMenunggu = 0;
                
                if (!empty($allGuestBook)) {
                    foreach ($allGuestBook as $guestBook): 
                        $data = is_string($guestBook['form_data']) ? json_decode($guestBook['form_data'], true) : $guestBook['form_data'];
                        $status = $guestBook['status_balasan'] ?? 'menunggu';
                        
                        if ($status == 'diterima') {
                            $statusText = '✓ DITERIMA';
                            $statusClass = 'status-diterima';
                            $statusDiterima++;
                        } elseif ($status == 'ditolak') {
                            $statusText = '✗ DITOLAK';
                            $statusClass = 'status-ditolak';
                            $statusDitolak++;
                        } else {
                            $statusText = '⏳ MENUNGGU';
                            $statusClass = 'status-menunggu';
                            $statusMenunggu++;
                        }
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['nama_lengkap'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($data['asal_instansi'] ?? '-') ?></td>
                    <td class="text-center"><?= intval($data['jumlah_laki_laki'] ?? 0) ?></td>
                    <td class="text-center"><?= intval($data['jumlah_perempuan'] ?? 0) ?></td>
                    <td class="text-center"><span class="<?= $statusClass ?>"><?= $statusText ?></span></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($guestBook['tanggal_kunjungan'])) ?></td>
                </tr>
                <?php endforeach;
                } else {
                ?>
                <tr>
                    <td colspan="7" class="text-center" style="padding: 15px 8px; color: #9ca3af;">Tidak ada data buku tamu</td>
                </tr>
                <?php } ?>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right; padding: 11px 8px;">📊 SUMMARY STATUS:</td>
                    <td colspan="3" class="text-center">✓ <?= $statusDiterima ?> | ✗ <?= $statusDitolak ?> | ⏳ <?= $statusMenunggu ?> (Total: <?= count($allGuestBook) ?>)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="footer">
        <div class="footer-line"></div>
        <p>✓ Dokumen ini digenerate secara otomatis dari Sistem Layanan Pengunjung Perpustakaan</p>
        <p>© <?= date('Y') ?> - Perpustakaan Provinsi Jawa Tengah | Semua Hak Dilindungi</p>
        <p>Generated: <?= date('d/m/Y H:i:s') ?></p>
    </div>
</body>
</html>
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
