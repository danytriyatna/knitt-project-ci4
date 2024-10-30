<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class CustomerReceipt extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {
    $this->data['titlehead'] = "Customer Receipt";
    
    return view($this->views . '\customer_receipt_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Customer Receipt";

    return view($this->views . '\customer_receipt_form', $this->data);
  }
}
