<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use IonAuth\Libraries\IonAuth;

class OtorisasiFilter implements FilterInterface
{
    protected $mcommon = null;
    protected $session = null;
    protected $MOD_ALIAS = null;
    protected $isAuthorized = false;
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $this->session = \Config\Services::session();
        $this->mcommon = new \App\Models\Mcommon();

        $auth = new IonAuth();
        
        if(isset($arguments[0])){
            $this->MOD_ALIAS = $arguments[0];
        }

        if (!$auth->loggedIn()) {
            return redirect()->to('/auth/login');
        } else {
            $role_id = $this->session->get('role_id');
            if ($this->MOD_ALIAS == "MOD_HOME" OR $this->mcommon->checkMenuAccess($role_id, $this->MOD_ALIAS)) {
				      $this->isAuthorized = true;
            } else {
                return redirect()->to('/auth/login');
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}