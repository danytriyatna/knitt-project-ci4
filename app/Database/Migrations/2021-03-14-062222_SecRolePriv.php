<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SecRolePriv extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'role_id'          		=> [
					'type'          => 'INT',
					'constraint'    => 11,
			],
			'module_id'       		=> [
					'type'       	=> 'INT',
					'constraint'    => 11,
			],
			'allow_view' 			=> [
					'type'       	=> 'TINYINT',
					'constraint' 	=> '1',
			],
			'allow_new' 			=> [
					'type'       	=> 'TINYINT',
					'constraint' 	=> '1',
			],
			'allow_edit' 			=> [
					'type'       	=> 'TINYINT',
					'constraint' 	=> '1',
			],
			'allow_delete' 			=> [
					'type'       	=> 'TINYINT',
					'constraint' 	=> '1',
			],
			'allow_print' 			=> [
					'type'       	=> 'TINYINT',
					'constraint' 	=> '1',
			],
			'allow_approve' 		=> [
					'type'       	=> 'TINYINT',
					'constraint' 	=> '1',
			],
		]);

		// $this->forge->addPrimaryKey('role_id');
		// $this->forge->addPrimaryKey('module_id');

		$this->forge->createTable('sec_role_priv');
	}

	public function down()
	{
		$this->forge->dropTable('sec_role_priv');
	}
}
