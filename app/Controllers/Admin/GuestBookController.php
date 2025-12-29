<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuestBookModel;
use App\Models\KeperluanModel;

class GuestBookController extends BaseController
{
    protected $guestBookModel;
    protected $keperluanModel;

    public function __construct()
    {
        $this->guestBookModel = new GuestBookModel();
        $this->keperluanModel = new KeperluanModel();
    }

    public function index()
    {
        $filterKeperluan = $this->request->getGet('keperluan');
        
        // Ambil semua data buku tamu
        $allGuestBook = $this->guestBookModel->orderBy('created_at', 'DESC')->findAll();
        
        // Filter di PHP jika ada filter keperluan
        $guestBook = $allGuestBook;
        if (!empty($filterKeperluan)) {
            $guestBook = array_filter($allGuestBook, function($item) use ($filterKeperluan) {
                $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                return isset($data['keperluan']) && $data['keperluan'] === $filterKeperluan;
            });
            // Re-index array setelah filter
            $guestBook = array_values($guestBook);
        }
        
        // Ambil daftar keperluan aktif
        $keperluanList = $this->keperluanModel->getActiveKeperluan();

        $data = [
            'title' => 'Data Buku Tamu',
            'guestBook' => $guestBook,
            'keperluanList' => $keperluanList,
            'selectedKeperluan' => $filterKeperluan
        ];

        return view('admin/guest_book/index', $data);
    }

    public function balas()
    {
        // Menampilkan surat yang belum ada balasan (status_balasan = null)
        $guestBook = $this->guestBookModel
            ->where('status_balasan', null)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Balas Surat Kunjungan',
            'guestBook' => $guestBook
        ];

        return view('admin/guest_book/index', $data);
    }

    public function view($id)
    {
        $guestBook = $this->guestBookModel->find($id);
        
        if (!$guestBook) {
            return redirect()->to('/admin/guest-book')->with('error', 'Data tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail Buku Tamu',
            'guestBook' => $guestBook
        ];

        return view('admin/guest_book/view', $data);
    }

    public function delete($id)
    {
        if ($this->guestBookModel->delete($id)) {
            return redirect()->to('/admin/guest-book')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect()->to('/admin/guest-book')->with('error', 'Gagal menghapus data!');
        }
    }

    public function reply($id)
    {
        $guestBook = $this->guestBookModel->find($id);
        
        if (!$guestBook) {
            return redirect()->to('/admin/guest-book')->with('error', 'Data tidak ditemukan!');
        }

        $data = [
            'title' => 'Balas Surat Kunjungan',
            'guestBook' => $guestBook
        ];

        return view('admin/guest_book/reply', $data);
    }

    public function saveReply($id)
    {
        $guestBook = $this->guestBookModel->find($id);
        
        if (!$guestBook) {
            return redirect()->to('/admin/guest-book')->with('error', 'Data tidak ditemukan!');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'status_balasan' => 'required|in_list[diterima,ditolak]',
            'catatan_balasan' => 'required|min_length[10]',
            'file_balasan' => 'uploaded[file_balasan]|max_size[file_balasan,5120]|ext_in[file_balasan,pdf,doc,docx]'
        ], [
            'status_balasan' => [
                'required' => 'Status balasan harus dipilih',
                'in_list' => 'Status balasan tidak valid'
            ],
            'catatan_balasan' => [
                'required' => 'Catatan balasan harus diisi',
                'min_length' => 'Catatan minimal 10 karakter'
            ],
            'file_balasan' => [
                'uploaded' => 'File surat balasan harus diunggah',
                'max_size' => 'Ukuran file maksimal 5 MB',
                'ext_in' => 'File harus berformat PDF, DOC, atau DOCX'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('file_balasan');
        $fileName = null;

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('writable/uploads/balasan_surat', $newName);
            $fileName = $newName;
        }

        $updateData = [
            'status_balasan' => $this->request->getPost('status_balasan'),
            'catatan_balasan' => $this->request->getPost('catatan_balasan'),
            'tanggal_balasan' => date('Y-m-d H:i:s'),
        ];

        if ($fileName) {
            $updateData['file_balasan'] = $fileName;
        }

        if ($this->guestBookModel->update($id, $updateData)) {
            return redirect()->to('/admin/guest-book')->with('success', 'Balasan surat berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan balasan surat!');
        }
    }

    public function deleteReply($id)
    {
        $guestBook = $this->guestBookModel->find($id);
        
        if (!$guestBook) {
            return redirect()->to('/admin/guest-book')->with('error', 'Data tidak ditemukan!');
        }

        $filePath = 'writable/uploads/balasan_surat/' . $guestBook['file_balasan'];
        if (!empty($guestBook['file_balasan']) && file_exists($filePath)) {
            unlink($filePath);
        }

        $updateData = [
            'status_balasan' => null,
            'file_balasan' => null,
            'catatan_balasan' => null,
            'tanggal_balasan' => null,
        ];

        if ($this->guestBookModel->update($id, $updateData)) {
            return redirect()->to('/admin/guest-book')->with('success', 'Balasan surat berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus balasan surat!');
        }
    }

    public function exportPdf()
    {
        $filterKeperluan = $this->request->getGet('keperluan');
        
        // Ambil semua data buku tamu
        $allGuestBook = $this->guestBookModel->orderBy('created_at', 'DESC')->findAll();
        
        // Filter di PHP jika ada filter keperluan
        $guestBook = $allGuestBook;
        if (!empty($filterKeperluan)) {
            $guestBook = array_filter($allGuestBook, function($item) use ($filterKeperluan) {
                $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                return isset($data['keperluan']) && $data['keperluan'] === $filterKeperluan;
            });
            $guestBook = array_values($guestBook);
        }
        
        $html = '<html>
            <head>
                <meta charset="UTF-8">
                <title>Data Buku Tamu</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h2 { text-align: center; color: #333; }
                    .subtitle { text-align: center; color: #666; margin-bottom: 20px; font-size: 12px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th { background-color: #4CAF50; color: white; padding: 12px; text-align: left; font-weight: bold; }
                    td { padding: 10px; border-bottom: 1px solid #ddd; }
                    tr:nth-child(even) { background-color: #f9f9f9; }
                    tr:hover { background-color: #f5f5f5; }
                    .status-diterima { color: #27ae60; font-weight: bold; }
                    .status-ditolak { color: #e74c3c; font-weight: bold; }
                    .status-menunggu { color: #f39c12; font-weight: bold; }
                </style>
            </head>
            <body>
                <h2>Data Buku Tamu Perpustakaan</h2>
                <p class="subtitle">Provinsi Jawa Tengah</p>';
        
        if (!empty($filterKeperluan)) {
            $html .= '<p class="subtitle">Filter: ' . esc($filterKeperluan) . '</p>';
        }
        
        $html .= '<p class="subtitle">Tanggal Export: ' . date('d/m/Y H:i:s') . '</p>
                <table border="1">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 15%;">Nama</th>
                            <th style="width: 15%;">Instansi</th>
                            <th style="width: 15%;">Keperluan</th>
                            <th style="width: 15%;">Status Balasan</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        if (!empty($guestBook)) {
            foreach ($guestBook as $index => $item) {
                $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                $statusClass = '';
                $statusText = 'Menunggu Balasan';
                
                if (!empty($item['status_balasan'])) {
                    $statusText = ucfirst($item['status_balasan']);
                    $statusClass = $item['status_balasan'] == 'diterima' ? 'status-diterima' : 'status-ditolak';
                } else {
                    $statusClass = 'status-menunggu';
                }
                
                $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . date('d/m/Y H:i', strtotime($item['created_at'])) . '</td>
                    <td>' . esc($data['nama_lengkap'] ?? '-') . '</td>
                    <td>' . esc($data['asal_instansi'] ?? '-') . '</td>
                    <td>' . esc($data['keperluan'] ?? '-') . '</td>
                    <td class="' . $statusClass . '">' . $statusText . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="6" style="text-align: center;">Tidak ada data</td></tr>';
        }
        
        $html .= '</tbody>
                </table>
            </body>
        </html>';
        
        $filename = 'Buku_Tamu_' . (!empty($filterKeperluan) ? str_replace(' ', '_', $filterKeperluan) . '_' : '') . date('Y-m-d_H-i-s') . '.pdf';
        
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $dompdf->stream($filename, array('Attachment' => 1));
    }

    public function exportExcel()
    {
        $filterKeperluan = $this->request->getGet('keperluan');
        
        // Ambil semua data buku tamu
        $allGuestBook = $this->guestBookModel->orderBy('created_at', 'DESC')->findAll();
        
        // Filter di PHP jika ada filter keperluan
        $guestBook = $allGuestBook;
        if (!empty($filterKeperluan)) {
            $guestBook = array_filter($allGuestBook, function($item) use ($filterKeperluan) {
                $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                return isset($data['keperluan']) && $data['keperluan'] === $filterKeperluan;
            });
            $guestBook = array_values($guestBook);
        }
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Buku Tamu');
        
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(18);
        
        // Header styling
        $headerStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ];
        
        // Add title
        $sheet->setCellValue('A1', 'DATA BUKU TAMU PERPUSTAKAAN PROVINSI JAWA TENGAH');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        if (!empty($filterKeperluan)) {
            $sheet->setCellValue('A2', 'Filter: ' . $filterKeperluan);
            $sheet->mergeCells('A2:F2');
            $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10);
        }
        
        $sheet->setCellValue('A3', 'Tanggal Export: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A3:F3');
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(10);
        
        // Headers
        $headerRow = 4;
        $sheet->setCellValue('A' . $headerRow, 'No');
        $sheet->setCellValue('B' . $headerRow, 'Tanggal');
        $sheet->setCellValue('C' . $headerRow, 'Nama');
        $sheet->setCellValue('D' . $headerRow, 'Instansi');
        $sheet->setCellValue('E' . $headerRow, 'Keperluan');
        $sheet->setCellValue('F' . $headerRow, 'Status Balasan');
        
        $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)->applyFromArray($headerStyle);
        
        // Data rows
        $row = $headerRow + 1;
        if (!empty($guestBook)) {
            foreach ($guestBook as $index => $item) {
                $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                $statusText = 'Menunggu Balasan';
                
                if (!empty($item['status_balasan'])) {
                    $statusText = ucfirst($item['status_balasan']);
                }
                
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, date('d/m/Y H:i', strtotime($item['created_at'])));
                $sheet->setCellValue('C' . $row, esc($data['nama_lengkap'] ?? '-'));
                $sheet->setCellValue('D' . $row, esc($data['asal_instansi'] ?? '-'));
                $sheet->setCellValue('E' . $row, esc($data['keperluan'] ?? '-'));
                $sheet->setCellValue('F' . $row, $statusText);
                
                // Row styling
                $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $row++;
            }
        }
        
        // Auto-size columns
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        
        $filename = 'Buku_Tamu_' . (!empty($filterKeperluan) ? str_replace(' ', '_', $filterKeperluan) . '_' : '') . date('Y-m-d_H-i-s') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}