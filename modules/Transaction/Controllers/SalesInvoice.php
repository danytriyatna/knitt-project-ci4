<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class SalesInvoice extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {
    $this->data['titlehead'] = "Sales Invoice";
    
    return view($this->views . '\sales_invoice_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Sales Invoice";

    return view($this->views . '\sales_invoice_form', $this->data);
  }
}
