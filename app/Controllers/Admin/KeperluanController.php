<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KeperluanModel;

class KeperluanController extends BaseController
{
    protected $keperluanModel;

    public function __construct()
    {
        $this->keperluanModel = new KeperluanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Keperluan',
            'keperluan' => $this->keperluanModel->findAll()
        ];

        return view('admin/keperluan/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'nama_keperluan' => $this->request->getPost('nama_keperluan'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($this->keperluanModel->insert($data)) {
                return redirect()->to('/admin/keperluan')->with('success', 'Keperluan berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('error', 'Gagal menambahkan keperluan!');
            }
        }

        $data = ['title' => 'Tambah Keperluan'];
        return view('admin/keperluan/create', $data);
    }

    public function edit($id)
    {
        $keperluan = $this->keperluanModel->find($id);
        
        if (!$keperluan) {
            return redirect()->to('/admin/keperluan')->with('error', 'Keperluan tidak ditemukan!');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'nama_keperluan' => $this->request->getPost('nama_keperluan'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($this->keperluanModel->update($id, $data)) {
                return redirect()->to('/admin/keperluan')->with('success', 'Keperluan berhasil diupdate!');
            } else {
                return redirect()->back()->with('error', 'Gagal mengupdate keperluan!');
            }
        }

        $data = [
            'title' => 'Edit Keperluan',
            'keperluan' => $keperluan
        ];
        
        return view('admin/keperluan/edit', $data);
    }

    public function delete($id)
    {
        if ($this->keperluanModel->delete($id)) {
            return redirect()->to('/admin/keperluan')->with('success', 'Keperluan berhasil dihapus!');
        } else {
            return redirect()->to('/admin/keperluan')->with('error', 'Gagal menghapus keperluan!');
        }
    }
}