<?php

namespace Modules\Referensi\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class RefProduk extends BaseController
{
  protected $views = '\Modules\Referensi\Views';

  public function index()
  {

    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Produk";
    
    return view($this->views . '\produk\index', $this->data);
  }
}
