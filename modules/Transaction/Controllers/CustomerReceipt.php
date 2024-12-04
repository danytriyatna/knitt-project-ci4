<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\ProductionModel;
use Modules\Transaction\Models\WalkorderModel;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Transaction\Models\SampleModel;
use Modules\Referensi\Models\ProsesProduksiModel;

class CustomerReceipt extends BaseController
{
  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/delivery-order';

  

  public function index()
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Customer Receipt";
    
    return view($this->views . '\customer_receipt_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Customer Receipt";

    return view($this->views . '\customer_receipt_form', $this->data);
  }
}
