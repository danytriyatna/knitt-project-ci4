<?php

namespace Modules\SDM\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class Absensi extends BaseController
{
  protected $views = '\Modules\SDM\Views';

  public function index()
  {
    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Absensi";
    
    return view($this->views . '\absensi_list', $this->data);
  }
}
