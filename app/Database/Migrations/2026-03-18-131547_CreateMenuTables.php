<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuTables extends Migration
{
    public function up()
    {
        // user_menu_category
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'menu_category' => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user_menu_category');

        // user_menu
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'menu_category' => ['type' => 'INT'],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'url'           => ['type' => 'VARCHAR', 'constraint' => 200],
            'icon'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user_menu');

        // user_submenu
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'menu_id'       => ['type' => 'INT'],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'url'           => ['type' => 'VARCHAR', 'constraint' => 200],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user_submenu');

        // user_access
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'role_id'          => ['type' => 'INT'],
            'menu_category_id' => ['type' => 'INT', 'null' => true],
            'menu_id'          => ['type' => 'INT', 'null' => true],
            'submenu_id'       => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user_access');
    }

    public function down()
    {
        $this->forge->dropTable('user_access', true);
        $this->forge->dropTable('user_submenu', true);
        $this->forge->dropTable('user_menu', true);
        $this->forge->dropTable('user_menu_category', true);
    }
}
