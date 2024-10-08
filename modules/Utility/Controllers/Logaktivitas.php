<?php

namespace Modules\Utility\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Utility\Models\LogaktivitasModel;

class Logaktivitas extends BaseController
{
    function __construct()
    {
        $this->MOD_ALIAS = "MOD_LOGACTIVITY";
        
        $this->log_aktivitas = new LogaktivitasModel();
    }

	public function index()
	{
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
        
        $this->data['titlehead'] = "Log Aktivitas";

        return view('\Modules\Utility\Views\log_activity', $this->data);
    }

    public function lists()
    {
        $start      = $this->request->getPost('start');
        $limit      = $this->request->getPost('length');
        $filters    = $this->request->getPost('filter');
        $order      = $this->request->getPost('sort');
        
        $results = $this->log_aktivitas->getData(null, $start, $limit, $order, $filters);
        $totalfiltered = $this->log_aktivitas->getDataCnt($filters);
        $totaldata = $this->log_aktivitas->getDataCnt();
        $maxpage = ceil($totalfiltered / $limit);
        
        $build_array = array(
            "last_page" => $maxpage,
            "recordsTotal" => $totaldata,
            "recordsFiltered" => $totalfiltered,
            "data" => array()
        );

        foreach ($results as $row) {
            
            array_push($build_array["data"],
                array(
                    "log_date"      => date_format(date_create($row->log_date),"d-m-Y H:i:s"),
                    "ip_address"    => $row->ip_address,
                    "comp_name"     => $row->comp_name,
                    "username"      => $row->username,
                    "module_alias"  => $row->module_alias,
                    "trans_id"      => $row->trans_id,
                    "activity"      => $row->activity,
                    "description"   => $row->description,
                    "http_agent"    => $row->http_agent,
                    "http_host"     => $row->http_host,
                    "mac_address"   => $row->mac_address,
                )
            );
        }
        
        return $this->response->setJSON($build_array);
    }

}
