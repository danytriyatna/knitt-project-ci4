<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Files extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
					'type'           => 'INT',
					'constraint'     => 11,
					'auto_increment' => true,
			],
			'file_name'       	 => [
					'type'       => 'TEXT',
			],
			'file_size' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'file_type' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'file_name_origin' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'active' => [
					'type'       => 'TINYINT',
					'constraint' => '1',
					'unsigned'   => true,
					'null'       => true,
			],
			'created_at' => [
					'type'       => 'DATETIME',
					'null'       => true,
			],
			'updated_at' => [
					'type'       => 'DATETIME',
					'null' 		 => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('_files');
	}

	public function down()
	{
		$this->forge->dropTable('_files');
	}
}
