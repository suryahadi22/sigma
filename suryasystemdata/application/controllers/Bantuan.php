<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bantuan extends CI_Controller {

    public function index()
    {
        redirect('bantuan/commingsoon'); //Bantuan saat ini sedang ada pengerjaan
    }

    public function commingsoon() // Comming soon... Maaf, sedang diperbaiki..
    {
        $data['judul'] = 'Bantuan';
        $data['konten'] = $this->load->view('errors/comming_soon', null, true);

        $this->load->view('dashboard/layout', $data);
    }

    public function license()
    {
        $data['judul'] = 'License';
        $data['konten'] = $this->load->view('bantuan/lisensi', null, true);

        $this->load->view('dashboard/layout', $data);
    }
}

/**
 * End of file Bantuan.php
 * By Suryahadi Eko Hanggoro
 */