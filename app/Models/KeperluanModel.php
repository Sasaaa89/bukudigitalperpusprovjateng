<?php

namespace App\Models;

use CodeIgniter\Model;

class KeperluanModel extends Model
{
    protected $table = 'keperluan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_keperluan', 'deskripsi', 'is_active'];

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

    public function getActiveKeperluan()
    {
        return $this->where('is_active', 1)
                   ->orderBy('nama_keperluan', 'ASC')
                   ->findAll();
    }
}