<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FeedbackModel;
use App\Models\GuestBookModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class DashboardController extends BaseController
{
    protected $feedbackModel;
    protected $guestBookModel;

    public function __construct()
    {
        $this->feedbackModel = new FeedbackModel();
        $this->guestBookModel = new GuestBookModel();
    }

    public function index()
    {
        // Get statistics
        $feedbackStats = $this->feedbackModel->getStatistics();
        $guestBookStats = $this->guestBookModel->getStatistics();
        $visitorStats = $this->guestBookModel->getVisitorStatistics();
        $dailyVisitorStats = $this->guestBookModel->getDailyVisitorStatistics();
        $monthlyVisitorStats = $this->guestBookModel->getMonthlyVisitorStatistics(); // Lifetime data
        $yearlyVisitorStats = $this->guestBookModel->getYearlyVisitorStatistics();

        // Get recent entries
        $recentFeedback = $this->feedbackModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        $recentGuestBook = $this->guestBookModel->orderBy('created_at', 'DESC')->limit(5)->findAll();

        $data = [
            'title' => 'Dashboard',
            'feedbackTotal' => $feedbackStats['total'],
            'guestBookTotal' => $guestBookStats['total'],
            'feedbackDaily' => $feedbackStats['daily'],
            'guestBookDaily' => $guestBookStats['daily'],
            'visitorStats' => $visitorStats,
            'dailyVisitorStats' => $dailyVisitorStats,
            'monthlyVisitorStats' => $monthlyVisitorStats,
            'yearlyVisitorStats' => $yearlyVisitorStats,
            'recentFeedback' => $recentFeedback,
            'recentGuestBook' => $recentGuestBook
        ];

        return view('admin/dashboard/index', $data);
    }

    public function getChartData()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $feedbackStats = $this->feedbackModel->getStatistics($startDate, $endDate);
        $guestBookStats = $this->guestBookModel->getStatistics($startDate, $endDate);

        return $this->response->setJSON([
            'feedback' => $feedbackStats['daily'],
            'guestBook' => $guestBookStats['daily']
        ]);
    }

    public function exportExcel()
    {
        // Get all statistics
        $visitorStats = $this->guestBookModel->getVisitorStatistics();
        $monthlyVisitorStats = $this->guestBookModel->getMonthlyVisitorStatistics();
        $yearlyVisitorStats = $this->guestBookModel->getYearlyVisitorStatistics();
        $feedbackStats = $this->feedbackModel->getStatistics();
        $guestBookStats = $this->guestBookModel->getStatistics();
        
        // Get all feedback data
        $allFeedback = $this->feedbackModel->findAll();
        
        // Get all guest book data
        $allGuestBook = $this->guestBookModel->findAll();

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        
        // ===== Sheet 1: Summary =====
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ringkasan');
        
        $sheet->setCellValue('A1', 'STATISTIK LENGKAP PENGUNJUNG PERPUSTAKAAN JAWA TENGAH');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        
        $sheet->setCellValue('A2', 'Tanggal Laporan: ' . date('d/m/Y H:i:s'));
        
        $sheet->setCellValue('A4', 'RINGKASAN TOTAL');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(11);
        
        $sheet->setCellValue('A5', 'Total Kritik & Saran');
        $sheet->setCellValue('B5', $feedbackStats['total']);
        
        $sheet->setCellValue('A6', 'Total Buku Tamu');
        $sheet->setCellValue('B6', $guestBookStats['total']);
        
        $sheet->setCellValue('A7', 'Total Pengunjung Laki-laki');
        $sheet->setCellValue('B7', $visitorStats['laki_laki']);
        
        $sheet->setCellValue('A8', 'Total Pengunjung Perempuan');
        $sheet->setCellValue('B8', $visitorStats['perempuan']);
        
        $sheet->setCellValue('A9', 'Total Pengunjung');
        $sheet->setCellValue('B9', $visitorStats['total']);
        
        // ===== Sheet 2: Monthly Statistics =====
        $monthlySheet = $spreadsheet->createSheet();
        $monthlySheet->setTitle('Statistik Bulanan');
        
        $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $monthlySheet->setCellValue('A1', 'STATISTIK PENGUNJUNG PER BULAN');
        $monthlySheet->mergeCells('A1:D1');
        $monthlySheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        
        $monthlySheet->setCellValue('A2', 'Tahun: ' . date('Y'));
        
        $monthlySheet->setCellValue('A4', 'Bulan');
        $monthlySheet->setCellValue('B4', 'Laki-laki');
        $monthlySheet->setCellValue('C4', 'Perempuan');
        $monthlySheet->setCellValue('D4', 'Total');
        
        $monthlySheet->getStyle('A4:D4')->getFont()->setBold(true);
        
        $row = 5;
        foreach ($monthlyVisitorStats as $stat) {
            $monthlySheet->setCellValue('A' . $row, $monthNames[$stat['month'] - 1]);
            $monthlySheet->setCellValue('B' . $row, $stat['laki_laki']);
            $monthlySheet->setCellValue('C' . $row, $stat['perempuan']);
            $monthlySheet->setCellValue('D' . $row, $stat['laki_laki'] + $stat['perempuan']);
            $row++;
        }
        
        // ===== Sheet 3: Yearly Statistics =====
        $yearlySheet = $spreadsheet->createSheet();
        $yearlySheet->setTitle('Statistik Tahunan');
        
        $yearlySheet->setCellValue('A1', 'STATISTIK PENGUNJUNG PER TAHUN');
        $yearlySheet->mergeCells('A1:D1');
        $yearlySheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        
        $yearlySheet->setCellValue('A3', 'Tahun');
        $yearlySheet->setCellValue('B3', 'Laki-laki');
        $yearlySheet->setCellValue('C3', 'Perempuan');
        $yearlySheet->setCellValue('D3', 'Total');
        
        $yearlySheet->getStyle('A3:D3')->getFont()->setBold(true);
        
        $row = 4;
        foreach ($yearlyVisitorStats as $stat) {
            $yearlySheet->setCellValue('A' . $row, $stat['year']);
            $yearlySheet->setCellValue('B' . $row, $stat['laki_laki']);
            $yearlySheet->setCellValue('C' . $row, $stat['perempuan']);
            $yearlySheet->setCellValue('D' . $row, $stat['laki_laki'] + $stat['perempuan']);
            $row++;
        }
        
        // ===== Sheet 4: Feedback Details =====
        $feedbackSheet = $spreadsheet->createSheet();
        $feedbackSheet->setTitle('Detail Kritik & Saran');
        
        $feedbackSheet->setCellValue('A1', 'DAFTAR KRITIK & SARAN');
        $feedbackSheet->mergeCells('A1:E1');
        $feedbackSheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        
        $feedbackSheet->setCellValue('A3', 'No');
        $feedbackSheet->setCellValue('B3', 'Nama');
        $feedbackSheet->setCellValue('C3', 'Email');
        $feedbackSheet->setCellValue('D3', 'Pesan');
        $feedbackSheet->setCellValue('E3', 'Tanggal');
        
        $feedbackSheet->getStyle('A3:E3')->getFont()->setBold(true);
        
        $row = 4;
        $no = 1;
        foreach ($allFeedback as $feedback) {
            $data = is_string($feedback['form_data']) ? json_decode($feedback['form_data'], true) : $feedback['form_data'];
            $feedbackSheet->setCellValue('A' . $row, $no++);
            $feedbackSheet->setCellValue('B' . $row, $data['nama_lengkap'] ?? '-');
            $feedbackSheet->setCellValue('C' . $row, $data['email'] ?? '-');
            $feedbackSheet->setCellValue('D' . $row, substr($data['pesan'] ?? '-', 0, 50) . '...');
            $feedbackSheet->setCellValue('E' . $row, date('d/m/Y', strtotime($feedback['created_at'])));
            $row++;
        }
        
        // ===== Sheet 5: Guest Book Details =====
        $guestBookSheet = $spreadsheet->createSheet();
        $guestBookSheet->setTitle('Detail Buku Tamu');
        
        $guestBookSheet->setCellValue('A1', 'DAFTAR BUKU TAMU');
        $guestBookSheet->mergeCells('A1:G1');
        $guestBookSheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        
        $guestBookSheet->setCellValue('A3', 'No');
        $guestBookSheet->setCellValue('B3', 'Nama');
        $guestBookSheet->setCellValue('C3', 'Instansi');
        $guestBookSheet->setCellValue('D3', 'Laki-laki');
        $guestBookSheet->setCellValue('E3', 'Perempuan');
        $guestBookSheet->setCellValue('F3', 'Status');
        $guestBookSheet->setCellValue('G3', 'Tanggal Kunjungan');
        
        $guestBookSheet->getStyle('A3:G3')->getFont()->setBold(true);
        
        $row = 4;
        $no = 1;
        foreach ($allGuestBook as $guestBook) {
            $data = is_string($guestBook['form_data']) ? json_decode($guestBook['form_data'], true) : $guestBook['form_data'];
            $guestBookSheet->setCellValue('A' . $row, $no++);
            $guestBookSheet->setCellValue('B' . $row, $data['nama_lengkap'] ?? '-');
            $guestBookSheet->setCellValue('C' . $row, $data['asal_instansi'] ?? '-');
            $guestBookSheet->setCellValue('D' . $row, $data['jumlah_laki_laki'] ?? 0);
            $guestBookSheet->setCellValue('E' . $row, $data['jumlah_perempuan'] ?? 0);
            
            $status = $guestBook['status_balasan'] ?? 'Menunggu';
            if ($status == 'diterima') {
                $status = 'Diterima';
            } elseif ($status == 'ditolak') {
                $status = 'Ditolak';
            } else {
                $status = 'Menunggu Balasan';
            }
            $guestBookSheet->setCellValue('F' . $row, $status);
            $guestBookSheet->setCellValue('G' . $row, date('d/m/Y', strtotime($guestBook['tanggal_kunjungan'])));
            $row++;
        }
        
        // Auto size columns
        foreach ($spreadsheet->getSheetNames() as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        }
        
        // Download
        $filename = 'Statistik_Lengkap_' . date('Y-m-d_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        // Get all statistics
        $visitorStats = $this->guestBookModel->getVisitorStatistics();
        $monthlyVisitorStats = $this->guestBookModel->getMonthlyVisitorStatistics();
        $yearlyVisitorStats = $this->guestBookModel->getYearlyVisitorStatistics();
        $feedbackStats = $this->feedbackModel->getStatistics();
        $guestBookStats = $this->guestBookModel->getStatistics();
        
        // Get all feedback data
        $allFeedback = $this->feedbackModel->findAll();
        
        // Get all guest book data
        $allGuestBook = $this->guestBookModel->findAll();

        $data = [
            'visitorStats' => $visitorStats,
            'monthlyVisitorStats' => $monthlyVisitorStats,
            'yearlyVisitorStats' => $yearlyVisitorStats,
            'feedbackStats' => $feedbackStats,
            'guestBookStats' => $guestBookStats,
            'allFeedback' => $allFeedback,
            'allGuestBook' => $allGuestBook,
            'date' => date('d/m/Y H:i:s')
        ];

        $html = view('admin/dashboard/export_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Statistik_Lengkap_' . date('Y-m-d_His') . '.pdf';
        $dompdf->stream($filename);
    }

    /**
     * API Endpoint untuk Real-time Chart Update
     */
    public function getChartDataRealtime()
    {
        $visitorStats = $this->guestBookModel->getVisitorStatistics();
        $dailyVisitorStats = $this->guestBookModel->getDailyVisitorStatistics();
        $monthlyVisitorStats = $this->guestBookModel->getMonthlyVisitorStatistics();
        $yearlyVisitorStats = $this->guestBookModel->getYearlyVisitorStatistics();

        return $this->response->setJSON([
            'success' => true,
            'timestamp' => date('Y-m-d H:i:s'),
            'visitorStats' => $visitorStats,
            'dailyVisitorStats' => $dailyVisitorStats,
            'monthlyVisitorStats' => $monthlyVisitorStats,
            'yearlyVisitorStats' => $yearlyVisitorStats
        ]);
    }
}