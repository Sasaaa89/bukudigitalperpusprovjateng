<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanupAndFixFormFields extends Migration
{
    public function up()
    {
        // First, delete ALL guest_book form fields
        $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->delete();

        // Then insert clean set of fields
        $guestBookFields = [
            [
                'form_type' => 'guest_book',
                'field_name' => 'nama_lengkap',
                'field_label' => 'Nama Lengkap',
                'field_type' => 'text',
                'is_required' => 1,
                'field_options' => null,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_type' => 'guest_book',
                'field_name' => 'asal_instansi',
                'field_label' => 'Asal Instansi',
                'field_type' => 'text',
                'is_required' => 1,
                'field_options' => null,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_type' => 'guest_book',
                'field_name' => 'keperluan',
                'field_label' => 'Keperluan',
                'field_type' => 'select',
                'is_required' => 1,
                'field_options' => 'keperluan_table',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_type' => 'guest_book',
                'field_name' => 'nomor_telepon',
                'field_label' => 'Nomor Telepon',
                'field_type' => 'text',
                'is_required' => 0,
                'field_options' => null,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_type' => 'guest_book',
                'field_name' => 'pesan',
                'field_label' => 'Pesan',
                'field_type' => 'textarea',
                'is_required' => 0,
                'field_options' => null,
                'sort_order' => 5,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_type' => 'guest_book',
                'field_name' => 'tanggal_kunjungan',
                'field_label' => 'Tanggal Kunjungan',
                'field_type' => 'date',
                'is_required' => 1,
                'field_options' => null,
                'sort_order' => 6,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'form_type' => 'guest_book',
                'field_name' => 'file_kunjungan',
                'field_label' => 'File Kunjungan',
                'field_type' => 'file',
                'is_required' => 0,
                'field_options' => null,
                'sort_order' => 7,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('form_fields')->insertBatch($guestBookFields);
    }

    public function down()
    {
        // Remove all guest_book fields
        $this->db->table('form_fields')
            ->where('form_type', 'guest_book')
            ->delete();
    }
}
