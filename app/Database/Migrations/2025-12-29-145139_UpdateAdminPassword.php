<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAdminPassword extends Migration
{
    public function up()
    {
        // Update admin password to adminperpusdajateng
        $this->db->table('admins')->where('username', 'admin')->update([
            'password' => '$2y$10$EljBRFuOaaPt/vvsphkrTOfIFHKH.zmaR9GsWFGSmGYNmmaE.rZqC'
        ]);
    }

    public function down()
    {
        // Rollback to old password (untuk safety, tidak direkomendasikan)
        // $this->db->table('admins')->where('username', 'admin')->update([
        //     'password' => password_hash('admin123', PASSWORD_DEFAULT)
        // ]);
    }
}
