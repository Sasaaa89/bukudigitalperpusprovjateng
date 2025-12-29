<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FeedbackModel;
use App\Models\GuestBookModel;

class RiwayatController extends BaseController
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
        $type = $this->request->getGet('type') ?? 'all';
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $riwayat = [];

        if ($type === 'all' || $type === 'feedback') {
            $feedbackData = $this->getFeedbackData($startDate, $endDate);
            foreach ($feedbackData as $item) {
                $riwayat[] = [
                    'id' => $item['id'],
                    'type' => 'feedback',
                    'type_label' => 'Kritik & Saran',
                    'data' => $item['form_data'],
                    'created_at' => $item['created_at']
                ];
            }
        }

        if ($type === 'all' || $type === 'guest_book') {
            $guestBookData = $this->getGuestBookData($startDate, $endDate);
            foreach ($guestBookData as $item) {
                $riwayat[] = [
                    'id' => $item['id'],
                    'type' => 'guest_book',
                    'type_label' => 'Buku Tamu',
                    'data' => $item['form_data'],
                    'created_at' => $item['created_at']
                ];
            }
        }

        // Sort by created_at descending
        usort($riwayat, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $data = [
            'title' => 'Riwayat Pengunjung',
            'riwayat' => $riwayat,
            'currentType' => $type,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('admin/riwayat/index', $data);
    }

    private function getFeedbackData($startDate = null, $endDate = null)
    {
        $builder = $this->feedbackModel->builder();
        
        if ($startDate) {
            $builder->where('created_at >=', $startDate . ' 00:00:00');
        }
        
        if ($endDate) {
            $builder->where('created_at <=', $endDate . ' 23:59:59');
        }
        
        return $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }

    private function getGuestBookData($startDate = null, $endDate = null)
    {
        $builder = $this->guestBookModel->builder();
        
        if ($startDate) {
            $builder->where('created_at >=', $startDate . ' 00:00:00');
        }
        
        if ($endDate) {
            $builder->where('created_at <=', $endDate . ' 23:59:59');
        }
        
        return $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }
}