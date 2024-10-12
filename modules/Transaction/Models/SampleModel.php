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

        $builder->select("abx.id, abx.kode_sample, abx.deskripsi, bbx.nama, abx.id_konsumen, abx.keterangan, abx.tgl_transaksi, abx.tgl_deadline, abx.status, abx.gambar_id,cbx.file_name");
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
	) AS colour");
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
    function getDataDetailSampleUkuran($idSample, $idSampleDet)
    {
        $sql = "SELECT
	bbx.id,
	abx.kode_ukuran as ukuran,
    bbx.id_ukuran,
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
    function getDataDetailSampleWarna($idSample)
    {
        $builder = $this->db->table("trans_sample_det");
        $builder->where("id_sample", $idSample);
        $this->_data = $builder->get()->getRow();
    }
}
