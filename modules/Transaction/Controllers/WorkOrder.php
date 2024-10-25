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
      
      $this->data['row']    = $stdData;
      $this->data['detail'] = json_encode($list_detail); 
    }

		return view($this->views.'/work_order_form', $this->data);

  }

  function detail($id)
  {
    $id = decrypt($id);
    $results = $this->mSalesOrder->getData($id);
    $build_array =  array(
      "id"   => encrypt($results->id),
      "keterangan" => $results->keterangan,
      "id_konsumen" => $results->id_konsumen,
      "tgl_transaksi" => $results->tgl_transaksi,
      "kode_sales_order" => $results->kode_sales_order,
      "tgl_deadline" => $results->tgl_deadline,
      "deskripsi" => $results->deskripsi,
      "gambar_id" => $results->gambar_id,
      "file_gambar" => !empty($results->file_name) ? base_url() . "uploads/sales_order/" . $results->file_name : "",
      "id_sample" => $results->id_sample,
      "detail" => $this->mSalesOrder->getDataDetailSalesOrder($results->id)
    );
    return $this->response->setJSON($build_array);
  }

  function detailQtyUkuran($idSalesOrder, $idSalesOrderDet)
  {
    $id = !empty($idSalesOrder) ? decrypt($idSalesOrder) : 0;
    $idSalesOrderDet = !empty($idSalesOrderDet) ? $idSalesOrderDet : 0;
    $results = $this->mSalesOrder->getData($id);
    $build_array =  array(
      "id"   => encrypt($results->id),
      "keterangan" => $results->keterangan,
      "nama" => $results->nama,
      "tgl_transaksi" => $results->tgl_transaksi,
      "kode_sales_order" => $results->kode_sales_order,
      "tgl_deadline" => $results->tgl_deadline,
      "deskripsi" => $results->deskripsi,
      "file_gambar" => !empty($results->file_name) ? base_url() . "uploads/sample/" . $results->file_name : "",
      "detail" => $this->mSalesOrder->getDataDetailSampleWarna($id, $idSalesOrderDet),
      "detailUkuran" =>  $this->mSalesOrder->getDataDetailSampleUkuran($id, $idSalesOrderDet)
    );
    return $this->response->setJSON($build_array);
  }

  function save()
  {
    $id         = $this->request->getPost('id');
    $idKonsumen         = $this->request->getPost('idKonsumen');
    $tglTransaksi = $this->request->getPost('tglTransaksi');
    $tglDeadline = $this->request->getPost('tglDeadline');
    $deskripsi = $this->request->getPost('deskripsi');
    $keterangan = $this->request->getPost('deskripsi');
    $fileIdSalesOrderOld = $this->request->getPost('fileIdSalesOrderOld');
    $noSalesOrder = $this->request->getPost('noSalesOrder');
    $sampleId = $this->request->getPost('samples');
    $submit_data = $this->request->getPost('submit_data');


    $this->validation->setRules([
      'idKonsumen '               => ['label' => 'Pilih Buyer', 'rules' => 'required'],
      'tglTransaksi'         => ['label' => 'Tanggal Transaksi', 'rules' => 'required'],
      'tglDeadline'          => ['label' => 'Tanggal Deadline', 'rules' => 'required'],
      'deskripsi'             => ['label' => 'Deskripsi', 'rules' => 'required|trim'],
    ]);

    if (!empty($this->request->getFile('fileSalesOrder'))) {
      $fileSalesOrder       = $this->request->getFile('fileSalesOrder');
      $fileName       = $fileSalesOrder->getRandomName();
      $originName     = $fileSalesOrder->getName();
      $fileType       = $fileSalesOrder->getMimeType();
      $fileSize       = $fileSalesOrder->getSize();


      if (!in_array($fileType, ['image/png', 'image/jpeg', 'image/webp'])) {
        $build_array['message'] = "<br>File <b>SalesOrder</b> hanya menerima tipe file <b>*.webp</b> <b>*.jpg</b>, atau <b>*.png</b>";
        $build_array['status']  = false;
        return $this->response->setJSON($build_array);
      }

      $this->files->insert([
        'file_name' => $fileName,
        'file_size' => $fileSize,
        'file_type' => $fileType,
        'file_name_origin' => $originName,
        'active'    => 1,
      ]);

      $fileIdSalesOrder = $this->files->insertID();
      $fileSalesOrder->move(WRITEPATH . 'uploads/sales_order/', $fileName);

      if ($fileIdSalesOrderOld != "") {
        $nama_file =  $this->files->where('id', $fileIdSalesOrderOld)->get()->getRow()->file_name;
        unlink(WRITEPATH . 'uploads/sales_order/' . $nama_file);

        $this->files->delete(['id' => $fileIdSalesOrderOld]);
      }
    }else{
      $fileIdSalesOrder = $fileIdSalesOrderOld;
    }

    $msg    = "Data gagal ditambahkan !";
    $status = false;

    $arr_isi = [
      'id_konsumen' => $idKonsumen,
      'keterangan' => $keterangan,
      'deskripsi' => $deskripsi,
      'tgl_transaksi' => $tglTransaksi,
      'tgl_deadline' => $tglDeadline,
      // 'kode_sales_order' => $noSalesOrder,
      'active' => 1,
      'gambar_id' => !empty($fileIdSalesOrder) ? $fileIdSalesOrder : null
    ];

    if(!empty($submit_data)){
      $arr_isi['status'] = 2;
    }

    if (empty($id)) {
      $this->db->transBegin();
      $arr_isi['created_at'] = date("Y-m-d H:i:s");
      $arr_isi['kode_sales_order'] = $this->mSalesOrder->generete_kode();
      $hid = $this->mSalesOrder->insertRecordGetid($this->mSalesOrder->table, $arr_isi);

      if(!empty($sampleId)){
        $data_detail = $this->mSample->getDataDetailSample_ori($sampleId);
        if(!empty($data_detail)){
          foreach ($data_detail as $r) {
            $arr_isid = [
              'id_sales_order' => $hid,
              'keterangan' => '',
              'id_warna_1' => $r->id_warna_1,
              'id_warna_2' => $r->id_warna_2,
              'id_warna_3' => $r->id_warna_3,
              'id_warna_4' => $r->id_warna_4,
              'id_warna_5' => $r->id_warna_5,
              'id_warna_6' => $r->id_warna_6,
              'id_warna_7' => $r->id_warna_7,
              'id_warna_8' => $r->id_warna_8,
              'total_harga' => $r->total_harga,
            ];
            $hidd = $this->mSalesOrder->insertRecordGetid('trans_sales_order_det', $arr_isid);
            $data_details = $this->mSample->getDataDetailSampleUkuran($sampleId, $r->id);
            if(!empty($data_details)){
                foreach ($data_details as $rx) {
                  $arr_isidx = [
                    'id_sales_order' => $hid,
                    'id_sales_order_det' => $hidd,
                    'id_ukuran' => $rx->id_ukuran,
                    'qty' => $rx->qty,
                    'harga_satuan' => $rx->harga_satuan,
                    'harga_total' => $rx->harga_total,
                  ];
                   $this->mSalesOrder->insertRecordGetid('trans_sales_order_ukuran', $arr_isidx);
                }
            }
          }
        }
      }

      if ($this->db->transStatus() === FALSE) {
        $this->db->transRollback();
      } else {
          $this->db->transCommit();
          $msg    = "Data berhasil ditambahkan !";
          $status = true;
      }
    } else {
      $arr_isi['updated_at'] = date("Y-m-d H:i:s");
      $id = decrypt($id);
      $this->mSalesOrder->updateRecord($this->mSalesOrder->table, $arr_isi, 'id', $id);

      if(!empty($submit_data)){
        $wo_data = [
          'ref_id' => $id,
          'ref_kode' => $noSalesOrder,
          'id_konsumen' => $idKonsumen,
          // 'id_style' => $id,
          'file_id' => !empty($fileIdSalesOrder) ? $fileIdSalesOrder : null,
          'status' => 1,
        ];
      }

      $msg    = "Data berhasil diupdate !";
      $status = true;
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;

    return $this->response->setJSON($build_array);
  }

  function saveDetail()
  {
    $msg    = "Data gagal disimpan !";
    $status = false;
    $idSalesOrder = $this->request->getPost('idSalesOrder');
    $idSalesOrderDet = $this->request->getPost('idSalesOrderDet');
    $warna1 = $this->request->getPost('warna1');
    $warna2 = $this->request->getPost('warna2');
    $warna3 = $this->request->getPost('warna3');
    $warna4 = $this->request->getPost('warna4');
    $warna5 = $this->request->getPost('warna5');
    $warna6 = $this->request->getPost('warna6');
    $warna7 = $this->request->getPost('warna7');
    $warna8 = $this->request->getPost('warna8');
    $dataUkuran = $this->request->getPost('dataUkuran');
    $dataWarna = [
      "id_warna_1" => !empty($warna1) ? $warna1 : null,
      "id_warna_2" => !empty($warna2) ? $warna2 : null,
      "id_warna_3" => !empty($warna3) ? $warna3 : null,
      "id_warna_4" => !empty($warna4) ? $warna4 : null,
      "id_warna_5" => !empty($warna5) ? $warna5 : null,
      "id_warna_6" => !empty($warna6) ? $warna6 : null,
      "id_warna_7" => !empty($warna7) ? $warna7 : null,
      "id_warna_8" => !empty($warna8) ? $warna8 : null,

      "id_sales_order" => (int)decrypt($idSalesOrder),
      "id" => !empty($idSalesOrderDet) ? $idSalesOrderDet :  null,
    ];

    $res = $this->mSalesOrder->trxInsertUpdateRecord($dataWarna, $dataUkuran);
    if ($res) {
      $status = true;
      $msg = "Data berhasil disimpan!";
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;

    return $this->response->setJSON($build_array);
  }

  public function deleteList($id = NULL)
  {
    if (!$this->auth->loggedIn() or (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
      throw new \Exception('You must be an administrator to view this page.');
    }

    if ($id != null && $id != "") {
      $id = decrypt($id);
    }

    $id = (int)$id;
    $msg    = "Data gagal dihapus !";
    $status = false;
    $res = $this->mSalesOrder->deleteRecord($this->mSalesOrder->table, 'id', $id);
    if ($res) {
      $this->mcommon->setLog($this->currentUser->user_id, $this->MOD_ALIAS, $id, "SalesOrder Dihapus");
      $this->session->setFlashdata('message', "SalesOrder berhasil dihapus");
    } else {
      $this->session->setFlashdata('err', "SalesOrder gagal dihapus");
    }


    return redirect()->to($this->urlv);
  }
  public function deleteDetailList($id = NULL)
  {
    if (!$this->auth->loggedIn() or (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
      throw new \Exception('You must be an administrator to view this page.');
    }

    if ($id != null && $id != "") {
      $id = decrypt($id);
    }

    $id = (int)$id;
    $msg    = "Data gagal dihapus !";
    $status = false;
    $res = $this->mSalesOrder->deleteRecord("trans_sales_order_det", 'id', $id);
    $resDel = $this->mSalesOrder->deleteRecord("trans_sales_order_ukuran", 'id_sales_order_det', $id);
    if ($resDel) {
      $this->mcommon->setLog($this->currentUser->user_id, $this->MOD_ALIAS, $id, "SalesOrder Dihapus");
      $status = true;
      $msg = "Data berhasil dihapus!";
    }
    $build_array['message'] = $msg;
    $build_array['status']  = $status;

    return $this->response->setJSON($build_array);
  }
}
