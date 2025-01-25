<?php

namespace App\Models;

use CodeIgniter\Model;

class Mdashboard extends Model
{
    public function getCombinedDetailsTransaktoion(array $where = [])
    {
        // Query untuk trans_sales_order dengan kondisi khusus
        $querySalesOrder = $this->db->query("
            qty_order_cte AS (
                SELECT 
                    id_sales_order, 
                    SUM(qty) AS total_qty_order
                FROM 
                    trans_sales_order_ukuran
                GROUP BY 
                    id_sales_order
            ),
            qty_prod_order_cte AS (
                SELECT 
                    tso.id AS order_id, 
                    wp.id_walkorder,
                    SUM(xk.qty_prod) AS total_qty_prod
                FROM 
                    trans_walkorder_proses_ukuran xk
                INNER JOIN 
                    trans_walkorder_proses wp ON wp.id = xk.id_walkorder_proses
                INNER JOIN 
                    trans_walkorder xp ON xp.id = wp.id_walkorder
                INNER JOIN 
                    trans_sales_order tso ON xp.ref_id = tso.id
                WHERE 
                    xp.tipe_id = 2
                    AND wp.id_proses = (
                        SELECT MAX(wp2.id_proses)
                        FROM trans_walkorder_proses wp2
                        WHERE wp2.id_walkorder = xp.id
                    )
                GROUP BY 
                    tso.id,wp.id_walkorder
            ),
            qty_kirim_order_cte AS (
                SELECT 
                    tso.id AS order_id, 
                    SUM(xd3.qty) AS total_qty_kirim
                FROM 
                    trans_delivery xd3
                INNER JOIN 
                    trans_walkorder te1 ON te1.id = xd3.id_walkorder
                INNER JOIN 
                    trans_sales_order tso ON te1.ref_id = tso.id
                WHERE 
                    te1.tipe_id = 2
                GROUP BY 
                    tso.id
            ),
            SELECT
                tso.id AS trans_id, 
                tso.kode_sales_order AS trans_kode,
                tso.id_konsumen,
                rk.nama,
                tso.keterangan,
                tso.tgl_deadline,
                2 as tipe,
                COALESCE(qo.total_qty_order, 0) AS qty,
                (select tp.kode_prod from trans_produksi tp where tp.id_walkorder = qp.id_walkorder) as kode_prod,
                (select tp.id from trans_produksi tp where tp.id_walkorder = qp.id_walkorder) as id_prod,
                COALESCE(qp_order.total_qty_prod, 0) AS qty_prod,
                (select td.delivery_kode from trans_delivery td where td.id_walkorder = qp.id_walkorder order by td.id desc limit 1) as kode_dev,
                (select td.id from trans_delivery td where td.id_walkorder = qp.id_walkorder order by td.id desc limit 1) as id_dev,
                COALESCE(qk_order.total_qty_kirim, 0) AS qty_kirim
            FROM
                trans_sales_order tso
            INNER JOIN ref_konsumen rk ON rk.id = tso.id_konsumen
            LEFT JOIN qty_order_cte qo ON qo.id_sales_order = tso.id
            LEFT JOIN qty_prod_order_cte qp_order ON qp_order.order_id = tso.id
            LEFT JOIN qty_kirim_order_cte qk_order ON qk_order.order_id = tso.id
            WHERE tso.active = 1
        ");

        // Query untuk trans_sample dengan kondisi khusus
        $querySample = $this->db->query("
            qty_sample_cte AS (
                SELECT 
                    id_sample, 
                    SUM(qty) AS total_qty_sample
                FROM 
                    trans_sample_ukuran
                GROUP BY 
                    id_sample
            ),
            qty_prod_sample_cte AS (
                SELECT 
                    ts.id AS sample_id, 
                    wp.id_walkorder,
                    SUM(xk.qty_prod) AS total_qty_prod
                FROM 
                    trans_walkorder_proses_ukuran xk
                INNER JOIN 
                    trans_walkorder_proses wp ON wp.id = xk.id_walkorder_proses
                INNER JOIN 
                    trans_walkorder xp ON xp.id = wp.id_walkorder
                INNER JOIN 
                    trans_sample ts ON xp.ref_id = ts.id
                WHERE 
                    xp.tipe_id = 1 
                    AND wp.id_proses = (
                        SELECT MAX(wp2.id_proses)
                        FROM trans_walkorder_proses wp2
                        WHERE wp2.id_walkorder = xp.id
                    )
                GROUP BY 
                    ts.id, wp.id_walkorder
            ),
            qty_kirim_sample_cte AS (
                SELECT 
                    ts.id AS sample_id, 
                    SUM(xd3.qty) AS total_qty_kirim
                FROM 
                    trans_delivery xd3
                INNER JOIN 
                    trans_walkorder te1 ON te1.id = xd3.id_walkorder
                INNER JOIN 
                    trans_sample ts ON te1.ref_id = ts.id
                WHERE 
                    te1.tipe_id = 1
                GROUP BY 
                    ts.id
            )
            SELECT
                ts.id AS trans_id, 
                ts.kode_sample AS trans_kode,
                ts.id_konsumen,
                rk.nama,
                ts.keterangan,
                ts.tgl_deadline,
                1 as tipe,
                COALESCE(qo.total_qty_sample, 0) AS qty,
                (select tp.kode_prod from trans_produksi tp where tp.id_walkorder = qp.id_walkorder) as kode_prod,
                (select tp.id from trans_produksi tp where tp.id_walkorder = qp.id_walkorder) as id_prod,
                COALESCE(qp_sample.total_qty_prod, 0) AS qty_prod,
                (select td.delivery_kode from trans_delivery td where td.id_walkorder = qp.id_walkorder order by td.id desc limit 1) as kode_dev,
                (select td.id from trans_delivery td where td.id_walkorder = qp.id_walkorder order by td.id desc limit 1) as id_dev,
                COALESCE(qk_sample.total_qty_kirim, 0) AS qty_kirim
            FROM
                    trans_sample ts
            INNER JOIN ref_konsumen rk ON rk.id = ts.id_konsumen
            LEFT JOIN qty_sample_cte qs ON qs.id_sample = ts.id
            LEFT JOIN qty_prod_sample_cte qp_sample ON qp_sample.sample_id = ts.id
            LEFT JOIN qty_kirim_sample_cte qk_sample ON qk_sample.sample_id = ts.id
            WHERE ts.active = 1
        ");

        // Menggabungkan hasil kedua query menggunakan UNION ALL
        $combinedQuery = $this->db->query("
            SELECT * FROM (
                ({$querySalesOrder->getQuery()})
                UNION ALL
                ({$querySample->getQuery()})
            ) as xc " . $this->buildWhereClause($where) . "
        ");

        // return $combinedQuery->getResultArray();
        return $combinedQuery->getQuery();
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        // $builder = $this->db->table($this->table . " sdm");

        $subQuery = $this->getCombinedDetailsTransaktoion([]);

        // Gunakan subquery dengan Query Builder
        $builder = $db->newQuery()->fromSubquery($subQuery, 'tbl');

        $builder->select("tbl.trans_id, tbl.trans_kode, tbl.id_konsumen, tbl.nama, tbl.keterangan, tbl.tgl_deadline, tbl.qty, tbl.tipe, 
                          tbl.kode_prod, tbl.id_prod, tbl.qty_prod, 
                          tbl.kode_dev, tbl.id_dev, tbl.qty_kirim");

        if ($id == null or $id == "") {
            $builder->where('sdm.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->where('LOWER(tbl.keterangan) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(tbl.trans_kode) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(tbl.kode_dev) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(tbl.kode_prod) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(tbl.nama) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy("tbl.trans_id desc");
            }

            if (empty($offset)) $offset = 0;
            if (empty($limit)) $limit = 10;

            $builder->limit($limit, $offset);

            $this->_data = $builder->get()->getResult();
        } else {
            $builder->where("tbl.trans_id", $id);

            $this->_data = $builder->get()->getRow();
        }

        return $this->_data;
    }

    function getDataCnt($filters = null, $params = null)
    {
        $subQuery = $this->getCombinedDetailsTransaktoion([]);

        $builder->select("count(1) as _cnt");

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
                $builder->where('LOWER(tbl.keterangan) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(tbl.trans_kode) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(tbl.kode_dev) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(tbl.kode_prod) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(tbl.nama) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }

}