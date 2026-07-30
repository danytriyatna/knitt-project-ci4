<?php 
namespace Modules\Utility\Models;

class SitusModel extends \App\Models\PrModel
{
    protected $table = "setting_situs";
    protected $_data = null;

    protected $allowedFields = [
        'name_app',
        'title',
        'footer'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    function getData()
    {
        $builder = $this->db->table($this->table);
        $this->_data = $builder->get()->getRow();
        return $this->_data;
    }
    
}