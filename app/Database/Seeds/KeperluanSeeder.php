<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KeperluanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_keperluan' => 'Kunjungan Sekolah',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_keperluan' => 'Kunjungan Perguruan Tinggi',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_keperluan' => 'Kunjungan Instansi/Industri',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('keperluan')->insertBatch($data);
    }
}