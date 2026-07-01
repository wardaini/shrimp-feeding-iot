<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pakan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Mengambil nilai suhu berdasarkan tanggal dan jadwal
    public function get_suhu($tanggal, $jadwal) {
        $this->db->select('suhu');
        $this->db->from('jadwal_udang');
        $this->db->where('tanggal', $tanggal);
        $this->db->where('jadwal', $jadwal);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->suhu;
        }
        
        return NULL; // Jika tidak ada data yang ditemukan
    }

    // Mengambil nilai pakan_per_frekuensi berdasarkan tanggal dan jadwal
    public function get_pakan_per_frekuensi($tanggal, $jadwal) {
        $this->db->select('pakan_per_frekuensi');
        $this->db->from('jadwal_udang');
        $this->db->where('tanggal', $tanggal);
        $this->db->where('jadwal', $jadwal);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->pakan_per_frekuensi;
        }
        
        return NULL; // Jika tidak ada data yang ditemukan
    }

    // Mengambil data umur udang berdasarkan umur yang diberikan
    public function get_data_umur_udang($umur_udang) {
        $this->db->select('*');
        $this->db->from('data_udang');
        $this->db->where('umur_udang', $umur_udang);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return NULL; // Jika tidak ada data yang ditemukan
    }
}
