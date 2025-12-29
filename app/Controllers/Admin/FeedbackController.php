<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FeedbackModel;

class FeedbackController extends BaseController
{
    protected $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = new FeedbackModel();
    }

    public function index()
    {
        $feedback = $this->feedbackModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Data Kritik & Saran',
            'feedback' => $feedback
        ];

        return view('admin/feedback/index', $data);
    }

    public function view($id)
    {
        $feedback = $this->feedbackModel->find($id);
        
        if (!$feedback) {
            return redirect()->to('/admin/feedback')->with('error', 'Data tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail Kritik & Saran',
            'feedback' => $feedback
        ];

        return view('admin/feedback/view', $data);
    }

    public function delete($id)
    {
        if ($this->feedbackModel->delete($id)) {
            return redirect()->to('/admin/feedback')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect()->to('/admin/feedback')->with('error', 'Gagal menghapus data!');
        }
    }
}