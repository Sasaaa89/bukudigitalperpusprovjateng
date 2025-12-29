<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestBookModel extends Model
{
    protected $table = 'guest_book';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['form_data', 'ip_address', 'user_agent', 'tanggal_kunjungan', 'tanggal_pengajuan', 'file_kunjungan', 'status_balasan', 'file_balasan', 'catatan_balasan', 'tanggal_balasan'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'form_data' => 'json-array'
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getStatistics($startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        
        if ($startDate) {
            $builder->where('created_at >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('created_at <=', $endDate);
        }
        
        return [
            'total' => $builder->countAllResults(false),
            'daily' => $this->getDailyStatistics($startDate, $endDate)
        ];
    }

    private function getDailyStatistics($startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        $builder->select('DATE(created_at) as date, COUNT(*) as count');
        
        if ($startDate) {
            $builder->where('created_at >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('created_at <=', $endDate);
        }
        
        return $builder->groupBy('DATE(created_at)')
                      ->orderBy('date', 'ASC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get visitor statistics (Laki-laki vs Perempuan)
     */
    public function getVisitorStatistics($startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        
        if ($startDate) {
            $builder->where('created_at >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('created_at <=', $endDate);
        }
        
        $results = $builder->get()->getResultArray();
        
        $totalLakiLaki = 0;
        $totalPerempuan = 0;
        
        foreach ($results as $row) {
            $formData = is_string($row['form_data']) ? json_decode($row['form_data'], true) : $row['form_data'];
            $totalLakiLaki += (int)($formData['jumlah_laki_laki'] ?? 0);
            $totalPerempuan += (int)($formData['jumlah_perempuan'] ?? 0);
        }
        
        return [
            'laki_laki' => $totalLakiLaki,
            'perempuan' => $totalPerempuan,
            'total' => $totalLakiLaki + $totalPerempuan
        ];
    }

    /**
     * Get daily visitor statistics (Laki-laki vs Perempuan)
     */
    public function getDailyVisitorStatistics($startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        
        if ($startDate) {
            $builder->where('created_at >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('created_at <=', $endDate);
        }
        
        $results = $builder->get()->getResultArray();
        
        $dailyStats = [];
        
        foreach ($results as $row) {
            $date = date('Y-m-d', strtotime($row['created_at']));
            $formData = is_string($row['form_data']) ? json_decode($row['form_data'], true) : $row['form_data'];
            
            if (!isset($dailyStats[$date])) {
                $dailyStats[$date] = [
                    'date' => $date,
                    'laki_laki' => 0,
                    'perempuan' => 0
                ];
            }
            
            $dailyStats[$date]['laki_laki'] += (int)($formData['jumlah_laki_laki'] ?? 0);
            $dailyStats[$date]['perempuan'] += (int)($formData['jumlah_perempuan'] ?? 0);
        }
        
        // Sort by date
        ksort($dailyStats);
        
        return array_values($dailyStats);
    }

    /**
     * Get monthly visitor statistics (Laki-laki vs Perempuan) - Lifetime (All years)
     */
    public function getMonthlyVisitorStatistics($year = null)
    {
        $builder = $this->builder();
        $results = $builder->get()->getResultArray();
        
        $monthlyStats = [];
        
        // Initialize all months with year context
        foreach ($results as $row) {
            $monthKey = date('n', strtotime($row['created_at'])); // Month 1-12
            $yearKey = date('Y', strtotime($row['created_at'])); // Year
            $key = $yearKey . '-' . str_pad($monthKey, 2, '0', STR_PAD_LEFT);
            
            $formData = is_string($row['form_data']) ? json_decode($row['form_data'], true) : $row['form_data'];
            
            if (!isset($monthlyStats[$key])) {
                $monthlyStats[$key] = [
                    'year' => $yearKey,
                    'month' => (int)$monthKey,
                    'laki_laki' => 0,
                    'perempuan' => 0
                ];
            }
            
            $monthlyStats[$key]['laki_laki'] += (int)($formData['jumlah_laki_laki'] ?? 0);
            $monthlyStats[$key]['perempuan'] += (int)($formData['jumlah_perempuan'] ?? 0);
        }
        
        // Sort by year and month
        ksort($monthlyStats);
        
        return array_values($monthlyStats);
    }

    /**
     * Get yearly visitor statistics (Laki-laki vs Perempuan) - All years available
     */
    public function getYearlyVisitorStatistics()
    {
        $builder = $this->builder();
        
        // Get all data to find year range
        $results = $builder->get()->getResultArray();
        
        if (empty($results)) {
            return [];
        }
        
        // Find min and max year from data
        $years = [];
        foreach ($results as $row) {
            $year = (int)date('Y', strtotime($row['created_at']));
            $years[$year] = true;
        }
        
        $minYear = min(array_keys($years));
        $maxYear = max(array_keys($years));
        
        $yearlyStats = [];
        
        // Initialize all years in range
        for ($year = $minYear; $year <= $maxYear; $year++) {
            $yearlyStats[$year] = [
                'year' => $year,
                'laki_laki' => 0,
                'perempuan' => 0
            ];
        }
        
        foreach ($results as $row) {
            $year = (int)date('Y', strtotime($row['created_at']));
            $formData = is_string($row['form_data']) ? json_decode($row['form_data'], true) : $row['form_data'];
            
            $yearlyStats[$year]['laki_laki'] += (int)($formData['jumlah_laki_laki'] ?? 0);
            $yearlyStats[$year]['perempuan'] += (int)($formData['jumlah_perempuan'] ?? 0);
        }
        
        return array_values($yearlyStats);
    }
}