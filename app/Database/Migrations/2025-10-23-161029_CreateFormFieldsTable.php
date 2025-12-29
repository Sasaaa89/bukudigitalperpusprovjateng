<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormFieldsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'form_type' => [
                'type'       => 'ENUM',
                'constraint' => ['feedback', 'guest_book'],
            ],
            'field_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'field_label' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'field_type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'textarea', 'select', 'file', 'email', 'number', 'date'],
            ],
            'is_required' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'field_options' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('form_fields');
    }

    public function down()
    {
        $this->forge->dropTable('form_fields');
    }
}