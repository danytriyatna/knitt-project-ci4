<?php

namespace App\Controllers\Api\user;

use App\Controllers\BaseController;
use Modules\Utility\Models\UserModel;

class Testjwt extends BaseController
{
	function __construct()
    {
        $this->users = new UserModel();
    }

	public function user()
	{
		$user = $this->users->findAll();

		$data = [
			'success' => true,
			'data' => $user,
		];
		
		return $this->response->setJSON($data);

	}
}
