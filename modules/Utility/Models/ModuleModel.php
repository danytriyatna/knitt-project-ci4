<?php

namespace Modules\Utility\Models;

class ModuleModel extends \App\Models\PrModel
{
    /**
     * table name
     */
    protected $table = "sec_modul";
    protected $_data = null;
    protected $primaryKey = 'id';
    protected $mauth = null;

    /**
     * allowed Field
     */
    protected $allowedFields = [
        'name',
        'alias',
        'url',
        'icon_cls',
        'seq',
        'pid',
        'publish',
        'group',
        'is_sapage',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->mauth = new \IonAuth\Models\IonAuthModel();
    }

    function getModules($id = null, $by = null)
    {
        $builder = $this->db->table($this->table);
        $query   = $builder->get();

        if ($id) {
            $builder->where('id', $id);
            if ($by != null)
                $builder->where($by);

            $query   = $builder->get();
            $this->_data = ($query)->getRow();
        } else {
            if ($by != null)
                $builder->where($by);

            $builder->orderBy('pid ASC, seq ASC, id ASC');

            $query   = $builder->get();
            $this->_data = ($query)->getResult();
        }

        return $this->_data;
    }

    public function insertRolePriv($module_id = null)
    {
        $roles = $this->getRoles();
        foreach ($roles as $role) {
            $builder = $this->db->table('sec_role_priv');
            $exist = $builder->select('count(role_id) as _cnt')
                ->where('role_id', $role->id)
                ->where('module_id', $module_id)
                ->get()->getRow()->_cnt;

            if ($exist == 0) {
                $datains = array(
                    'role_id' => $role->id,
                    'module_id' => $module_id,
                    'allow_view' => true,
                    'allow_new' => true,
                    'allow_edit' => true,
                    'allow_delete' => true,
                    'allow_print' => true,
                    'allow_approve' => true
                );
                $this->db->table('sec_role_priv')->insert($datains);
            }
        }
    }

    public function getRoles($id = null, $by = null)
    {
        $builder = $this->db->table('sec_role');

        if ($this->session->role_name == "superadmin") {
            $builder->where("id >=", 1);
        } elseif ($this->session->role_name == "admin") {
            $builder->where("id >", 2);
        }

        if ($id) {
            $builder->where('id', $id);

            $this->_data = $builder->get()->getResult();
        } else {
            if ($by != null)
                $builder->where($by);

            $this->_data = $builder->get()->getResult();
        }
        return $this->_data;
    }

    public function deactivate(int $id = 0): bool
    {
        $data = [
            'active' => 0,
        ];

        $this->db->table($this->table)->update($data, ['id' => $id]);

        $return = $this->db->affectedRows() === 1;
        if ($return) {
            $this->setMessage('deactivate successful');
        } else {
            $this->setError('deactivate unsuccessful');
        }

        return $return;
    }

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null)
    {
        $builder = $this->db->table($this->table);
        if ($id == null or $id == "") {
            if (!empty($filters) && is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                $builder->where('LOWER(name) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(alias) LIKE', strtolower("%{$filters[0]['value']}%"));
                $builder->orWhere('LOWER(url) LIKE', strtolower("%{$filters[0]['value']}%"));
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

            $builder->get();
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
            $builder->orWhere('LOWER(alias) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->orWhere('LOWER(url) LIKE', strtolower("%{$filters[0]['value']}%"));
            $builder->groupEnd();
        }

        $this->_data = $builder->get()->getRow()->_cnt;

        return $this->_data;
    }
}
