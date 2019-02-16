<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->cekLogin();

        $this->load->model('model_events');
        $this->load->model('model_loker');
    }

    public function index()
    {
        $event = $this->model_events->get_where(array(
            'tanggal_berakhir >=' => date('Y-m-d')
        ))->row();

        $loker = $this->model_loker->get_where(array(
            'tanggal_berakhir >=' => date('Y-m-d')
        ))->row();

        $data['event'] = $event;
        $data['loker'] = $loker;
        $data['judul'] = 'Dashboard';
        $data['konten'] = $this->load->view('dashboard/konten_utama', $data, true);

        $this->load->view('dashboard/layout', $data);
    }
}

/**
 * End of file Dashboard.php
 * By Suryahadi Eko Hanggoro
 */