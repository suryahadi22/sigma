<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->cekLogin();
        $this->load->model('model_users');
    }

    public function index()
    {
        if ($this->input->post('submit-information')) {
            if (!empty($_FILES['avatar']['name'])) {
                $config['upload_path'] = './assets/datapengguna/fotoprofil';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 2000;
                $config['file_name'] = 'surfile_'.$this->session->userdata('username').'_'.date('YmdHis');

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('avatar')) {
                    exit($this->upload->display_errors());
                }

                $data['avatar'] = $this->upload->data()['file_name'];
            }

            if (!empty($_FILES['cv']['name'])) {
                $config['upload_path'] = './assets/datapengguna/dokumen';
                $config['allowed_types'] = 'pdf|doc|docx|odt';
                $config['max_size'] = 1500;
                $config['file_name'] = 'cv_'.$this->session->userdata('username').'_'.date('YmdHis');

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('cv')) {
                    exit($this->upload->display_errors());
                }

                $data['cv'] = $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('telp', 'Telepon', 'required');
            $this->form_validation->set_rules('email', 'E-Mail', 'required');
            $this->form_validation->set_message('required', '%s jangan sampai kosong gan...');

            if ($this->form_validation->run() === TRUE) {
                $data['nama'] = $this->input->post('nama');
                $data['alamat'] = $this->input->post('alamat');
                $data['telp'] = $this->input->post('telp');
                $data['email'] = $this->input->post('email');

                $userId = $this->session->userdata('id');
                $query = $this->model_users->update($userId, $data);

                if ($query) {
                    $message = array('status' => true, 'message' => 'Profil agan berhasil diperbarui..');
                    $this->session->set_userdata($data);
                } else {
                    $message = array('status' => false, 'message' => 'Maaf, profil agan gagal diperbarui');
                }

                $this->session->set_flashdata('message_profile', $message);

                redirect('profile', 'refresh');
            }
        }

        if ($this->input->post('submit-password')) {
            $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|callback_cekPasswordLama');
            $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[5]');
            $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

            $this->form_validation->set_message('required', '%s jangan sampai kosong gan...');
            $this->form_validation->set_message('min_length', '{field} setidaknya harus {param} karakter.');
            $this->form_validation->set_message('matches', '{field} tidak sama dengan {param}');

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'password' => password_hash($this->input->post('konfirmasi_password'), PASSWORD_DEFAULT)
                );
                $userId = $this->session->userdata('id');
                $query = $this->model_users->update($userId, $data);

                if ($query) {
                    redirect('auth/logout');
                } else {
                    $message = array('status' => false, 'message' => 'Gagal memperbarui profil');
                }
                $this->session->set_flashdata('message_profile', $message);
                redirect('profile', 'refresh');
            }
        }
        $data['judul'] = 'Informasi Profil Anda';
        $data['konten'] = $this->load->view('profile/profile', $data, TRUE);

        $this->load->view('dashboard/layout', $data);
    }

    public function cekPasswordLama()
    {
        $userId = $this->session->userdata('id');
        $password = $this->input->post('password_lama');
        $query = $this->model_users->cekPasswordLama($userId, $password);

        if (!$query) {
            $this->form_validation->set_message('cekPasswordLama', 'Password Lama tidak sesuai');
            return false;
        }
        return true;
    }
}

/**
 * End of file Profile.php
 * By Suryahadi Eko Hanggoro
 */