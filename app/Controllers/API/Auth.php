<?php

namespace App\Controllers\Api;
use Modules\Utility\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    function __construct()
    {
		$this->users 		= new UserModel();
    }

	public function login()
    {
        $this->validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required']
        ]);
        
        if ($this->validation->withRequest($this->request)->run() === TRUE) {

            $user = $this->users->where('username', $this->request->getPost('username'))->first();

            if($user){  
                $verivikasi_login =  password_verify($this->request->getPost('password'), $user['password']);

                if(!$verivikasi_login){
                    return $this->response
                        ->setJSON(
                            ["status" => false,
                            "message" => "Password salah!"]
                        );
                }

                return $this->getJWTForUser($this->request->getPost('username'));

            }else{
                return $this->response
                            ->setJSON(
                                ["status" => false,
                                "message" => "Username tidak ditemukan dalam database"]
                            );
            }

        }else{
            return $this->response
                        ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                        ->setJSON(
                            ["status" => false,
                            "message" => $this->validation->getErrors(),
                            "data" => ""]
                        );
        }

    }

    private function getJWTForUser(string $username, int $responseCode = ResponseInterface::HTTP_OK)
    {
        try {
            $user = $this->users->where('username', $this->request->getPost('username'))->first();
            unset($user['password']);

            helper('jwt');

            return $this->response
                ->setJSON(
                    ["status" => true,
                    "message" => "User authenticated successfully",
                    'data' => $user,
                    'access_token' => getSignedJWTForUser($username)
                    ]
                );
        } catch (Exception $exception) {
            return $this->response
                ->setJSON(
                    ["status" => false,
                    "message" => "User authenticated failed",
                    "error"   => $exception->getMessage(),
                    ]
                );
        }
    }
}
