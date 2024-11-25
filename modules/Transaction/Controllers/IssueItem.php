<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class IssueItem extends BaseController
{
  protected $views = '\Modules\Transaction\Views';

  public function index()
  {
    $this->data['titlehead'] = "Issue Item";
    
    return view($this->views . '\issue_item_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Issue Item";

    return view($this->views . '\issue_item_form', $this->data);
  }
}
