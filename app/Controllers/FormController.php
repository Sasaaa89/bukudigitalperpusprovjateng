<?php

namespace App\Controllers;

use App\Models\FeedbackModel;
use App\Models\GuestBookModel;
use App\Models\FormFieldModel;
use App\Models\KeperluanModel;

class FormController extends BaseController
{
    protected $feedbackModel;
    protected $guestBookModel;
    protected $formFieldModel;
    protected $keperluanModel;

    public function __construct()
    {
        $this->feedbackModel = new FeedbackModel();
        $this->guestBookModel = new GuestBookModel();
        $this->formFieldModel = new FormFieldModel();
        $this->keperluanModel = new KeperluanModel();
        helper(['form', 'url', 'filesystem']);
    }

    /**
     * Landing page - pilihan antara Buku Tamu atau Kritik & Saran
     */
    public function index()
    {
        return view('public/welcome', [
            'title' => 'Selamat Datang di Perpustakaan'
        ]);
    }

    /**
     * Form Kritik & Saran
     */
    public function feedback()
    {
        // Get form fields untuk feedback
        $fields = $this->formFieldModel
            ->where('form_type', 'feedback')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        // Get keperluan options (needed if form has select with keperluan_table)
        $keperluanList = $this->keperluanModel
            ->where('is_active', 1)
            ->findAll();

        // Handle POST submission
        if ($this->request->getMethod() === 'POST') {
            return $this->submitFeedback($fields);
        }

        // Show form
        return view('public/feedback_form', [
            'title' => 'Kritik & Saran',
            'fields' => $fields,
            'keperluan' => $keperluanList,
            'token' => $this->request->getGet('token') ?? ''
        ]);
    }

    /**
     * Form Buku Tamu
     */
    public function guestBook()
    {
        // Get form fields untuk guest book
        $fields = $this->formFieldModel
            ->where('form_type', 'guest_book')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        // Get keperluan options
        $keperluanList = $this->keperluanModel
            ->where('is_active', 1)
            ->findAll();

        // Handle POST submission
        if ($this->request->getMethod() === 'POST') {
            return $this->submitGuestBook($fields);
        }

        // Show form
        return view('public/guest_book_form', [
            'title' => 'Buku Tamu',
            'fields' => $fields,
            'keperluanList' => $keperluanList,
            'keperluan' => $keperluanList,
            'token' => $this->request->getGet('token') ?? ''
        ]);
    }

    /**
     * Submit Feedback Form
     */
    private function submitFeedback($fields)
    {
        $validation = \Config\Services::validation();
        $formData = [];
        $uploadedFiles = [];

        // Build validation rules - file upload optional
        $rules = [];
        foreach ($fields as $field) {
            if ($field['is_required'] && $field['field_type'] !== 'file') {
                $rules[$field['field_name']] = 'required';
            }
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Process form data
        foreach ($fields as $field) {
            $fieldName = $field['field_name'];
            
            if ($field['field_type'] === 'file') {
                // Handle file upload
                $file = $this->request->getFile($fieldName);
                if ($file && $file->isValid()) {
                    $uploadResult = $this->handleFileUpload($file);
                    if ($uploadResult['success']) {
                        $uploadedFiles[] = $uploadResult['data'];
                        $formData[$fieldName] = $uploadResult['data'];
                    } else {
                        return redirect()->back()->withInput()->with('error', $uploadResult['message']);
                    }
                }
            } else {
                $formData[$fieldName] = $this->request->getPost($fieldName);
            }
        }

        // Save to database
        $data = [
            'form_data' => $formData,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString()
        ];

        // DEBUG: Log form data
        log_message('info', '[FEEDBACK] Attempting to insert data');
        log_message('debug', '[FEEDBACK] Form Data: ' . json_encode($formData));
        log_message('debug', '[FEEDBACK] Insert Data: ' . json_encode($data));

        if ($this->feedbackModel->insert($data)) {
            $insertId = $this->feedbackModel->getInsertID();
            log_message('info', '[FEEDBACK] Insert SUCCESS - ID: ' . $insertId);
            return redirect()->to('/thank-you')->with('success', 'Terima kasih atas kritik dan saran Anda!');
        }

        $errors = $this->feedbackModel->errors();
        log_message('error', '[FEEDBACK] Insert FAILED: ' . json_encode($errors));
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }

    /**
     * Submit Guest Book Form
     */
    private function submitGuestBook($fields)
    {
        $validation = \Config\Services::validation();
        $formData = [];
        $uploadedFiles = [];

        // Build validation rules - file upload optional
        $rules = [];
        foreach ($fields as $field) {
            if ($field['is_required'] && $field['field_type'] !== 'file') {
                $rules[$field['field_name']] = 'required';
            }
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Process form data
        foreach ($fields as $field) {
            $fieldName = $field['field_name'];
            
            if ($field['field_type'] === 'file') {
                // Handle file upload
                $file = $this->request->getFile($fieldName);
                if ($file && $file->isValid()) {
                    $uploadResult = $this->handleFileUpload($file);
                    if ($uploadResult['success']) {
                        $uploadedFiles[] = $uploadResult['data'];
                        $formData[$fieldName] = $uploadResult['data'];
                    } else {
                        return redirect()->back()->withInput()->with('error', $uploadResult['message']);
                    }
                }
            } else {
                $formData[$fieldName] = $this->request->getPost($fieldName);
            }
        }

        // Save to database
        $data = [
            'form_data' => $formData,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'tanggal_kunjungan' => $formData['tanggal_kunjungan'] ?? null,
            'tanggal_pengajuan' => $formData['tanggal_pengajuan'] ?? null,
            'file_kunjungan' => $formData['file_kunjungan']['saved_name'] ?? null
        ];

        // DEBUG: Log form data
        log_message('info', '[GUEST_BOOK] Attempting to insert data');
        log_message('debug', '[GUEST_BOOK] Form Data: ' . json_encode($formData));
        log_message('debug', '[GUEST_BOOK] Insert Data: ' . json_encode($data));

        if ($this->guestBookModel->insert($data)) {
            $insertId = $this->guestBookModel->getInsertID();
            log_message('info', '[GUEST_BOOK] Insert SUCCESS - ID: ' . $insertId);
            return redirect()->to('/thank-you')->with('success', 'Terima kasih telah mengisi buku tamu!');
        }

        $errors = $this->guestBookModel->errors();
        log_message('error', '[GUEST_BOOK] Insert FAILED: ' . json_encode($errors));
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }

    /**
     * Handle file upload dengan security validation
     */
    private function handleFileUpload($file)
    {
        // Allowed extensions HANYA untuk doc, pdf, docx
        $allowedExtensions = [
            'pdf', 'doc', 'docx'
        ];

        // Allowed MIME types untuk doc, pdf, docx
        $allowedMimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $maxSize = 20 * 1024 * 1024; // 20MB in bytes

        // Validation
        if (!$file->isValid()) {
            return [
                'success' => false,
                'message' => 'File tidak valid: ' . $file->getErrorString()
            ];
        }

        // Check file size
        if ($file->getSize() > $maxSize) {
            return [
                'success' => false,
                'message' => 'Ukuran file melebihi 20MB'
            ];
        }

        // Check extension
        $extension = strtolower($file->getClientExtension());
        if (!in_array($extension, $allowedExtensions)) {
            return [
                'success' => false,
                'message' => 'Format file tidak diperbolehkan. Hanya format: PDF, DOC, DOCX'
            ];
        }

        // Check MIME type
        $mimeType = $file->getClientMimeType();
        if (!in_array($mimeType, $allowedMimeTypes)) {
            return [
                'success' => false,
                'message' => 'Tipe file tidak sesuai. Pastikan file adalah PDF, DOC, atau DOCX'
            ];
        }

        // Generate random filename
        $newName = $file->getRandomName();
        
        // Move file to uploads directory
        $uploadPath = WRITEPATH . 'uploads/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        try {
            $file->move($uploadPath, $newName);
            
            return [
                'success' => true,
                'data' => [
                    'original_name' => $file->getClientName(),
                    'saved_name' => $newName,
                    'file_size' => $file->getSize(),
                    'mime_type' => $mimeType,
                    'extension' => $extension,
                    'upload_date' => date('Y-m-d H:i:s')
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Thank you page
     */
    public function thankYou()
    {
        return view('public/thank_you', [
            'title' => 'Terima Kasih'
        ]);
    }

    /**
     * Cari surat kunjungan berdasarkan nama
     */
    public function searchGuestBook()
    {
        $nama = $this->request->getGet('nama');
        $guestBooks = [];
        $error = null;

        if ($this->request->getMethod() === 'GET' && $nama) {
            $nama = trim($nama);
            
            if (strlen($nama) < 3) {
                $error = 'Nama minimal 3 karakter';
            } else {
                $guestBooks = $this->guestBookModel
                    ->orderBy('created_at', 'DESC')
                    ->findAll();

                // Filter berdasarkan nama_lengkap dari form_data JSON
                $guestBooks = array_filter($guestBooks, function ($item) use ($nama) {
                    $data = is_string($item['form_data']) ? json_decode($item['form_data'], true) : $item['form_data'];
                    return isset($data['nama_lengkap']) && stripos($data['nama_lengkap'], $nama) !== false;
                });

                if (empty($guestBooks)) {
                    $error = 'Tidak ada surat kunjungan yang ditemukan dengan nama ini';
                }
            }
        }

        return view('public/guest_book_list', [
            'title' => 'Status Surat Kunjungan Anda',
            'guestBooks' => array_values($guestBooks),
            'searchNama' => $nama,
            'error' => $error
        ]);
    }

    /**
     * Detail balasan surat kunjungan
     */
    public function detailBalasan($id)
    {
        $guestBook = $this->guestBookModel->find($id);

        if (!$guestBook) {
            return redirect()->to('/welcome')->with('error', 'Surat tidak ditemukan');
        }

        $data = is_string($guestBook['form_data']) ? json_decode($guestBook['form_data'], true) : $guestBook['form_data'];

        return view('public/detail_balasan', [
            'title' => 'Detail Balasan Surat',
            'guestBook' => $guestBook,
            'formData' => $data
        ]);
    }
}

