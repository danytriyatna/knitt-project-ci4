<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Referensi\Models\BarangModel;
use Modules\Referensi\Models\JenisBarangModel;
use Modules\Referensi\Models\SatuanModel;
use Modules\Transaction\Models\IncomingGoodsModel;
use Modules\Transaction\Models\BarangMasukModel;
use Modules\Transaction\Models\ItemTransferModel;
use Modules\Transaction\Models\BarangMasukDetailModel;
use Modules\Referensi\Models\GudangModel;
use Modules\Transaction\Models\ItemTransferDetailModel;

class ItemTransfer extends BaseController
{
  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/item-transfer';
  protected $mBarang;
  protected $mRef;
  protected $mRefDet;
  protected $mJenisBarang;
  protected $mSatuan;
  protected $mBarangMasuk;
  protected $mGudang;

  function __construct()
  {
    $this->MOD_ALIAS = "MOD_TRANSAKSI_BARANG_MASUK";
    $this->mBarang = new BarangModel();
    $this->mJenisBarang = new JenisBarangModel();
    $this->mSatuan = new SatuanModel();
    $this->mBarangMasuk = new IncomingGoodsModel();
    $this->mRef = new ItemTransferModel();
    $this->mRefDet = new ItemTransferDetailModel();
    $this->mGudang = new GudangModel();
  }

  public function index()
  {

    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Item Transfer";

    return view($this->views . '\item_transfer_list', $this->data);
  }

  public function lists()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mRef->getData(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mRef->getDataCnt($filters, $params);
    $totaldata = $this->mRef->getDataCnt(null, $params);
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
      //     $atr_del['title'] = 'Hapus';
      //     $atr_del['url'] = $this->urlv . '/delete/';
      //     $atr_del['class'] = '';
      //     $atr_del['onclick'] = "return confirm('Hapus Data ?')";
      // }
      if ($atr_edit || $atr_del)
        $btnAction = btn_action_group($id, $atr_edit, $atr_del);

      // $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan user ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
      //                            "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan user ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";
      $status = "";
      if ($row->status == 0) {
        $status = "<span class='badge bg-secondary'>Draft</span>";
      } else if ($row->status == 1) {
        $status = "<span class='badge bg-success'>Approved</span>";
      }
      array_push(
        $build_array["data"],
        array(
          "aksi" => $btnAction ? $btnAction : '',
          "id"   => ($id),
          "kode_transaksi" => $row->kode_transaksi,
          "tanggal" => fdate_eng_to_ind($row->tanggal),
          "gudang_asal" => $row->gudang_asal,
          "gudang_tujuan" => $row->gudang_tujuan,
          "keterangan" => $row->keterangan,
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
      $resData = $this->mRef->getData($id);
      $tanggal = date("d F Y", strtotime($resData->tanggal));
      $resData->tanggal = $tanggal;

      $sort = [
        [
          'field' => 'uk.id',
          'dir' => 'ASC'
        ]
      ];

      $resDataDetail = $this->mRefDet->getData(null, 0, 99999, $sort, params: array("id_header" => $id, "isReceive" => false));

      // foreach ($resDataDetail as &$rowData) {
      //     $rowData->id_barang = encrypt($rowData->id_barang);
      // }

      $this->data['resData'] = $resData;
      $this->data['detail'] = json_encode($resDataDetail);
    }

    $this->data['titlehead'] = "Form Item Transfer";
    $sortGudang = [
      [
        'field' => 'nama_gudang',
        'dir' => 'ASC'
      ]
    ];
    $resDataGudang = $this->mGudang->getData(null, 0, 99999, $sortGudang);
    $this->data['gudang']    = $resDataGudang;
    return view($this->views . '\item_transfer_form', $this->data);
  }

  function save()
  {
    $msg    = "Data gagal disimpan !";
    $status = false;
    $id = $this->request->getPost('id');
    $tanggal = $this->request->getPost('tanggal');
    $statusData = $this->request->getPost('status');
    $id_gudang_asal = $this->request->getPost('id_gudang_asal');
    $id_gudang_tujuan = $this->request->getPost('id_gudang_tujuan');
    $keterangan = $this->request->getPost('keterangan');
    $dataDetail = $this->request->getPost('data');
    if ($id != "") {
      $id = decrypt($id);
    }

    $dataHeader = [
      "id_gudang_asal" => !empty($id_gudang_asal) ? $id_gudang_asal : null,
      "id_gudang_tujuan" => !empty($id_gudang_tujuan) ? $id_gudang_tujuan : null,
      "tanggal" => $tanggal,
      "status" => $statusData,
      "keterangan" => $keterangan,
    ];
    if ($id) {
      $dataHeader['updated_at'] = date("Y-m-d H:i:s");
      $dataHeader['updated_by'] = $this->get_userid();
    } else {
      $dataHeader['created_at'] = date("Y-m-d H:i:s");
      $dataHeader['created_by'] = $this->get_userid();
    }
    // print_r($data);exit;
    $res = $this->mRef->trxInsertUpdateRecord($dataHeader, $id, $dataDetail);
    if ($res) {
      $status = true;
      $msg = "Data berhasil disimpan!";
    }

    $build_array['message'] = $msg;
    $build_array['status']  = $status;
    return $this->response->setJSON($build_array);
  }
}
