<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Referensi\Models\KonsumenModel;
use App\Models\FileModel;

class SalesOrder extends BaseController
{
  protected $mSalesOrder;
  protected $mkonsumen;
  protected $files;

  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/sales_order';

  function __construct()
  {
    $this->MOD_ALIAS = "MOD_TRANSAKSI_SALES_ORDER";

    $this->mSalesOrder = new SalesOrderModel();
    $this->mkonsumen = new KonsumenModel();
    $this->files  = new FileModel();
  }


  public function index()
  {
    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "SalesOrder";
    $this->data['buyer'] = $this->mkonsumen->where("active", 1)->findAll();

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
      "detail" => $this->mSalesOrder->getDataDetailSalesOrder($results->id)
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
      $arr_isi['created_at'] = date("Y-m-d H:i:s");
      $arr_isi['status'] = 0;
      $this->mSalesOrder->insertRecordGetid($this->mSalesOrder->table, $arr_isi);
      $msg    = "Data berhasil ditambahkan !";
      $status = true;
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
