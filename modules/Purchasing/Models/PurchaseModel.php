<?php

namespace Modules\Purchasing\Models;

class PurchaseModel extends \App\Models\PrModel
{

    protected $table = "trans_po_header";
    protected $tblTerm = "ref_term";
    protected $tblVendor = "ref_vendor";
    protected $tblTax = "ref_tax";


    protected $_data = null;
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " uk");
        $builder->join($this->tblVendor . " dbx", "uk.id_vendor = dbx.id", "inner");
        $builder->join($this->tblTerm . " ebx", "uk.id_term = ebx.id", "inner");
        $builder->select("uk.id, uk.id_vendor, uk.id_term, uk.po_no,dbx.nama as nama_vendor, ebx.name as term, uk.po_date, uk.date_exc, uk.ship_to, uk.qty, uk.qty_payment, uk.total, uk.total_payment");

        if ($id == null or $id == "") {
            $builder->where('uk.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                $builder->where('LOWER(dbx.nama) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(uk.po_no) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('id');
            }

            if (empty($offset)) $offset = 0;
            if (empty($limit)) $limit = 10;

            $builder->limit($limit, $offset);

            $this->_data = $builder->get()->getResult();
        } else {
            $builder->where("uk.id", $id);

            $this->_data = $builder->get()->getRow();
        }

        return $this->_data;
    }

    function getDataCnt($filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " uk");
        $builder->select("count(1) as _cnt");
        $builder->where('uk.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
            $builder->where('LOWER(dbx.nama) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(uk.po_no) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }

    function generateKodePO()
    {
        $kd = "POD";
        $builder = $this->db->table($this->table . ' a');
        $builder->select("LEFT(kode_transaksi, 7) AS tgl, RIGHT( kode_transaksi, 4 ) AS kode ");

        $builder->orderBy('a.id', "DESC");
        $builder->limit(1);
        $query = $builder->get()->getRow();

        if ($query != NULL) {
            if ($query->tgl == $kd . date('y') . date('m')) {     //cek dulu apakah ada sudah ada tahun dan bulan di tabel.   
                //jika tahun dan bulan ternyata sudah ada.      
                // $data = $query->row();
                $kode = intval($query->kode) + 1;
            } else {
                //jika tahun dan belum ada      
                $kode = 1;
            }
        } else {
            $kode = 1;
        }

        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 3 menunjukkan jumlah digit angka 0
        $kodejadi = $kd . date('y') . date('m') . $kodemax;

        // hasilnya SOD24100001 dst.
        return $kodejadi;
    }

    function getRefTerm()
    {
        $builder = $this->db->table($this->tblTerm);
        $builder->select("*");
        $this->_data = $builder->get()->getResultArray();
        return $this->_data;
    }

    function getRefTax()
    {
        $builder = $this->db->table($this->tblTax);
        $builder->select("*");
        $this->_data = $builder->get()->getRow();
        return $this->_data;
    }

    function getLastStokBarang($idBarang, $idGudang)
    {
        $builder = $this->db->table("trans_persediaan");
        $builder->select("stok");
        $builder->where('id_barang', $idBarang);
        $builder->where('id_gudang', $idGudang);
        $this->_data = $builder->get()->getRow();
        return $this->_data;
    }

    function trxInsertUpdateRecord($data)
    {
        $this->db->transStart();
        try {


            $this->insertRecordGetid("trans_barang", $data);
            $arrPersediaan = [
                "id_barang" => $data['id_barang'],
                "id_gudang" => $data['id_gudang_tujuan'],
                "stok" => $data['stok'],
                "created_at" =>  $data['created_at'],
                "created_by" =>  $data['created_by'],
                "active" => 1,
            ];
            $arrParam =  [
                "id_barang" => $data['id_barang'],
                "id_gudang" => $data['id_gudang_tujuan'],
            ];
            $resData = $this->getLastStokBarang($data['id_barang'], $data['id_gudang_tujuan']);
            if (!empty($resData)) {
                $this->updateRecords("trans_persediaan", $arrPersediaan, $arrParam);
            } else {
                $this->insertRecordGetid("trans_persediaan", $arrPersediaan);
            }

            if ($data['id_kategori'] == 1) {
                $data['tipe'] = 2;
                $data['id_kategori'] = 4;
                $data['jenis_transaksi'] = 2;
                $this->insertRecordGetid("trans_barang", $data);
                $resDataKeluar = $this->getLastStokBarang($data['id_barang'], $data['id_gudang_asal']);
                $arrPersediaanKeluar = [
                    "id_barang" => $data['id_barang'],
                    "id_gudang" => $data['id_gudang_asal'],
                    "stok" => $data['stok'],
                    "created_at" =>  $data['created_at'],
                    "created_by" =>  $data['created_by'],
                    "active" => 1,
                ];
                $arrParamKeluar =  [
                    "id_barang" => $data['id_barang'],
                    "id_gudang" => $data['id_gudang_asal'],
                ];
                $resDataKeluar = $this->getLastStokBarang($data['id_barang'], $data['id_gudang_asal']);
                if (!empty($resDataKeluar)) {
                    $this->updateRecords("trans_persediaan", $arrPersediaanKeluar, $arrParamKeluar);
                } else {
                    $this->insertRecordGetid("trans_persediaan", $arrPersediaanKeluar);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === TRUE) {
                return true;
            } else {
                throw new \Exception("Transaction failed");
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            throw $e;
        }
    }
}
