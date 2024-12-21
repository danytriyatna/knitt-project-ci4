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

    function getLaporanStockCard($idBarang = null, $idGudang = null, $year = null, $month = null)
    {
        $params = [];
        $sql = "
    WITH normalized_trans AS (
        SELECT
            abx.tanggal,
            abx.created_at,
            abx.kode_transaksi,
            abx.id_barang,
            abx.id_gudang_asal AS id_gudang,
            'keluar' AS jenis_transaksi,
            abx.jumlah * -1 AS jumlah,
            abx.id,
            bbx.name
        FROM
            trans_barang abx
            LEFT JOIN ref_trans bbx ON LEFT(abx.kode_transaksi, 3) = bbx.alias
        WHERE
            abx.id_gudang_asal IS NOT NULL ";
        if (!empty($month)) {
            $sql .= " AND EXTRACT(MONTH FROM abx.tanggal) = :bulan:";
            $params['bulan'] = $month;
        }
        if (!empty($year)) {
            $sql .= " AND EXTRACT(YEAR FROM  abx.tanggal) = :tahun:";
            $params['tahun'] = $year;
        }
        if (!empty($idGudang)) {
            $sql .= " AND abx.id_gudang_asal = :id_gudang:";
            $params['id_gudang'] = $idGudang;
        }
        $sql .= " UNION ALL
        SELECT
            abx.tanggal,
            abx.created_at,
            abx.kode_transaksi,
            abx.id_barang,
            abx.id_gudang_tujuan AS id_gudang,
            'masuk' AS jenis_transaksi,
            abx.jumlah AS jumlah,
            abx.id,
            bbx.name
        FROM
            trans_barang abx 
            LEFT JOIN ref_trans bbx ON LEFT(abx.kode_transaksi, 3) = bbx.alias
        WHERE
            abx.id_gudang_tujuan IS NOT NULL ";
        if (!empty($month)) {
            $sql .= " AND EXTRACT(MONTH FROM abx.tanggal) = :bulan:";
            $params['bulan'] = $month;
        }
        if (!empty($year)) {
            $sql .= " AND EXTRACT(YEAR FROM  abx.tanggal) = :tahun:";
            $params['tahun'] = $year;
        }
        if (!empty($idGudang)) {
            $sql .= " AND abx.id_gudang_tujuan = :id_gudang:";
            $params['id_gudang'] = $idGudang;
        }
        $sql .= " ),
    saldo_awal AS (
        SELECT
            nt.id_barang,
            nt.id_gudang,
            SUM(nt.jumlah) AS saldo_awal
        FROM
            normalized_trans nt ";
        if (!empty($idGudang)) {
            $sql .= "WHERE nt.id_gudang = :id_gudang: ";
            $params['id_gudang'] = $idGudang;
        }

        if (!empty($idBarang)) {
            $sql .= "AND nt.id_barang = :id_barang: ";
            $params['id_barang'] = $idBarang;
        }

        $sql .= " GROUP BY
            nt.id_barang,nt.id_gudang
    ),
    stock_card AS (
        SELECT
            nt.tanggal,
            nt.created_at,
            nt.name as transaksi,
            nt.kode_transaksi,
            nt.id_barang,
            nt.id_gudang,
            CASE
                WHEN nt.jenis_transaksi = 'masuk' THEN nt.jumlah 
                ELSE 0 
            END AS masuk,
            CASE
                WHEN nt.jenis_transaksi = 'keluar' THEN -nt.jumlah 
                ELSE 0 
            END AS keluar,
            COALESCE(sa.saldo_awal, 0) + SUM(nt.jumlah) OVER (
                PARTITION BY nt.id_barang,  nt.id_gudang
                ORDER BY nt.id ASC, nt.kode_transaksi
            ) AS saldo_akhir
        FROM
            normalized_trans nt
            LEFT JOIN saldo_awal sa 
                ON nt.id_barang = sa.id_barang 
                AND nt.id_gudang = sa.id_gudang
    )
    SELECT *
    FROM stock_card ";


        $sql .=  " ORDER BY
        created_at ASC,
        id_barang,
        id_gudang,
        tanggal,
        kode_transaksi";
        $query = $this->db->query($sql, $params);

        $this->_data  = $query->getResult();
        return $this->_data;
    }

    function getLaporanStockCardOld($idBarang = null, $tglMulai = null, $tglAkhir = null)
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
    ({$subQuery->getCompiledSelect()}) AS saldo
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

    function getTahun()
    {
        $builder = $this->db->table("ref_tahun");
        $builder->select("*");
        $this->_data = $builder->get()->getResult();
        return $this->_data;
    }
    function getBulan()
    {
        $builder = $this->db->table("ref_bulan");
        $builder->select("*");
        $this->_data = $builder->get()->getResult();
        return $this->_data;
    }
}
