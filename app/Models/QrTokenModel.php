<?php

namespace App\Models;

use CodeIgniter\Model;

class QrTokenModel extends Model
{
    protected $table = 'qr_tokens';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['token', 'is_active', 'created_by'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function generateNewToken($adminId)
    {
        // Deactivate all existing tokens
        $this->where('is_active', 1)->set('is_active', 0)->update();
        
        // Generate new token
        $token = bin2hex(random_bytes(32));
        
        return $this->insert([
            'token' => $token,
            'is_active' => 1,
            'created_by' => $adminId
        ]);
    }

    public function validateToken($token)
    {
        return $this->where('token', $token)
                   ->where('is_active', 1)
                   ->first();
    }

    public function getActiveToken()
    {
        return $this->where('is_active', 1)->first();
    }
}