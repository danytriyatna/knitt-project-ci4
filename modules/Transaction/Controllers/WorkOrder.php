<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\WalkorderModel;
use Modules\Referensi\Models\ProsesProduksiModel;
use Modules\Referensi\Models\KonsumenModel;
use Modules\Referensi\Models\UkuranModel;
use Modules\Referensi\Models\WarnaModel;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Transaction\Models\SampleModel;
use App\Models\FileModel;

class WorkOrder extends BaseController
{
  protected $mWalkorder;
  protected $mkonsumen;
  protected $files;
  protected $mUkuran;
  protected $mWarna;
  protected $mSample;
  protected $mSalesOrder;
  protected $mPproduksi;

  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/work-order';

  function __construct()
  {
    $this->MOD_ALIAS = "MOD_TRANSAKSI_WALKORDER";

    $this->mWalkorder = new WalkorderModel();
    $this->mkonsumen = new KonsumenModel();
    $this->files  = new FileModel();
    $this->mUkuran = new UkuranModel();
    $this->mWarna = new WarnaModel();
    $this->mSample = new SampleModel();
    $this->mSalesOrder = new SalesOrderModel();
    $this->mPproduksi = new ProsesProduksiModel();
  }


  public function index()
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Work Order";

    return view($this->views . '\work_order_list', $this->data);
  }

  public function lists()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mWalkorder->getData(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mWalkorder->getDataCnt($filters, $params);
    $totaldata = $this->mWalkorder->getDataCnt(null, $params);
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

      array_push(
        $build_array["data"],
          array(
          "id"                => ($id),
          "ref_kode"          => ($row->ref_kode),
          "konsumen_nama"     => $row->konsumen_nama,
          "kode_walkorder"    => $row->kode_walkorder,
          "qty"               => $row->qty,
          "qty_prod"          => 0,
          "qty_remain"        => $row->qty - 0,
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

  function form($id = null){
    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['id'] = $id;
    $this->data['titlehead'] = "Form Work Order";
    if ($id != ""){
        $id = decrypt($id);
        $this->data['titlehead'] = "Form Work Order";
    }
    
    if(!empty($id)){
      $stdData = $this->mWalkorder->getData($id);  
      
      $data_detail = [];
      if($stdData->tipe_id == 1){
        $list_detail = $this->mSample->getDataDetailSample($stdData->ref_id);
        $stdData->file_gambar = !empty($stdData->file_name) ? base_url() . "uploads/sample/"  . $stdData->file_name : "";
      }else{
        $list_detail = $this->mSalesOrder->getDataDetailSalesOrder($stdData->ref_id);
        $stdData->file_gambar = !empty($stdData->file_name) ? base_url() . "uploads/sales_order/"  . $stdData->file_name : "";
      }
      
      if(!empty($list_detail)){
        for ($i=0; $i < count($list_detail); $i++) { 
          $drow = $list_detail[$i];
          $allQty = $this->mSalesOrder->getTotal_qty($drow->id, 2);
          $list_detail[$i]->qty      = $allQty;
          $list_detail[$i]->qty_prod = 0;
        }
      }

      if(isset($_POST)){
        
      }
      
      $this->data['row']    = $stdData;
      $this->data['detail'] = json_encode($list_detail); 
    }

    $proces_data = $this->mPproduksi->getData(null, 0, 999);

    $this->data['proses'] = $proces_data;

		return view($this->views.'/work_order_form', $this->data);

  }

  public function lists_detail()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mWalkorder->getData_detail(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mWalkorder->getDataCnt_detail($filters, $params);
    $totaldata = $this->mWalkorder->getDataCnt_detail(null, $params);
    $maxpage = ceil($totalfiltered / $limit);

    $build_array = array(
      "last_page" => $maxpage,
      "recordsTotal" => $totaldata,
      "recordsFiltered" => $totalfiltered,
      "data" => array()
    );

    foreach ($results as $row) {
      $id = encrypt($row->id);

      $params_d['id_walkorder_detail'] = $row->id;
      $data_detail = $this->mWalkorder->getData_warna(null, 0, 9999, null, null, $params_d);

      array_push(
        $build_array["data"],
          array(
          "id"      => ($id),
          "wdasar"  => ($row->wdasar),
          "qty"     => $row->qty,
          "gram"    => $row->gram,
          "gram_nd" => $row->gram_nd,
          "kg"      => $row->kg,
          "kg_loss" => $row->kg_loss,
          "total"   => $row->total,
          "loss"    => $row->loss,
          'details' => !empty($data_detail) ? $data_detail : []
        )
      );
    }
    return $this->response->setJSON($build_array);
  }

  function saveWarna()
  {
    $msg    = "Data gagal disimpan !";
    $status = false;

    $detail_id    = $this->request->getPost('detail');
    $detail_qty   = $this->request->getPost('detail_qty');
    $detail_loss  = $this->request->getPost('detail_loss');
    $list_data    = $this->request->getPost('warna_data');


    $detail_id = \decrypt($detail_id);
    $det_grams = 0;
    $det_grams_nd = 0;
    $det_kg = 0;
    $det_kg_loss = 0;
    $det_total = 0;
    
    $this->db->transBegin();
    $list_data = json_decode($list_data, true);
    
    try {
      if(!empty($list_data)){
        foreach ($list_data as $r) {
          $warna_id = $r['id'];
  
          $det_grams = $det_grams + $r['gram'];
          $det_grams_nd = $det_grams_nd + $r['gram_nd'];
          $det_kg = $det_kg + $r['kg'];
          $det_kg_loss = $det_kg_loss + $r['kg_loss'];
          $det_total = $det_total + $r['total'];
  
          $warna_isi = [
            'persen'  => $r['persen'],
            'gram'    => $r['gram'],
            'gram_nd' => $r['gram_nd'],
            'kg'      => $r['kg'],
            'kg_loss' => $r['kg_loss'],
            'total'   => $r['total'],
            'kuota'   => $r['kuota'],
            'loss'    => $detail_loss
          ];
          
          $this->mWalkorder->updateRecord($this->mWalkorder->table5, $warna_isi, 'id', $warna_id);
        }
      }
  
      $detail_isi = [
        'gram'    => $det_grams,
        'gram_nd' => $det_grams_nd,
        'kg'      => $det_kg,
        'loss'    => $detail_loss,
        'kg_loss' => $det_kg_loss,
        'total'   => $det_total
      ];
  
      $this->mWalkorder->updateRecord($this->mWalkorder->table2, $detail_isi, 'id', $detail_id);
  
      if ($this->db->transStatus() === FALSE) {
        $this->db->transRollback();

      } else {
          $this->db->transCommit();
          $msg    = "Data berhasil disimpan !";
          $status = true;
      }
    } catch (\Throwable $th) {
      //throw $th;
      $this->db->transRollback();
      // $msg    = $th;
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;

    return $this->response->setJSON($build_array);
  }
}
