<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class WorkOrder extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {
    $this->data['titlehead'] = "Work Order";
    
    return view($this->views . '\work_order_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Work Order";

    return view($this->views . '\work_order_form', $this->data);
  }
}
