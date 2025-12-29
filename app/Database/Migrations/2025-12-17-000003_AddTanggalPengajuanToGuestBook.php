<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanggalPengajuanToGuestBook extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guest_book', [
            'tanggal_pengajuan' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'tanggal_kunjungan'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guest_book', 'tanggal_pengajuan');
    }
}
