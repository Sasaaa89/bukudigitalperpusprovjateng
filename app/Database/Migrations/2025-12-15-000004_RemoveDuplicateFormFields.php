<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDuplicateFormFields extends Migration
{
    public function up()
    {
        // Get all guest_book form fields with keperluan
        $keperluanFields = $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->where('field_name', 'keperluan')
            ->get()
            ->getResultArray();

        // If there are multiple keperluan fields, keep only the first one and delete the rest
        if (count($keperluanFields) > 1) {
            // Get the ID of the first keperluan field to keep
            $keepId = $keperluanFields[0]['id'];
            
            // Delete all other keperluan fields
            $this->db->table('form_fields')
                ->where('form_type', 'guest_book')
                ->where('field_name', 'keperluan')
                ->whereNotIn('id', [$keepId])
                ->delete();
        }
    }

    public function down()
    {
        // Nothing to rollback
    }
}
