<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CleanupTanggalPengajuan extends Seeder
{
    public function run()
    {
        // Delete all tanggal_pengajuan fields
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

        echo "Tanggal Pengajuan field cleaned up successfully!\n";
    }
}
