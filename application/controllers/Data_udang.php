<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_udang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_udang_model');
        $this->load->model('Tb_jadwal_pakan_model');
        $this->load->model('Umur_udang_model');
    }

    public function index()
    {
        $data = ['page' => "Data_udang"];
        $data['umur_udang_options'] = $this->Umur_udang_model->get_all_umur_udang();
        $data['data_udang'] = $this->Data_udang_model->get_all_data();
        $data['data_udang'] = $this->Data_udang_model->get_all_data_with_umur();
        $this->load->view('data_udang/index', $data);
    }

    public function create()
    {
        $data = ['page' => "Data_udang"];
        $data['umur_udang_options'] = $this->Umur_udang_model->get_all_umur_udang();
        $data['data_udang'] = $this->Data_udang_model->get_all_data();
        $data['data_udang'] = $this->Data_udang_model->get_all_data_with_umur();
        $this->load->view('data_udang/create', $data);
    }

    public function submit()
    {
        // Mengambil data inputan user
        $umur_udang = $this->input->post('umur_udang');
        $populasi = $this->input->post('populasi');
        $id_umur = $this->input->post('id_umur');

        // Menyimpan data ke tabel data_udang
        $data = array(
            'umur_udang' => $umur_udang,
            'populasi' => $populasi,
            'id_umur' => $id_umur,
            'tanggal' => date('Y-m-d H:i:s')
        );

        // Menyimpan data udang
        $id_data = $this->Data_udang_model->insert_data_udang($data);

        // Mengambil jadwal pakan berdasarkan id_umur
        $jadwal_pakan = $this->Tb_jadwal_pakan_model->get_jadwal_by_id_umur($id_umur);

        // Menyimpan setiap jadwal ke tabel jadwal_udang
        foreach ($jadwal_pakan as $jadwal) {
            $jadwal_data = array(
                'id_data' => $id_data,  // Menghubungkan jadwal ke data udang
                'id_umur' => $id_umur,  // Menambahkan id_umur
                'jadwal' => $jadwal->jadwal
            );
            $this->Data_udang_model->insert_jadwal_udang($jadwal_data);
        }

        // Redirect atau tampilkan pesan sukses
        redirect('jadwal');
    }

    public function edit($id_data)
    {
        $data = ['page' => "Data_udang"];
        $this->load->model('Data_udang_model');
        $this->load->model('Umur_udang_model');

        $data['data_udang'] = $this->Data_udang_model->get_data_by_id($id_data);
        $data['umur_udang'] = $this->Umur_udang_model->get_all();

        if (!$data['data_udang']) {
            show_404();
        }

        $this->load->view('Data_udang/edit', $data);
    }


    public function update()
    {
        $id_data = $this->input->post('id_data');
        $update_data = [
            'umur_udang' => $this->input->post('umur_udang'),
            'populasi' => $this->input->post('populasi'),
            'id_umur' => $this->input->post('id_umur'), // Tangkap nilai dari dropdown
        ];

        $this->load->model('Data_udang_model');
        $this->Data_udang_model->update_data($id_data, $update_data);

        redirect('jadwal');
    }

    public function delete($id_data)
    {
        $this->load->model('Data_udang_model');
        $this->Data_udang_model->delete_data($id_data);

        redirect('Data_udang/index');
    }

}
