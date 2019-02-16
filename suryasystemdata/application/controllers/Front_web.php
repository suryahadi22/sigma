<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_web extends CI_Controller {

    public function index()
    {
        $data['judulbos'] = 'Halaman Depan';
        $data['konten'] = $this->load->view('front/content-data/indexpage', NULL, TRUE);
        $this->load->view('front/layout', $data);
    }

    public function profil()
    {
        $data['judulbos'] = 'Profil Kami';
        $data['konten'] = $this->load->view('front/content-data/profil', NULL, TRUE);
        $this->load->view('front/layout', $data);
    }

    public function galerry()
    {
        $this->load->view('errors/comming_soon'); //This is a comming soon view. For a comming soon function
    }
}

/**
 * End of file Front_web.php 
 * By Suryahadi Eko Hanggoro
 */