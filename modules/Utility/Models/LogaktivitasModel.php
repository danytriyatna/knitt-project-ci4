<?php 
namespace Modules\Utility\Models;

class LogaktivitasModel extends \App\Models\PrModel
{
    protected $table = "log_activity";

    function getData($id = null, $offset = null, $limit = null, $order = null, $filters = null)
    {
        $builder = $this->db->table($this->table." la");

        $builder->select("la.*, u.username");
        $builder->join("sec_user u", "u.id = la.user_id", "inner");

        if ($id == null OR $id == "") {
            if (!empty($filters)) {
                if (is_array($filters) && count($filters) >= 1) {
                    $builder->groupStart();
                        $builder->like('la.activity', $filters[0]['value']);
                        $builder->orLike('u.username', $filters[0]['value']);
                        $builder->orLike('la.ip_address', $filters[0]['value']);
                        $builder->orLike('la.comp_name', $filters[0]['value']);
                    $builder->groupEnd();
                }
            }

            if (!empty($order)) {
                $builder->orderBy($order[0]['field'], $order[0]['dir'], TRUE);
            } else {
                $builder->orderBy('log_date','DESC');
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
        $builder = $this->db->table($this->table." la");

        $builder->select('count(log_date) as _cnt');
        $builder->join("sec_user u", "u.id = la.user_id", "inner");

        if (!empty($filters)) {
            if (is_array($filters) && count($filters) >= 1) {
                $builder->groupStart();
                    $builder->like('la.activity', $filters[0]['value']);
                    $builder->orLike('u.username', $filters[0]['value']);
                    $builder->orLike('la.ip_address', $filters[0]['value']);
                    $builder->orLike('la.comp_name', $filters[0]['value']);
                $builder->groupEnd();
            }
        }

        $this->_data = $builder->get()->getRow()->_cnt;
        return $this->_data;
    }

    public function getLogActivity($id = null, $by = null)
    {
        $builder = $this->db->table($this->table);

        if ($id) {
            
            $builder->where('id', $id);

            $this->_data = $builder->get()->getRow();
        } else {
           
            $this->_data   = $builder->get()->getResult();
        }
        return $this->_data;
    }
}