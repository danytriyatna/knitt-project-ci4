<?php

namespace Modules\SDM\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\FileModel;
use Modules\Referensi\Models\BarangModel;
use Modules\Referensi\Models\JenisBarangModel;
use Modules\Referensi\Models\SatuanModel;
use Modules\Referensi\Models\KaryawanModel;
use Modules\SDM\Models\Mabsensi;

class Absensi extends BaseController
{
  protected $views = '\Modules\SDM\Views';

  protected $mabsen;
  protected $mkaryawan;


  function __construct()
  {
      $this->MOD_ALIAS = "MOD_SDM_ABSENSI";
      $this->mabsen = new Mabsensi();
      $this->mkaryawan = new KaryawanModel();
      
  }

  public function index()
  {
    if (!$this->auth->loggedIn()) {
        return redirect()->to('/auth/login');
    }

    $this->data['titlehead'] = "Absensi";
    $this->data['dnow'] = date('d-m-Y');
    return view($this->views . '\absensi_list', $this->data);
  }

  public function lists()
  {
      $start      = $this->request->getPost('start');
      $limit      = $this->request->getPost('length');
      $filters    = $this->request->getPost('filter');
      $order      = $this->request->getPost('sort');
      $tgl_absen      = $this->request->getPost('tgl_absen');

      // $params = [];

      $params['tgl_absen'] = \fdate_ind_to_eng($tgl_absen);

      $results = $this->mabsen->getData(null, $start, $limit, $order, $filters, $params);
      $totalfiltered = $this->mabsen->getDataCnt($filters, $params);
      $totaldata = $this->mabsen->getDataCnt(null, $params);
      $maxpage = ceil($totalfiltered / $limit);

      $build_array = array(
          "last_page" => $maxpage,
          "recordsTotal" => $totaldata,
          "recordsFiltered" => $totalfiltered,
          "data" => array()
      );

      foreach ($results as $row) {
          $id = encrypt($row->id);

          // $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan user ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
          //                            "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan user ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";

          // nip
          // full_name
          // posisi
          // upah_lembur
          // upah_harian
          // upah_lembur_we

          // id_karyawan
          // posisi

          $status_kehadiran = "";

          if($row->status_kehadiran == 1){
            $status_kehadiran = "Hadir";
          } else if($row->status_kehadiran == 2){
            $status_kehadiran = "Izin";
          } if($row->status_kehadiran == 3){
            $status_kehadiran = "Sakit";
          } if($row->status_kehadiran == 4){
            $status_kehadiran = "Tanpa Keterangan";
          }

          $status_lembur = "";
          if($row->status_lembur == 0){
            $status_lembur = "-";
          } else if($row->status_lembur == 1){
            $status_lembur = "Lembur Weekday";
          } if($row->status_lembur == 2){
            $status_lembur = "Lembur Weekend/Hari Libur";
          }

          $inHour = '';
          if(!empty($row->jam_masuk)){
            $inHour = date('H:i', strtotime($row->jam_masuk));
          }
          $outHour = '';
          if(!empty($row->jam_keluar)){
            $outHour = date('H:i', strtotime($row->jam_keluar));
          }

          $tgl_absen = \fdate_eng_to_ind($row->tgl_absen);
          array_push(
              $build_array["data"],
              array(
                  "id"   => ($id),
                  "nip" => $row->nip,
                  "full_name" => $row->full_name,
                  "id_karyawan" => $row->id_karyawan,
                  "posisi" => $row->posisi,
                  "upah_lembur" => $row->upah_lembur,
                  "upah_harian" => $row->upah_harian,
                  "upah_lembur_we" => $row->upah_lembur_we,
                  "tgl_absen" => $tgl_absen,
                  "jam_masuk" => $inHour,
                  "jam_keluar" => $outHour,
                  "status_kehadiran" => $status_kehadiran,
                  "hari_hadir" => $row->hari_hadir,
                  "keterangan_kehadiran" => $row->keterangan_kehadiran,
                  "status_lembur" => $row->status_lembur,
                  "jml_lembur" => $row->jml_lembur,
                  "keterangan_lembur" => $row->keterangan_lembur,
              )
          );
      }
      return $this->response->setJSON($build_array);
  }

  public function generate_absen_karyawan(){
    $tgl_absen = $this->request->getPost('tgl_absen');

    $status = false;
    $msg = "Absensi karyawan tidak ditemukan !";
    $data = [];

    $data_karyawan = $this->mkaryawan->getData(null, 0, 9999);

    $params['tgl_absen'] = \fdate_ind_to_eng($tgl_absen);

    $dt_absen = $this->mabsen->getData(null, 0, 9999, null, null, $params);
    if(!empty($data_karyawan ) && empty($dt_absen)){  
        foreach ($data_karyawan  as $dt) {
          $isi = [];
          $isi['id_karyawan'] = $dt->id;
          $isi['posisi'] = $dt->posisi;
          $isi['tgl_absen'] = fdate_ind_to_eng($tgl_absen);
          $this->mabsen->insertRecordGetid($this->mabsen->table, $isi);
        }

        $status = true;
        $msg = "Absensi karyawan tidak ditemukan !";
    }else{
      $msg = "Absensi pada tgl tesebut sudah ada !";
    }

    $build_array["status"] = $status;
    $build_array["msg"] = $msg;
    $build_array["data"] = $data;
    return $this->response->setJSON($build_array);

  }

  function simpanData(){
    $tgl_absen = $this->request->getPost('tgl_absen');
    $data_list = $this->request->getPost('data_list');

    $status = false;
    $msg = "Absensi karyawan tidak ditemukan !";
    $data = [];

    if(!empty($data_list)){
      $data_list = json_decode($data_list, true);
      $tgl_absen = \fdate_ind_to_eng($tgl_absen);
      foreach ($data_list as $x) {
        $id = \decrypt($x['id']);
        $status_kehadiran = null;

        if($x['status_kehadiran'] == "Hadir"){
          $status_kehadiran = 1;
        } else if($x['status_kehadiran'] == "Izin"){
          $status_kehadiran = 2;
        } if($x['status_kehadiran'] == "Sakit"){
          $status_kehadiran = 3;
        } if($x['status_kehadiran'] == "Tanpa Keterangan"){
          $status_kehadiran = 4;
        }

        $status_lembur = "";
        if($x['status_lembur'] == "-"){
          $status_lembur = 0;
        } else if($x['status_lembur'] == "Lembur Weekday"){
          $status_lembur = 1;
        } if($x['status_lembur'] == "Lembur Weekend/Hari Libur"){
          $status_lembur = 2;
        }

        $isi = [];
        $isi['jam_masuk'] = $tgl_absen . ' ' . $x['jam_masuk'];
        $isi['jam_keluar'] = $tgl_absen . ' ' . $x['jam_keluar'];
        $isi['status_kehadiran'] = $status_kehadiran;
        $isi['hari_hadir'] = $x['hari_hadir'];
        $isi['keterangan_kehadiran'] = $x['keterangan_kehadiran'];
        $isi['status_lembur'] = $status_lembur;
        $isi['jml_lembur'] = $x['jml_lembur'];
        $isi['keterangan_lembur'] = $x['keterangan_lembur'];

        $this->mabsen->updateRecord($this->mabsen->table, $isi, 'id', $id);
      }

      $status = true;
       $msg = "Absensi karyawan berhasil disimpan !";
    }

    $build_array["status"] = $status;
    $build_array["msg"] = $msg;
    $build_array["data"] = $data;
    return $this->response->setJSON($build_array);
  }
}
