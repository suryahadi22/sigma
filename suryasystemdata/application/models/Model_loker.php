<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_loker extends CI_Model {

    public $table = 'loker';

    public function get()
    {
        $query = $this->db->get($this->table);
        return $query;
    }

    public function get_offset($limit, $offset)
    {
        $query = $this->db->limit($limit, $offset)->get($this->table);
        return $query;
    }

    public function get_where($where)
    {
        $query = $this->db->where($where)->get($this->table);
        return $query;
    }

    public function insert($data)
    {
        $query = $this->db->insert($this->table, $data);
        return $query;
    }

    public function update($id, $data)
    {
        $query = $this->db->where('id', $id)->update($this->table, $data);
        return $query;
    }

    public function delete($id)
    {
        $query = $this->db->where('id', $id)->delete($this->table);
        return $query;
    }
}

/**
 * End of file Model_loker.php
 * By Suryahadi Eko Hanggoro
 */