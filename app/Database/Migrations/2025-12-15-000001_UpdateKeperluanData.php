<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateKeperluanData extends Migration
{
    public function up()
    {
        // Clear existing keperluan data
        $this->db->table('keperluan')->truncate();

        // Insert new keperluan data
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

    public function down()
    {
        // Restore old keperluan data if needed
        $this->db->table('keperluan')->truncate();

        $data = [
            [
                'nama_keperluan' => 'Membaca Buku',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_keperluan' => 'Meminjam Buku',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_keperluan' => 'Penelitian',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_keperluan' => 'Belajar Kelompok',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_keperluan' => 'Kunjungan',
                'deskripsi' => '',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('keperluan')->insertBatch($data);
    }
}
