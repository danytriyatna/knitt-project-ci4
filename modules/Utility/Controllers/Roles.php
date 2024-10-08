<?php

namespace Modules\Utility\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Utility\Models\RoleModel;

class Roles extends BaseController
{
    protected $roles;

    function __construct()
    {
        $this->MOD_ALIAS = "MOD_ROLEMANAGE";

        $this->roles = new RoleModel();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
        
        $this->data['titlehead'] = "Group / Role";

        return view('\Modules\Utility\Views\roles', $this->data);
    }

    public function lists()
    {
        $start      = $this->request->getPost('start');
        $limit      = $this->request->getPost('length');
        $filters    = $this->request->getPost('filter');
        $order      = $this->request->getPost('sort');

        $results = $this->roles->getData(null, $start, $limit, $order, $filters);
        $totalfiltered = $this->roles->getDataCnt($filters);
        $totaldata = $this->roles->getDataCnt();
        $maxpage = ceil($totalfiltered / $limit);

        $build_array = array(
            "last_page" => $maxpage,
            "recordsTotal" => $totaldata,
            "recordsFiltered" => $totalfiltered,
            "data" => array()
        );

        foreach ($results as $row) {
            
            $id = encrypt($row->id);

            $atr_edit = null; $atr_del = null; $btnAction = null;
            if ($this->_edit) {
                $atr_edit['title'] = 'Edit';
                $atr_edit['url'] = 'utilitas/roles/edit/';
                $atr_edit['class'] = '';
            }
            if ($this->_delete) {
                $atr_del['title'] = 'Hapus';
                $atr_del['url'] = 'utilitas/roles/delete/';
                $atr_del['class'] = '';
                $atr_del['del_msg'] = 'Anda yakin ingin menghapus role ini?';
            }
            
            if($atr_edit || $atr_del)
                $btnAction = btn_action_group($id, $atr_edit, $atr_del);

            $aktif =  ($row->active) ? "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/roles/deactivate/".$id."' data-confirm-message='Anda yakin ingin menonaktifkan role ini?'><i class='fa fa-check text-success'>&nbsp;</i></a>" :
                "<a href='javascript:void(0)' class='atr_active' data-item-active='utilitas/roles/activate/".$id."' data-confirm-message='Anda yakin ingin mengaktifkan role ini?'><i class='fa fa-times text-danger'>&nbsp;</i></a>";
            
            array_push($build_array["data"],
                array(
                    "aksi" => $btnAction ? $btnAction : '',
                    "name" => $row->name,
                    "description" => $row->description,
                    "active" => $aktif,
                )
            );
        }
        
        return $this->response->setJSON($build_array);
    }

    public function form()
    {
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        } elseif(!$this->auth->isSuperAdmin() && !$this->auth->isAdmin()){
			throw new \Exception('You must be an administrator to view this page.');
        }

        $id = 0;
        $this->data['id'] = current_url(true)->getSegment(4);
        if (trim($this->data['id']) != ""){
            $id = decrypt($this->data['id']);
            $this->data['titlehead'] = "Edit Role";
        }else{
            $this->data['titlehead'] = "Input Role";
        }

        //validate form input
        $this->validation->setRules([
            'name'              => ['label' => 'Nama Role', 'rules' => 'required|trim|max_length[100]'],
            'description'       => ['label' => 'Alias', 'rules' => 'required|trim|max_length[100]'],
        ]);

        if( $id > 0 AND !$this->request->getPost('id')) {
            // retrieve data for edit
            $role = $this->roles->getRoles($id);      
            $this->data['role'] = $role;     
        }else{
            $role = new \stdClass();            
            $role->name = '';
            $role->description = '';
        }

        if (isset($_POST) && !empty($_POST))
        {           
            $name       = $this->request->getPost('name');
            $description= $this->request->getPost('description');
            $data = array (
                  'name'        => $name,
                  'description' => $description,         
            );
                                   
            //check to see if we are updating
            if( $id > 0 AND $this->request->getPost('id')) { // update
                if ($this->validation->withRequest($this->request)->run() === TRUE AND $this->roles->updateRecord($this->roles->table,$data, 'id',$id))
                {
                    $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,$id,"Update Role");        
                    $this->session->setFlashdata('message', "Update role berhasil.." );
		            return redirect()->to('/utilitas/roles');
                }else{
                    //set the flash data error message if there is one
                    $this->data['errmsg'] = $this->validation->listErrors();
                    $this->data['message'] = $this->session->getFlashdata('message');
                    $this->session->setFlashdata('err', $this->data['errmsg']); 
                    
                    $role = new \stdClass();
                    $role->name = $this->request->getPost('name');
                    $role->description = $this->request->getPost('description');
                    $this->data['role'] = $role;
                }
                
            } else { // insert
                $data['active'] = 1;

                if ($this->validation->withRequest($this->request)->run() === TRUE  )
                {
                    $id = $this->roles->insertRecordGetid($this->roles->table,$data);
                    $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,$id,"Tambah Role");        
                    $this->session->setFlashdata('message', "Tambah role berhasil..");
                    return redirect()->to("/utilitas/roles");
                }else{
                    //set the flash data error message if there is one
                    $this->data['errmsg'] = $this->validation->listErrors();
                    $this->data['message'] = $this->session->getFlashdata('message');
                    $this->session->setFlashdata('err', $this->data['errmsg']);       

                    $role = new \stdClass();
                    $role->name = $this->request->getPost('name');
                    $role->description = $this->request->getPost('description');
                    $this->data['role'] = $role;                        
                } 
            }
            
        }//endif POST

        //display the create modul form                                              
        $this->data['role_name'] = array(
                'name'  => 'name',
                'id'    => 'name',
                'type'  => 'text',
                'value' => set_value('name', $role->name),
                'class' => 'form-control',
                'placeholder' => 'Ketikkan nama role',
                'required' => 'true'
        );
        
        $this->data['role_alias'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'value' => set_value('description', $role->description),
                'class' => 'form-control',
                'placeholder' => 'Ketikkan nama alias role',
                'required' => 'true'
        );
        $this->data['role_alias_edit'] =  $role->description;
        
        $this->data['csrf'] = $this->_get_sess_csrf();

        return view('\Modules\Utility\Views\roles_form', $this->data);
    }

    public function activate($id)
    {
        if (!$this->auth->loggedIn() OR (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
			throw new \Exception('You must be an administrator to view this page.');
        }

        if ($id != null && $id != "") {
            $id = decrypt($id);
        }

        $id = (int)$id;

        $data['active'] = 1;
        $activation = $this->roles->updateRecord('sec_role', $data, 'id', $id);

        if ($activation) {
            $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,$id,"Role Diaktifkan");        
            $this->session->setFlashdata('message', "Role berhasil di aktifkan...");
        } else {
            $this->session->setFlashdata('err', "Role gagal di aktifkan !");
        }
		return redirect()->to('/utilitas/roles');

    }

    public function deactivate($id = NULL)
    {
        if (!$this->auth->loggedIn() OR (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
			throw new \Exception('You must be an administrator to view this page.');
        }
        
        if ($id != null && $id != "") {
            $id = decrypt($id);
        }

        $id = (int)$id;
        if ($id == 1) {
		    return redirect()->to('/utilitas/roles');
        }
        
        $data['active'] = 0;

        $deactivate = $this->roles->updateRecord('sec_role', $data, 'id', $id);

        if ($deactivate) {
            $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,$id,"Role Dinonaktifkan");        
            $this->session->setFlashdata('message', "Role berhasil di non-aktifkan...");
        } else {
            $this->session->setFlashdata('err', "Role gagal di non-aktifkan !");
        }
		return redirect()->to('/utilitas/roles');
    }

    public function delete($id = NULL)
    {
        if (!$this->auth->loggedIn() OR (!$this->auth->isAdmin() && !$this->auth->isSuperadmin())) {
			throw new \Exception('You must be an administrator to view this page.');
        }

        if ($id != null && $id != "") {
            $id = decrypt($id);
        }
        $id = (int)$id;
        
        if ($id == 1) {
		    return redirect()->to('/utilitas/roles');
        }       
             
        $res = $this->roles->deleteRecord('sec_role', 'id', $id);
        if ($res) {
            $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,$id,"Role Dihapus");        
            $this->session->setFlashdata('message', "Role berhasil dihapus...");
        } else {
            $this->session->setFlashdata('err', "Role gagal dihapus !");
        }
        return redirect()->to('/utilitas/roles');
    }
}
