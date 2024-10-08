<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SecModul extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
					'type'           => 'INT',
					'constraint'     => 11,
					'auto_increment' => true,
			],
			'name'       => [
					'type'       => 'VARCHAR',
					'constraint' => '100',
			],
			'alias' => [
					'type'       => 'VARCHAR',
					'constraint' => '100',
					'null' => true,
			],
			'url' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'icon_cls' => [
					'type'       => 'VARCHAR',
					'constraint' => '50',
					'null' => true,
			],
			'seq' => [
					'type'       => 'INT',
					'constraint' => 11,
			],
			'pid' => [
					'type'       => 'INT',
					'constraint' => 11,
					'null' => true,
			],
			'publish' => [
					'type'       => 'INT',
					'constraint' => 11,
			],
			'group' => [
					'type'       => 'VARCHAR',
					'constraint' => '100',
					'null' => true,
			],
			'is_sapage' => [
					'type'       => 'TINYINT',
					'constraint' => 4,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('sec_modul');
	}

	public function down()
	{
		$this->forge->dropTable('sec_modul');
	}
}
