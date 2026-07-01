<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('JadwalModel');  // Model untuk mengambil data jadwal
    }

    // Fungsi untuk mengambil data jadwal berdasarkan waktu
    public function getJadwalData() {
        $currentDateTime = date("Y-m-d H:i:s");  // Ambil tanggal dan waktu saat ini
        $jadwalData = $this->JadwalModel->getJadwalByTime($currentDateTime);  // Ambil data dari model

        // Cek apakah data ada
        if ($jadwalData) {
            $response = array(
                'status' => 'success',
                'data' => $jadwalData
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'No matching schedule found.'
            );
        }

        // Kirimkan response dalam format JSON
        echo json_encode($response);
    }
}
