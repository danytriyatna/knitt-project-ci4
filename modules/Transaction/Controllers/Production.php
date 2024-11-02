<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\ProductionModel;
use Modules\Transaction\Models\WalkorderModel;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Transaction\Models\SampleModel;
use Modules\Referensi\Models\ProsesProduksiModel;
use Modules\Referensi\Models\OperatorModel;

class Production extends BaseController
{
  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/production';
  protected $mProduksi;
  protected $mSample;
  protected $mSalesOrder;
  protected $mWalkorder;
  protected $mPproduksi;
  protected $mOperator;

  function __construct()
  {
    $this->MOD_ALIAS = "MOD_TRANSAKSI_PRODUKSI";
    $this->mProduksi = new ProductionModel();
    $this->mSample = new SampleModel();
    $this->mSalesOrder = new SalesOrderModel();
    $this->mWalkorder = new WalkorderModel();
    $this->mPproduksi = new ProsesProduksiModel();
    $this->mOperator = new OperatorModel();
  }

  public function index()
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Production";

    return view($this->views . '\production_list', $this->data);
  }

  public function lists()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mProduksi->getData(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mProduksi->getDataCnt($filters, $params);
    $totaldata = $this->mProduksi->getDataCnt(null, $params);
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
      if (true) {
        $atr_edit['title'] = 'Edit';
        $atr_edit['url'] = $this->urlv . '/form/';
        $atr_edit['class'] = '';
      }
      // if ($this->_delete) {
      if (false) {
        $atr_del['title'] = 'Hapus';
        $atr_del['url'] = $this->urlv . '/delete/';
        $atr_del['class'] = '';
        $atr_del['onclick'] = "return confirm('Hapus Data ?')";
      }
      // if ($atr_edit || $atr_del)
      $btnAction = btn_action_group($id, $atr_edit, $atr_del);

      // $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan user ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
      //                            "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan user ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";

      $status = $row->status == 1 ? "Draft" : "Submit";
      $tipe = $row->tipe_id == 1 ? "Sample" : "Sales Order";

      $qty = $row->qty;
      $qty_prod = $this->mWalkorder->getCnt_produksi($row->id_walkorder);

      array_push(
        $build_array["data"],
        array(
          "id"                => ($id),
          "ref_kode"          => ($row->kode_walkorder),
          "konsumen_nama"     => $row->konsumen_nama,
          "kode_prod"    => $row->kode_prod,
          "qty"               => $row->qty,
          "tipe"              => $tipe,
          "qty_prod"          => $qty_prod,
          "qty_remain"        => $qty - $qty_prod,
          "tgl_deadline"      => fdate_eng_to_ind($row->tgl_deadline),
          "tgl_transaksi"     => fdate_eng_to_ind($row->tgl_transaksi),
          "keterangan_style"  => $row->keterangan_style,
          "status"            => $status,
          "aksi"              => $btnAction
        )
      );
    }
    return $this->response->setJSON($build_array);
  }

  public function lists_ukuran()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');
    $tipeId      = $this->request->getPost('tipe_id');
    $refId      = $this->request->getPost('ref_id');
    $id_proses      = $this->request->getPost('id_proses');
    if ($refId != "") {
      $refId = decrypt($refId);
    }
    if ($tipeId != "") {
      $tipeId = decrypt($tipeId);
    }


    $params = [];
    if ($tipeId == 1) {
      $params = [];
      $params['id_sample'] = $refId;
      $results = $this->mSample->getDataUkuran(null, $start, $limit, $order, $filters, $params, $id_proses);
      $totalfiltered = $this->mSample->getDataUkuranCnt($filters, $params);
      $totaldata = $this->mSample->getDataUkuranCnt(null, $params);
    } else {
      $params = [];
      $params['id_sales_order'] = $refId;
      $results = $this->mSalesOrder->getDataUkuran(null, $start, $limit, $order, $filters, $params, $id_proses);
      $totalfiltered = $this->mSalesOrder->getDataUkuranCnt($filters, $params, $id_proses);
      $totaldata = $this->mSalesOrder->getDataUkuranCnt(null, $params, $id_proses);
    }


    $maxpage = ceil($totalfiltered / $limit);

    $build_array = array(
      "last_page" => $maxpage,
      "recordsTotal" => $totaldata,
      "recordsFiltered" => $totalfiltered,
      "data" => array()
    );

    foreach ($results as $row) {
      $id = encrypt($row->id);


      array_push(
        $build_array["data"],
        array(
          "id"                => ($id),
          "kode_warna"          => ($row->kode_warna),
          "kode_ukuran"     => $row->kode_ukuran,
          "id_ukuran"     => $row->id_ukuran,
          "id_walkorder_proses"     => $row->id_walkorder_proses,
          "id_warna"     => $row->id_warna,
          "qty"    => $row->qty,
          "harga_satuan"               => $row->harga_satuan,
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
    }

    if (!empty($id)) {
      $data_detail = [];
      $resData = $this->mProduksi->getData($id);
      $stdData = $this->mWalkorder->getData($resData->id_walkorder);
      if ($stdData->tipe_id == 1) {
        $list_detail = $this->mSample->getDataDetailSample($stdData->ref_id);
        $resData->file_gambar = !empty($resData->file_name) ? base_url() . "uploads/sample/"  . $resData->file_name : "";
      } else {
        $list_detail = $this->mSalesOrder->getDataDetailSalesOrder($stdData->ref_id);
        $resData->file_gambar = !empty($resData->file_name) ? base_url() . "uploads/sales_order/"  . $resData->file_name : "";
      }
      if (!empty($list_detail)) {
        for ($i = 0; $i < count($list_detail); $i++) {
          $drow = $list_detail[$i];
          if ($stdData->tipe_id == 1) {
            $allQty = $this->mSample->getTotal_qty($drow->id, 2);
          } else {
            $allQty = $this->mSalesOrder->getTotal_qty($drow->id, 2);
          }
          $list_detail[$i]->qty      = $allQty;
          $list_detail[$i]->qty_prod = 0;
        }
      }
      $dataProses = $this->mProduksi->getDataProsesProd($resData->id_walkorder);

      $sort = [
        [
          'field' => 'nama_operator',
          'dir' => 'ASC'
        ]
      ];

      $dataOperator = $this->mOperator->getData(null, 0, 99999, $sort);


      $this->data['proses']    = $dataProses;
      $this->data['operator']    = $dataOperator;
      // $this->data['listProd']    = json_encode($detailProd);
      $this->data['row']    = $resData;
      $this->data['id_produksi'] = encrypt($resData->id);
      $this->data['id_walkorder'] = encrypt($resData->id_walkorder);
      $this->data['tipe_id'] = encrypt($stdData->tipe_id);
      $this->data['ref_id'] = encrypt($stdData->ref_id);
      $this->data['detail'] = json_encode($list_detail);

      $status = $stdData->status;
    }

    $this->data['titlehead'] = "Form Production";

    return view($this->views . '\production_form', $this->data);
  }

  public function save()
  {
    $msg    = "Data gagal disimpan !";
    $status = false;
    $idProduksi = $this->request->getPost('idProduksi');
    $idWorkOrder = $this->request->getPost('idWorkOrder');
    if ($idProduksi != "") {
      $idProduksi = decrypt($idProduksi);
    }
    if ($idWorkOrder != "") {
      $idWorkOrder = decrypt($idWorkOrder);
    }
    $data = $this->request->getPost('data');

    $res = $this->mProduksi->trxInsertUpdateRecord($data, $idProduksi, $idWorkOrder);
    if ($res) {
      $status = true;
      $msg = "Data berhasil disimpan!";
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;

    return $this->response->setJSON($build_array);
  }

  public function getDataListProd()
  {
    $build_array['message'] = "data tidak ditemukan";
    $build_array['status']  = false;
    $id = $this->request->getPost('id');
    if ($id != "") {
      $id = decrypt($id);
    }
    $tglTransaksi = $this->request->getPost('tglTransaksi');
    $detailProd = $this->mProduksi->getDataOperatorProd($id, $tglTransaksi);
    if (!empty($detailProd)) {
      $build_array['message'] = "data ditemukan";
      $build_array['status']  = true;
      $build_array['data'] = json_encode($detailProd);
    }

    return $this->response->setJSON($build_array);
  }
}
