<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuestBookModel;

class GuestBookController extends BaseController
{
    protected $guestBookModel;

    public function __construct()
    {
        $this->guestBookModel = new GuestBookModel();
    }

    public function index()
    {
        $guestBook = $this->guestBookModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Data Buku Tamu',
            'guestBook' => $guestBook
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
}