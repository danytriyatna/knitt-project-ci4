<?php

namespace Modules\Purchasing\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class PurchasePayment extends BaseController
{
  protected $views = '\Modules\Purchasing\Views';

  public function index()
  {

    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Purchase Payment";
    
    return view($this->views . '\purchase_payment_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Purchase Payment";

    return view($this->views . '\purchase_payment_form', $this->data);
  }
}
