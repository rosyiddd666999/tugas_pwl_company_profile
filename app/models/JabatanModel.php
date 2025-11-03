<?php
use Core\Model;

class Jabatan extends Model {

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'jabatan';
    }
    public function getAll()
    {
        return $this->select()
                    ->orderBy('nama_jabatan')
                    ->get();
    }
    public function getById($id)
    {
        return $this->select()
                    ->where(array(
                        array('id_jabatan', '=', $id)
                    ))
                    ->get();
    }
    public function insertData($data = array())
    {
        if (empty($data)) {
            return false;
        }
        
        return $this->data($data)->insert();
    }
    public function updateData($data = array(), $id)
    {
        if (empty($data)) {
            return false;
        }
        
        return $this->data($data)
                    ->where(array(
                        array('id_jabatan', '=', $id)
                    ))
                    ->update();
    }
    public function deleteData($id)
    {
        return $this->where(array(
                    array('id_jabatan', '=', $id)
                ))
                ->delete();
    }
}
?>