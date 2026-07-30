<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
	protected $table                = '_files';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'object';
	protected $allowedFields        = ['file_name','file_size','file_type','file_name_origin','active'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';


    function getFiles($id)
    {
		return	$this->db->table($this->table)->where('id',$id)->get()->getRow();
    }
}
