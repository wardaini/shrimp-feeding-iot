<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Umur_udang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->model('Umur_udang_model');

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
        $data['page'] = "Umur_udang";
        $data['list'] = $this->Umur_udang_model->tampil();
        $this->load->view('umur_udang/index', $data);
    }

    //menampilkan view create
    public function create()
    {
        $data['page'] = "Umur_udang";
        $this->load->view('umur_udang/create', $data);
    }

    //menambahkan data ke database
    public function store()
    {
        $data = [
            'umur_udang' => $this->input->post('umur_udang'),
            'frekuensi_pakan' => $this->input->post('frekuensi_pakan')
        ];

        $this->form_validation->set_rules('umur_udang', 'Umur_udang', 'required');
        $this->form_validation->set_rules('frekuensi_pakan', 'Frekuensi Pakan', 'required');

        if ($this->form_validation->run() != false) {
            $result = $this->Umur_udang_model->insert($data);
            if ($result) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>');
                redirect('Umur_udang');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>');
            redirect('Umur_udang/create');
        }
    }

    public function edit($id_umur)
    {
        $data['page'] = "Umur_udang";
        $data['umur_udang'] = $this->Umur_udang_model->show($id_umur);
        $this->load->view('umur_udang/edit', $data);
    }

    public function update($id_umur)
    {
        // implementasi update data berdasarkan $id_umur
        $id_umur = $this->input->post('id_umur');
        $data = array(
            'umur_udang' => $this->input->post('umur_udang'),
            'frekuensi_pakan' => $this->input->post('frekuensi_pakan')
        );

        $this->Umur_udang_model->update($id_umur, $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diupdate!</div>');
        redirect('umur_udang');
    }

    public function destroy($id_umur)
    {
        $this->Umur_udang_model->delete($id_umur);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');
        redirect('umur_udang');
    }
}
