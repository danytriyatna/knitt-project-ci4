<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllSeeder extends Seeder
{
	public function run()
	{
		$this->call('IonauthSeeder');
		$this->call('SecModulSeeder');
		$this->call('SecRolePrivSeeder');
		$this->call('SitesSeeder');
	}
}
