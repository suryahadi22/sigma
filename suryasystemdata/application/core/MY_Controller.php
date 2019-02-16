<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function cekLogin()
    {
        if(!$this->session->userdata('username')) {
            
            redirect('auth/login');
            
        }
    }

    public function getUserData()
    {
        $userData = $this->session->userdata();
        return $userData;
    }

    public function isAdmin()
    {
        $userData = $this->getUserData();
        if ($userData['level'] !== 'administrator') show_404();
    }
}

/**
 * End of file MY_Controller
 * By Suryahadi Eko Hanggoro
 */