<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Referensi\Models\KonsumenModel;
use Modules\Referensi\Models\UkuranModel;
use Modules\Referensi\Models\WarnaModel;
use Modules\Transaction\Models\SampleModel;
use App\Models\FileModel;

class SalesOrder extends BaseController
{
  protected $mSalesOrder;
  protected $mSample;
  protected $mkonsumen;
  protected $files;
  protected $mUkuran;
  protected $mWarna;

  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/sales_order';

  function __construct()
  {
    $this->MOD_ALIAS = "MOD_TRANSAKSI_SALES_ORDER";

    $this->mSalesOrder = new SalesOrderModel();
    $this->mkonsumen = new KonsumenModel();
    $this->files  = new FileModel();
    $this->mUkuran = new UkuranModel();
    $this->mWarna = new WarnaModel();
    $this->mSample = new SampleModel();
  }


  public function index()
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "SalesOrder";
    $this->data['buyer'] = $this->mkonsumen->where("active", 1)->findAll();
    $this->data['ukuran'] = $this->mUkuran->where("active", 1)->findAll();
    $this->data['warna'] = $this->mWarna->where("active", 1)->findAll();

    return view($this->views . '\sales_order_list', $this->data);
  }

  public function lists()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mSalesOrder->getData(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mSalesOrder->getDataCnt($filters, $params);
    $totaldata = $this->mSalesOrder->getDataCnt(null, $params);
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
      if ($this->_delete) {
        $atr_del['title'] = 'Hapus';
        $atr_del['url'] = $this->urlv . '/delete/';
        $atr_del['class'] = '';
        $atr_del['onclick'] = "return confirm('Hapus Data ?')";
      }
      if ($atr_edit || $atr_del)
        $btnAction = btn_action_group($id, $atr_edit, $atr_del);

      // $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan user ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
      //                            "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan user ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";

      array_push(
        $build_array["data"],
        array(
          "id"   => ($id),
          "id_sample"   => ($row->id_sample),
          "nama" => $row->nama,
          "tgl_transaksi" => $row->tgl_transaksi,
          "kode_sales_order" => $row->kode_sales_order,
          "tgl_deadline" => $row->tgl_deadline,
          "deskripsi" => $row->deskripsi,
          "file_gambar" => !empty($row->file_name) ? base_url() . "uploads/sales_order/"  . $row->file_name : "",
          "detail" => $this->mSalesOrder->getDataDetailSalesOrder($row->id)
        )
      );
    }
    return $this->response->setJSON($build_array);
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
    }

    $msg    = "Data gagal ditambahkan !";
    $status = false;

    $arr_isi = [
      'id_konsumen' => $idKonsumen,
      'keterangan' => $keterangan,
      'deskripsi' => $deskripsi,
      'tgl_transaksi' => $tglTransaksi,
      'tgl_deadline' => $tglDeadline,
      'kode_sales_order' => $noSalesOrder,
      'active' => 1,
      'gambar_id' => !empty($fileIdSalesOrder) ? $fileIdSalesOrder : null
    ];




    if (empty($id)) {
      $this->db->transBegin();
      $arr_isi['created_at'] = date("Y-m-d H:i:s");
      $arr_isi['status'] = 0;
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

  public function getSampleBuyer(){
    $buyerId = $this->request->getPost("buyers");

    $msg = "Gagal mengambil data sample !";
    $status = false;
    $data = [];

    if(!empty($buyerId)){
      $params = [
        'id_konsumen' => $buyerId
      ];
      $data_sample = $this->mSample->getData(0, 0, 99999, null, null, $params);
      if(!empty($data_sample)){
        $msg = "Berhasil mengambil data sample !";
        $status = true;
        $data = $data_sample;
      }
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;
    $build_array['data']    = $data;
    return $this->response->setJSON($build_array);
  }
}
