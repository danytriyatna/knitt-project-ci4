<?php

namespace Modules\SDM\Models;

class Mabsensi extends \App\Models\PrModel
{

    protected $table = "sdm_absensi";
    protected $_data = null;
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " sdm");

        $builder->select("sdm.id,  sdm.id_karyawan,  sdm.posisi,  sdm.tgl_absen,  sdm.jam_masuk,  sdm.status_kehadiran,  sdm.jam_keluar,  sdm.hari_hadir,  
                          sdm.keterangan_kehadiran,  sdm.status_lembur,  sdm.jml_lambur,  sdm.keterangan_lembur,  sdm.active, 
                          rk.id as id_karyawan_tbl, rk.nip, rk.full_name, rk.posisi, rk.upah_lembur, rk.upah_harian, rk.upah_lembur_we");

        $builder->join("ref_karyawan rk", "sdm.id_karyawan = rk.id");

        if ($id == null or $id == "") {
            $builder->where('sdm.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                $builder->where('LOWER(rk.full_name) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(rk.nip) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(rk.posisi) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }
            
            if(!empty($params['tgl_absen'])){
                $builder->where('sdm.tgl_absen', $params['tgl_absen']);
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
        $builder = $this->db->table($this->table . " sdm");

        $builder->select("count(1) as _cnt");

        $builder->join("ref_karyawan rk", "sdm.id_karyawan = rk.id");

        $builder->where('sdm.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
            $builder->where('LOWER(rk.full_name) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(rk.nip) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(rk.posisi) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }
}
