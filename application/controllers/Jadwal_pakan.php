<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_pakan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->model('Jadwal_pakan_model');

        if ($this->session->userdata('id_user_level') != "1") {
            ?>
            <script type="text/javascript">
                alert('Anda tidak berhak mengakses halaman ini!');
                window.location = '<?php echo base_url("Login/home"); ?>'
            </script>
            <?php
        }
    }

    public function index()
    {
        $data = [
            'page' => "Jadwal Pakan",
            // 'list' => $this->Jadwal_pakan_model->tampil(),
            'umur_udang' => $this->Jadwal_pakan_model->get_umur_udang(),
            // 'count_umur_udang' => $this->Jadwal_pakan_model->count_umur_udang(),
            'jadwal' => $this->Jadwal_pakan_model->tampil()

        ];
        $this->load->view('jadwal_pakan/index', $data);
    }

    //menambahkan data ke database
    public function store()
    {
        $data = [
            'id_umur' => $this->input->post('id_umur'),
            'jadwal' => $this->input->post('jadwal'),
        ];

        $this->form_validation->set_rules('id_umur', 'ID umur', 'required');
        $this->form_validation->set_rules('jadwal', 'jadwal', 'required');

        if ($this->form_validation->run() != false) {
            $result = $this->Jadwal_pakan_model->insert($data);
            if ($result) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>');
                redirect('jadwal_pakan');
            }

        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>');
            redirect('jadwal_pakan');
        }
    }

    public function update($id_jadwal)
    {
        $this->form_validation->set_rules('jadwal', 'Jadwal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal diupdate!</div>');
        } else {
            $data = [
                'jadwal' => $this->input->post('jadwal'),
            ];
            $this->Jadwal_pakan_model->update($id_jadwal, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diupdate!</div>');
        }

        redirect('jadwal_pakan');
    }

    public function delete($id_jadwal)
    {
        $this->Jadwal_pakan_model->delete($id_jadwal);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');
        redirect('jadwal_pakan');
    }

    public function edit($id_jadwal)
    {
        $data = [
            'page' => "Jadwal Pakan",
        ];
        // Ambil data jadwal berdasarkan ID
        $data['jadwal'] = $this->Jadwal_pakan_model->show($id_jadwal);

        if (!$data['jadwal']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Jadwal tidak ditemukan!</div>');
            redirect('jadwal_pakan');
        }

        $this->load->view('jadwal_pakan/edit', $data);
    }

}
