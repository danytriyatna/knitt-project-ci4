<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogActivity extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'log_date' => [
					'type'       => 'DATETIME',
					'null' => true,
			],
			'ip_address' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'comp_name' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'user_id' => [
					'type'       => 'INT',
					'constraint' => 11,
					'null' => true,
			],
			'module_alias' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'trans_id' => [
					'type'       => 'VARCHAR',
					'constraint' => '50',
					'null' => true,
			],
			'activity' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'description' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'http_agent' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'http_host' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
			'mac_address' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
					'null' => true,
			],
		]);
		$this->forge->createTable('log_activity');
	}

	public function down()
	{
		$this->forge->dropTable('log_activity');
	}
}
