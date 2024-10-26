<?php

namespace Modules\Transaction\Models;

class ProductionModel extends \App\Models\PrModel
{

    protected $table = "trans_produksi";
    protected $_data = null;
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " abx");

        $builder->select("abx.id, abx.id_walkorder,  abx.kode_walkorder, abx.id_konsumen, abx.id_style, abx.qty, abx.file_id,
                        abx.status, bbx.nama as konsumen_nama, abx.tgl_deadline, abx.tgl_transaksi, abx.keterangan_style,
                        abx.tipe_id, cbx.file_name,abx.kode_prod");

        $builder->join("ref_konsumen bbx", "abx.id_konsumen = bbx.id", "inner");
        // $builder->join("trans_sample ts", "ts.id = abx.ref_id and abx.tipe_id = 1", "left");
        // $builder->join("trans_sales_order tso", "tso.id = abx.ref_id and abx.tipe_id = 2", "left");
        $builder->join("_files cbx", "abx.file_id = cbx.id", "left");
        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                $builder->where('LOWER(abx.kode_prod) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(abx.kode_walkorder) LIKE', strtolower("%{$filters[0]['value']}%"));
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
            $builder->where('LOWER(abx.kode_prod) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(abx.kode_walkorder) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }

    function getDataProsesProd($id)
    {
        $builder = $this->db->table("trans_walkorder_proses abx");
        $builder->select("bbx.seq,bbx.nama,bbx.id,SUM(qty) AS qty,SUM(qty_prod) AS qty_prod");
        $builder->join("_jenis_proses_produksi bbx", "abx.id_proses = bbx.id", "inner");
        $builder->join("trans_walkorder_proses_ukuran cbx", "cbx.id_walkorder_proses = abx.id", "inner");
        $builder->where('abx.id_walkorder', $id);
        $builder->groupBy("bbx.nama");
        $builder->groupBy("bbx.seq");
        $builder->groupBy("bbx.id");
        $builder->orderBy("bbx.seq", "ASC");
        $this->_data = $builder->get()->getResult();

        return $this->_data;
    }
    function getDataOperatorProd($id)
    {
        $builder = $this->db->table("trans_produksi_operator abx");
        $builder->select("abx.flag, abx.id_proses as id_walkorder_proses_ukuran, abx.qty, CASE WHEN id_operator = 1 THEN 'Teh Endok' WHEN id_operator = 2 THEN 'Amih' WHEN id_operator = 3 THEN 'Pak Juju' ELSE 'Pak Iyang' END as operator, dbx.kode_warna,  abx.harga_total, abx.harga, abx.tgl_transaksi as date,bbx.nama as process,cbx.kode_ukuran");
        $builder->join("_jenis_proses_produksi bbx", "abx.id_proses = bbx.id", "inner");
        $builder->join("ref_ukuran cbx", "abx.id_ukuran = cbx.id", "inner");
        $builder->join("ref_warna dbx", "abx.id_warna = dbx.id", "inner");
        $builder->where('abx.id_produksi', $id);
        $builder->orderBy("abx.id", "ASC");
        $this->_data = $builder->get()->getResult();

        return $this->_data;
    }

    function trxInsertUpdateRecord($data, $idProduksi)
    {
        $this->db->transStart();
        try {
            foreach ($data as $rowData) {

                $arrDataUkuran = [
                    "id_produksi" => $idProduksi,
                    "id_proses" => !empty($rowData['id_walkorder_proses_ukuran']) ? $rowData['id_walkorder_proses_ukuran'] : null,
                    "id_ukuran" => $rowData['id_ukuran'],
                    "id_warna" => $rowData['id_warna'],
                    "id_operator" => $rowData['id_operator'],
                    "tgl_transaksi" => $rowData['date'],
                    "qty" => $rowData['qty'],
                    "harga" => $rowData['harga'],
                    "harga_total" => $rowData['harga_total'],
                    "active" => 1,
                    "flag" => 1,
                    "created_at" =>  date("Y-m-d H:i:s"),

                ];
                $this->insertRecordGetid("trans_produksi_operator", $arrDataUkuran);
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
