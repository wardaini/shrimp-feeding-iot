<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tb_jadwal_pakan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mengambil jadwal pakan berdasarkan id_umur
    public function get_jadwal_by_id_umur($id_umur)
    {
        $this->db->select('jadwal');
        $this->db->from('tb_jadwal_pakan');
        $this->db->where('id_umur', $id_umur);
        $query = $this->db->get();
        return $query->result();  // Mengembalikan semua jadwal untuk id_umur
    }

    public function get_by_id_umur($id_umur)
    {
        $this->db->where('id_umur', $id_umur);
        return $this->db->get('tb_jadwal_pakan')->result_array();
    }

    public function delete_by_id_data($id_data)
    {
        $this->db->where('id_data', $id_data);
        $this->db->delete('jadwal_udang');
    }

    public function insert_jadwal($data)
    {
        $this->db->insert('jadwal_udang', $data);
    }
}
