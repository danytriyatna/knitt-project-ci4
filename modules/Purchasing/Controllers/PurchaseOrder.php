<?php

namespace Modules\Purchasing\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use DateTime;
use Modules\Purchasing\Models\PurchaseModel;
use Modules\Purchasing\Models\PurchaseDetailModel;

class PurchaseOrder extends BaseController
{
  protected $views = '\Modules\Purchasing\Views';
  protected $mPO;
  protected $mPODetail;
  protected $urlv  = 'purchasing/purchase-order';
  function __construct()
  {
    $this->MOD_ALIAS = "MOD_PURCHASE_ORDER";
    $this->mPO = new PurchaseModel();
    $this->mPODetail = new PurchaseDetailModel();
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
    $isReceive      = $this->request->getPost('isReceive');

    $params = [];
    $params['isReceive'] = $isReceive;

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
      // if ($this->_edit) {
      $atr_edit['title'] = 'Edit';
      $atr_edit['url'] = $this->urlv . '/form/';
      $atr_edit['class'] = '';
      // }
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
      $status = "";
      if ($row->status == 0) {
        $status = "Menunggu<br>Pembayaran";
      } else if ($row->status == 1) {
        $status = "Dibayar Sebagian";
      } else if ($row->status == 2) {
        $status = "Dibayar Penuh";
      }
      array_push(
        $build_array["data"],
        array(
          "aksi" => $btnAction ? $btnAction : '',
          "id"   => ($id),
          "nama_vendor" => $row->nama_vendor,
          "po_no" => $row->po_no,
          "term" => $row->term,
          "po_date" => fdate_eng_to_ind($row->po_date),
          "date_exc" => $row->date_exc,
          "qty" => $row->qty_payment . "/" . $row->qty,
          "total" => $row->total,
          "total_payment" => $row->total_payment,
          "sisa" => $row->total -  $row->total_payment,
          "status" => $status
        )
      );
    }
    return $this->response->setJSON($build_array);
  }

  public function form($id = null)
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }


    $this->data['id'] = $id;
    if ($id != "") {
      $id = decrypt($id);
      $resData = $this->mPO->getData($id);
      $resData->id_vendor = encrypt($resData->id_vendor);
      $poDate = date("d F Y", strtotime($resData->po_date));
      $dateExc = date("d F Y", strtotime($resData->date_exc));
      $resData->po_date = $poDate;
      $resData->date_exc = $dateExc;

      $sort = [
        [
          'field' => 'uk.id',
          'dir' => 'ASC'
        ]
      ];

      $resDataDetail = $this->mPODetail->getData(null, 0, 99999, $sort, params: array("id_header" => $id));
      foreach ($resDataDetail as &$rowData) {
        $rowData->id_barang = encrypt($rowData->id_barang);
      }
      $this->data['resData'] = $resData;
      $this->data['detail'] = json_encode($resDataDetail);
    }


    $this->data['titlehead'] = "Form Purchase Order";
    $resTerm = $this->mPO->getRefTerm();
    $resTax = $this->mPO->getRefTax();
    $this->data['term'] = $resTerm;
    $this->data['tax'] = $resTax;
    return view($this->views . '\purchase_order_form', $this->data);
  }

  public function save()
  {
    $msg    = "Data gagal disimpan !";
    $status = false;
    $id = $this->request->getPost('id');
    $id_vendor = $this->request->getPost('id_vendor');
    $po_date = $this->request->getPost('po_date');
    $date_exc = $this->request->getPost('date_exc');
    $id_term = $this->request->getPost('id_term');
    $ship_to = $this->request->getPost('ship_to');
    $total = $this->request->getPost('total');
    $qty = $this->request->getPost('qty');
    $dataDetail = $this->request->getPost('data');
    if ($id != "") {
      $id = decrypt($id);
    }
    if ($id_vendor != "") {
      $id_vendor = decrypt($id_vendor);
    }
    $dataHeader = [
      "id_vendor" => $id_vendor,
      "po_date" => $po_date,
      "date_exc" => $date_exc,
      "id_term" => $id_term,
      "ship_to" => $ship_to,
      "qty_payment" => 0,
      "total" => $total,
      "qty" => $qty,
      "status" => 0
    ];
    if ($id) {
      $dataHeader['updated_at'] = date("Y-m-d H:i:s");
      $dataHeader['updated_by'] = $this->get_userid();
    } else {
      $dataHeader['created_at'] = date("Y-m-d H:i:s");
      $dataHeader['created_by'] = $this->get_userid();
    }
    // print_r($data);exit;
    $res = $this->mPO->trxInsertUpdateRecord($dataHeader, $id, $dataDetail);
    if ($res) {
      $status = true;
      $msg = "Data berhasil disimpan!";
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;

    return $this->response->setJSON($build_array);
  }
}
