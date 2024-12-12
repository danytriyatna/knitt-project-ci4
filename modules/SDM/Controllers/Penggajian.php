<?php

namespace Modules\SDM\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class Penggajian extends BaseController
{
  protected $views = '\Modules\SDM\Views';

  public function index()
  {
    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Penggajian";
    
    return view($this->views . '\penggajian_list', $this->data);
  }
}
