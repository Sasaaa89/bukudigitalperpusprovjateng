<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanupTanggalPengajuanFields extends Migration
{
    public function up()
    {
        // Delete all tanggal_pengajuan fields to clean up duplicates
        $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->where('field_name', 'tanggal_pengajuan')
            ->delete();

        // Insert single clean tanggal_pengajuan field
        $this->db->table('form_fields')->insert([
            'form_type' => 'guest_book',
            'field_name' => 'tanggal_pengajuan',
            'field_label' => 'Tanggal Pengajuan',
            'field_type' => 'date',
            'is_required' => 1,
            'field_options' => null,
            'sort_order' => 5,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->where('field_name', 'tanggal_pengajuan')
            ->delete();
    }
}
