<?php

namespace Modules\Keuangan\Controllers;

// user library spreadsheet for excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsx_r;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FileModel;
use Modules\Keuangan\Models\Mcoa;
use Modules\Keuangan\Models\Mtrans_akun;
use Modules\Keuangan\Models\Mtrans_akun_det;
use Modules\Referensi\Models\RekeningModel;
use Modules\Keuangan\Models\Mlaba_rugi;


class Rpt_laba_rugi extends BaseController
{   
    private $url_v = "Modules\Keuangan\Views";
    private $url_in = "/keuangan/laporan_laba";

    protected $mcoa;
    protected $mtrans_akun;
    protected $mtrans_det;
    protected $mrekening;
    protected $mlaba;

	function __construct()
    {
        $this->MOD_ALIAS = "MOD_LAPORAN_LABA";
        $this->mcoa = new Mcoa();
        $this->mtrans_akun = new Mtrans_akun();
        $this->mtrans_det = new Mtrans_akun_det();
        $this->mrekening = new RekeningModel();
        $this->mlaba = new Mlaba_rugi();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $dt_rek = $this->mlaba->getTahun_invoice();
        // dd($dt_rek);
        // $list_tahun[''] = 'Pilih Tahun';
        foreach ($dt_rek as $r) {
            $list_tahun[$r->tahun] = $r->tahun;
        }
        // dd($list_tahun);
        $this->data['slc_tahun'] = array(
            'name' => 'slc_tahun',
            'id' => 'slc_tahun',
            'options' => $list_tahun,
            'class' => 'form-control'
        );
        
        $tahun = !empty($this->request->getGet("tahun")) ? $this->request->getGet("tahun") : date('Y');
        $bulan = !empty($this->request->getGet("bulan")) ? $this->request->getGet("bulan") : date('m');

        $this->data['tahun'] = $tahun;
        $this->data['bulan'] = $bulan;
        // dd($this->data['oke']);
        $this->data['list_coa'] = $this->mcoa->getData(null, 0, 9999, null, null, null, null, '');
        $this->data['mlaba'] = $this->mlaba;
		$this->data['titlehead'] = "Laporan Laba Rugi";
		return view($this->url_v.'\vakun_rep_laba', $this->data);
	}

    public function lists()
    {
        $start      = $this->request->getPost('start');
        $limit      = $this->request->getPost('length');
        $filters    = $this->request->getPost('filters');
        $order      = $this->request->getPost('order');
        $tahun      = $this->request->getPost('tahun');
        

        if(empty($tahun)){
            $tahun  = '9999';
        }

        $results = $this->mcoa->get_mutasi($tahun);
        $totalfiltered = $this->mcoa->getDataCnt($filters);
        $totaldata = $this->mcoa->getDataCnt();
        $maxpage = ceil($totalfiltered / $limit);
        $build_array = array(
            "last_page" => $maxpage,
            "recordsTotal" => $totaldata,
            "recordsFiltered" => $totalfiltered,
            "data" => array()
        );
        // 
        foreach ($results as $row) {
            $coa_nama =  $row->kode ." - " .$row->nama;
            if($row->level == 1){
                $coa_nama = "<b>". $row->kode ." - " .$row->nama. "</b>";
            }
            array_push($build_array['data'], array(
               'coa_kode' => $row->kode,
               'id' => $row->id,
               'parent_id' => $row->parent_id,
               'coa_nama' => $coa_nama,
               'bln1' => !empty($row->bln1) ? $row->bln1 : 0,
               'bln2' => !empty($row->bln2) ? $row->bln2 : 0,
               'bln3' => !empty($row->bln3) ? $row->bln3 : 0,
               'bln4' => !empty($row->bln4) ? $row->bln4 : 0,
               'bln5' => !empty($row->bln5) ? $row->bln5 : 0,
               'bln6' => !empty($row->bln6) ? $row->bln6 : 0,
               'bln7' => !empty($row->bln7) ? $row->bln7 : 0,
               'bln8' => !empty($row->bln8) ? $row->bln8 : 0,
               'bln9' => !empty($row->bln9) ? $row->bln9 : 0,
               'bln10' => !empty($row->bln10) ? $row->bln10 : 0,
               'bln11' => !empty($row->bln11) ? $row->bln11 : 0,
               'bln12' => !empty($row->bln12) ? $row->bln12 : 0
            ));

        }

        $output = $build_array["data"];
        $out = build_tree($output, 'parent_id', 'id', null);
        $build_array["data"] = $out;
       
        return $this->response->setJSON($build_array);
    }

    public function exp_laba($bulan, $tahun){
        $fileName = "laporan-laba-periode-{$bulan}-{$tahun}.xlsx";

        $results = $this->mcoa->getData(null, 0, 9999);
        // dd($results);
    
        //start phpspreadsheet
        $sheets    = new Spreadsheet;

        $gets = $sheets->getActiveSheet();
        
        $gets->getStyle('A2')->getFont()->setName('Arial Narrow')->setSize('16')->setBold(true);
          

        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A2', 'Laporan Laba Rugi  Periode ' . bulan($bulan) . ' '. $tahun)
            //    ->setCellValue('A4', 'Nomor Akun')
               ->setCellValue('A4', 'Nama Akun')
               ->setCellValue('B4', 'Jumlah');

            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
                        'color' => ['argb' => '1f1f1f'],
                    ],
                ],
            ];

            $stylexArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '1f1f1f'],
                    ],
                ],
            ];

            $styleArray_header = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '1f1f1f'],
                    ],
                ],
            ];

            $style_bodyRight = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '1f1f1f'],
                    ],
                ],
            ];
            $style_bodyTop = [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '1f1f1f'],
                    ],
                ],
            ];
            $style_bodyBottom = [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '1f1f1f'],
                    ],
                ],
            ];
            
        $gets->getStyle('A4:C4')->applyFromArray($styleArray_header);
        // $gets->getStyle('B4:C4')->applyFromArray($styleArray_header);
        // $gets->getStyle('A3:I3')->applyFromArray($styleArray_header);
        
        // set mergecell
        // $sheets->getActiveSheet()->mergeCells('A2:I2');
        $sheets->getActiveSheet()->mergeCells('A2:C2');
        $sheets->getActiveSheet()->mergeCells('B4:C4');
        // $sheets->getActiveSheet()->mergeCells('A4:I4');
        // $sheets->getActiveSheet()->mergeCells('A5:C5');

        // set Center title
        $sheets->getActiveSheet()->getStyle('A2')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        
        // set width
          $gets->getColumnDimension('A')->setWidth(60);
          $gets->getColumnDimension('B')->setWidth(20);
          $gets->getColumnDimension('C')->setWidth(20);

        // end set width
        //   $gets->getStyle('A3:I3')->getFont()->setName('Arial Narrow')->setSize('12')->setBold(true);
          $gets->getStyle('A4:C4')->getFont()->setName('Arial Narrow')->setSize('12')->setBold(true);
          $gets->getStyle('A4:C4')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        
        $gets->setTitle('Detail');
        $indexs = array(
            'A','B','C','D', 'E','F','G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'
        );

        for ($i=0; $i < 3 ; $i++) { 

                $sheets->getActiveSheet()->getStyle($indexs[$i] .'4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('C5D9F1');
                $sheets->getActiveSheet()->getStyle($indexs[$i] .'4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getEndColor()->setARGB('C5D9F1');
            
            // $sheets->getActiveSheet()->mergeCells($indexs[$i].'2');

            $sheets->getActiveSheet()->getStyle($indexs[$i].'4')
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                    
            $gets->getStyle($indexs[$i].'4')->applyFromArray($styleArray_header);
           
        }

        $ix = 5;
        $is = 0;
        
        
        $length = $ix;

        if(!empty($results)){
            $length += count($results);
        }else{
            $length = 0;
        }
        $bckColor = "F2F2F2";
        $ig = $ix;
        $ip = $ix;
        
        $g_id = null; 
        $p_id = null; 

        $pdpt_sw = $this->mlaba->getDataPendapatan(1, $tahun, $bulan);
        $pdpt_ju = 0;//$this->mlaba->getDataPendapatan(2, $tahun, $bulan);
        $pdpt_ttl = $pdpt_sw + $pdpt_ju;

        $pngl_sw = $this->mlaba->getDataPengeluaran(1, 2, $tahun, $bulan);
        $pngl_ju = 0;//$this->mlaba->getDataPengeluaran(1, 1, $tahun, $bulan);
        $pngl_spt = 0;//$this->mlaba->getDataPengeluaran(2, 2, $tahun, $bulan);

        $spas = "    ";
        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A'.$ix, "4000 - Sales")
               ->setCellValue('B'.$ix, "");
        $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A'.$ix, $spas . " 4001 - Pendapatan")
               ->setCellValue('B'.$ix, ($pdpt_sw));
        $ix = $ix + 1;
        // $sheets->setActiveSheetIndex(0)
        //        ->setCellValue('A'.$ix, $spas ."    4011 - Sewa")
        //        ->setCellValue('B'.$ix, ($pdpt_sw));
        // $ix = $ix + 1;
        // $sheets->setActiveSheetIndex(0)
        //        ->setCellValue('A'.$ix, $spas ."    4012 - Penjualan")
        //        ->setCellValue('B'.$ix, ($pdpt_ju));

        // $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
                ->setCellValue('A'.$ix, $spas ."Total Pendapatan")
                ->setCellValue('C'.$ix, $pdpt_ttl);

        $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
                ->setCellValue('A'.$ix, $spas . " 4002 - Pengeluaran")
                ->setCellValue('B'.$ix,  $pngl_sw);
        $ix = $ix + 1;
        // // $sheets->setActiveSheetIndex(0)
        // //         ->setCellValue('A'.$ix, $spas ."    4021 - Sewa")
        // //         ->setCellValue('B'.$ix, $pngl_sw);
        // // $ix = $ix + 1;
        // // $sheets->setActiveSheetIndex(0)
        // //         ->setCellValue('A'.$ix, $spas ."    4022 - Pembelian")
        // //         ->setCellValue('B'.$ix,  $pngl_ju);

        // // $ix = $ix + 1;
        // $sheets->setActiveSheetIndex(0)
        //         ->setCellValue('A'.$ix, $spas ."    4023 - Pembelian Sparepart")
        //         ->setCellValue('B'.$ix, $pngl_spt);
        
        //         $ix = $ix + 1;
        $pngl_ttl = $pngl_sw + $pngl_ju + $pngl_spt;


        for ($rw=5; $rw < $ix ; $rw++) { 
            $sheets->getActiveSheet()->getStyle('B' . $rw . ":C" . $rw )->getNumberFormat()
                   ->setFormatCode('#,##0.00');

            $gets->getStyle('A'.$rw.':C'.$rw)->applyFromArray($stylexArray);
        }

        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A'.$ix, "Total Pengeluaran")
               ->setCellValue('C'.$ix, $pngl_ttl); 
       
        $gets->getStyle('A'.$ix.':C'.$ix)->applyFromArray($stylexArray);

        $gets->getStyle('B' . $ix . ":C" . $ix )->getNumberFormat()
               ->setFormatCode('#,##0.00');
        $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A'.$ix, "Total Sale")
               ->setCellValue('C'.$ix, $pdpt_ttl - $pngl_ttl); 
       
        $gets->getStyle('A'.$ix.':C'.$ix)->applyFromArray($stylexArray);

        $gets->getStyle('B' . $ix . ":C" . $ix )->getNumberFormat()
               ->setFormatCode('#,##0.00');

        $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A'.$ix, "5000 - Fix Cost")
               ->setCellValue('B'.$ix, "");
       
            //    dd(count($results) );
        for ($xx = 0; $xx < count($results) ; $xx++) { 
            $r = $results[$xx];

            $spasi = "    ";
            if( $r->level == 2){
            $spasi = $spasi . $spasi;
            } else if( $r->level == 3){
            $spasi = $spasi . $spasi . $spasi;
            } 

            $coa_ttl = $this->mlaba->getDataTransaksi($r->coa_id, $tahun, $bulan);
            if($coa_ttl > 0){
                $pngl_ttl +=  $coa_ttl;
                $sheets->setActiveSheetIndex(0)
                        ->setCellValue('A'.$ix,  $spasi.$r->kode." - ".$r->nama)
                        ->setCellValue('B'.$ix,  $coa_ttl);
                        // ->setCellValue('O'.$ix, !empty($row->bln1) ? $row->bln1 : 0);

                // if($length > 0 && $ix === $length - 1){
                //     $gets->getStyle('A'.$ix.':N'.$ix)->applyFromArray($style_bodyBottom);
                // }else{
                    $gets->getStyle('A'.$ix.':C'.$ix)->applyFromArray($stylexArray);
                // }

                $sheets->getActiveSheet()->getStyle('B' . $ix . ":C" . $ix )->getNumberFormat()
                        ->setFormatCode('#,##0.00');

                        
                $ix++;
            }
        }

        // $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
                ->setCellValue('A'.$ix, "Total Fix Cost")
                ->setCellValue('C'.$ix, $pngl_ttl);
        $gets->getStyle('A'.$ix.':C'.$ix)->applyFromArray($stylexArray);

        $gets->getStyle('B' . $ix . ":C" . $ix )->getNumberFormat()
                ->setFormatCode('#,##0.00'); 

        $ix = $ix + 1;
        $sheets->setActiveSheetIndex(0)
               ->setCellValue('A'.$ix, "Laba Bersih")
               ->setCellValue('C'.$ix, $pdpt_ttl - $pngl_ttl); 
       
        $gets->getStyle('A'.$ix.':C'.$ix)->applyFromArray($stylexArray);

        $gets->getStyle('B' . $ix . ":C" . $ix )->getNumberFormat()
               ->setFormatCode('#,##0.00');


        
        
        $sheets->setActiveSheetIndex(0);
        $writer = new Xlsx($sheets);
		
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"'); 
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output'); // download file 
        exit;
    }

    public function formatValueMoney($number){
        $val = number_format($number,2,".",",");
        $setVal = 'Rp '.$val;
      
        return $setVal;
      }

    public function get_node_org()
    {
        $out = [];
        // $id = decrypt($id);
        $results = $this->mcoa->getData(null, 0, 999999, null, null);
        
        if (!empty($results)) {
            // build tree
            $output = [];
            foreach ($results as $row) {
                // $compCode_sap = $row->compCode_sap;
                $arr = [];
                $arr['id'] = $row->coa_id;
                $arr['parent_id'] = $row->parent_id;
                $arr['unit_name'] = " {$row->kode} - {$row->nama}";
                $output[] = $arr;
            }
            $out = build_tree($output, 'parent_id', 'id', null);
        }

        return $this->response->setJSON(json_encode($out));
    }

    function _get_message($msg_type, $message = '', $mode = 'success', $icons = 'check', $fadeOut = true)
    {
        $title = '';
        switch ($msg_type) {
            //--== SUCCESS
            case 'SUCCESS_INSERTED':
                $title = 'Tambah Berhasil';
                $message = 'Penambahan data berhasil dilakukan.';
                $icons = 'check';
                break;

            case 'SUCCESS_UPDATED':
                $title = 'Update Berhasil';
                $message = 'Pembaharuan data berhasil dilakukan.';
                $icons = 'check';
                break;

            case 'SUCCESS_DELETED':
                $title = 'Hapus Berhasil';
                $message = 'Penghapusan data berhasil dilakukan.';
                $icons = 'check';
                break;

            case 'SUCCESS_ACTIVATED':
                $title = 'Mengaktifkan Berhasil';
                $message = 'Pengaktifan data berhasil dilakukan.';
                $icons = 'check';
                break;

            case 'SUCCESS_DEACTIVATED':
                $title = 'Menonaktifkan Berhasil';
                $message = 'Penonaktifan data berhasil dilakukan.';
                $icons = 'check';
                break;

            //---== FAILED
            case 'FAILED_INSERTED':
                $title = 'Tambah Gagal';
                $message = 'Penambahan data gagal !';
                $mode = 'danger';
                $icons = '';
                break;

            case 'FAILED_UPDATED':
                $title = 'Update Gagal';
                $message = 'Pembaharuan data gagal !';
                $mode = 'danger';
                $icons = '';
                break;

            case 'FAILED_DELETED':
                $title = 'Hapus Gagal';
                $message = 'Penghapusan data gagal !';
                $mode = 'danger';
                $icons = '';
                break;

            case 'FAILED_ACTIVATED':
                $title = 'Mengaktifkan Gagal';
                $message = 'Pengaktifan data gagal !';
                $mode = 'danger';
                $icons = '';
                break;

            case 'FAILED_DEACTIVATED':
                $title = 'Menonaktifkan Gagal';
                $message = 'Penonaktifan data gagal !';
                $mode = 'danger';
                $icons = '';
                break;

            case 'ERROR_VALIDATION':
                $title = '';
                $mode = 'danger';
                $icons = '';
                $fadeOut = false;
                break;
        }

        $html = message_box($title, $message, $mode, $icons, $fadeOut);
        return $html;
    }


}
