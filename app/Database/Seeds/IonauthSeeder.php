<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IonauthSeeder extends Seeder
{
	public function run()
	{
		$config = config('IonAuth\\Config\\IonAuth');
		$this->DBGroup = empty($config->databaseGroupName) ? '' : $config->databaseGroupName;
		$tables        = $config->tables;

		$groups = [
			[
				'id'          => 1,
				'name'        => 'superadmin',
				'description' => 'Super Administrator',
				'active' 	  	=> 1,
			],
			[
				'id'          => 2,
				'name'        => 'admin',
				'description' => 'Administrator',
				'active' 	  	=> 1,
			],
			[
				'id'          => 3,
				'name'        => 'members',
				'description' => 'Member',
				'active' 	  	=> 1,
			],
		];
		$this->db->table($tables['groups'])->insertBatch($groups);

		$users = [
			[
				'id'											=> 1,
				'ip_address'              => '127.0.0.1',
				'username'                => 'superadmin',
				'password'                => password_hash('P@ssw0rd*', PASSWORD_BCRYPT),
				'email'                   => 'superadmin@pejuang.com',
				'activation_code'         => '',
				'forgotten_password_code' => null,
				'created_on'              => '1268889823',
				'last_login'              => '1268889823',
				'active'                  => '1',
				'first_name'              => 'Super',
				'last_name'               => 'Administrator',
				'full_name'               => 'Super Admnistrator',
				'prefix'                  => 'Bpk.',
				'nip'		                  => '0000',
				'company'                 => 'Pejuang Rupiah',
				'phone'                   => '081123456678',
			],
			[
				'id'											=> 2,
				'ip_address'              => '127.0.0.1',
				'username'                => 'admin',
				'password'                => password_hash('P@ssw0rd*', PASSWORD_BCRYPT),
				'email'                   => 'admin@pejuang.com',
				'activation_code'         => '',
				'forgotten_password_code' => null,
				'created_on'              => '1268889823',
				'last_login'              => '1268889823',
				'active'                  => '1',
				'first_name'              => 'Administrator',
				'last_name'               => '',
				'full_name'               => 'Admnistrator',
				'prefix'                  => 'Bpk.',
				'nip'		                  => '0000',
				'company'                 => 'Pejuang Rupiah',
				'phone'                   => '081123456678',
			],
			[
				'id'											=> 3,
				'ip_address'              => '127.0.0.1',
				'username'                => 'member',
				'password'                => password_hash('P@ssw0rd*', PASSWORD_BCRYPT),
				'email'                   => 'member@pejuang.com',
				'activation_code'         => '',
				'forgotten_password_code' => null,
				'created_on'              => '1268889823',
				'last_login'              => '1268889823',
				'active'                  => '1',
				'first_name'              => 'Member',
				'last_name'               => 'PR',
				'full_name'               => 'Member PR',
				'prefix'                  => 'Bpk.',
				'nip'		                  => '0000',
				'company'                 => 'Pejuang Rupiah',
				'phone'                   => '081123456678',
			],
		];
		$this->db->table($tables['users'])->insertBatch($users);

		$usersGroups = [
			[
				'id'			=> 1,
				'user_id' => '1',
				'role_id' => '1',
			],
			[
				'id'			=> 2,
				'user_id' => '2',
				'role_id' => '2',
			],
			[
				'id'			=> 3,
				'user_id' => '3',
				'role_id' => '3',
			],
		];
		$this->db->table($tables['users_groups'])->insertBatch($usersGroups);
	}
}
