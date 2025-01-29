<?php

namespace Modules\Keuangan\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FileModel;
use Modules\Keuangan\Models\Mcoa;


class Ref_coa extends BaseController
{   
    private $url_v = "Modules\Keuangan\Views";
    private $url_in = "/keuangan/daftar_akun";

    protected $mcoa;

	function __construct()
    {
        $this->MOD_ALIAS = "MOD_REF_COA";
        $this->mcoa = new Mcoa();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

		$this->data['titlehead'] = "Daftar Beban";
		return view($this->url_v.'\vref_coa_list', $this->data);
	}

    public function lists()
    {
        $start      = $this->request->getPost('start');
        $limit      = $this->request->getPost('length');
        $filters    = $this->request->getPost('filter');
        $order      = $this->request->getPost('order');
        
        $results = $this->mcoa->getData(null, $start, $limit, $order, $filters);
        $totalfiltered = $this->mcoa->getDataCnt($filters);
        $totaldata = $this->mcoa->getDataCnt();
        $maxpage = ceil($totalfiltered / $limit);
        $build_array = array(
            "last_page" => $maxpage,
            "recordsTotal" => $totaldata,
            "recordsFiltered" => $totalfiltered,
            "data" => array()
        );

        foreach ($results as $row) {
            $id = encrypt($row->coa_id);

            $atr_edit = null; $atr_del = null; $atr_bar = null;

            $is_edit = true; $is_del = true; $is_view = false;
            
            if ($this->_edit) {
                $atr_edit['title'] = 'Edit';
                $atr_edit['url'] = $this->url_in.'/edit/';
                $atr_edit['class'] = '';
            }

            if ($this->_delete) {
                $atr_del['title'] = 'Hapus';
                $atr_del['url'] = $this->url_in.'/delete/';
                $atr_del['class'] = '';
                $atr_del['onclick'] = "return confirm('Hapus data ?')";
            }

           

            if(empty($row->parent_id)){
                $atr_del = null;
            }

            $btnAction = btn_action_group($id, $atr_edit, $atr_del);

            array_push($build_array['data'], array(
               'aksi' => $btnAction,
               'kode' => $row->kode,
               'level' => $row->level,
               'parent_kode' => $row->parent_kode,
               'parent_coa' => $row->parent_coa,
               'parent_id' => $row->parent_id,
               'nama' =>  $row->nama,
               'coa_id' =>  $row->coa_id
            ));

        }

        $output = $build_array["data"];
        // print_r($output);exit;
        // $build_array['data'] = \build_tree($build_array['data']);
        if ($totalfiltered <> $totaldata) {
            $build_array["data"] = $output;
        } else {
            $build_array["data"] = build_tree($output, "parent_id", "coa_id", null);
        }
       
        return $this->response->setJSON($build_array);
    }

    public function form($id = null)
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $this->data['id'] = $id;

        $this->data['titlehead'] = "Input Daftar Beban";
        if ($id != ""){
            $id = decrypt($id);
            $this->data['titlehead'] = "Edit Daftar Beban";
        }

		

        $stdData = new \stdClass();
        $stdData->kode = '';
        $stdData->parent_id = '';
        $stdData->level = '';
        $stdData->nama = '';
        $stdData->position = '';
        
        if($id) {
            $stdData = $this->mcoa->getData($id);  
        }

        if($_POST)
		{
            $stdData->kode = trim($this->request->getPost('kode'));
            $stdData->parent_id = trim($this->request->getPost('parent_id'));
            $stdData->nama = trim($this->request->getPost('nama'));
            $stdData->position = trim($this->request->getPost('position'));

            $arr_rules = [
                'kode' => ['label' => 'Nomor Akun Beban', 'rules' => 'required', 'errors' =>  $this->validation_msg_error()],
                'nama' => ['label' => 'Nama Akun Beban', 'rules' => 'required', 'errors' =>  $this->validation_msg_error()],
                // 'no_hp' => ['label' => 'No. Telp.', 'rules' => 'required', 'errors' =>  $this->validation_msg_error()]
            ];

            if(!empty($id) && $stdData->level == 1){
                $stdData->parent_id = null;
            }else{
                $arr_rules['parent_id'] = ['label' => 'Parent Akun Beban', 'rules' => 'required', 'errors' =>  $this->validation_msg_error()];
            }

            $this->validation->setRules($arr_rules);
            
            if ($this->validation->withRequest($this->request)->run() === TRUE)
            {
                $level = 1;
                if(!empty($stdData->parent_id)){
                    $ck_lvl = $this->mcoa->cek_level($stdData->parent_id);
                    $level = $ck_lvl->level + 1;
                }
                // else{
                //     $ck_lvl = $this->mcoa->cek_level();
                //     $level = $ck_lvl->level + 1;
                // }

                $dataIn['kode'] = $stdData->kode;
                $dataIn['parent_id'] = !empty($stdData->parent_id) ? $stdData->parent_id : null;
                $dataIn['nama'] = $stdData->nama;
                $dataIn['position'] = 'd';//$stdData->position;
                $dataIn['level'] = $level;
                
                $mtd = "Simpan";
                if(!empty($id)){

                    $dataIn['updated_by'] =  $this->get_userid();
                    $dataIn['updated_date'] = date('Y-m-d H:i:s');
                    $mtd = "Update";
                    
                    $inUp = $this->mcoa->updateRecord($this->mcoa->table, $dataIn, 'id', $id);
                }else{
                    $dataIn['created_by'] = $this->get_userid();
                    $dataIn['created_date'] = date('Y-m-d H:i:s');
                    $dataIn['active'] = 1;
                    $inUp = $this->mcoa->insertRecordGetid($this->mcoa->table, $dataIn);
                }

                if($inUp){
                    // return redirect()->to('/asesmen/sni_form/'.$idx);
                    $this->session->setFlashdata('message', "{$mtd} data berhasil.." );
                    return redirect()->to('/keuangan/daftar_akun');
                }else{
                    $this->_get_message("ERROR_VALIDATION", "Ulangi simpan data !");
                }
            }else{
                $this->data['errmsg'] = $this->_get_message("ERROR_VALIDATION", $this->validation->listErrors());
            }
        }

        // $dt_company = $this->mcompany->getData(null, 0, 999);
        // $list_company[''] = 'Pilih Company';
        // foreach ($dt_company as $r) {
        //     $list_company[$r->comp_id] = $r->comp_nama;
        // }
        $this->data['parent_id'] = array(
            'name' => 'parent_id',
            'id' => 'parent_id',
            'value' => set_value('parent_id', $stdData->parent_id),
            // 'options' => $list_company,
            'class' => 'form-control'
        );

        $pos_list[''] = "";
        $pos_list['d'] = "Debit";
        $pos_list['c'] = "Kredit";

        $this->data['position'] = array(
            'name' => 'position',
            'id' => 'position',
            'value' => set_value('position', $stdData->position),
            'options' => $pos_list,
            'class' => 'form-control'
        );

        $this->data['nama'] = array(
            'id' => 'nama',
            'name'  => 'nama',
            'type' => 'text',
            'class' => 'form-control',
            'placeholder' => 'Nama Akun Beban',
            'value' =>  $stdData->nama //set_value('coa_nama', $stdData->coa_nama)
        );

        $this->data['kode'] = array(
            'id' => 'kode',
            'name'  => 'kode',
            'type' => 'text',
            'class' => 'form-control',
            'placeholder' => 'Nomor Akun Beban',
            'value' => set_value('kode', $stdData->kode)
        );

		return view($this->url_v.'\vref_coa_form', $this->data);
	}

    public function delete($id = NULL)
    {
        $this->deactived($id);
        // if ($id != null && $id != "") {
        //     $id = decrypt($id);
        // }

        // $id = (int) $id;
                
        // $res = $this->porudk->deleteRecord($this->porudk->table, 'porudkt_id', $id);
        // if ($res) {
        //     $this->session->setFlashdata('message', "Data berhasil dihapus !");
        // } else {
        //     $this->session->setFlashdata('err', "Data gagal dihapus !");
        // }
        return redirect()->to('/keuangan/daftar_akun');
    }

    public function deactived($id){
        if ($id != null && $id != "") {
            $id = decrypt($id);
        }

        $id = (int) $id;
        $dataIn['active'] = 0;
        $dataIn['updated_by'] =  $this->auth->getUserId();
        $dataIn['updated_date'] = date('Y-m-d H:i:s');
        $res = $this->mcoa->updateRecord($this->mcoa->table, $dataIn, 'id',$id);
        if ($res) {
            $this->session->setFlashdata('message', "Data berhasil dihapus !");
        } else {
            $this->session->setFlashdata('err', "Data gagal dihapus !");
        }
        return redirect()->to('/keuangan/daftar_akun');
    }

    public function get_node_org($id)
    {
        $out = [];
        $idx = null;
        if(!empty($id)){
            $idx = decrypt($id);
        }
        $results = $this->mcoa->getData(null, 0, 999999, null, null, $idx, 2);
        
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
            // $out = build_tree($output, 'parent_id', 'id', null);
            $out = $output;
        }

       
       

        // $this->output
        //     ->set_content_type('application/json')
        //     ->set_output(json_encode($out));
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
