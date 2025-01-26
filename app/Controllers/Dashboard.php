<?php

namespace App\Controllers;

use App\Models\Mdashboard;

class Dashboard extends BaseController
{
    protected $mdashboard;

    function __construct()
    {
        $this->mdashboard = new Mdashboard();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        } else {
            $this->data['titlehead'] = "Dashboard";

            return view('dashboard/index', $this->data);
        }
	}

    public function lists()
  {
      $start   = $this->request->getPost('start');
      $limit   = $this->request->getPost('length');
      $filters = $this->request->getPost('filter');
      $order   = $this->request->getPost('order');
      // $tahun   = $this->request->getPost('tahun');

      // $params['tahun'] = $tahun;
      $params = [];
      $results = $this->mdashboard->getData(null, $start, $limit, $order, $filters, $params);
      $totalfiltered = $this->mdashboard->getDataCnt($filters, $params);
      $totaldata = $this->mdashboard->getDataCnt(null, $params);
      $maxpage = ceil($totalfiltered / $limit);
      $build_array = array(
          "last_page" => $maxpage,
          "recordsTotal" => $totaldata,
          "recordsFiltered" => $totalfiltered,
          "data" => array()
      );

      foreach ($results as $row) {
          $id = encrypt($row->trans_id);

          $btnOrder = "";
          $btnProd = "";
          $btnDev = "";

          $tipe = "-";
          
          if($row->tipe == 1){
            $link_order = base_url() . "/trans/sample";
            $btnOrder = "<a class='btn btn-sm btn-primary' target='_blank' href=".$link_order." > ".$row->trans_kode." </a>";

            $tipe = "Sample";
          }else{
            $link_order = base_url() . "/trans/sales-order";
            $btnOrder = "<a class='btn btn-sm btn-primary' target='_blank' href=".$link_order." > ".$row->trans_kode." </a>";

            $tipe = "Sales Order";
          }
          
          if(!empty($row->id_prod)){
            $prod_id = encrypt($row->id_prod);
            $link_prod = base_url() . "/trans/production/form/" . $prod_id;

            $btnProd = "<a class='btn btn-sm btn-primary' target='_blank' href=".$link_prod." > ".$row->kode_prod." </a>";
          }

          if(!empty($row->id_dev)){
            $dev_id = encrypt($row->id_dev);
            $link_dev = base_url() . "/trans/delivery-order/form/" . $dev_id;

            $btnDev = "<a class='btn btn-sm btn-primary' target='_blank' href=".$link_dev." > ".$row->kode_dev." </a>";
          }
          
          $tgl_deadline = "";
          if(!empty($row->tgl_deadline)){
              $tgl_deadline = fdate_eng_to_ind($row->tgl_deadline);
          }

          $tgl_transaksi = "";
          if(!empty($row->tgl_transaksi)){
              $tgl_transaksi = fdate_eng_to_ind($row->tgl_transaksi);
          }

          $qty_sisa = (int) $row->qty - (int) $row->qty_prod;
          $qty_sisa_kirim = (int) $row->qty_prod - (int) $row->qty_kirim;

          
          
          array_push($build_array['data'], array(
              'btnOrder' => $btnOrder,
              'btnProd' => $btnProd,
              'btnDev' => $btnDev,
              'tipe' => $tipe,
              'nama' => $row->nama,
              'keterangan' => $row->keterangan,
              'tgl_transaksi' => $tgl_transaksi,
              'tgl_deadline' => $tgl_deadline,
              'qty' => $row->qty,
              'qty_prod' => $row->qty_prod,
              'qty_kirim' => $row->qty_kirim,
              'qty_sisa' => $qty_sisa,
              'qty_sisa_kirim' => $qty_sisa_kirim,
          ));

      }
      
      return $this->response->setJSON($build_array);
  }
    
}
