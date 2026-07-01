<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_suhu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Update_suhu_model');
    }

    // Fungsi untuk INSERT data suhu baru
    public function insertSuhu() {
        $suhu = $this->input->get('suhu');

        if ($suhu === NULL) {
            echo json_encode(['status' => 'error', 'message' => 'Parameter suhu diperlukan.']);
            return;
        }

        $this->Update_suhu_model->insert_suhu($suhu);
        echo json_encode(['status' => 'success', 'message' => 'Suhu berhasil disimpan (insert).']);
    }

    // Fungsi untuk UPDATE baris terakhir dengan suhu baru
    public function updateSuhu() {
        $suhu = $this->input->get('suhu');

        if ($suhu === NULL) {
            echo json_encode(['status' => 'error', 'message' => 'Parameter suhu diperlukan.']);
            return;
        }

        $updated = $this->Update_suhu_model->update_suhu_terakhir($suhu);

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Suhu terakhir berhasil diupdate.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data untuk diupdate.']);
        }
    }
}
