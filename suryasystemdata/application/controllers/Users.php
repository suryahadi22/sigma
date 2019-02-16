<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
 
    $this->cekLogin();

    $this->isAdmin();

    $this->load->model('model_users');
  }

  public function index()
  {
    $data['judul'] = 'Users';
    $data['users'] = $this->model_users->get()->result();
    $data['konten'] = $this->load->view('users/userList', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }
  
  public function add()
  {
    if ($this->input->post('submit')) {
      
      $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[pengguna.username]');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
      $this->form_validation->set_rules('level', 'Level', 'required|in_list[administrator,biasa]');
      $this->form_validation->set_rules('active', 'Active', 'required|in_list[0,1]');
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');
      $this->form_validation->set_message('min_length', '%s minimal %d karakter!');
      if ($this->form_validation->run() === TRUE) {

        $data = array(
          'username' => $this->input->post('username'),
          'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
          'level' => $this->input->post('level'),
          'active' => $this->input->post('active')
        );

        $query = $this->model_users->insert($data);

        if ($query) $message = array('status' => true, 'message' => 'Selamat boss.. Kamu berhasil menambahkan user');
        else $message = array('status' => true, 'message' => 'Ups. Kamu Gagal menambahkan user');

        $this->session->set_flashdata('message', $message);

        redirect('users/add', 'refresh');
			} 
    }

    $data['judul'] = 'Tambah Data User';
    $data['konten'] = $this->load->view('users/userAdd', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }

  public function edit($id = null)
  {
    if ($this->input->post('submit')) {
      
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

      $this->form_validation->set_rules('level', 'Level', 'required|in_list[administrator,biasa]');

      $this->form_validation->set_rules('active', 'Active', 'required|in_list[0,1]');

      $this->form_validation->set_message('required', '%s tidak boleh kosong!');
      $this->form_validation->set_message('min_length', '%s minimal %d karakter!');

   		if ($this->form_validation->run() === TRUE) {

        $data = array(
          'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
          'level' => $this->input->post('level'),
          'active' => $this->input->post('active')
        );

        $query = $this->model_users->update($id, $data);

        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui user');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui user');

        $this->session->set_flashdata('message', $message);

        redirect('users/edit/'.$id, 'refresh');
			} 
    }
    
    $user = $this->model_users->get_where(array('id' => $id))->row();

    if (!$user) show_404();

    $data['judul'] = 'Edit Data Users';
    $data['user'] = $user;
    $data['konten'] = $this->load->view('users/userEdit', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }

  public function delete($id)
  {
    $user = $this->model_users->get_where(array('id' => $id))->row();

    if (!$user) show_404();

    $query = $this->model_users->delete($id);

    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus user');
    else $message = array('status' => true, 'message' => 'Gagal menghapus user');

    $this->session->set_flashdata('message', $message);

    redirect('users', 'refresh');
  }
}

/**
 * End of file Users.php
 * By Suryahadi Eko Hanggoro
 */