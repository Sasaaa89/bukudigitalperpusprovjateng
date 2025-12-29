<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateTanggalPengajuanLabel extends Seeder
{
    public function run()
    {
        $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->where('field_name', 'tanggal_pengajuan')
            ->update(['field_label' => 'Tanggal Pengajuan']);
    }
}
