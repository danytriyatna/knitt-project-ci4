<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class DeliveryOrder extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {
    $this->data['titlehead'] = "Delivery Order";
    
    return view($this->views . '\delivery_order_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Delivery Order";

    return view($this->views . '\delivery_order_form', $this->data);
  }
}
