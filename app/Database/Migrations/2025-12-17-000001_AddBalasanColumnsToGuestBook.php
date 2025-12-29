<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalasanColumnsToGuestBook extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guest_book', [
            'status_balasan' => [
                'type'       => 'ENUM',
                'constraint' => ['diterima', 'ditolak'],
                'null'       => true,
                'comment'    => 'Status balasan surat kunjungan'
            ],
            'file_balasan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'File surat balasan dari admin'
            ],
            'catatan_balasan' => [
                'type'  => 'TEXT',
                'null'  => true,
                'comment' => 'Catatan atau alasan balasan dari admin'
            ],
            'tanggal_balasan' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'comment' => 'Tanggal admin memberikan balasan'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guest_book', ['status_balasan', 'file_balasan', 'catatan_balasan', 'tanggal_balasan']);
    }
}
