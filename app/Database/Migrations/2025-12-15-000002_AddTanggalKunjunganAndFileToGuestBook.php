<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalKunjunganAndFileToGuestBook extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guest_book', [
            'tanggal_kunjungan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'file_kunjungan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guest_book', ['tanggal_kunjungan', 'file_kunjungan']);
    }
}
