<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_udang_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Menyimpan data udang ke tabel data_udang
    public function insert_data_udang($data)
    {
        $this->db->insert('data_udang', $data);
        return $this->db->insert_id();  // Mengembalikan id_data yang baru saja dimasukkan
    }

    // Menyimpan jadwal pakan ke tabel jadwal_udang
    public function insert_jadwal_udang($data)
    {
        $this->db->insert('jadwal_udang', $data);
    }

    public function get_all_data()
    {
        return $this->db->get('data_udang')->result_array();
    }

    public function get_data_by_id($id_data)
    {
        return $this->db->get_where('data_udang', ['id_data' => $id_data])->row_array();
    }


    public function update_data($id_data, $data)
    {
        $this->db->where('id_data', $id_data);
        $this->db->update('data_udang', $data);
    }


    public function delete_data($id_data)
    {
        $this->db->where('id_data', $id_data);
        $this->db->delete('data_udang');
    }

    public function get_all_data_with_umur()
    {
        $this->db->select('data_udang.*, umur_udang.umur_udang AS rentang_umur');
        $this->db->from('data_udang');
        $this->db->join('umur_udang', 'data_udang.id_umur = umur_udang.id_umur', 'left');
        return $this->db->get()->result_array();
    }



}
