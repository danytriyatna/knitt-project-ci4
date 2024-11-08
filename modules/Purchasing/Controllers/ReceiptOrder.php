<?php

namespace Modules\Purchasing\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class ReceiptOrder extends BaseController
{
  protected $views = '\Modules\Purchasing\Views';

  public function index()
  {
    $this->data['titlehead'] = "Receipt Order";
    
    return view($this->views . '\receipt_order_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Receipt Order";

    return view($this->views . '\receipt_order_form', $this->data);
  }
}
