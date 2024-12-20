<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\ProductionModel;
use Modules\Transaction\Models\WalkorderModel;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Transaction\Models\SampleModel;
use Modules\Transaction\Models\DeliveryModel;
use Modules\Referensi\Models\ProsesProduksiModel;
use Modules\Referensi\Models\KonsumenModel;
use Modules\Referensi\Models\UkuranModel;
use Modules\Referensi\Models\WarnaModel;

class DeliveryOrder extends BaseController
{
  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/delivery-order';

  protected $mProduksi;
  protected $mSample;
  protected $mSalesOrder;
  protected $mWalkorder;
  protected $mPproduksi;
  protected $mDelivery;
  protected $mkonsumen;
  protected $mUkuran;
  protected $mWarna;

  function __construct()
  {
    $this->MOD_ALIAS   = "MOD_TRANSAKSI_DELIVERY";
    $this->mProduksi   = new ProductionModel();
    $this->mSample     = new SampleModel();
    $this->mSalesOrder = new SalesOrderModel();
    $this->mWalkorder  = new WalkorderModel();
    $this->mPproduksi  = new ProsesProduksiModel();
    $this->mDelivery   = new DeliveryModel();
    $this->mkonsumen   = new KonsumenModel();
    $this->mUkuran     = new UkuranModel();
    $this->mWarna      = new WarnaModel();
  }

  public function index()
  {

    if (!$this->auth->loggedIn()) {
      return redirect()->to('/auth/login');
    }
    $this->data['titlehead'] = "Delivery Order";

    
    return view($this->views . '\delivery_order_list', $this->data);
  }

  public function lists()
  {
    $start      = $this->request->getPost('start');
    $limit      = $this->request->getPost('length');
    $filters    = $this->request->getPost('filter');
    $order      = $this->request->getPost('sort');

    $params = [];

    $results = $this->mDelivery->getData(null, $start, $limit, $order, $filters, $params);
    $totalfiltered = $this->mDelivery->getDataCnt($filters, $params);
    $totaldata = $this->mDelivery->getDataCnt(null, $params);
    $maxpage = ceil($totalfiltered / $limit);

    $build_array = array(
      "last_page" => $maxpage,
      "recordsTotal" => $totaldata,
      "recordsFiltered" => $totalfiltered,
      "data" => array()
    );

    foreach ($results as $row) {
      $id = encrypt($row->id);

      $atr_edit  = null;
      $atr_del   = null;
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

      $status = $row->status  == 1 ? "Draft" : "Approved";
      $tipe   = $row->tipe_id == 1 ? "Sample" : "Sales Order";

      $qty      = $row->qty;
      $qty_delv = $row->qty_delv;

      array_push(
        $build_array["data"],
        array(
          "id"                => ($id),
          "delivery_kode"     => ($row->delivery_kode),
          "produksi_kode"     => $row->produksi_kode,
          "konsumen_nama"     => $row->konsumen_nama,
          "alamat"            => $row->alamat,
          "qty"               => $qty,
          "qty_delv"          => $qty_delv,
          "qty_remain"        => $qty - $qty_delv,
          "tgl_transaksi"     => fdate_eng_to_ind($row->tgl_transaksi),
          "keterangan_style"  => $row->keterangan_style,
          "status"            => $status,
          "aksi"              => $btnAction
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
    $this->data['titlehead'] = "Form Delivery Order";
    if ($id != "") {
      $id = decrypt($id);
      $this->data['titlehead'] = "Form Delivery Order";
    }

    $stdData = new \stdClass();
    $stdData->delivery_kode = '';
    $stdData->do_no = '';
    $stdData->id_produksi = '';
    $stdData->id_walkorder = '';
    $stdData->kode_produksi = '';
    $stdData->tgl_do = date('d-m-Y');
    $stdData->keterangan_style = '';
    $stdData->select_buyer = '';
    $stdData->alamat_buyer  = '';
    $dt_details = [];
    $dt_prods = [];

    $status = 1;
    if (!empty($id)) {
      $stdData = $this->mDelivery->getData($id);
      
      $stdData->do_no = $stdData->delivery_kode;
      $stdData->id_produksi = $stdData->id_produksi;
      $stdData->id_walkorder = $stdData->id_walkorder;
      $stdData->kode_produksi = $stdData->produksi_kode;
      $stdData->tgl_do = $stdData->tgl_transaksi;
      $stdData->keterangan_style = $stdData->keterangan_style;
      $stdData->select_buyer =  $stdData->id_konsumen;
      $stdData->alamat_buyer  =  $stdData->alamat;
      $status = $stdData->status;
      

      // $this->data['row']    = $stdData;
      // $this->data['detail'] = json_encode($list_detail);

      $status = $stdData->status;

      $arr_qty = [];

      $prx['id_delivery'] = $stdData->id;
      $rs_prod = $this->mDelivery->getDataProduksi($prx);
      if(!empty($rs_prod)){
        foreach ($rs_prod as $xitem) {
          $xisi = [];
          $xisi['id_ukuran'] = $xitem->id_ukuran;
          $xisi['ref_detail_id'] = $xitem->ref_detail_id;
          $xisi['kode_warna'] = $xitem->kode_warna;
          $xisi['kode_ukuran'] = $xitem->kode_ukuran;
          $xisi['qty'] = $xitem->qty;
          $dt_prods[] = $xisi;

          $arr_qty[$xitem->ref_detail_id] = $xitem->qty;
        }
      }

      $dt_details = [];
      $prm['id_walkorder'] = $stdData->id_walkorder;
      $rukuran = $this->mUkuran->getData(0, 0, 999);
      $ukuran = "";
      foreach ($rukuran as $iu) {
        $keyUkuran = $iu->key_ukuran;
        if($iu->key_ukuran == 'all') $keyUkuran = 'all_';
        $ukuran .= ($ukuran == "") ? $keyUkuran : ", ". $keyUkuran;
      }
      $prm['ukuran'] = $ukuran;
      $dataProd = [];
      $rsProd = $this->mProduksi->getProduksilast($prm); 
      
      if(!empty($rsProd)){
        foreach ($rsProd as $item) {
          $isi = array(
            "ref_detail_id" => ($item->ref_detail_id),
            "id_walkorder"  => ($item->id_walkorder),
            "colordasar"    => ($item->kode_warna),
          );
          
          $qty = 0;
          foreach ($rukuran as $iu) {
            $keyUkuran = $iu->key_ukuran;
            $indx      = $iu->key_ukuran;
         
            if($iu->key_ukuran == 'all') $keyUkuran = 'all_';
            $xharga    = $keyUkuran.'_hrg';

            $isi[$indx] = $item->$keyUkuran;
            $isi[$xharga] = $item->$xharga;

            $qty = $qty +  $item->$keyUkuran;
          }
          $isi['qty'] = $qty;
          $isi['qty_prod'] = !empty($arr_qty[$item->ref_detail_id]) ? $arr_qty[$item->ref_detail_id] : 0;
          $isi['qty_remain'] = $qty -  $isi['qty_prod'];
          array_push(
            $dataProd, $isi
          );
        }
      }

      $dt_details  = $dataProd;

      $dt_details = json_encode($dt_details, true);
      $dt_prods = json_encode($dt_prods, true);

    }
    $this->data['row']    = $stdData;
    if (!empty($_POST)) {
      if(true){

        $stdData->do_no = trim($this->request->getPost('do_no'));
        $stdData->id_produksi = trim($this->request->getPost('id_produksi'));
        $stdData->id_walkorder = trim($this->request->getPost('id_walkorder'));
        $stdData->kode_produksi = trim($this->request->getPost('kode_produksi'));
        $stdData->tgl_do = trim($this->request->getPost('tgl_do'));
        $stdData->keterangan_style = trim($this->request->getPost('keterangan_style'));
        $stdData->select_buyer = trim($this->request->getPost('select_buyer'));
        $stdData->alamat_buyer  = trim($this->request->getPost('alamat_buyer'));
        $dt_prods   = trim($this->request->getPost('data-details'));
        $dt_details = trim($this->request->getPost('data-prods'));

        $dt_details = json_decode($dt_details, true);
        $dt_prods = json_decode($dt_prods, true);

        $action = $this->request->getPost('actionf');

        

        $data['tgl_transaksi'] = fdate_ind_to_eng($stdData->tgl_do);
        $data['id_produksi'] = $stdData->id_produksi;
        $data['produksi_kode'] = $stdData->kode_produksi;
        $data['alamat'] = $stdData->alamat_buyer;
        $data['id_konsumen'] = $stdData->select_buyer;
        $data['id_walkorder'] = $stdData->id_walkorder;
        $data['status'] =  $action == "kirim" ? 2 : 1;

        if(!empty($id)){
          $data['updated_at'] = date('Y-m-d H:i:s');
          $data['updated_by'] = $this->get_userid();

          $inUp = $this->update($id, $data, $dt_details, $dt_prods);
        }else{
          $data['active'] = 1;
          $data['delivery_kode'] = $this->mSample->generateNo("DO", "trans_delivery", "delivery_kode");
          $data['created_at'] = date('Y-m-d H:i:s');
          $data['created_by'] = $this->get_userid();

          $inUp = $this->insert($data, $dt_details, $dt_prods);
        }

        if($inUp){
            $this->session->setFlashdata('message', "Simpan data berhasil.." );
            return redirect()->to('/trans/delivery-order');
        }else{
            // $this->_get_message("ERROR_VALIDATION", "Ulangi simpan data !");
            $this->session->setFlashdata('error', "Ulangi simpan data !" );
        }

      }else{
          $this->data['errmsg'] = $this->_get_message("ERROR_VALIDATION", $this->validation->listErrors());
      }
    }

    $view_read = false;
    if($status != 1){
      $view_read = true;
    }
    
    $this->data['view_read'] = $view_read;
    $this->data['buyer'] = $this->mkonsumen->where("active", 1)->findAll();
    $this->data['dt_details'] = $dt_details;// = json_decode($dt_details, true);
    $this->data['dt_prods'] = $dt_prods;// = json_decode($dt_prods, true);
    $this->data['status'] = $status;

    return view($this->views . '\delivery_order_form', $this->data);
  }

  function insert($dataIn, $detail, $produksi){
    $tgl = date('Y-m-d H:i:s');
    $userId = $this->get_userid();
    
    $this->db->transBegin();

    $id = $this->mDelivery->insertRecordGetid($this->mDelivery->table,$dataIn);

    $qty = 0;
    if(!empty($detail)){
      $builderx = $this->mDelivery->table($this->mDelivery->table2);
      $builderx->where("id_delivery", $id);
      $builderx->delete();
      foreach ($detail as $item) {
        $ddata = [];
        $ddata['id_delivery'] = $id;
        $ddata['ref_detail_id'] = $item['ref_detail_id'];
        $ddata['id_ukuran'] = $item['id_ukuran'];
        $ddata['qty'] = $item['qty'];
        $ddata['created_at'] = $tgl;
        $ddata['created_by'] = $userId;
        $this->mDelivery->insertRecordGetid($this->mDelivery->table2,$ddata);

        $qty = $qty + $item['qty'];
      }
    }

    $dataIn['qty'] = $qty;
    $this->mDelivery->updateRecord($this->mDelivery->table, $dataIn, 'id', $id);
    
    if(!empty($produksi)){

      $rukuran = $this->mUkuran->getData(0, 0, 999);
      foreach ($produksi as $itemx) {
        // dd($itemx);
        $xdata = [];
        $xdata['id_delivery']   = $id;
        $xdata['ref_detail_id'] = $itemx['ref_detail_id'];
       
        $xdata['created_at']    = $tgl;
        $xdata['created_by']    = $userId;
        foreach ($rukuran as $iu) {
          $keyUkuran = $iu->key_ukuran;
          $indx      = $iu->key_ukuran;


          $xdata['qty']          = $itemx[$keyUkuran];
          if($iu->key_ukuran == 'all') $keyUkuran = 'all_';
          $xharga    = $keyUkuran.'_hrg';

          $xdata['id_ukuran']    = $iu->id;
          $xdata['harga_satuan'] = $itemx[$xharga];
         
          $this->mDelivery->insertRecordGetid($this->mDelivery->table3,$xdata);
        }
      }
    }



    $this->mcommon->setLog($this->auth->getUserId() ,$this->MOD_ALIAS, $id,"Insert Delivery");   

    if ($this->db->transStatus() === FALSE) {
        $this->db->transRollback();
        return FALSE;
    } else {
        $this->db->transCommit();
        return TRUE;
    }
  }



  function update($id, $dataIn, $detail, $produksi){
    $tgl = date('Y-m-d H:i:s');
    $userId = $this->get_userid();

    $this->db->transBegin();

    $this->mDelivery->updateRecord($this->mDelivery->table, $dataIn, 'id', $id);

    $qty = 0;
    
    if(!empty($detail)){
      $builderx = $this->db->table($this->mDelivery->table2);
      $builderx->where("id_delivery", $id);
      $builderx->delete();
      
      foreach ($detail as $item) {
        $ddata = [];
        $ddata['id_delivery'] = $id;
        $ddata['ref_detail_id'] = $item['ref_detail_id'];
        $ddata['id_ukuran'] = $item['id_ukuran'];
        $ddata['qty'] = $item['qty'];
        $ddata['created_at'] = $tgl;
        $ddata['created_by'] = $userId;
        $this->mDelivery->insertRecordGetid($this->mDelivery->table2,$ddata);

        $qty = $qty + $item['qty'];
      }
    }

    $dataIn['qty'] = $qty;
    $this->mDelivery->updateRecord($this->mDelivery->table, $dataIn, 'id', $id);
    if(!empty($produksi)){

      $rukuran = $this->mUkuran->getData(0, 0, 999);

      $builderv = $this->mDelivery->table($this->mDelivery->table3);
      $builderv->where("id_delivery", $id);
      $builderv->delete();
      foreach ($produksi as $itemx) {
        // dd($itemx);
        $xdata = [];
        $xdata['id_delivery']   = $id;
        $xdata['ref_detail_id'] = $itemx['ref_detail_id'];
       
        $xdata['created_at']    = $tgl;
        $xdata['created_by']    = $userId;
        foreach ($rukuran as $iu) {
          $keyUkuran = $iu->key_ukuran;
          $indx      = $iu->key_ukuran;


          $xdata['qty']          = $itemx[$keyUkuran];
          if($iu->key_ukuran == 'all') $keyUkuran = 'all_';
          $xharga    = $keyUkuran.'_hrg';

          $xdata['id_ukuran']    = $iu->id;
          $xdata['harga_satuan'] = $itemx[$xharga];
         
          $this->mDelivery->insertRecordGetid($this->mDelivery->table3,$xdata);
        }
      }
    }



    $this->mcommon->setLog($this->auth->getUserId() ,$this->MOD_ALIAS, $id,"Update Delivery");   

    if ($this->db->transStatus() === FALSE) {
        $this->db->transRollback();
        return FALSE;
    } else {
        $this->db->transCommit();
        return TRUE;
    }
  }


  // get data produksi
  public function lists_produksi()
  {
    $start       = $this->request->getPost('start');
    $limit       = $this->request->getPost('length');
    $filters     = $this->request->getPost('filter');
    $order       = $this->request->getPost('sort');
    $id_konsumen = $this->request->getPost('id_konsumen');

    $params = [];
    $params['id_konsumen'] = $id_konsumen;

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
      $id = ($row->id);

      $status = $row->status == 1 ? "Draft" : "Approved";
      $tipe = $row->tipe_id == 1 ? "Sample" : "Sales Order";

      $qty = $row->qty;
      $qty_prod = 0;

      array_push(
        $build_array["data"],
        array(
          "id"                => ($id),
          "id_walkorder"      => ($row->id_walkorder),
          "ref_kode"          => ($row->kode_walkorder),
          "konsumen_nama"     => $row->konsumen_nama,
          "kode_prod"         => $row->kode_prod,
          "qty"               => $row->qty,
          "tipe"              => $tipe,
          "qty_prod"          => $qty_prod,
          "qty_remain"        => $qty - $qty_prod,
          "tgl_deadline"      => fdate_eng_to_ind($row->tgl_deadline),
          "tgl_transaksi"     => fdate_eng_to_ind($row->tgl_transaksi),
          "keterangan_style"  => $row->keterangan_style,
          "status"            => $status,
        )
      );
    }
    return $this->response->setJSON($build_array);
  } 


  function getDataProduksi(){
      $id_walkorder = $this->request->getPost("id_walkorder");
      $id_produksi  = $this->request->getPost("produkds");

      $status = false;
      $msg    = "Gagal mengambil data produksi !";
      $data   = [];

      $results = $this->mProduksi->getData($id_produksi);

      if(!empty($results)){
        $data['produksi']         = $results;


        $prm['id_walkorder'] = $id_walkorder;
        $rukuran = $this->mUkuran->getData(0, 0, 999);
        $ukuran = "";
        foreach ($rukuran as $iu) {
          $keyUkuran = $iu->key_ukuran;
          if($iu->key_ukuran == 'all') $keyUkuran = 'all_';
          $ukuran .= ($ukuran == "") ? $keyUkuran : ", ". $keyUkuran;
        }
        $prm['ukuran'] = $ukuran;

        $dataProd = [];
        $rsProd = $this->mProduksi->getProduksilast($prm); 
        
        if(!empty($rsProd)){
          foreach ($rsProd as $item) {
            $isi = array(
              "ref_detail_id" => ($item->ref_detail_id),
              "id_walkorder"  => ($item->id_walkorder),
              "colordasar"    => ($item->kode_warna),
            );
            
            $qty = 0;
            foreach ($rukuran as $iu) {
              $keyUkuran = $iu->key_ukuran;
              $indx      = $iu->key_ukuran;
              
              if($iu->key_ukuran == 'all') $keyUkuran = 'all_';
              $xharga    = $keyUkuran.'_hrg';

              $isi[$indx]   = $item->$keyUkuran;
              $isi[$xharga] = $item->$xharga;

              $qty = $qty +  $item->$keyUkuran;
            }
            $isi['qty'] = $qty;
            $isi['qty_prod'] = 0;
            $isi['qty_remain'] = $qty;
            array_push(
              $dataProd, $isi
            );
          }
        }

        $data['detail_produksi']  = $dataProd;

        $status = true;
        $msg    = "Berhasil mengambil data produksi !";
      }

      $build_array['status']  = $status;
      $build_array['message'] = $msg;
      $build_array['data']    = $data;

      return $this->response->setJSON($build_array);
  }

  public function getDataProduksiItem(){
      $barcode_code = $this->request->getPost("kata_kunci");
      $id_walkorder = $this->request->getPost("id_walkorder");
      $id_produksi  = $this->request->getPost("id_produksi");

      $status = false;
      $msg = "Data warna ukuran tidak ditemukan !";
      $data = [];
      $slc  = [];

      // if(!empty($barcode_code)){
          $params['last_proses']  = 1;
          $params['id_walkorder'] = $id_walkorder;
          $params['kata_kunci'] = $barcode_code;
          $result = $this->mWalkorder->getListProduksiUkuran($params);
          if(!empty($result)){
              foreach ($result as $r) {
                  $isi = [];
                  $isi["id_walkorder"]  = $r->id_walkorder;
                  $isi["ref_detail_id"] = $r->ref_detail_id;
                  $isi["id_ukuran"]     = $r->id_ukuran;
                  $isi["id_warna"]      = $r->id_warna;
                  $isi["qty"]           = $r->qty_prod;
                  $isi["qty_prod"]      = 0;
                  $isi["kata_kunci"]    =  "(".$r->kode_warna.") " . $r->kode_ukuran;
                  $isi["kode_warna"]    = $r->kode_warna;
                  $isi["kode_ukuran"]   = $r->kode_ukuran;
                  $isi["key_ukuran"]    = $r->key_ukuran;
                  $data[] = $isi;


                  $isi_slc = [];
                  $isi_slc["id"]    = $r->ref_detail_id;
                  $isi_slc["idx"]   = $r->kode_warna;
                  $isi_slc["label"] = "(".$r->kode_warna.") " . $r->kode_ukuran;
                  $isi_slc["value"] = $r->ref_detail_id;
                  $isi_slc["data"]  = $isi;
                  $slc[] = $isi_slc;
              }
              $status = true;
              $msg = "Data produk ditemukan !";
          }
        
      // }

      $build_array["status"] = $status;
      $build_array["msg"] = $msg;
      $build_array["data"] = $data;
      $build_array["slc"] = $slc;
      return $this->response->setJSON($build_array);
  }
}
