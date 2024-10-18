<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class Production extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {
    $this->data['titlehead'] = "Production";

    return view($this->views . '\production_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Production";

    return view($this->views . '\production_form', $this->data);
  }
}
