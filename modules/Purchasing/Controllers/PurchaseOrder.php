<?php

namespace Modules\Purchasing\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class PurchaseOrder extends BaseController
{
  protected $views = '\Modules\Purchasing\Views';

  public function index()
  {
    $this->data['titlehead'] = "Purchase Order";
    
    return view($this->views . '\purchase_order_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Purchase Order";

    return view($this->views . '\purchase_order_form', $this->data);
  }
}
