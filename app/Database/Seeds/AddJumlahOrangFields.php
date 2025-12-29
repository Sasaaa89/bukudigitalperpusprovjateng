<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddJumlahOrangFields extends Seeder
{
    public function run()
    {
        // Check if field already exists
        $exists = $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->where('field_name', 'jumlah_laki_laki')
            ->countAllResults();

        if (!$exists) {
            // Insert the fields
            $this->db->table('form_fields')->insertBatch([
                [
                    'form_type' => 'guest_book',
                    'field_name' => 'jumlah_laki_laki',
                    'field_label' => 'Jumlah Laki-laki',
                    'field_type' => 'number',
                    'is_required' => 0,
                    'field_options' => null,
                    'sort_order' => 7,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'form_type' => 'guest_book',
                    'field_name' => 'jumlah_perempuan',
                    'field_label' => 'Jumlah Perempuan',
                    'field_type' => 'number',
                    'is_required' => 0,
                    'field_options' => null,
                    'sort_order' => 8,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'form_type' => 'guest_book',
                    'field_name' => 'tanggal_pengajuan',
                    'field_label' => 'Tanggal Pengajuan',
                    'field_type' => 'date',
                    'is_required' => 1,
                    'field_options' => null,
                    'sort_order' => 9,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);

            echo "Jumlah orang fields added successfully!\n";
        } else {
            echo "Fields already exist, skipping...\n";
        }
    }
}
