<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PakanController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load Model
        $this->load->model('Pakan_model');
    }

    // Method untuk menghitung pakan berdasarkan umur dan suhu
    public function hitung_pakan() {
        // Ambil data input umur dan suhu
        $umur_udang = $this->input->post('umur_udang');  // Umur udang dari form
        $tanggal = date('Y-m-d'); // Ambil tanggal hari ini
        $jadwal = $this->input->post('jadwal');  // Jadwal yang dipilih

        // Ambil nilai suhu berdasarkan jadwal dan tanggal
        $suhu = $this->Pakan_model->get_suhu($tanggal, $jadwal);
        if ($suhu === NULL) {
            // Jika tidak ditemukan suhu yang sesuai
            echo "Tidak ada data suhu untuk tanggal ini dan jadwal ini.";
            return;
        }

        // Ambil nilai pakan per frekuensi berdasarkan jadwal dan tanggal
        $pakan_per_frekuensi = $this->Pakan_model->get_pakan_per_frekuensi($tanggal, $jadwal);
        if ($pakan_per_frekuensi === NULL) {
            // Jika tidak ditemukan data pakan per frekuensi yang sesuai
            echo "Tidak ada data pakan untuk tanggal ini dan jadwal ini.";
            return;
        }

        // Ambil data umur udang berdasarkan umur yang diberikan
        $data_umur_udang = $this->Pakan_model->get_data_umur_udang($umur_udang);
        if ($data_umur_udang === NULL) {
            // Jika tidak ada data umur udang
            echo "Data umur udang tidak ditemukan.";
            return;
        }

        // Hitung nilai pakan menggunakan metode fuzzy
        $pakan = $this->hitung_fuzzy($suhu, $umur_udang, $pakan_per_frekuensi);

        // Tampilkan hasil
        echo "Jumlah pakan yang dihitung: " . $pakan . " gram";
    }

    // Fungsi untuk menghitung pakan berdasarkan suhu dan umur udang
    // private function hitung_fuzzy($suhu, $umur_udang, $pakan_per_frekuensi) {
        // Menentukan aturan fuzzy sesuai dengan suhu dan umur udang
        // Misalkan kita implementasikan logika fuzzy seperti yang sudah dijelaskan

        // Suhu Dingin, Normal, Panas
        // if ($suhu <= 27) {
        //     $suhu_fuzzy = 'dingin';
        // } elseif ($suhu >= 27 && $suhu <= 32) {
        //     $suhu_fuzzy = 'normal';
        // } else {
        //     $suhu_fuzzy = 'panas';
        // }

        // Umur 1-10, 11-20, 21-30
        // if ($umur_udang >= 1 && $umur_udang <= 10) {
        //     $umur_fuzzy = '1-10';
        // } elseif ($umur_udang >= 11 && $umur_udang <= 20) {
        //     $umur_fuzzy = '11-20';
        // } else {
        //     $umur_fuzzy = '21-30';
        // }

        // Menentukan hasil pakan berdasarkan aturan fuzzy
    //     if ($umur_fuzzy == '1-10') {
    //         if ($suhu_fuzzy == 'dingin') {
    //             return $pakan_per_frekuensi * 0.5;
    //         } elseif ($suhu_fuzzy == 'normal') {
    //             return $pakan_per_frekuensi;
    //         } else {
    //             return $pakan_per_frekuensi * 0.5;
    //         }
    //     } elseif ($umur_fuzzy == '11-20') {
    //         if ($suhu_fuzzy == 'dingin') {
    //             return $pakan_per_frekuensi * 0.5;
    //         } elseif ($suhu_fuzzy == 'normal') {
    //             return $pakan_per_frekuensi;
    //         } else {
    //             return $pakan_per_frekuensi * 0.5;
    //         }
    //     } else {
    //         if ($suhu_fuzzy == 'dingin') {
    //             return $pakan_per_frekuensi * 0.5;
    //         } elseif ($suhu_fuzzy == 'normal') {
    //             return $pakan_per_frekuensi;
    //         } else {
    //             return $pakan_per_frekuensi * 0.5;
    //         }
    //     }
    // }
}
