<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loker extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->cekLogin();

    $this->load->model('model_loker');
  }

  public function index()
  {
    $this->load->library('pagination');

    $config['base_url'] = base_url('loker/index/');
    $config['total_rows'] = $this->model_loker->get()->num_rows();
    $config['per_page'] = 5;
    $config['offset'] = $this->uri->segment(3);

    $config['first_link'] = false;
    $config['last_link'] = false;

    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';

    $config['num_tag_open'] = '<li class="waves-effect">';
    $config['num_tag_close'] = '</li>';

    $config['prev_tag_open'] = '<li class="waves-effect">';
    $config['prev_tag_close'] = '</li>';

    $config['next_tag_open'] = '<li class="waves-effect">';
    $config['next_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);

    $data['judul'] = 'Lowongan Kerja';
    $data['loker'] = $this->model_loker->get_offset($config['per_page'], $config['offset'])->result();
    $data['konten'] = $this->load->view('loker/lokerList', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }

  public function add()
  {
    if ($this->input->post('submit')) {
      
      $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
      $this->form_validation->set_rules('contact', 'Contact Person', 'required');
      $this->form_validation->set_rules('tanggal_berakhir', 'Tanggal Berakhir', 'required');
      $this->form_validation->set_rules('posisi', 'Posisi', 'required');
      $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');
		if ($this->form_validation->run() === TRUE) {

        $data = array(
          'nama_perusahaan' => $this->input->post('nama_perusahaan'),
          'contact' => $this->input->post('contact'),
          'tanggal_berakhir' => date_format(date_create($this->input->post('tanggal_berakhir')), 'Y-m-d'),
          'posisi' => $this->input->post('posisi'),
          'deskripsi' => $this->input->post('deskripsi'),
          'username' => $this->session->userdata('username')
        );

        $query = $this->model_loker->insert($data);

        if ($query) $message = array('status' => true, 'message' => 'Berhasil menambahkan lowongan kerja');
        else $message = array('status' => false, 'message' => 'Gagal menambahkan lowongan kerja');

        $this->session->set_flashdata('message', $message);

        redirect('loker/add', 'refresh');
			} 
    }
    
    $data['judul'] = 'Tambah Data Lowongan Kerja';
    $data['konten'] = $this->load->view('loker/lokerAdd', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }

  public function detail($id = null)
  {
    $loker = $this->model_loker->get_where(array('id' => $id))->row();
    
    if (!$loker) show_404();

    $data['judul'] = 'Detail Lowongan Kerja';
    $data['loker'] = $loker;
    $data['konten'] = $this->load->view('loker/lokerDetail', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }

  public function edit($id = null)
  {
    if ($this->input->post('submit')) {
      
      $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
      $this->form_validation->set_rules('contact', 'Contact Person', 'required');
      $this->form_validation->set_rules('tanggal_berakhir', 'Tanggal Berakhir', 'required');
      $this->form_validation->set_rules('posisi', 'Posisi', 'required');
      $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
      $this->form_validation->set_message('required', '%s tidak boleh kosong!');

		if ($this->form_validation->run() === TRUE) {

        $data = array(
          'nama_perusahaan' => $this->input->post('nama_perusahaan'),
          'contact' => $this->input->post('contact'),
          'tanggal_berakhir' => date_format(date_create($this->input->post('tanggal_berakhir')), 'Y-m-d'),
          'posisi' => $this->input->post('posisi'),
          'deskripsi' => $this->input->post('deskripsi')
        );

        $query = $this->model_loker->update($id, $data);

        if ($query) $message = array('status' => true, 'message' => 'Berhasil memperbarui lowongan kerja');
        else $message = array('status' => true, 'message' => 'Gagal memperbarui lowongan kerja');

        $this->session->set_flashdata('message', $message);

        redirect('loker/edit/'.$id, 'refresh');
	    } 
    }
    
    $loker = $this->model_loker->get_where(array('id' => $id))->row();
    
    $loker->tanggal_berakhir = date_format(date_create($loker->tanggal_berakhir), 'd-m-Y');

    if (!$loker) show_404();

    if ($loker->username !== $this->session->userdata('username')) show_404();

    $data['judul'] = 'Edit Data Lowongan Kerja';
    $data['loker'] = $loker;
    $data['konten'] = $this->load->view('loker/lokerEdit', $data, TRUE);

    $this->load->view('dashboard/layout', $data);
  }

  public function delete($id)
  {
    $loker = $this->model_loker->get_where(array('id' => $id))->row();

    if (!$loker) show_404();

    if ($loker->username !== $this->session->userdata('username')) show_404();

    $query = $this->model_loker->delete($id);

    if ($query) $message = array('status' => true, 'message' => 'Berhasil menghapus lowongan kerja');
    else $message = array('status' => true, 'message' => 'Gagal menghapus lowongan kerja');

    $this->session->set_flashdata('message', $message);

    redirect('loker', 'refresh');
  }
}

/**
 * End of file Loker.php
 * By Suryahadi Eko Hanggoro
 */