<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cekLogin();
        $this->load->model('model_events');
    }

    public function index()
    {
        $this->load->library('pagination');

        $config['base_url'] = base_url('events/index/');
        $config['total_rows'] = $this->model_events->get()->num_rows();
        $config['per_page'] = 5;
        $config['offset'] = $this->uri->segment(3);

        $config['first_link'] = false;
        $config['last_link'] = false;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['num_tag_open'] = '<ul class="pagination">';
        $config['num_tag_close'] = '</ul>';

        $config['prev_tag_open'] = '<li class="waves-effect">';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li class="waves-effect">';
        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $this->pagination->initialize($config);

        $data['judul'] = 'Event lurr.. Jangan sampai ketinggalan';
        $data['events'] = $this->model_events->get_offset($config['per_page'], $config['offset'])->result();
        $data['konten'] = $this->load->view('events/eventList', $data, TRUE);

        $this->load->view('dashboard/layout', $data);
    }

    public function add()
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('nama', 'Nama Event', 'required');
            $this->form_validation->set_rules('contact', 'Contact Person', 'required');
            $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
            $this->form_validation->set_rules('tanggal_berakhir', 'Tanggal Berakhir', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_message('required', '%s jangan sampai kosong ya Boss!!');

            if ($this->form_validation->run() === TRUE) {

                $data = array(
                    'nama' => $this->input->post('nama'),
                    'contact' => $this->input->post('contact'),
                    'tanggal_mulai' => date_format(date_create($this->input->post('tanggal_mulai')), 'Y-m-d'),
                    'tanggal_berakhir' => date_format(date_create($this->input->post('tanggal_berakhir')), 'Y-m-d'),
                    'keterangan' => $this->input->post('keterangan')
                );

                $query = $this->model_events->insert($data);
                if ($query) $message = array('status' => true, 'message' => 'Selamat boss.. Kamu berhasil menambahkan event :)');
                else $message = array('status' => true, 'message' => 'Ups... Kayaknya ada yang salah boss. Kamu gagal menambahkan Event :(');
                $this->session->set_flashdata('message', $message);
                
                redirect('events/add','refresh');
                
            }
        }
        $data['judul'] = 'Tambah event boss...';
        $data['konten'] = $this->load->view('events/eventAdd', $data, TRUE);
        $this->load->view('dashboard/layout', $data);
    }

    public function edit($id = null)
    {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('nama', 'Nama Event', 'required');
            $this->form_validation->set_rules('contact', 'Contact Person', 'required');
            $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
            $this->form_validation->set_rules('tanggal_berakhir', 'Tanggal Berakhir', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_message('required', '%s jangan sampai kosong ya boss...!');

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'nama' => $this->input->post('nama'),
                    'contact' => $this->input->post('contact'),
                    'tanggal_mulai' => date_format(date_create($this->input->post('tanggal_mulai')), 'Y-m-d'),
                    'tanggal_berakhir' => date_format(date_create($this->input->post('tanggal_berakhir')), 'Y-m-d'),
                    'keterangan' => $this->input->post('keterangan')
                );
                $query = $this->model_events->update($id, $data);
                if ($query) $message = array('status' => true, 'message' => 'Selamat bos, kamu berhasil memperbarui event');
                else $message = array('status' => true, 'message' => 'Ups. Kamu gagal memperbarui boss');
                $this->session->set_flashdata('message', $message);
                
                redirect('events/edit'.$id,'refresh');
            }
        }
        $event = $this->model_events->get_where(array('id' => $id))->row();

        $event->tanggal_mulai = date_format(date_create($event->tanggal_mulai), 'd-m-Y');
        $event->tanggal_berakhir = date_format(date_create($event->tanggal_berakhir), 'd-m-Y');

        if (!$event) show_404();

        $data['judul'] = 'Yaps, Ini halaman edit event';
        $data['event'] = $event;
        $data['konten'] = $this->load->view('events/eventEdit', $data, TRUE);
        $this->load->view('dashboard/layout', $data);
    }

    public function delete($id)
    {
        $user = $this->model_events->get_where(array('id' => $id))->row();
        if (!$user) show_404();
        $query = $this->model_events->delete($id);
        if ($query) $message = array('status' => true, 'message' => 'Boss, selamat. Kamu berhasil menghapus event');
        else $message = array('status' => true, 'message' => 'Ups... Sepertinya boss gagal menghapus event.');
        $this->session->set_flashdata('message', $message);
        
        redirect('events','refresh');
        
    }
}

/**
 * End of file Events.php
 * By Suryahadi Eko Hanggoro
 */