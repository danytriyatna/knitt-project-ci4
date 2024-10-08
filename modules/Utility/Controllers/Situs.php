<?php

namespace Modules\Utility\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Utility\Models\SitusModel;
use App\Models\FileModel;

class Situs extends BaseController
{
    protected $situs;

    function __construct()
    {
        $this->MOD_ALIAS = "MOD_SITUSMANAGE";
        
        $this->situs = new SitusModel();
        $this->files = new FileModel();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
        
        $this->data['titlehead'] = "Setting Situs";

        $this->form();

        return view('\Modules\Utility\Views\setting_situs', $this->data);
    }

    public function form()
    {
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        } elseif(!$this->auth->isSuperAdmin() && !$this->auth->isAdmin()){
			throw new \Exception('You must be an administrator to view this page.');
        }

        $res = $this->situs->getData();    
        
        if($res){
            $showLogo = $this->files->getFiles($res->file_id_logo);
            $showLogoText = $this->files->getFiles($res->file_id_logo_text);
            $showBackgroundImg = $this->files->getFiles($res->file_id_background_img);

            $id                         = $res->id;
            $input_name_app             = $res->name_app;
            $description                = $res->description;
            $title                      = $res->title;
            $footer                     = $res->footer;
            $view_logo                  = ($showLogo)? $showLogo->file_name : "";
            $view_logo_text             = ($showLogoText)? $showLogoText->file_name : "";
            $view_background_img        = ($showBackgroundImg)? $showBackgroundImg->file_name : "";
            $file_id_logo_old           = $res->file_id_logo;
            $file_id_logo_text_old      = $res->file_id_logo_text;
            $file_id_background_img_old = $res->file_id_background_img;
            $primary_color              = $res->primary_color;
            $accent_color               = $res->accent_color;
            $bg_thead_color             = $res->bg_thead_color;
            $text_thead_color           = $res->text_thead_color;
            $primary_dark_color         = $res->primary_dark_color;
            $accent_dark_color          = $res->accent_dark_color;
            $bg_thead_dark_color        = $res->bg_thead_dark_color;
            $text_thead_dark_color      = $res->text_thead_dark_color;
        }else{
            $id                     = "";
            $input_name_app         = "";
            $description            = "";
            $title                  = "";
            $footer                 = "";
            $view_logo              = "";
            $view_logo_text         = "";
            $view_background_img    = "";
            $primary_color          = "";
            $accent_color           = "";
            $bg_thead_color         = "";
            $text_thead_color       = "";
            $primary_dark_color     = "";
            $accent_dark_color      = "";
            $bg_thead_dark_color    = "";
            $text_thead_dark_color  = "";
        }

        $this->data['input_name_app'] = array(
                'name'  => 'input_name_app',
                'id'    => 'input_name_app',
                'type'  => 'text',
                'value' => set_value('input_name_app', $input_name_app),
                'class' => 'form-control',
                'placeholder' => 'Ketikkan nama aplikasi',
                'required' => 'true'
        );

        $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'rows'  => '2',
                'value' => set_value('description', $description),
                'class' => 'form-control',
                'placeholder' => 'Ketikkan deskripsi aplikasi',
                'required' => 'true'
        );
        
        $this->data['title'] = array(
                'name'  => 'title',
                'id'    => 'title',
                'type'  => 'text',
                'value' => set_value('title', $title),
                'class' => 'form-control',
                'placeholder' => 'Ketikkan site title',
                'required' => 'true'  
        );

        $this->data['footer'] = array(
                'name'  => 'footer',
                'id'    => 'footer',
                'type'  => 'text',
                'value' => set_value('footer', $footer),
                'class' => 'form-control',
                'placeholder' => 'Ketikkan teks copyright footer',
                'required' => 'true'
        );

        $this->data['file_id_logo'] = array(
                'name'  => 'file_id_logo',
                'id'    => 'file_id_logo',
                'type'  => 'text',
                'class' => 'form-control',
                'accept' => 'image/webp, image/jpeg, image/png'
        );

        $this->data['file_id_logo_text'] = array(
                'name'  => 'file_id_logo_text',
                'id'    => 'file_id_logo_text',
                'type'  => 'text',
                'class' => 'form-control',
                'accept' => 'image/webp, image/jpeg, image/png'
        );

        $this->data['file_id_background_img'] = array(
                'name'  => 'file_id_background_img',
                'id'    => 'file_id_background_img',
                'type'  => 'text',
                'class' => 'form-control',
                'accept' => 'image/webp, image/jpeg, image/png'
        );

        $this->data['theme_primary_color'] = array(
                'name'  => 'theme_primary_color',
                'id'    => 'theme_primary_color',
                'type'  => 'color',
                'value' => set_value('theme_primary_color', $primary_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_bg_thead_color'] = array(
                'name'  => 'theme_bg_thead_color',
                'id'    => 'theme_bg_thead_color',
                'type'  => 'color',
                'value' => set_value('theme_bg_thead_color', $bg_thead_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_accent_color'] = array(
                'name'  => 'theme_accent_color',
                'id'    => 'theme_accent_color',
                'type'  => 'color',
                'value' => set_value('theme_accent_color', $accent_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_text_thead_color'] = array(
                'name'  => 'theme_text_thead_color',
                'id'    => 'theme_text_thead_color',
                'type'  => 'color',
                'value' => set_value('theme_text_thead_color', $text_thead_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_primary_dark_color'] = array(
                'name'  => 'theme_primary_dark_color',
                'id'    => 'theme_primary_dark_color',
                'type'  => 'color',
                'value' => set_value('theme_primary_dark_color', $primary_dark_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_bg_thead_dark_color'] = array(
                'name'  => 'theme_bg_thead_dark_color',
                'id'    => 'theme_bg_thead_dark_color',
                'type'  => 'color',
                'value' => set_value('theme_bg_thead_dark_color', $bg_thead_dark_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_accent_dark_color'] = array(
                'name'  => 'theme_accent_dark_color',
                'id'    => 'theme_accent_dark_color',
                'type'  => 'color',
                'value' => set_value('theme_accent_dark_color', $accent_dark_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['theme_text_thead_dark_color'] = array(
                'name'  => 'theme_text_thead_dark_color',
                'id'    => 'theme_text_thead_dark_color',
                'type'  => 'color',
                'value' => set_value('theme_text_thead_dark_color', $text_thead_dark_color),
                'class' => 'form-control-color w-100'
        );

        $this->data['file_id_logo_old'] =  ($file_id_logo_old)?$file_id_logo_old:"";
        $this->data['file_id_logo_text_old'] =  ($file_id_logo_text_old)?$file_id_logo_text_old:"";
        $this->data['file_id_background_img_old'] =  ($file_id_background_img_old)?$file_id_background_img_old:"";
        $this->data['situs_id_edit'] =  $id;
        $this->data['view_logo'] =  $view_logo;
        $this->data['view_logo_text'] =  $view_logo_text;
        $this->data['view_background_img'] =  $view_background_img;
        
        $this->data['csrf'] = $this->_get_sess_csrf();

    }

    public function save()
    {
        $input_name_app             = $this->request->getPost('input_name_app');
        $description                = $this->request->getPost('description');
        $title                      = $this->request->getPost('title');
        $footer                     = $this->request->getPost('footer');
        $file_id_logo_old           = $this->request->getPost('file_id_logo_old');
        $file_id_logo_text_old      = $this->request->getPost('file_id_logo_text_old');
        $file_id_background_img_old = $this->request->getPost('file_id_background_img_old');
        $primary_color              = $this->request->getPost('theme_primary_color');
        $accent_color               = $this->request->getPost('theme_accent_color');
        $bg_thead_color             = $this->request->getPost('theme_bg_thead_color');
        $text_thead_color           = $this->request->getPost('theme_text_thead_color');
        $primary_dark_color         = $this->request->getPost('theme_primary_dark_color');
        $accent_dark_color          = $this->request->getPost('theme_accent_dark_color');
        $bg_thead_dark_color        = $this->request->getPost('theme_bg_thead_dark_color');
        $text_thead_dark_color      = $this->request->getPost('theme_text_thead_dark_color');

        if($this->request->getFile('file_id_logo')->getName()){
            $fileLogo       = $this->request->getFile('file_id_logo');
            $fileName       = $fileLogo->getRandomName();
            $originName     = $fileLogo->getName();
            $fileType       = $fileLogo->getMimeType();
            $fileSize       = $fileLogo->getSize();
    
            $files = new FileModel();

            if (!in_array($fileType, ['image/png', 'image/jpeg', 'image/webp'])) {
                $this->session->setFlashdata('err', "<br>File <b>Logo</b> hanya menerima tipe file <b>*.webp</b> <b>*.jpg</b>, atau <b>*.png</b>");
			    return redirect()->to('/utilitas/setting-situs');
            }
    
            $files->insert([
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'file_type' => $fileType,
                'file_name_origin' => $originName,
                'active'    => 1,
            ]);

            $file_id_logo = $files->insertID();
            $fileLogo->move(WRITEPATH.'uploads/situs/', $fileName);

            if($file_id_logo_old != ""){
                $nama_file = $files->where('id',$file_id_logo_old)->get()->getRow()->file_name;
                unlink(WRITEPATH.'uploads/situs/'.$nama_file);

                $files->delete(['id' => $file_id_logo_old]);
            }
        }

        if($this->request->getFile('file_id_logo_text')->getName()){
            $fileLogo       = $this->request->getFile('file_id_logo_text');
            $fileName       = $fileLogo->getRandomName();
            $originName     = $fileLogo->getName();
            $fileType       = $fileLogo->getMimeType();
            $fileSize       = $fileLogo->getSize();
    
            $files = new FileModel();

            if (!in_array($fileType, ['image/png', 'image/jpeg', 'image/webp'])) {
                $this->session->setFlashdata('err', "<br>File <b>Logo Text</b> hanya menerima tipe file <b>*.webp</b> <b>*.jpg</b>, atau <b>*.png</b>");
			    return redirect()->to('/utilitas/setting-situs');
            }
    
            $files->insert([
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'file_type' => $fileType,
                'file_name_origin' => $originName,
                'active'    => 1,
            ]);

            $file_id_logo_text = $files->insertID();
            $fileLogo->move(WRITEPATH.'uploads/situs/', $fileName);

            if($file_id_logo_text_old != ""){
                $nama_file = $files->where('id',$file_id_logo_text_old)->get()->getRow()->file_name;
                unlink(WRITEPATH.'uploads/situs/'.$nama_file);

                $files->delete(['id' => $file_id_logo_text_old]);
            }
        }

        if($this->request->getFile('file_id_background_img')->getName()){
            $fileBg       = $this->request->getFile('file_id_background_img');
            $fileName       = $fileBg->getRandomName();
            $originName     = $fileBg->getName();
            $fileType       = $fileBg->getMimeType();
            $fileSize       = $fileBg->getSize();
    
            $files = new FileModel();

            if (!in_array($fileType, ['image/png', 'image/jpeg', 'image/webp'])) {
                $this->session->setFlashdata('err', "<br>File <b>Login Background</b> hanya menerima tipe file <b>*.webp</b> <b>*.jpg</b>, atau <b>*.png</b>");
			    return redirect()->to('/utilitas/setting-situs');
            }
    
            $files->insert([
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'file_type' => $fileType,
                'file_name_origin' => $originName,
                'active'    => 1,
            ]);

            $file_id_background_img = $files->insertID();
            $fileBg->move(WRITEPATH.'uploads/situs/', $fileName);

            if($file_id_background_img_old != ""){
                $nama_file = $files->where('id',$file_id_background_img_old)->get()->getRow()->file_name;
                unlink(WRITEPATH.'uploads/situs/'.$nama_file);

                $files->delete(['id' => $file_id_background_img_old]);
            }
        }

        $data = array (
            'name_app'              => $input_name_app,
            'description'           => $description,
            'title'                 => $title,
            'footer'                => $footer,
            'primary_color'         => $primary_color,
            'accent_color'          => $accent_color,
            'bg_thead_color'        => $bg_thead_color,
            'text_thead_color'      => $text_thead_color,
            'primary_dark_color'    => $primary_dark_color,
            'accent_dark_color'     => $accent_dark_color,
            'bg_thead_dark_color'   => $bg_thead_dark_color,
            'text_thead_dark_color' => $text_thead_dark_color,
        );

        if($this->request->getFile('file_id_logo')->getName()){
            $data['file_id_logo'] = $file_id_logo;
        }
        if($this->request->getFile('file_id_logo_text')->getName()){
            $data['file_id_logo_text'] = $file_id_logo_text;
        }
        if($this->request->getFile('file_id_background_img')->getName()){
            $data['file_id_background_img'] = $file_id_background_img;
        }

        $this->validation->setRules([
            'input_name_app'        => ['label' => 'Nama App', 'rules' => 'required', 'errors' => ['required' => '{field} Tidak boleh kosong']],
            'description'           => ['label' => 'Deskripsi App', 'rules' => 'required', 'errors' => ['required' => '{field} Tidak boleh kosong']],
            'title'                 => ['label' => 'Title', 'rules' => 'required', 'errors' => ['required' => '{field} Tidak boleh kosong']],
            'footer'                => ['label' => 'Footer', 'rules' => 'required', 'errors' => ['required' => '{field} Tidak boleh kosong']],
        ]);
        
        if (isset($_POST) && !empty($_POST))
        {
            if($this->request->getPost('id')) {
                if ($this->validation->withRequest($this->request)->run() === TRUE AND $this->situs->updateRecord($this->situs->table,$data, 'id',$this->request->getPost('id')))
                {
                    $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,$this->request->getPost('id'),"Update Informasi Situs");        
                    $this->session->setFlashdata('message', "Update berhasil.." );
		            return redirect()->to('/utilitas/setting-situs');
                }else{
                    $this->data['errmsg'] = $this->validation->listErrors();
                    $this->data['message'] = $this->session->getFlashdata('message');
                    $this->session->setFlashdata('err', $this->data['errmsg']);
		            return redirect()->to('/utilitas/setting-situs');
                }
                
            }else{
                if ($this->validation->withRequest($this->request)->run() === TRUE AND $this->situs->insertRecordGetid($this->situs->table,$data))
                {
                    $this->mcommon->setLog($this->currentUser->user_id,$this->MOD_ALIAS,"","Tambah Informasi Situs");        
                    $this->session->setFlashdata('message', "Tambah berhasil.." );
		            return redirect()->to('/utilitas/setting-situs');
                }else{
                    $this->data['errmsg'] = $this->validation->listErrors();
                    $this->data['message'] = $this->session->getFlashdata('message');
                    $this->session->setFlashdata('err', $this->data['errmsg']);
		            return redirect()->to('/utilitas/setting-situs');
                }
            }
            
        }
    }

    public function get_colors()
    {
        $res = $this->situs->getData();
        $colors;

        if($res){
            $colors = array(
                'primaryColor' => $res->primary_color,
                'accentColor' => $res->accent_color,
                'bgTheadColor' => $res->bg_thead_color,
                'textTheadColor' => $res->text_thead_color,
                'primaryDarkColor' => $res->primary_dark_color,
                'accentDarkColor' => $res->accent_dark_color,
                'bgTheadDarkColor' => $res->bg_thead_dark_color,
                'textTheadDarkColor' => $res->text_thead_dark_color
            );
        }

        return $this->response->setJSON($colors);
    }
}
