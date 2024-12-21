<?php

namespace Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use Modules\Referensi\Models\BarangModel;
use Modules\Referensi\Models\JenisBarangModel;
use Modules\Referensi\Models\SatuanModel;
use Modules\Transaction\Models\IncomingGoodsModel;
use Modules\Referensi\Models\GudangModel;
use Modules\Laporan\Models\LaporanStockCardModel;

class LaporanStockCard extends BaseController
{
    protected $mBarang;
    protected $mJenisBarang;
    protected $mSatuan;
    protected $mBarangMasuk;
    protected $mGudang;
    protected $mLaporan;

    protected $views = '\Modules\Laporan\Views';
    protected $urlv  = 'laporan/stock-card';

    function __construct()
    {
        $this->MOD_ALIAS = "MOD_LAPORAN_STOCK_CARD";
        $this->mBarang = new BarangModel();
        $this->mJenisBarang = new JenisBarangModel();
        $this->mSatuan = new SatuanModel();
        $this->mBarangMasuk = new IncomingGoodsModel();
        $this->mGudang = new GudangModel();
        $this->mLaporan = new LaporanStockCardModel();
        $this->files  = new FileModel();
    }

    public function index()
    {

        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $this->data['titlehead'] = "Laporan Stock Card ";
        $sortGudang = [
            [
                'field' => 'nama_gudang',
                'dir' => 'ASC'
            ]
        ];
        $resDataGudang = $this->mGudang->getData(null, 0, 99999, $sortGudang);
        $resTahun = $this->mLaporan->getTahun();
        $resBulan = $this->mLaporan->getBulan();

        $this->data['gudang']    = $resDataGudang;
        $this->data['tahun']    = $resTahun;
        $this->data['bulan']    = $resBulan;
        return view($this->views . '\laporan_stock_card', $this->data);
    }


    public function getDataLaporanStockCard()
    {

        $build_array = [];
        $build_array["code"] = 200;
        $build_array["status"] = false;

        $idBarang = $this->request->getGet('filter_barang_id');
        if ($idBarang != null) {
            $idBarang = decrypt($idBarang);
        }
        $filter_gudang = $this->request->getGet('filter_gudang_id');

        $tahun = $this->request->getGet('tahun');
        $bulan = $this->request->getGet('bulan');

        $resData = $this->mLaporan->getLaporanStockCard($idBarang, $filter_gudang, $tahun, $bulan);

        if(!empty($resData)){
            for ($i=0; $i < count($resData); $i++) { 
                $resData[$i]->tanggal = \fdate_eng_to_ind_3($resData[$i]->tanggal);
            }
        }

        $build_array["message"] = "Data ditemukan";
        $build_array["data"] =  !empty($resData) ? $resData : [];
        $build_array["status"] = true;

        return $this->response->setJSON($build_array);
    }
}
