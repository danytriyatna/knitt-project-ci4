<?php

namespace Modules\Transaction\Models;

class SampleModel extends \App\Models\PrModel
{

    protected $table = "trans_sample";
    protected $_data = null;
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " abx");

        $builder->select("abx.id, abx.kode_sample,abx.status, abx.deskripsi, bbx.nama, abx.id_konsumen, abx.keterangan, abx.tgl_transaksi, abx.tgl_deadline, abx.status, abx.gambar_id,cbx.file_name");
        $builder->join("ref_konsumen bbx", "abx.id_konsumen = bbx.id", "inner");
        $builder->join("_files cbx", "abx.gambar_id = cbx.id", "left");
        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                $builder->where('LOWER(abx.kode_sample) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(bbx.nama) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if (!empty($params['id_konsumen'])) {
                $builder->where('abx.id_konsumen', $params['id_konsumen']);
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('abx.id');
            }

            if (empty($offset)) $offset = 0;
            if (empty($limit)) $limit = 10;

            $builder->limit($limit, $offset);

            $this->_data = $builder->get()->getResult();
        } else {
            $builder->where("abx.id", $id);

            $this->_data = $builder->get()->getRow();
        }

        return $this->_data;
    }

    function getDataCnt($filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " abx");

        $builder->join("ref_konsumen bbx", "abx.id_konsumen = bbx.id", "inner");
        $builder->select("count(1) as _cnt");
        $builder->where('abx.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
            $builder->where('LOWER(abx.kode_sample) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(bbx.nama) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }

    function getDataDetailSample($idSample)
    {
        $builder = $this->db->table("trans_sample_det" . " abx");
        $builder->select("abx.id,ROW_NUMBER
	( ) OVER ( ORDER BY abx.id ) AS No,
            TRIM (
                BOTH ' - ' 
            FROM
                COALESCE ( w1.kode_warna, '' ) ||
            CASE
                    
                    WHEN w2.kode_warna IS NOT NULL THEN
                    ' - ' || w2.kode_warna ELSE'' 
                END ||
        CASE
            
            WHEN w3.kode_warna IS NOT NULL THEN
            ' - ' || w3.kode_warna ELSE'' 
            END ||
        CASE
            
            WHEN w4.kode_warna IS NOT NULL THEN
            ' - ' || w4.kode_warna ELSE'' 
            END ||
        CASE
            
            WHEN w5.kode_warna IS NOT NULL THEN
            ' - ' || w5.kode_warna ELSE'' 
            END ||
        CASE
            
            WHEN w6.kode_warna IS NOT NULL THEN
            ' - ' || w6.kode_warna ELSE'' 
            END ||
        CASE
            
            WHEN w7.kode_warna IS NOT NULL THEN
            ' - ' || w7.kode_warna ELSE'' 
            END ||
        CASE
            
            WHEN w8.kode_warna IS NOT NULL THEN
            ' - ' || w8.kode_warna ELSE'' 
        END 
            ) AS colour,
             COALESCE ( w1.kode_warna, '' ) as colorDasar");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = 'S' THEN bbx.qty ELSE 0 END ) AS S ");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = 'M' THEN bbx.qty ELSE 0 END ) AS M ");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = 'L' THEN bbx.qty ELSE 0 END ) AS L ");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = 'XL' THEN bbx.qty ELSE 0 END ) AS XL ");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = 'XXL' THEN bbx.qty ELSE 0 END ) AS XXL ");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = '3XL' THEN bbx.qty ELSE 0 END ) AS XXXL ");
        $builder->select("MAX ( CASE WHEN cbx.kode_ukuran = 'All' THEN bbx.qty ELSE 0 END ) AS All ");
        $builder->select("SUM(bbx.harga_satuan) AS harga_satuan");
        $builder->join("trans_sample_ukuran bbx", "abx.id = bbx.id_sample_det AND abx.id_sample = bbx.id_sample", "inner");
        $builder->join("ref_ukuran cbx", "bbx.id_ukuran = cbx.id", "left");
        $builder->join("ref_warna w1", "abx.id_warna_1 = w1.id", "left");
        $builder->join("ref_warna w2", "abx.id_warna_2 = w2.id", "left");
        $builder->join("ref_warna w3", "abx.id_warna_3 = w3.id", "left");
        $builder->join("ref_warna w4", "abx.id_warna_4 = w4.id", "left");
        $builder->join("ref_warna w5", "abx.id_warna_5 = w5.id", "left");
        $builder->join("ref_warna w6", "abx.id_warna_6 = w6.id", "left");
        $builder->join("ref_warna w7", "abx.id_warna_7 = w7.id", "left");
        $builder->join("ref_warna w8", "abx.id_warna_8 = w8.id", "left");
        $builder->where("abx.id_sample", $idSample);
        $builder->groupBy(array("abx.id", "w1.kode_warna", "w2.kode_warna", "w3.kode_warna", "w4.kode_warna", "w5.kode_warna", "w6.kode_warna", "w7.kode_warna", "w8.kode_warna"));
        $this->_data = $builder->get()->getResult();
        return $this->_data;
    }

    function getDataDetailSample_ori($idSample)
    {
        $builder = $this->db->table("trans_sample_det" . " abx");
        $builder->where("abx.id_sample", $idSample);
        $this->_data = $builder->get()->getResult();
        return $this->_data;
    }

    function getDataDetailSampleUkuran($idSample, $idSampleDet)
    {
        $sql = "SELECT
                    bbx.id,
                    abx.kode_ukuran as ukuran,
                    abx.id AS id_ukuran,
                    bbx.qty,
                    bbx.harga_satuan,
                    bbx.harga_total
                FROM
                    ref_ukuran abx
                    LEFT JOIN trans_sample_ukuran bbx ON bbx.id_ukuran = abx.id
                    AND bbx.id_sample = $idSample
                    AND bbx.id_sample_det = $idSampleDet
                    ORDER BY abx.id";
        $result = $this->db->query($sql);
        $this->_data   = $result->getResult();
        return $this->_data;
    }

    function getDataDetailSampleWarna($idSample, $id = null)
    {

        $builder = $this->db->table("trans_sample_det");
        $builder->where("id_sample", $idSample);
        if (!empty($id)) {
            $builder->where("id", $id);
            $this->_data = $builder->get()->getRow();
        } else {
            $this->_data = $builder->get()->getResult();
        }
        return $this->_data;
    }
    function getDataDetailSampleUkuranById($id)
    {

        $builder = $this->db->table("trans_sample_ukuran abx");
        $builder->select("w1.kode_warna as warna1,w2.kode_warna as warna2,w3.kode_warna as warna3,w4.kode_warna as warna4");
        $builder->select("w5.kode_warna as warna5,w6.kode_warna as warna6,w7.kode_warna as warna7,w8.kode_warna as warna8");
        $builder->select("abx.id_sample, abx.id_sample_det");
        $builder->join("trans_sample_det bbx", "abx.id_sample_det=bbx.id", "inner");
        $builder->join("ref_warna w1", "bbx.id_warna_1 = w1.id", "left");
        $builder->join("ref_warna w2", "bbx.id_warna_2 = w2.id", "left");
        $builder->join("ref_warna w3", "bbx.id_warna_3 = w3.id", "left");
        $builder->join("ref_warna w4", "bbx.id_warna_4 = w4.id", "left");
        $builder->join("ref_warna w5", "bbx.id_warna_5 = w5.id", "left");
        $builder->join("ref_warna w6", "bbx.id_warna_6 = w6.id", "left");
        $builder->join("ref_warna w7", "bbx.id_warna_7 = w7.id", "left");
        $builder->join("ref_warna w8", "bbx.id_warna_8 = w8.id", "left");
        $builder->where("abx.id", $id);
        $this->_data = $builder->get()->getRow();
        return $this->_data;
    }

    function trxInsertUpdateRecord($dataWarna, $dataUkuran)
    {
        $this->db->transStart();
        try {
            if (!empty($dataWarna['id'])) {
                $dataWarna['updated_at'] = date("Y-m-d H:i:s");
                $this->updateRecord("trans_sample_det", $dataWarna, 'id', $dataWarna['id']);
            } else {
                unset($dataWarna['id']);
                $dataWarna['created_at'] = date("Y-m-d H:i:s");
                $idSampleDet = $this->insertRecordGetid("trans_sample_det", $dataWarna);
            }
            if (!empty($dataWarna['id']) && ($dataWarna['id_sample'])) {
                $arrDelete = [
                    "id_sample" => $dataWarna['id_sample'],
                    "id_sample_det" => $dataWarna['id']
                ];
                $this->deleteRecordMultipleColumn("trans_sample_ukuran", $arrDelete);
            }
            foreach ($dataUkuran as $rowData) {

                $arrDataUkuran = [
                    "id_sample" => $dataWarna['id_sample'],
                    "id_sample_det" => !empty($dataWarna['id']) ? $dataWarna['id'] : $idSampleDet,
                    "id_ukuran" => $rowData['id_ukuran'],
                    "qty" => $rowData['qty'],
                    "harga_satuan" => $rowData['harga_satuan'],
                    "harga_total" => (!empty($rowData['qty']) && !empty($rowData['harga_satuan'])) ? $rowData['qty'] * $rowData['harga_satuan'] : 0, //$rowData['harga_total'],
                    "active" => 1,
                    "created_at" =>  date("Y-m-d H:i:s"),

                ];
                $this->insertRecordGetid("trans_sample_ukuran", $arrDataUkuran);
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

    function trxSubmitSample($arrData, $id)
    {
        $this->db->transStart();
        try {

            $this->updateRecord("trans_sample", $arrData, 'id', $id);
            if ($arrData['status'] == 1) {
                $result = $this->getData($id);
                $arrWorkOrder = [
                    "ref_id" => $id,
                    "ref_kode" => !empty($result->kode_sample) ? $result->kode_sample : null,
                    "kode_walkorder" => $this->generateNo("WRD", "trans_walkorder", "kode_walkorder"),
                    "id_konsumen" => $arrData['id_konsumen'],
                    'tgl_transaksi' => date("Y-m-d"),
                    'tgl_deadline' => $arrData['tgl_deadline'],
                    "qty" => !empty($arrData['qty']) ? $arrData['qty'] : 0,
                    "file_id" => !empty($arrData['gambar_id']) ? $arrData['gambar_id'] : null,
                    "status" => 1,
                    "tipe_id" => 2,
                    "active" => 1,
                    'keterangan_style' => $arrData['keterangan'],
                    "created_at" => $arrData['updated_at'],

                ];
                $idWorkOrder = $this->insertRecordGetid("trans_walkorder", $arrWorkOrder);
                $dataWarna = $this->getDataDetailSampleWarna($id);

                if (!empty($dataWarna)) {
                    foreach ($dataWarna as $rowData) {

                        $detailWorkOrder = [
                            'id_walkorder' => $idWorkOrder,
                            'ref_detail_id' => $rowData->id,
                            'tipe_id' => 2,
                            'created_at' => date("Y-m-d H:i:s")
                        ];

                        $woIdDet = $this->insertRecordGetid("trans_walkorder_detail", $detailWorkOrder);

                        for ($i = 0; $i < 8; $i++) {
                            $field_name = 'id_warna_' . ($i + 1);
                            if (!empty($field_name)) {
                                $arrWarna = [
                                    'id_walkorder_detail' => $woIdDet,
                                    'id_warna' => $field_name,
                                    'created_at' => date("Y-m-d H:i:s")
                                ];
                                $this->insertRecordGetid("trans_walkorder_warna", $arrWarna);
                            }
                        }
                    }
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

    function generateNo($prefix, $table, $kode)
    {
        $kd = $prefix;
        $builder = $this->db->table($table . ' a');
        $builder->select("LEFT($kode, 7) AS tgl, RIGHT( $kode, 4 ) AS kode ");

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
}
