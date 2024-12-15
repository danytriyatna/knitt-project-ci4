<?php

namespace Modules\Laporan\Models;

class LaporanStockCardModel extends \App\Models\PrModel
{

    protected $table = "trans_barang";
    protected $kd = "1";
    protected $tblGudang = "ref_gudang";
    protected $tblBarang = "ref_barang";
    protected $tblKategori = "ref_kategori_persediaan";
    protected $tblSatuan = "ref_satuan";

    protected $_data = null;
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    function getLaporanStockCard($idBarang = null, $tglMulai = null, $tglAkhir = null)
    {
        $subQuery = $this->db->table('trans_barang t2')
            ->select("
        SUM(CASE WHEN t2.jenis_transaksi = '1' THEN t2.jumlah ELSE 0 END) -
        SUM(CASE WHEN t2.jenis_transaksi = '2' THEN t2.jumlah ELSE 0 END)
    ", false)
            ->where('t2.id_barang = t.id_barang')
            ->where('t2.id_gudang_tujuan = t.id_gudang_tujuan')
            ->where('t2.tanggal <= t.tanggal');

        // Main query
        $builder = $this->db->table('trans_barang t');
        $builder->select("
    t.tanggal,
    kt.kategori,
    t.keterangan,
    t.stok as saldo,
    lt.nama_barang,
    CASE 
        WHEN t.jenis_transaksi = '1' THEN ht.nama_gudang
        WHEN t.jenis_transaksi = '2' THEN gt.nama_gudang
        ELSE NULL 
    END AS nama_gudang,
    CASE 
        WHEN t.jenis_transaksi = '1' THEN t.jumlah 
        ELSE 0 
    END AS masuk,
    CASE 
        WHEN t.jenis_transaksi = '2' THEN t.jumlah 
        ELSE 0 
    END AS keluar,
    ({$subQuery->getCompiledSelect()}) AS saldo_
", false)
            ->join('ref_kategori_persediaan kt', 't.id_kategori = kt.id', 'inner')
            ->join('ref_gudang gt', 't.id_gudang_asal = gt.id', 'left')
            ->join('ref_gudang ht', 't.id_gudang_tujuan = ht.id', 'left')
            ->join('ref_barang lt', 't.id_barang = lt.id', 'left');
        $builder->where('t.active', 1);
        $builder->orderBy('t.tanggal', 'DESC');
        if (!empty($idBarang)) {
            $builder->where('t.id_barang', $idBarang);
        }
        if (!empty($tglMulai)) {
            $builder->where('t.tanggal>=', $tglMulai);
        }
        if (!empty($tglAkhir)) {
            $builder->where('t.tanggal<=', $tglAkhir);
        }

        $query = $builder->get();
        $this->_data  = $query->getResult();
        return $this->_data;
    }
}
