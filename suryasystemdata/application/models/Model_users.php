<?php
  class Model_users extends CI_Model {

    public $table = 'pengguna';


    public function cekAkun($username, $password)
    {
			$this->db->where('username', $username);
			$this->db->where('active', '1');
			
      $query = $this->db->get($this->table)->row();
      

			if (!$query) return false;

      $hash = $query->password;
      
      if (!password_verify($password, $hash)) return false;
      
      $last_login = $this->update($query->id, array('last_login' => date('Y-m-d H:i:s')));
      
      return $query;        
    }

    public function cekPasswordLama($id, $password)
    {
 			$this->db->where('id', $id);
			$this->db->where('active', '1');
			
      $query = $this->db->get($this->table)->row();
      
 			if (!$query) return false;
			
      $hash = $query->password;
      
      if (!password_verify($password, $hash)) return false;
      
      return $query;        
    }

    public function get()
    {
      $query = $this->db->get($this->table);

      return $query;
    }

    public function get_where($where)
    {
      $query = $this->db
        ->where($where)
        ->get($this->table);

      return $query;
    }

    public function insert($data)
    {
      $query = $this->db->insert($this->table, $data);

      return $query;
    }

    public function update($id, $data)
    {
      $query = $this->db
        ->where('id', $id)
        ->update($this->table, $data);
      
      return $query;
    }

    public function delete($id)
    {
      $query = $this->db
        ->where('id', $id)
        ->delete($this->table);
      
      return $query;
    }
    
  }

  /**
   * End of file Model_users.php 
   * By Suryahadi Eko Hanggoro
   */