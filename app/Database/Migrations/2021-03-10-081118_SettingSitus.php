<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SettingSitus extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
					'type'           => 'INT',
					'constraint'     => 11,
					'auto_increment' => true,
			],
			'name_app'       => [
					'type'       => 'VARCHAR',
					'constraint' => '200',
			],
			'description'    => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
			],
			'title' => [
					'type'       => 'VARCHAR',
					'constraint' => '200',
			],
			'footer' => [
					'type'       => 'VARCHAR',
					'constraint' => '255',
			],
			'file_id_logo' => [
					'type'       => 'INT',
					'constraint' => 11,
					'null' => true,
			],
			'file_id_logo_text' => [
					'type'       => 'INT',
					'constraint' => 11,
					'null' => true,
			],
			'file_id_background_img' => [
					'type'       => 'INT',
					'constraint' => 11,
					'null' => true,
			],
			'other' => [
				'type'       => 'TEXT',
				'null' => true,
			],
			'primary_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'accent_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'bg_thead_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'text_thead_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'primary_dark_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'accent_dark_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'bg_thead_dark_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
			'text_thead_dark_color' => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null'			 => false,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('setting_situs');
	}

	public function down()
	{
		$this->forge->dropTable('setting_situs');
	}
}
