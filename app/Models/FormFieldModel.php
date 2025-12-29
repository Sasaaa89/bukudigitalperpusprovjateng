<?php

namespace App\Models;

use CodeIgniter\Model;

class FormFieldModel extends Model
{
    protected $table = 'form_fields';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['form_type', 'field_name', 'field_label', 'field_type', 'is_required', 'field_options', 'sort_order', 'is_active'];

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

    public function getFormFields($formType)
    {
        return $this->where('form_type', $formType)
                   ->where('is_active', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    public function updateSortOrder($fieldId, $newOrder)
    {
        return $this->update($fieldId, ['sort_order' => $newOrder]);
    }
}