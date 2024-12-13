<?php

namespace Modules\Purchasing\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Purchasing\Models\PurchaseModel;

class PurchaseOrder extends BaseController
{
  protected $views = '\Modules\Purchasing\Views';
  protected $mPO;
  protected $urlv  = 'trans/purchase-order';
  function __construct()
  {
    $this->MOD_ALIAS = "MOD_PURCHASE_ORDER";
    $this->mPO = new PurchaseModel();
  }

  public function index()
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }


    $this->data['titlehead'] = "Purchase Order";

    return view($this->views . '\purchase_order_list', $this->data);
  }

  public function lists()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mPO->getData(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mPO->getDataCnt($filters, $params);
    $totaldata = $this->mPO->getDataCnt(null, $params);
    $maxpage = ceil($totalfiltered / $limit);

    $build_array = array(
      "last_page" => $maxpage,
      "recordsTotal" => $totaldata,
      "recordsFiltered" => $totalfiltered,
      "data" => array()
    );

    foreach ($results as $row) {
      $id = encrypt($row->id);

      $atr_edit = null;
      $atr_del = null;
      $btnAction = null;
      if ($this->_edit) {
        $atr_edit['title'] = 'Edit';
        $atr_edit['url'] = $this->urlv . '/edit/';
        $atr_edit['class'] = '';
      }
      // if ($this->_delete) {
      //   $atr_del['title'] = 'Hapus';
      //   $atr_del['url'] = $this->urlv . '/delete/';
      //   $atr_del['class'] = '';
      //   $atr_del['onclick'] = "return confirm('Hapus Data ?')";
      // }
      if ($atr_edit || $atr_del)
        $btnAction = btn_action_group($id, $atr_edit, $atr_del);




      // $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan user ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
      //                            "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan user ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";

      array_push(
        $build_array["data"],
        array(
          "aksi" => $btnAction ? $btnAction : '',
          "id"   => ($id),
          "nama_vendor" => $row->nama_vendor,
          "po_no" => $row->po_no,
          "term" => $row->term,
          "po_date" => fdate_eng_to_ind($row->po_date),
          "qty" => $row->qty_payment . "/" . $row->qty,
          "total" => $row->total,
          "total_payment" => $row->total_payment,
          "sisa" => $row->total -  $row->total_payment
        )
      );
    }
    return $this->response->setJSON($build_array);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Purchase Order";
    $resTerm = $this->mPO->getRefTerm();
    $resTax = $this->mPO->getRefTax();
    $this->data['term'] = $resTerm;
    $this->data['tax'] = $resTax;
    $this->data['status'] = 0;
    return view($this->views . '\purchase_order_form', $this->data);
  }
}
