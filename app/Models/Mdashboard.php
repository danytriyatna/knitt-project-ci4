<?php

namespace App\Models;

use CodeIgniter\Model;

class Mdashboard extends Model
{
    protected $_data = null;

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table("v_traking_order tbl");

        $builder->select("tbl.trans_id, tbl.trans_kode, tbl.tgl_transaksi, tbl.id_konsumen, tbl.nama, tbl.keterangan, tbl.tgl_deadline, tbl.qty, tbl.tipe, 
                          tbl.kode_prod, tbl.id_prod, tbl.qty_prod, 
                          tbl.kode_dev, tbl.id_dev, tbl.qty_kirim");

        if ($id == null or $id == "") {
            
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
                $builder->orderBy("tbl.tgl_transaksi desc");
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
        $builder = $this->db->table("v_traking_order tbl");

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