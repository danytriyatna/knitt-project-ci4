<?php

namespace Modules\Vip\Controllers;

use App\Controllers\BaseController;
use Modules\Utility\Models\RoleModel;
use Modules\Utility\Models\UserModel;

class Vip extends BaseController
{
    protected $roles;
    protected $users;

    function __construct()
    {
        $this->MOD_ALIAS = "GO_TO";
        
        $this->roles = new RoleModel();
        $this->users = new UserModel();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
    }

	public function loginAs()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
        
        $this->data['titlehead'] = "Login Sebagai";

        $this->data['roles'] = $this->roles->getRolesActive();

        return view('\Modules\Vip\Views\login_as', $this->data);
    }

    public function setLoginAs()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $user_id      = $this->request->getPost('user_id');

        $user = $this->users->asObject()->find($user_id);

        if($user)
        {
            $sessionData = [
                'identity'            => $user->username,
                'username'            => $user->username,
                'email'               => $user->email,
                'user_id'             => $user->id,
                'old_last_login'      => $user->last_login,
                'last_check'          => time(),
            ];

            $sessionData['mode_penyamaran'] = true;
    
            $this->session->set($sessionData);
        }

        return $this->response->setJSON(['status' => true]);
        
    }

    public function backToAdmin()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }

        $user_id      = $this->session->get('primary_user_id');

        $user = $this->users->asObject()->find($user_id);

        if($user)
        {
            $sessionData = [
                'identity'            => $user->username,
                'username'            => $user->username,
                'email'               => $user->email,
                'user_id'             => $user->id,
                'old_last_login'      => $user->last_login,
                'last_check'          => time(),
            ];

            $sessionData['mode_penyamaran'] = false;
    
            $this->session->set($sessionData);

            return redirect()->to('/');

        }
    }

}
