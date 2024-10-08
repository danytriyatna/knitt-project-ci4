<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SitesSeeder extends Seeder
{
	public function run()
	{
		$data = [
			'name_app'							=> 'Template CI4 PR4',
			'description'						=> 'Template untuk pengembangan aplikasi berbasis framework CodeIgniter 4 di lingkungan Pejuang Rupiah',
			'title'									=> 'Pejuang Rupiah',
			'footer'								=> 'Hak Cipta © Pejuang Rupiah',
			'primary_color'					=> '#1C40E2',
			'accent_color'					=> '#01A9CF',
			'bg_thead_color'				=> '#CCEEF6',
			'text_thead_color'			=> '#212529',
			'primary_dark_color'		=> '#5981EA',
			'accent_dark_color'			=> '#5981EA',
			'bg_thead_dark_color'		=> '#1E515E',
			'text_thead_dark_color'	=> '#CAD6E3'
		];

		$this->db->table('setting_situs')->insert($data);
	}
}
