<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['form_data', 'ip_address', 'user_agent'];

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
}