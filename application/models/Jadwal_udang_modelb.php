<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Model: Jadwal_udang_model.php

class Jadwal_udang_model extends CI_Model
{
    // public function get_jadwal_today($today)
    // {
    //     $this->db->select('jadwal, tanggal');
    //     $this->db->from('jadwal_udang');
    //     $this->db->where('tanggal', $today); 
    //     $query = $this->db->get();

    // Kembalikan hasil sebagai array objek
    //     return $query->result();
    // }

    public function getTodayJadwal()
    {
        $today = date('Y-m-d');
        $this->db->select('id_jadwal_udang, jadwal, tanggal, pakan_per_frekuensi, suhu, fuzzy_pakan');
        $this->db->from('jadwal_udang');
        $this->db->where('tanggal', $today);
        return $this->db->get()->result();
    }

    public function getById($id_jadwal_udang)
    {
        return $this->db->get_where('jadwal_udang', ['id_jadwal_udang' => $id_jadwal_udang])->row();
    }

    public function update($id_jadwal_udang, $data)
    {
        $this->db->where('id_jadwal_udang', $id_jadwal_udang);
        return $this->db->update('jadwal_udang', $data);
    }

    public function delete($id_jadwal_udang)
    {
        $this->db->where('id_jadwal_udang', $id_jadwal_udang);
        return $this->db->delete('jadwal_udang');
    }

    public function get_all_data_udang()
    {
        return $this->db->get('data_udang')->result_array(); // Menggunakan result_array() untuk mendapatkan array
    }


    public function update_pakan_harian($id_data, $pakan_harian)
    {
        // Update nilai pakan_harian berdasarkan id_data
        $this->db->where('id_data', $id_data);
        $this->db->update('data_udang', ['pakan_harian' => $pakan_harian]);
    }

    public function get_data_udang_with_frekuensi_pakan()
    {
        $this->db->select('data_udang.id_data, data_udang.populasi, data_udang.umur_udang, umur_udang.frekuensi_pakan');
        $this->db->from('data_udang');
        $this->db->join('umur_udang', 'data_udang.id_umur = umur_udang.id_umur');
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }

    public function update_pakan_per_frekuensi($id_data, $pakan_per_frekuensi)
    {
        $this->db->where('id_data', $id_data);
        $this->db->update('jadwal_udang', ['pakan_per_frekuensi' => $pakan_per_frekuensi]);
    }

    public function get_data_udang()
    {
        $this->db->select('data_udang.id_data, data_udang.populasi, data_udang.umur_udang, data_udang.pakan_harian');
        $this->db->from('data_udang');
        return $this->db->get()->result_array();
    }

    public function get_suhu_pakan_and_umur_by_jadwal()
    {
        // Mendapatkan waktu saat ini (jam dan menit)
        $currentTime = date('H:i');  // Format HH:MM (jam dan menit)
        $currentDate = date('Y-m-d'); // Mendapatkan tanggal saat ini dalam format YYYY-MM-DD

        // Mengambil data suhu, pakan_per_frekuensi, dan umur_udang berdasarkan tanggal dan waktu yang sesuai dengan current time
        $this->db->select('jadwal_udang.jadwal, jadwal_udang.tanggal, jadwal_udang.suhu, jadwal_udang.pakan_per_frekuensi, data_udang.umur_udang');
        $this->db->from('jadwal_udang');
        $this->db->join('data_udang', 'data_udang.id_data = jadwal_udang.id_data', 'inner');
        $this->db->where('jadwal_udang.tanggal', $currentDate);
        $this->db->where('jadwal_udang.jadwal', $currentTime);
        $query = $this->db->get();

        // Debugging: Cek hasil query
        $result = $query->row_array();

        // Memeriksa apakah ada hasil yang ditemukan
        if ($query->num_rows() > 0) {
            return $result;  // Mengembalikan satu baris hasil (suhu, pakan_per_frekuensi, dan umur_udang)
        } else {
            return null; // Jika tidak ada data, mengembalikan null
        }
    }

    // Fungsi untuk menghitung dan memperbarui fuzzy_pakan secara otomatis
    public function hitung_fuzzy_automatis()
    {
        // Mendapatkan waktu real-time (tanggal dan jam)
        $currentTime = date('H:i');  // Jam dan menit
        $currentDate = date('Y-m-d'); // Tanggal saat ini

        // Mengambil data jadwal_udang, pakan_per_frekuensi, suhu, dan umur_udang berdasarkan waktu saat ini
        $this->db->select('jadwal_udang.jadwal, jadwal_udang.tanggal, jadwal_udang.suhu, jadwal_udang.pakan_per_frekuensi, data_udang.umur_udang');
        $this->db->from('jadwal_udang');
        $this->db->join('data_udang', 'data_udang.id_data = jadwal_udang.id_data', 'inner');
        $this->db->where('jadwal_udang.tanggal', $currentDate);
        $this->db->where('jadwal_udang.jadwal', $currentTime);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Looping melalui hasil query untuk menghitung fuzzy untuk setiap baris yang sesuai
            foreach ($query->result_array() as $row) {
                $suhu = $row['suhu'];
                $umur_udang = $row['umur_udang'];
                $pakan_per_frekuensi = $row['pakan_per_frekuensi'];

                // Lakukan perhitungan fuzzy
                $fuzzy_pakan = $this->hitung_fuzzy($suhu, $umur_udang, $pakan_per_frekuensi);

                // Update nilai fuzzy_pakan di tabel jadwal_udang
                $this->db->where('jadwal', $row['jadwal']);
                $this->db->where('tanggal', $row['tanggal']);
                $this->db->update('jadwal_udang', ['fuzzy_pakan' => $fuzzy_pakan]);

                if ($this->db->affected_rows() > 0) {
                    log_message('info', 'Fuzzy_pakan berhasil diupdate untuk jadwal: ' . $row['jadwal']);
                } else {
                    log_message('error', 'Tidak ada perubahan yang dilakukan untuk jadwal: ' . $row['jadwal']);
                }
            }
        } else {
            log_message('info', 'Tidak ada data yang ditemukan untuk jadwal: ' . $currentTime . ' tanggal: ' . $currentDate);
        }
    }


}
