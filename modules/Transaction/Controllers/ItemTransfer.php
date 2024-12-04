<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class ItemTransfer extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {

    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    
    $this->data['titlehead'] = "Item Transfer";
    
    return view($this->views . '\item_transfer_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Item Transfer";

    return view($this->views . '\item_transfer_form', $this->data);
  }
}
