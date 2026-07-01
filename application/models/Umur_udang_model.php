<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Umur_udang_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Mengambil semua data umur udang
    public function get_all_umur_udang()
    {
        $query = $this->db->get('umur_udang');  // Mengambil semua data dari tabel umur_udang
        return $query->result();  // Mengembalikan hasil dalam bentuk array objek
    }

    public function get_all()
    {
        return $this->db->get('umur_udang')->result_array();
    }

    public function insert($data = [])
    {
        $result = $this->db->insert('umur_udang', $data);
        return $result;
    }

    public function show($id_umur)
    {
        $this->db->where('id_umur', $id_umur);
        $query = $this->db->get('umur_udang');
        return $query->row();
    }

    public function update($id_umur, $data = [])
    {
        $ubah = array(
            'umur_udang' => $data['umur_udang'],
            'frekuensi_pakan' => $data['frekuensi_pakan'],
        );

        $this->db->where('id_umur', $id_umur);
        $this->db->update('umur_udang', $ubah);
    }

    public function delete($id_umur)
    {
        $this->db->where('id_umur', $id_umur);
        $this->db->delete('umur_udang');
    }

    public function getFrekuensiPakan($id_umur)
    {
        $this->db->select('frekuensi_pakan');
        $this->db->from('umur_udang');
        $this->db->where('id_umur', $id_umur);
        $query = $this->db->get();
        return $query->row()->frekuensi_pakan;
    }

    public function tampil()
    {
        $query = $this->db->get('umur_udang');
        return $query->result();
    }

}
