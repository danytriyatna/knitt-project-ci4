<?php

namespace Modules\Utility\Models;

class RoleModel extends \App\Models\PrModel
{
    /**
     * table name
     */
    protected $table = "sec_role";
    protected $_data = null;
    protected $mauth = null;

    /**
     * allowed Field
     */
    protected $allowedFields = [
        'name',
        'description',
        'active'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->mauth = new \IonAuth\Models\IonAuthModel();
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null)
    {
        $builder = $this->db->table($this->table);
        if ($id == null or $id == "") {
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                $builder->where('LOWER(name) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(description) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->groupEnd();
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('id');
            }

            if (empty($offset)) $offset = 0;
            if (empty($limit)) $limit = 10;

            $builder->limit($limit, $offset);

            $this->_data = $builder->get()->getResult();
        } else {
            $builder->where("id", $id);

            $this->_data = $builder->get()->getRow();
        }

        return $this->_data;
    }

    function getDataCnt($filters = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('count(id) as _cnt');

        if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
            $builder->groupStart();
            $builder->where('LOWER(name) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(description) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;
        return $this->_data;
    }

    public function getRoles($id = null, $by = null)
    {
        $builder = $this->db->table('sec_role');

        if ($id) {

            $builder->where('id', $id);

            $this->_data = $builder->get()->getRow();
        } else {
            if ($this->session->name == "superadmin") {
                $builder->where("id >=", 1);
            } elseif ($this->session->name == "admin") {
                $builder->where("id >", 2);
            }

            $this->_data   = $builder->get()->getResult();
        }
        return $this->_data;
    }

    function getRolesActive()
    {
        $builder = $this->db->table("sec_role");
        $builder->where("active", 1);
        $builder->where("id >", 1);

        $builder->orderBy("id", "asc");
        return $builder->get()->getResult();
    }
}
