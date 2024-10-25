<?php

namespace Modules\Transaction\Models;

class WalkorderModel extends \App\Models\PrModel
{

    protected $table = "trans_walkorder";
    protected $table2 = "trans_walkorder_detail";
    protected $table3 = "trans_walkorder_proses";
    protected $table4 = "trans_walkorder_proses_ukuran";
    protected $table5 = "trans_walkorder_warna";

    protected $_data = null;
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    // walkorder head 
    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table . " abx");

        $builder->select("abx.id, abx.ref_id, abx.ref_kode, abx.kode_walkorder, abx.id_konsumen, abx.id_style, abx.qty, abx.file_id,
                          abx.ref_kode, abx.status, bbx.nama as konsumen_nama, abx.tgl_deadline, abx.tgl_transaksi, abx.keterangan_style,
                          abx.tipe_id, cbx.file_name
                        ");

        $builder->join("ref_konsumen bbx", "abx.id_konsumen = bbx.id", "inner");
        // $builder->join("trans_sample ts", "ts.id = abx.ref_id and abx.tipe_id = 1", "left");
        // $builder->join("trans_sales_order tso", "tso.id = abx.ref_id and abx.tipe_id = 2", "left");
        $builder->join("_files cbx", "abx.file_id = cbx.id", "left");

        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->where('LOWER(abx.kode_walkorder) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(abx.ref_kode) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if(!empty($params['id_konsumen'])){
                $builder->where('abx.id_konsumen', $params['id_konsumen']);
            }

            if(!empty($params['ref_kode'])){
                $builder->where('abx.ref_kode', $params['ref_kode']);
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
                $builder->where('LOWER(abx.kode_walkorder) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(abx.ref_kode) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }

    function generete_kode(){
        $kd = "WRD";
        $builder = $this->db->table($this->table . ' a');
        $builder->select('LEFT(kode_walkorder, 7) AS tgl, RIGHT( kode_walkorder, 4 ) AS kode ');

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

    // end walkorder head 

    // WALKORDER DETAIL 
    function getData_detail($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table2 . " abx");

        $builder->select("abx.id, abx.id_walkorder, abx.ref_detail_id, bbx.qty, abx.gram, abx.gram_nd, abx.kg, abx.loss,
                          abx.kg_loss, abx.total, abx.tipe_id
                        ");

        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->where('LOWER(abx.qty) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(bbx.gram) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(bbx.gram_nd) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(bbx.kg) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(bbx.loss) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if(!empty($params['id_walkorder'])){
                $builder->where('abx.id_walkorder', $params['id_walkorder']);
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('abx.id ASC');
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

    function getDataCnt_detail($filters = null, $params = null)
    {
        $builder = $this->db->table($this->table2 . " abx");

        $builder->select("count(1) as _cnt");
        $builder->where('abx.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
                $builder->where('LOWER(abx.qty) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(bbx.gram) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(bbx.gram_nd) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(bbx.kg) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(bbx.loss) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }
    // END WALKORDER DETAIL 

    // PROSES
    function getData_proses($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table3 . " abx");

        $builder->select(" abx.id, abx.id_walkorder, abx.id_proses, bbx.keterangan,
                           pp.seq, pp.nama as proses
                        ");

        $builder->join("_jenis_proses_produksi pp", "pp.id = abx.id_proses", "inner");
        
        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->where('LOWER(pp.proses) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if(!empty($params['id_walkorder'])){
                $builder->where('abx.id_walkorder', $params['id_walkorder']);
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('abx.id ASC');
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

    function getDataCnt_proses($filters = null, $params = null)
    {
        $builder = $this->db->table($this->table3 . " abx");

        $builder->select("count(1) as _cnt");
        $builder->join("_jenis_proses_produksi pp", "pp.id = abx.id_proses", "inner");

        $builder->where('abx.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
                $builder->where('LOWER(pp.proses) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }
    // END PROSES

    // PROSES UKURAN 
    function getData_proses_ukuran($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table4 . " abx");

        $builder->select(" abx.id, abx.id_walkorder_proses, abx.id_ukuran, bbx.qty,
                           rk.kode_ukuran, rk.keterangan
                        ");

        $builder->join("ref_ukuran rk", "rk.id = abx.id_ukuran", "inner");
        
        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->where('LOWER(rk.kode_ukuran) LIKE', strtolower("%{$filters[0]['value']}%"));
                    $builder->orWhere('LOWER(rk.keterangan) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if(!empty($params['id_walkorder'])){
                $builder->where('abx.id_walkorder', $params['id_walkorder']);
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('abx.id ASC');
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

    function getDataCnt_proses_ukuran($filters = null, $params = null)
    {
        $builder = $this->db->table($this->table4 . " abx");

        $builder->select("count(1) as _cnt");
        $builder->join("ref_ukuran rk", "rk.id = abx.id_ukuran", "inner");

        $builder->where('abx.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
                $builder->where('LOWER(rk.kode_ukuran) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(rk.keterangan) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }
    // END PROSES UKURAN 

    // WARNA    
    function getData_warna($id = null, $offset = null, $limit = null, $order = null, $filters = null, $params = null)
    {
        $builder = $this->db->table($this->table5 . " abx");

        $builder->select(" abx.id, abx.id_walkorder_detail, abx.id_warna, bbx.persen,
                           abx.gram, abx.gram_nd, abx.kg, abx.loss, abx.kg_loss, abx.total
                           abx.kuota, abx.kuota_tambah, rw.kode_warna, rw.keterangan as warna_keterangan
                        ");

        $builder->join("ref_warna rw", "rw.id = abx.id_warna", "inner");
        
        if ($id == null or $id == "") {
            $builder->where('abx.active = 1');
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->where('LOWER(rw.kode_warna) LIKE', strtolower("%{$filters[0]['value']}%"));
                    // $builder->orWhere('LOWER(rk.keterangan) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if(!empty($params['id_walkorder'])){
                $builder->where('abx.id_walkorder', $params['id_walkorder']);
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('abx.id ASC');
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

    function getDataCnt_warna($filters = null, $params = null)
    {
        $builder = $this->db->table($this->table5 . " abx");

        $builder->select("count(1) as _cnt");
        $builder->join("ref_warna rw", "rw.id = abx.id_warna", "inner");

        $builder->where('abx.active = 1');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
                $builder->where('LOWER(rw.kode_warna) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }
    // END WARNA    
}