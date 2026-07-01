<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_pakan_model extends CI_Model
{

    public function tampil()
    {
        $query = $this->db->get('tb_jadwal_pakan');
        return $query->result();
    }

    public function getTotal()
    {
        return $this->db->count_all('tb_jadwal_pakan');
    }

    public function insert($data = [])
    {
        $result = $this->db->insert('tb_jadwal_pakan', $data);
        return $result;
    }

    public function show($id_jadwal)
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $query = $this->db->get('tb_jadwal_pakan');
        return $query->row();
    }

    public function update($id_jadwal, $data = [])
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->update('tb_jadwal_pakan', $data);
    }

    public function delete($id_jadwal)
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->delete('tb_jadwal_pakan');
    }

    public function get_umur_udang()
    {
        $query = $this->db->get('umur_udang');
        return $query->result();
    }

    // public function count_kriteria()
    // {
    //     $query = $this->db->query("SELECT id_kriteria,COUNT(deskripsi) AS jml_setoran FROM sub_kriteria GROUP BY id_kriteria")->result();
    //     return $query;
    // }

    public function data_jadwal_pakan($id_umur)
    {
        // $query = $this->db->query("SELECT * FROM tb_jadwal_pakan");
        $query = $this->db->query("SELECT * FROM tb_jadwal_pakan WHERE id_umur='$id_umur';");
        // $query = $this->db->query("SELECT * FROM tb_jadwal_pakan WHERE id_umur='$id_umur'  ORDER BY nilai DESC;");
        return $query->result_array();
    }
}

/* End of file Kategori_model.php */
