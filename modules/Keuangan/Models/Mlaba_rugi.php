<?php

namespace Modules\Keuangan\Models;

use App\Models\PrModel;

class Mlaba_rugi extends PrModel
{
	protected $table                = 'mm_coa';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $protectFields        = false;

	protected $useTimestamps        = true;

	public $_data = '';

    function getDataPendapatan2($tipe, $tahun, $bulan)
    {
        $builder = $this->db->table('trans_customer_receipt_det ae');
        $builder->select("sum(ae.pay_item - ae.pph) as pendapatan");

        $builder->join('trans_invoice ar', 'ae.id_invoice = ar.id', 'inner');
        $builder->join('trans_customer_receipt aq', 'aq.id = ae.id_cr', 'inner');

        $builder->where("aq.active = 1");
        $builder->where("EXTRACT ( YEAR FROM aq.tgl_transaksi )", $tahun);
        $builder->where("EXTRACT ( MONTH FROM aq.tgl_transaksi )", $bulan);
    
        $this->_data = $builder->get()->getRow();

        if(!empty($this->_data)){
            $this->_data = $this->_data->pendapatan;
        }else{
            $this->_data = 0;
        }

        return $this->_data;
    }


    function getDataPendapatan($tipe, $tahun, $bulan)
    {
        $builder = $this->db->table('trans_invoice ae');
        $builder->select("sum(ae.grand_total) as pendapatan");

        $builder->where("ae.active = 1");
        $builder->where("EXTRACT ( YEAR FROM ae.tgl_transaksi )", $tahun);
        $builder->where("EXTRACT ( MONTH FROM ae.tgl_transaksi )", $bulan);
    
        $this->_data = $builder->get()->getRow();

        if(!empty($this->_data)){
            $this->_data = $this->_data->pendapatan;
        }else{
            $this->_data = 0;
        }

        return $this->_data;
    }

    function getDataPengeluaran($jenis_barang, $tipe, $tahun, $bulan){
        $builder = $this->db->table('trans_po_header ad');
        $builder->select("SUM(ad.total) as pengeluaran");

        $builder->where("ad.active = 1");
        // $builder->where("ad.jenis_barang_id", $jenis_barang);
        // $builder->where("ad.tipe_beli_id", $tipe);
        $builder->where("EXTRACT ( YEAR FROM ad.po_date )", $tahun);
        $builder->where("EXTRACT ( MONTH FROM ad.po_date )", $bulan);

        $this->_data = $builder->get()->getRow();
        if(!empty($this->_data)){
            $this->_data = $this->_data->pengeluaran;
        }else{
            $this->_data = 0;
        }
        return $this->_data;
    }

    public function getDataTransaksi($coa_id, $tahun, $bulan, $parent = null){
        $builder = $this->db->table('trans_akun_det ai');

        $builder->select("au.nama, au.kode, au2.nama as par_nama, au2.kode as par_kode, SUM(ai.jumlah) as pengeluaran");
        $builder->join('m_coa au', 'ai.coa_id = au.id', 'inner');
        $builder->join('m_coa au2', 'au.parent_id = au2.id', 'inner');
        $builder->join('trans_akun ay', 'ai.trans_akun_id = ay.id', 'inner');

        $builder->where("ai.active = 1");
        $builder->where("ay.active = 1");
        if(!empty($parent)){
            $builder->where("au.parent_id", $parent);
        }else{
            $builder->where("au.id", $coa_id);
        }
        $builder->where("EXTRACT ( YEAR FROM ay.trans_akun_date )", $tahun);
        $builder->where("EXTRACT ( MONTH FROM ay.trans_akun_date )", $bulan);

        $builder->groupBy("au.kode, au.nama, au2.nama, au2.kode");
        $builder->orderBy("au.kode");

        $this->_data = $builder->get()->getRow();
        if(!empty($this->_data)){
            $this->_data = $this->_data->pengeluaran;
        }else{
            $this->_data = 0;
        }
        return $this->_data;

    }

    public function getTahun_invoice(){
        $builder = $this->db->table("trans_invoice aw");
        $builder->select("EXTRACT ( YEAR FROM aw.tgl_transaksi ) as tahun");
        $builder->where("aw.active = 1");
        $builder->groupBy("EXTRACT ( YEAR FROM aw.tgl_transaksi )");
        $builder->orderBy("EXTRACT ( YEAR FROM aw.tgl_transaksi ) DESC");

        $this->_data = $builder->get()->getResult();
        return $this->_data;
    }


}
