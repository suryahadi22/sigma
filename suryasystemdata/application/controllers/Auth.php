<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function cekAkun()
    {
        $this->load->model('model_users');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $query = $this->model_users->cekAkun($username, $password);

        if (!$query) {
            $this->form_validation->set_message('cekAkun', 'Ups.. Sepertinya kamu salah memasukkan username atau password :(');
            return FALSE;
        } else {
            $userData = array(
                'id' => $query->id,
                'username' => $query->username,
                'level' => $query->level,
                'avatar' => $query->avatar,
                'cv' => $query->cv,
                'nama' => $query->nama,
                'email' => $query->email,
                'alamat' => $query->alamat,
                'telp' => $query->telp,
                'logged_in' => true
            );

            $this->session->set_userdata($userData);
            return TRUE;
        }
    }

    public function index()
    {
        
        redirect('auth/login','refresh');
        
    }

    public function login()
    {
        if($this->session->userdata('logged_in')) redirect(base_url());
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|callback_cekAkun');
            $this->form_validation->set_message('required', '%s jangan sampai kosong ya :)');

            if ($this->form_validation->run() === TRUE) {
                redirect('dashboard');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

/**
 * End of file Auth.php
 * By Suryahadi Eko Hanggoro
 */