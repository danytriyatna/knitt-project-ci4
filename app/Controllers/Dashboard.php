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
      $filters = $this->request->getPost('filters');
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
          $id = encrypt($row->id);

          $link_order = "";
          $link_prod = "";
          $link_dev = "";
          
          if($row->tipe == 1){
            $link_order = base_url() . "/trans/sample";
          }else{
            $link_order = base_url() . "/trans/sales-order";
          }

          if(!empty($row->id_prod)){
            $prod_id = encrypt($row->id_prod);
            $link_prod = base_url() . "/trans/production/form/" . $prod_id;
          }

          if(!empty($row->id_dev)){
            $dev_id = encrypt($row->id_dev);
            $link_dev = base_url() . "/trans/delivery-order/form/" . $dev_id;
          }

        //   tbl.trans_id, tbl.trans_kode, tbl.id_konsumen, tbl.nama, tbl.keterangan, tbl.tgl_deadline, tbl.qty, 
        //   tbl.kode_prod, tbl.id_prod, tbl.qty_prod, 
        //   tbl.kode_dev, tbl.id_dev, tbl.qty_kirim
          
          $tgl_deadline = "";
          if(!empty($row->tgl_deadline)){
              $tgl_deadline = fdate_eng_to_ind($row->tgl_deadline);
          }
          
          $status = '-';
          // $total_pay = $this->mtrans_pay_det->get_total_bayar($row->sl_customer_receipt_id);
          array_push($build_array['data'], array(
              'aksi' => $btnAction,
              'kode_gaji' => $row->kode_gaji,
              'periode_awal' => $periode_awal,
              'periode_akhir' => $periode_akhir,
              'keterangan' => $row->keterangan,
              'status' => $status,
          ));

      }
      
      return $this->response->setJSON($build_array);
  }
    
}
