<?php
class JadwalModel extends CI_Model {

    // Ambil data jadwal berdasarkan waktu sekarang
    public function getJadwalByTime($currentDateTime) {
        // Ambil hanya bagian waktu dari $currentDateTime
        $currentTime = date("H:i:s", strtotime($currentDateTime));
        
        // Cari data jadwal yang mendekati waktu sekarang
        $this->db->select('jadwal, tanggal, fuzzy_pakan');
        $this->db->from('jadwal_udang');
        $this->db->where('jadwal', $currentTime); // Bandingkan waktu dari jadwal
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();  // Mengembalikan data pertama jika ada
        } else {
            return null;  // Tidak ditemukan data
        }
    }
}
