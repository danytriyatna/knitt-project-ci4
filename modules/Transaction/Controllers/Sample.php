<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;

class Sample extends BaseController
{
	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
        
        $this->data['titlehead'] = "Sample";
        $this->data['buyer'] = [
            (object) [
              'nama' => 'Pak Gilang',
              'alamat' => 'Jl. Kawaluyaan No. 111',
              'no_telp_wa' => '081123445678',
              'email' => 'gilang@mail.id',
            ],
            (object) [
              'nama' => 'Bu Indri',
              'alamat' => 'Jl. Katapang No. 40',
              'no_telp_wa' => '0827189187722',
              'email' => 'indri@mail.id',
            ],
            (object) [
              'nama' => 'Bu Desty',
              'alamat' => 'Jl. Ciwastra No. 13',
              'no_telp_wa' => '089927156362',
              'email' => 'desty@mail.id',
            ],
            (object) [
              'nama' => 'Wa Hakam',
              'alamat' => 'Jl. Soekarno-Hatta No. 90',
              'no_telp_wa' => '0816273738791',
              'email' => 'hakam@mail.id',
            ],
          ];

        return view('\Modules\Transaction\Views\sample_list', $this->data);
    }
}
