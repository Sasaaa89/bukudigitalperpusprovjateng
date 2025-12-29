<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'    => 'admin',
            'password'    => '$2y$10$EljBRFuOaaPt/vvsphkrTOfIFHKH.zmaR9GsWFGSmGYNmmaE.rZqC',
            'nama_lengkap' => 'Administrator',
            'email'       => 'admin@perpustakaan.com',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->db->table('admins')->insert($data);
    }
}