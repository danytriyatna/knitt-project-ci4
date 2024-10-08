<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    function __construct()
    {

    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        } else {
            $this->data['titlehead'] = "Dashboard";

            return view('dashboard/index', $this->data);
        }

	}
    
}
