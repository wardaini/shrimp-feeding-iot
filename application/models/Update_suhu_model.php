<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_suhu_model extends CI_Model {

    // Insert baris baru suhu
    public function insert_suhu($suhu) {
        $this->db->insert('suhu_realtime', ['suhu' => $suhu]);
    }

    // Update baris terakhir dengan suhu baru
    public function update_suhu_terakhir($suhu) {
        $this->db->select('id');
        $this->db->from('suhu_realtime');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get()->row();

        if ($last) {
            $this->db->where('id', $last->id);
            return $this->db->update('suhu_realtime', ['suhu' => $suhu]);
        } else {
            return false;
        }
    }
}
