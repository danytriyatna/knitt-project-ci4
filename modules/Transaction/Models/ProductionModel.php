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
                $builder->orderBy('abx.id desc');
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

        if (!empty($params['id_konsumen'])) {
            $builder->where('abx.id_konsumen', $params['id_konsumen']);
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }

    function getDataProsesProd($params)
    {
        $builder = $this->db->table("trans_walkorder_proses abx");
        $builder->select("bbx.seq,bbx.nama,bbx.id ,SUM(COALESCE(qty, 0)) AS qty, SUM(COALESCE(qty_prod, 0)) AS qty_prod");
        $builder->join("_jenis_proses_produksi bbx", "abx.id_proses = bbx.id", "inner");
        $builder->join("trans_walkorder_proses_ukuran cbx", "cbx.id_walkorder_proses = abx.id", "inner");
        if(!empty($params['id_walkorder'])){
            $builder->where('abx.id_walkorder', $params['id_walkorder']);
        }
        if(!empty($params['last_proses']) && !empty($params['id_walkorder'])){
            $builder->where('abx.id_proses = (select max(tx.id_proses) from trans_walkorder_proses tx where tx.id_walkorder = '.$params['id_walkorder'].')');
        }
        $builder->groupBy("bbx.nama, bbx.seq, bbx.id");
        $builder->orderBy("bbx.seq", "ASC");
        $this->_data = $builder->get()->getResult();

        return $this->_data;
    }

    function getDataNextProses($idWorkOrder, $id)
    {
        $builder = $this->db->table("trans_walkorder_proses abx");
        $builder->select("abx.id");
        $builder->where('abx.id_walkorder', $idWorkOrder);
        $builder->where('abx.id >', $id);
        $builder->orderBy("abx.id", "ASC");
        $builder->limit(1);
        $this->_data = $builder->get()->getRow();

        return $this->_data;
    }

    function getDataQuantityCurrent($id, $idUkuran)
    {
        $builder = $this->db->table("trans_walkorder_proses_ukuran abx");
        $builder->select("abx.qty_prod");
        $builder->where('abx.id_walkorder_proses', $id);
        $builder->where('abx.id_ukuran', $idUkuran);
        $builder->orderBy("abx.id", "ASC");
        $this->_data = $builder->get()->getRow();

        return $this->_data;
    }

    function getDataOperatorProd($id, $tgl_transaksi = null)
    {
        $builder = $this->db->table("trans_produksi_operator abx");
        $builder->select("abx.flag, abx.id_proses as id_walkorder_proses_ukuran, abx.qty, ebx.nama_operator as operator, dbx.kode_warna,  abx.harga_total, abx.harga, abx.tgl_transaksi as date,bbx.nama as process,cbx.kode_ukuran");
        $builder->join("_jenis_proses_produksi bbx", "abx.id_proses = bbx.id", "inner");
        $builder->join("ref_ukuran cbx", "abx.id_ukuran = cbx.id", "inner");
        $builder->join("ref_warna dbx", "abx.id_warna = dbx.id", "inner");
        $builder->join("ref_operator ebx", "abx.id_operator = ebx.id", "inner");
        $builder->where('abx.id_produksi', $id);

        if (!empty($tgl_transaksi)) {
            $builder->where('abx.tgl_transaksi', $tgl_transaksi);
        }
        
        $builder->orderBy("abx.id", "ASC");
        $this->_data = $builder->get()->getResult();

        return $this->_data;
    }

    function trxInsertUpdateRecord($data, $idProduksi, $idWorkOrder)
    {
        $this->db->transStart();
        try {


            foreach ($data as $rowData) {
                $resData = $this->getDataNextProses($idWorkOrder, $rowData['id_walkorder_proses_ukuran']);
                $resQtyCurrent = $this->getDataQuantityCurrent($rowData['id_walkorder_proses_ukuran'], $rowData['id_ukuran']);

                $arrDataUkuran = [
                    "id_produksi" => $idProduksi,
                    "id_walkorder_proses_ukuran" => !empty($rowData['id_walkorder_proses_ukuran']) ? $rowData['id_walkorder_proses_ukuran'] : null,
                    "id_proses" => $rowData['id_proses'],
                    "id_ukuran" => $rowData['id_ukuran'],
                    "id_warna" => $rowData['id_warna'],
                    "id_operator" => $rowData['id_operator'],
                    "tgl_transaksi" => $rowData['date'],
                    "qty" => $rowData['qty'],
                    "harga" => $rowData['harga'],
                    "harga_total" => $rowData['harga_total'],
                    "ref_detail_id" => $rowData['ref_detail_id'],
                    "active" => 1,
                    "flag" => 1,
                    "created_at" =>  date("Y-m-d H:i:s"),

                ];
                $this->insertRecordGetid("trans_produksi_operator", $arrDataUkuran);
                $arrUpdData = [
                    "qty_prod" => !empty($resQtyCurrent) + $rowData['qty'] ? (float)$resQtyCurrent->qty_prod + (float)$rowData['qty'] : $rowData['qty']
                ];
                $arrParam =  [
                    "id_walkorder_proses" => $rowData['id_walkorder_proses_ukuran'],
                    "id_ukuran" => $rowData['id_ukuran'],
                    "ref_detail_id" => $rowData['ref_detail_id'],
                ];
                $this->updateRecords("trans_walkorder_proses_ukuran", $arrUpdData, $arrParam);
               
                if(!empty($resData)){
                    $arrUpdData2 = [
                        "qty" => !empty($resQtyCurrent) ?  (float)$resQtyCurrent->qty_prod + (float)$rowData['qty']  : $rowData['qty']
                    ];
                    $arrParam2 =  [
                        "id_walkorder_proses" => $resData->id,
                        "id_ukuran" => $rowData['id_ukuran'],
                        "ref_detail_id" => $rowData['ref_detail_id'],
                    ];
                    $this->updateRecords("trans_walkorder_proses_ukuran", $arrUpdData2, $arrParam2);
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

    function getProduksilast($params){
        $id_walkorder = $params['id_walkorder'];
         // Dynamic Columns
         $col11 = "";
         $col12 = "";
         $col21 = "";
         $col22 = "";
         $col3 = "";
         $ukuranArr = explode(",", $params['ukuran']);
         foreach ($ukuranArr as $item) {
             $hrg = $item . '_hrg';
             $col11 .= ($col11 == "") ? "coalesce(tbl.$item,0) as $item" : ",coalesce(tbl.$item,0) as $item";
             $col12 .= ($col12 == "") ? "coalesce(tbl.$hrg,0) as $hrg" : ",coalesce(tbl.$hrg,0) as $hrg";

             $col21 .= ($col21 == "") ? "$item Int" : ",$item Int";
             $col22 .= ($col22 == "") ? "$hrg Float" : ",$hrg Float";
         }

        // $sql = "
        //     select 
        //         tbl.ref_detail_id__,
        //         tbl.id_walkorder,
        //         tbl.id_proses,
        //         tw.tipe_id,
        //         rw.kode_warna,
        //         coalesce(tbl.harga_satuan, 0) as harga_satuan,
        //         {$col1}
        //     from
        //         CROSSTAB(
        //             'select 
        //                 twpu.ref_detail_id,
        //                 twp.id_walkorder,
        //                 twp.id_proses,
        //                 (CASE WHEN tw.tipe_id = 1 THEN 
        //                     (select xt.harga_satuan from trans_sample_ukuran xt where xt.id_ukuran = twpu.id_ukuran and xt.id_sample_det =  twpu.ref_detail_id)
        //                 ELSE 
        //                     (select xt.harga_satuan from trans_sample_ukuran xt where xt.id_ukuran = twpu.id_ukuran and xt.id_sample_det =  twpu.ref_detail_id)
        //                 END) as harga_satuan,
        //                 rk.key_ukuran,
        //                 COALESCE(twpu.qty_prod, 0) as qty_prod
        //             from trans_walkorder_proses_ukuran twpu
        //             inner join trans_walkorder_proses twp on twp.id = twpu.id_walkorder_proses
        //             inner join trans_walkorder tw on tw.id = twp.id_walkorder
        //             inner join ref_ukuran rk on rk.id = twpu.id_ukuran
        //             where twp.id_walkorder = ".$id_walkorder." and  twp.id_proses = (select max(tx.id_proses) from trans_walkorder_proses tx where tx.id_walkorder = ".$id_walkorder.")
        //             order by twpu.ref_detail_id, twp.id_proses asc, twpu.id_ukuran',
        //         'select key_ukuran from ref_ukuran rx where rx.active = 1 order by rx.seq asc'
        //     ) as tbl (ref_detail_id int, id_walkorder int, id_proses int, harga_satuan float, {$col2})
        //     inner join trans_walkorder tw on tbl.id_walkorder = tw.id
        //     left join trans_sample_det tsd on tbl.ref_detail_id = tsd.id and tw.tipe_id = 1
        //     left join trans_sales_order_det tsod on tbl.ref_detail_id = tsod.id and tw.tipe_id = 2
        //     left join ref_warna rw on rw.id = (case when tw.tipe_id = 1 then tsd.id_warna_1 when tw.tipe_id = 2 then tsod.id_warna_1 else -1 end)
        // ";

        $sql = "
                SELECT 
                    tbl.ref_detail_id,
                    tbl.id_walkorder,
                    tbl.id_proses,
                    tw.tipe_id,
                    rw.kode_warna,
                    {$col11},
                    {$col12}
                FROM 
                    CROSSTAB(
                        $$ 
                        SELECT 
                            twpu.ref_detail_id,
                            twp.id_walkorder,
                            twp.id_proses,
                            rk.key_ukuran || CASE 
                                WHEN subquery.is_qty THEN ''
                                ELSE '_hrg'
                            END AS column_name,
                            CASE 
                                WHEN subquery.is_qty THEN COALESCE(twpu.qty_prod, 0)
                                ELSE 
                                    CASE 
                                        WHEN tw.tipe_id = 1 THEN
                                            (
                                                SELECT xt.harga_satuan 
                                                FROM trans_sample_ukuran xt 
                                                WHERE xt.id_ukuran = twpu.id_ukuran 
                                                AND xt.id_sample_det = twpu.ref_detail_id
                                            )
                                        WHEN tw.tipe_id = 2 THEN
                                            (
                                                SELECT xt.harga_satuan 
                                                FROM trans_sales_order_ukuran xt 
                                                WHERE xt.id_ukuran = twpu.id_ukuran 
                                                AND xt.id_sales_order_det = twpu.ref_detail_id
                                            )
                                        ELSE
                                            0
                                    END
                            END AS value
                        FROM trans_walkorder_proses_ukuran twpu
                        INNER JOIN trans_walkorder_proses twp 
                            ON twp.id = twpu.id_walkorder_proses
                        INNER JOIN trans_walkorder tw 
                            ON tw.id = twp.id_walkorder
                        INNER JOIN ref_ukuran rk 
                            ON rk.id = twpu.id_ukuran
                        CROSS JOIN (
                            SELECT DISTINCT key_ukuran, TRUE AS is_qty 
                            FROM ref_ukuran 
                            WHERE active = 1
                            UNION ALL
                            SELECT DISTINCT key_ukuran, FALSE AS is_qty 
                            FROM ref_ukuran 
                            WHERE active = 1
                        ) subquery
                        WHERE twp.id_walkorder = {$id_walkorder}
                        AND twp.id_proses = (
                            SELECT MAX(tx.id_proses) 
                            FROM trans_walkorder_proses tx 
                            WHERE tx.id_walkorder = {$id_walkorder}
                        )
                        ORDER BY twpu.ref_detail_id, twp.id_proses, column_name
                        $$,
                        $$ 
                        SELECT key_ukuran 
                        FROM (
                            SELECT key_ukuran, 1 as tseq, seq  FROM ref_ukuran WHERE active = 1
                            UNION ALL
                            SELECT CONCAT(key_ukuran, '_hrg'), 2 as tseq, seq  FROM ref_ukuran WHERE active = 1
                        ) AS subquery
                        ORDER BY tseq, seq
                        $$
                    ) AS tbl (
                        ref_detail_id INT,
                        id_walkorder INT,
                        id_proses INT,
                        {$col21},
                        {$col22}
                    )
                INNER JOIN trans_walkorder tw ON tbl.id_walkorder = tw.id
                LEFT JOIN trans_sample_det tsd ON tbl.ref_detail_id = tsd.id AND tw.tipe_id = 1
                LEFT JOIN trans_sales_order_det tsod ON tbl.ref_detail_id = tsod.id AND tw.tipe_id = 2
                LEFT JOIN ref_warna rw ON rw.id = CASE 
                    WHEN tw.tipe_id = 1 THEN tsd.id_warna_1
                    WHEN tw.tipe_id = 2 THEN tsod.id_warna_1 
                    ELSE -1 
                END;

        ";

        // -- s INT, m INT, l INT, xl INT, xxl INT, all_ INT, xxxl INT, xs INT,
        //                 == s_hrg FLOAT, m_hrg FLOAT, l_hrg FLOAT, xl_hrg FLOAT, xxl_hrg FLOAT, all_hrg FLOAT, xxxl_hrg FLOAT, xs_hrg FLOAT

        $query = $this->db->query($sql);

        $this->_data = $query->getResult();

        return $this->_data;
    }   
}
