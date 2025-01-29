<?php

namespace Modules\Keuangan\Models;

use App\Models\PrModel;

class Mtrans_akun_det extends PrModel
{
	protected $table                = 'trans_akun_det';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $protectFields        = false;

	protected $useTimestamps        = true;

	public $_data = '';

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $trans_id = null)
    {
        $builder = $this->db->table($this->table.' a');
        $builder->select("a.id as trans_akun_det_id, a.trans_akun_id, a.coa_id, a.jumlah, a.keterangan,
                          b.kode as coa_kode, b.nama as coa_nama");

        $builder->join('m_coa b', "a.coa_id = b.id", "left");
       
        if ($id == null OR $id == "") {

            $builder->where("a.active = 1");

            if (!empty($filters)) {
                if (is_array($filters) && count($filters) >= 1) {
                    $builder->groupStart();
                    $builder->like('upper(a.keterangan)', strtoupper($filters[0]['value']));
                    $builder->orLike('upper(a.jumlah)', strtoupper($filters[0]['value']));
                    $builder->orLike('upper(b.kode)', strtoupper($filters[0]['value']));
                    $builder->orLike('upper(b.nama)', strtoupper($filters[0]['value']));
                    $builder->groupEnd();
                }
            }

            if(!empty($trans_id)){
                $builder->where("a.trans_akun_id", $trans_id);
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('a.id DESC');
            }

            if (empty($offset)) $offset = 0;
            if (empty($limit)) $limit = 10;
            
            $builder->limit($limit, $offset);

            $this->_data = $builder->get()->getResult();
        } else {
            $builder->where("a." . $this->primaryKey, $id);

            $this->_data = $builder->get()->getRow();
        }

        return $this->_data;
    }

    function getDataCnt($filters = null, $trans_id = null)
    {
        $builder = $this->db->table($this->table.' a');
        $builder->select('count(1) as _cnt');

        $builder->join('m_coa b', "a.coa_id = b.id", "left");

        $builder->where("a.active = 1");
        if(!empty($trans_id)){
            $builder->where("a.trans_akun_id", $trans_id);
        }
        if (!empty($filters)) {
            if (is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->like('upper(a.keterangan)', strtoupper($filters[0]['value']));
                    $builder->orLike('upper(a.jumlah)', strtoupper($filters[0]['value']));
                    $builder->orLike('upper(b.kode)', strtoupper($filters[0]['value']));
                    $builder->orLike('upper(b.nama)', strtoupper($filters[0]['value']));
                $builder->groupEnd();
            }
        }

        $this->_data = $builder->get()->getRow()->_cnt;
        return $this->_data;
    }

    function get_mutasi_bulan($akun_id, $bulan = null, $tahun = null){
        $builder = $this->db->table($this->table.' a');

        $builder->select('count(1) as _cnt');

        $this->_data = $builder->get()->getRow()->_cnt;
        return $this->_data;
    }
}
