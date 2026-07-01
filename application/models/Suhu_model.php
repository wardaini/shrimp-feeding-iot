<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suhu_model extends CI_Model {

    // Fungsi untuk memperbarui suhu di tabel suhu_realtime
    public function update_suhu($suhu)
    {
        // Update nilai suhu
        $this->db->set('suhu', $suhu);
        $this->db->where('id', 1); // Sesuaikan ID jika diperlukan
        return $this->db->update('suhu_realtime');
    }
}
