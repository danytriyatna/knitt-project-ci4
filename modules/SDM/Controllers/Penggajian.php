<?php

namespace Modules\SDM\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Referensi\Models\BarangModel;
use Modules\Referensi\Models\JenisBarangModel;
use Modules\Referensi\Models\SatuanModel;
use Modules\Referensi\Models\KaryawanModel;
use Modules\SDM\Models\Mabsensi;

class Penggajian extends BaseController
{
  protected $views = '\Modules\SDM\Views';

  protected $mabsen;
  protected $mkaryawan;

  function __construct()
  {
      $this->MOD_ALIAS = "MOD_SDM_PENGGAJIAN";
      $this->mabsen = new Mabsensi();
      $this->mkaryawan = new KaryawanModel();
      
  }

  public function index()
  {
    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Penggajian";
    
    return view($this->views . '\penggajian_list', $this->data);
  }

  function getDataPenggajian(){
    $tgl_mulai = $this->request->getPost('tgl_mulai');
    $tgl_akhir = $this->request->getPost('tgl_akhir');

    $status = false;
    $msg = "Laporan Penggajian tidak ditemukan !";
    $data = [];


    $params['tgl_mulai'] = \fdate_ind_to_eng($tgl_mulai);
    $params['tgl_akhir'] = \fdate_ind_to_eng($tgl_akhir);
    $data_laporan = $this->mabsen->laporan_penggajian($params);
    // print_r($data_laporan);exit;
    if(!empty($data_laporan)){
      for ($i=0; $i < count($data_laporan); $i++) { 
        $data_laporan[$i]->uang_lembur = $data_laporan[$i]->gaji_lembur + $data_laporan[$i]->gaji_lembur_we;
        $data_laporan[$i]->total = $data_laporan[$i]->uang_lembur + $data_laporan[$i]->gaji_harian;
      }
      $status = true;
      $msg = "Laporan Penggajian ditemukan !";
      $data = $data_laporan;
    }

    $build_array["status"] = $status;
    $build_array["msg"] = $msg;
    $build_array["data"] = $data;
    return $this->response->setJSON($build_array);
  }
}
