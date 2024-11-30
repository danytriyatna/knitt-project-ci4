<?php

namespace Modules\Transaction\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use Modules\Referensi\Models\BarangModel;
use Modules\Referensi\Models\JenisBarangModel;
use Modules\Referensi\Models\SatuanModel;
use Modules\Transaction\Models\IncomingGoodsModel;
use Modules\Referensi\Models\GudangModel;

class IncomingGoods extends BaseController
{
    protected $mBarang;
    protected $mJenisBarang;
    protected $mSatuan;
    protected $mBarangMasuk;
    protected $mGudang;

    protected $views = '\Modules\Transaction\Views';
    protected $urlv  = 'trans/incoming-goods';

    function __construct()
    {
        $this->MOD_ALIAS = "MOD_TRANSAKSI_BARANG_MASUK";
        $this->mBarang = new BarangModel();
        $this->mJenisBarang = new JenisBarangModel();
        $this->mSatuan = new SatuanModel();
        $this->mBarangMasuk = new IncomingGoodsModel();
        $this->mGudang = new GudangModel();
        $this->files  = new FileModel();
    }

    public function index()
    {

        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $this->data['titlehead'] = "Transaksi Data Barang Masuk ";

        $sortSatuan = [
            [
                'field' => 'nama_satuan',
                'dir' => 'ASC'
            ]
        ];
        $sortJenisBarang = [
            [
                'field' => 'nama_jenis_barang',
                'dir' => 'ASC'
            ]
        ];

        $dataSatuan = $this->mSatuan->getData(null, 0, 99999, $sortSatuan);
        $dataJenisBarang = $this->mJenisBarang->getData(null, 0, 99999, $sortJenisBarang);
        $this->data['satuan'] = $dataSatuan;
        $this->data['jenisBarang'] = $dataJenisBarang;
        return view($this->views . '\incoming_goods_list', $this->data);
    }


    public function lists()
    {
        $start      = $this->request->getPost('start');
        $limit      = $this->request->getPost('length');
        $filters    = $this->request->getPost('filter');
        $order      = $this->request->getPost('sort');

        $params = [];

        $results = $this->mBarangMasuk->getData(null, $start, $limit, $order, $filters, $params);
        $totalfiltered = $this->mBarangMasuk->getDataCnt($filters, $params);
        $totaldata = $this->mBarangMasuk->getDataCnt(null, $params);
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
            //     $atr_edit['title'] = 'Edit';
            //     $atr_edit['url'] = $this->urlv . '/edit/';
            //     $atr_edit['class'] = '';
            // }
            if ($this->_delete) {
                $atr_del['title'] = 'Hapus';
                $atr_del['url'] = $this->urlv . '/delete/';
                $atr_del['class'] = '';
                $atr_del['onclick'] = "return confirm('Hapus Data ?')";
            }
            if ($atr_edit || $atr_del)
                $btnAction = btn_action_group($id, $atr_edit, $atr_del);

            if ($row->id_kategori == 10) {
                $informasi = "Gudang Tujuan: $row->gudang_tujuan<br>";
                $informasi .= "Gudang Asal: $row->gudang_asal";
            } else if ($row->id_kategori == 2) {
                $informasi = "Gudang Tujuan: $row->gudang_tujuan<br>";
                $informasi .= "Pemasok: $row->nama";
            } else if ($row->id_kategori == 3) {
                $informasi = "Gudang Tujuan: $row->gudang_tujuan<br>";
                $informasi .= "Pelanggan: $row->nama";
            } else if ($row->id_kategori == 9) {
                $informasi = "Gudang Tujuan: $row->gudang_tujuan<br>";
            }


            // $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan user ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
            //                            "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/users/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan user ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";

            array_push(
                $build_array["data"],
                array(
                    "aksi" => $btnAction ? $btnAction : '',
                    "id"   => ($id),
                    "nama_barang" => $row->nama_barang,
                    "kode_barang" => $row->kode_barang,
                    "nama_satuan" => $row->nama_satuan,
                    "kode_transaksi" => $row->kode_transaksi,
                    "jumlah" => $row->jumlah,
                    "informasi" => $informasi,
                    "tanggal" => fdate_eng_to_ind($row->tanggal),
                    "kategori" => $row->kategori,
                    "keterangan" => $row->keterangan,
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
        }

        if (!empty($id)) {
            $data_detail = [];
            $resData = $this->mBarangMasuk->getData($id);
            $this->data['data']    = $resData;
        }
        $reDataKategori = $this->mBarangMasuk->getRefKategoriPersedian();
        $sortGudang = [
            [
                'field' => 'nama_gudang',
                'dir' => 'ASC'
            ]
        ];
        $resDataGudang = $this->mGudang->getData(null, 0, 99999, $sortGudang);
        $this->data['kategori']    = $reDataKategori;
        $this->data['gudang']    = $resDataGudang;

        $this->data['titlehead'] = "Form Barang Masuk";

        return view($this->views . '\incoming_goods_form', $this->data);
    }

    function save()
    {

        $idBarang = $this->request->getPost('idBarang');
        $idBarang = decrypt($idBarang);
        $keterangan = $this->request->getPost('keterangan');
        $namaKonsumen = $this->request->getPost('namaKonsumen');
        $namaVendor = $this->request->getPost('namaVendor');
        $jmlMasuk = $this->request->getPost('jmlMasuk');
        $totalStok = $this->request->getPost('totalStok');
        $tanggal = $this->request->getPost('tanggal');
        $idGudangAsal = $this->request->getPost('idGudangAsal');
        $idGudangTujuan = $this->request->getPost('idGudangTujuan');
        $idKategori = $this->request->getPost('idKategori');

        $msg    = "Data gagal ditambahkan !";
        $status = false;
        $nama = "";
        if (!empty($namaKonsumen)) {
            $nama = $namaKonsumen;
        } else if (!empty($namaVendor)) {
            $nama = $namaVendor;
        }


        $arrData = [
            "id_barang" => $idBarang,
            "jenis_transaksi" => 1,
            "jumlah" => $jmlMasuk,
            "tanggal" => $tanggal,
            "id_gudang_asal" => !empty($idGudangAsal) ? $idGudangAsal : null,
            "id_gudang_tujuan" =>  !empty($idGudangTujuan) ? $idGudangTujuan : null,
            "nama" => $nama,
            "id_kategori" => $idKategori,
            "keterangan" => $keterangan,
            "stok" => $totalStok,
            "active" => 1,
            "tipe" => 1,
            "kode_transaksi" => $this->mBarangMasuk->generateKodePersediaan(),
        ];

        $arrData['created_at'] = date("Y-m-d H:i:s");
        $arrData['created_by'] = $this->get_userid();


        $res = $this->mBarangMasuk->trxInsertUpdateRecord($arrData);
        if ($res) {
            $msg    = "Data berhasil ditambahkan !";
            $status = true;
        }


        $build_array['message'] = $msg;
        $build_array['status']  = $status;

        return $this->response->setJSON($build_array);
    }

    function getLastStock()
    {
        $idGudangTujuan = $this->request->getPost("idGudangTujuan");
        $idGudangAsal = $this->request->getPost("idGudangAsal");
        $idBarang = $this->request->getPost("idBarang");
        $data = [];
        $idBarang = decrypt($idBarang);
        $results = $this->mBarangMasuk->getLastStokBarang($idBarang, $idGudangTujuan);
        if (!empty($idGudangAsal)) {
            $resGudangAsal = $this->mBarangMasuk->getLastStokBarang($idBarang, $idGudangAsal);
        }
        $data['status'] = true;
        $data['stok'] = !empty($results) ? $results->stok : 0;
        $data['stokAsal'] = !empty($resGudangAsal) ? $resGudangAsal->stok : 0;

        return $this->response->setJSON($data);
    }

    public function activate($id)
    {
        if (!$this->auth->loggedIn() or (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
            throw new \Exception('You must be an administrator to view this page.');
        }

        if ($id != null && $id != "") {
            $id = decrypt($id);
        }

        $id = (int)$id;
        $activation = $this->mBarang->activate($id);
        if ($activation) {
            $this->mcommon->setLog($this->currentUser->user_id, $this->MOD_ALIAS, $id, "User Diaktifkan");
            $this->session->setFlashdata('message', "User berhasil di aktifkan");
        } else {
            $this->session->setFlashdata('err', "User gagal di aktifkan !");
        }
        return redirect()->to($this->urlv);
    }

    public function deactivate($id = NULL)
    {
        if (!$this->auth->loggedIn() or (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
            throw new \Exception('You must be an administrator to view this page.');
        }

        if ($id != null && $id != "") {
            $id = decrypt($id);
        }

        $id = (int)$id;
        // if ($id == 1) {
        //     return redirect()->to($this->urlv);
        // }
        $data = ['active' => 0];

        $deactivate = $this->mBarang->updateRecord($this->mBarang->table, $data, 'id', $id);
        if ($deactivate) {
            $this->mcommon->setLog($this->currentUser->user_id, $this->MOD_ALIAS, $id, "Data Barang Dinonaktifkan");
            $this->session->setFlashdata('message', "Data Barang berhasil di Hapus ");
        } else {
            $this->session->setFlashdata('err', "Data Barang gagal di Hapus !");
        }
        return redirect()->to($this->urlv);
    }

    public function delete($id = NULL)
    {
        if (!$this->auth->loggedIn() or (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
            throw new \Exception('You must be an administrator to view this page.');
        }

        if ($id != null && $id != "") {
            $id = decrypt($id);
        }

        $id = (int)$id;
        if ($id == 1) {
            return redirect()->to($this->urlv);
        }

        $res = $this->mBarang->deleteUser($id);
        if ($res) {
            $this->mcommon->setLog($this->currentUser->user_id, $this->MOD_ALIAS, $id, "Master Ukuran Dihapus");
            $this->session->setFlashdata('message', "Master Ukuran berhasil dihapus");
        } else {
            $this->session->setFlashdata('err', "Master Ukuran gagal dihapus");
        }
        return redirect()->to($this->urlv);
    }
}
