<?php

namespace Modules\Purchasing\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class ReceiveItem extends BaseController
{
  protected $views = '\Modules\Purchasing\Views';

  public function index()
  {
    $this->data['titlehead'] = "Receive Item";
    
    return view($this->views . '\receive_item_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Receive Item";

    return view($this->views . '\receive_item_form', $this->data);
  }
}
