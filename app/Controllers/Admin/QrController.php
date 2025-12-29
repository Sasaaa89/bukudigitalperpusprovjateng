<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QrTokenModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;

class QrController extends BaseController
{
    protected $qrTokenModel;

    public function __construct()
    {
        $this->qrTokenModel = new QrTokenModel();
    }

    public function index()
    {
        $activeToken = $this->qrTokenModel->getActiveToken();
        
        // Gunakan baseURL dari config (bisa dari environment di production)
        $baseUrl = rtrim(config('App')->baseURL, '/');
        $qrUrl = $activeToken 
            ? $baseUrl . '/welcome?token=' . $activeToken['token']
            : $baseUrl . '/welcome';

        $data = [
            'title' => 'Generate QR Code',
            'activeToken' => $activeToken,
            'qrUrl' => $qrUrl
        ];

        return view('admin/qr/index', $data);
    }

    public function generate()
    {
        $adminId = session()->get('admin_id');
        
        if ($this->qrTokenModel->generateNewToken($adminId)) {
            return redirect()->to('/admin/generate-qr')->with('success', 'QR Code baru berhasil dibuat!');
        } else {
            return redirect()->to('/admin/generate-qr')->with('error', 'Gagal membuat QR Code!');
        }
    }

    public function print()
    {
        $activeToken = $this->qrTokenModel->getActiveToken();
        
        if (!$activeToken) {
            return redirect()->to('/admin/generate-qr')->with('error', 'Tidak ada QR Code aktif!');
        }
        
        // Gunakan baseURL dari config
        $baseUrl = rtrim(config('App')->baseURL, '/');
        $qrUrl = $baseUrl . '/welcome?token=' . $activeToken['token'];
        
        $data = [
            'title' => 'Print QR Code',
            'qrUrl' => $qrUrl,
            'token' => $activeToken['token']
        ];

        return view('admin/qr/print', $data);
    }

    /**
     * Download QR Code sebagai PDF print-ready
     */
    public function downloadPdf()
    {
        $activeToken = $this->qrTokenModel->getActiveToken();
        
        if (!$activeToken) {
            return redirect()->to('/admin/generate-qr')->with('error', 'Tidak ada QR Code aktif!');
        }
        
        // Gunakan baseURL dari config
        $baseUrl = rtrim(config('App')->baseURL, '/');
        $qrUrl = $baseUrl . '/welcome?token=' . $activeToken['token'];
        
        // Generate QR Code menggunakan Builder dengan API v6
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qrUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );
        
        $result = $builder->build();
        $qrBase64 = base64_encode($result->getString());
        
        // Prepare HTML untuk PDF
        $html = $this->generatePdfHtml($qrBase64, $qrUrl);
        
        // Generate PDF dengan Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Download PDF
        $filename = 'QR-Code-Perpustakaan-' . date('Y-m-d') . '.pdf';
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($dompdf->output());
    }

    /**
     * Generate HTML template untuk PDF
     */
    private function generatePdfHtml($qrBase64, $qrUrl)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding: 40px 20px;
                    margin: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    border: 3px solid #2c3e50;
                    padding: 30px;
                    border-radius: 10px;
                }
                h1 {
                    color: #2c3e50;
                    font-size: 28px;
                    margin: 10px 0;
                    font-weight: bold;
                }
                h2 {
                    color: #3498db;
                    font-size: 22px;
                    margin: 10px 0 20px 0;
                }
                .qr-image {
                    margin: 20px 0;
                }
                .instructions {
                    background: #ecf0f1;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                    text-align: left;
                }
                .instructions h3 {
                    color: #2c3e50;
                    margin: 0 0 10px 0;
                    font-size: 16px;
                }
                .instructions ol {
                    padding-left: 20px;
                    margin: 10px 0;
                }
                .instructions li {
                    margin: 8px 0;
                    line-height: 1.6;
                }
                }
                .url {
                    font-size: 10px;
                    color: #7f8c8d;
                    margin-top: 15px;
                    word-break: break-all;
                    line-height: 1.6;
                    padding: 10px;
                    background: #f8f9fa;
                    border-radius: 5px;
                }
                .footer {
                    margin-top: 20px;
                    color: #95a5a6;
                    font-size: 11px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Perpustakaan Provinsi</h1>
                <h2>Formulir Pengunjung Digital</h2>
                
                <div class="qr-image">
                    <img src="data:image/png;base64,' . $qrBase64 . '" alt="QR Code" width="300" height="300">
                </div>
                
                <div class="instructions">
                    <h3>Cara Menggunakan:</h3>
                    <ol>
                        <li>Hubungkan ke <strong>WiFi Perpustakaan</strong></li>
                        <li><strong>Scan QR Code</strong> dengan kamera smartphone</li>
                        <li>Pilih formulir: <strong>Buku Tamu</strong> atau <strong>Kritik & Saran</strong></li>
                        <li>Isi form dan klik <strong>Kirim</strong></li>
                    </ol>
                </div>
                
                <div class="url">
                    <strong>URL Manual:</strong><br>
                    ' . $qrUrl . '
                </div>
                
                <div class="footer">
                    Generated: ' . date('d M Y H:i') . '<br>
                    Hubungi staf perpustakaan untuk bantuan
                </div>
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Generate QR Code image (PNG) untuk ditampilkan di browser
     */
    public function qrImage($token)
    {
        // Gunakan baseURL dari config
        $baseUrl = rtrim(config('App')->baseURL, '/');
        $qrUrl = $baseUrl . '/welcome?token=' . $token;
        
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qrUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );
        
        $result = $builder->build();
        
        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setBody($result->getString());
    }

    /**
     * Get local IP address
     */
    private function getLocalIpAddress()
    {
        // Coba ambil dari server variable REMOTE_ADDR atau SERVER_ADDR
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = $_SERVER['SERVER_ADDR'] ?? '192.168.50.17';
        }
        
        return trim($ip);
    }
}