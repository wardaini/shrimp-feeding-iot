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
        $this->db->select('id_jadwal_udang, jadwal, tanggal, pakan_per_frekuensi, suhu, fuzzy_pakan, berat_akhir');
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
        $this->db->where("TIME_FORMAT(jadwal_udang.jadwal, '%H:%i') =", $currentTime);
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

    public function hitung_fuzzy_pakan()
{
    // Ambil data suhu, pakan_per_frekuensi, dan umur_udang berdasarkan tanggal dan jadwal realtime
    $data = $this->get_suhu_pakan_and_umur_by_jadwal();

    if ($data === null) {
        return "Data tidak ditemukan untuk jadwal dan tanggal saat ini.";
    }

    $suhu = $data['suhu'];
    $umur = $data['umur_udang'];
    $pakan_per_frekuensi = $data['pakan_per_frekuensi'];

    // **1. Fuzzifikasi**
    // Keanggotaan suhu dingin dengan keanggotaan linear menurun
    $μ_dingin = $suhu <= 26 ? 1 : (($suhu >= 26 && $suhu <= 28) ? (28 - $suhu) / (28 - 26) : 0);
    

    // Keanggotaan suhu normal dengan keanggotaan segitiga
    $μ_normal = ($suhu <= 26 || $suhu >= 33) ? 0 :
                (($suhu >= 26 && $suhu <= 29.5) ? ($suhu - 26) / (29.5 - 26) :
                (($suhu >= 29.5 && $suhu <= 33) ? (33 - $suhu) / (33 - 29.5) : 0));
    
    // Keanggotaan suhu panas dengan keanggotaan linear menaik
    $μ_panas = $suhu <= 31 ? 0 : (($suhu >= 31 && $suhu <= 33) ? ($suhu - 31) / (33 - 31) : 1);
    



    // Derajat keanggotaan umur 1-10
    // $μ_doc_1_10 = ($umur <= 0 || $umur >= 11) ? 0 : 
    //             (($umur >= 1 && $umur <= 5) ? ($umur - 1) / (5 - 1) : 
    //             (($umur >= 5 && $umur <= 10) ? (11 - $umur) / (11 - 5) : 0));

    // Keanggotaan umur 11-20 dengan keanggotaan segitiga
    // $μ_doc_11_20 = ($umur <= 9 || $umur >= 21) ? 0 : 
    //             (($umur >= 9 && $umur <= 15) ? ($umur - 9) / (15 - 9) : 
    //             (($umur >= 15 && $umur <= 20) ? (21 - $umur) / (21 - 15) : 0));

    // Keanggotaan umur 21-30 dengan keanggotaan segitiga
    // $μ_doc_21_30 = ($umur <= 19 || $umur >= 31) ? 0 : 
    //             (($umur >= 19 && $umur <= 25) ? ($umur - 19) / (25 - 19) : 
    //             (($umur >= 25 && $umur <= 31) ? (31 - $umur) / (31 - 25) : 0));
// Fuzzifikasi untuk rentang umur
$μ_doc_1_10 = $umur <= 9 ? 1 : (($umur >= 9 && $umur <= 11) ? (11 - $umur) / (11 - 9) : 0);

$μ_doc_11_20 = ($umur <= 9 || $umur >= 21) ? 0 :
               (($umur >= 9 && $umur <= 15) ? ($umur - 29) / (15 - 9) :
               (($umur >= 15 && $umur <= 21) ? (21 - $umur) / (21 - 15) : 0));

$μ_doc_21_30 = $umur <= 20 ? 0 : (($umur >= 20 && $umur <= 30) ? ($umur - 20) / (30 - 20) : 1);



    // **2. Inferensi untuk 9 aturan**
    // R1: Dingin AND doc_1_10
    $μ_R1 = min($μ_dingin, $μ_doc_1_10);
    $z1 = 0.5 * $pakan_per_frekuensi;

    // R2: Normal AND doc_1_10
    $μ_R2 = min($μ_normal, $μ_doc_1_10);
    $z2 = $pakan_per_frekuensi;

    // R3: Panas AND doc_1_10
    $μ_R3 = min($μ_panas, $μ_doc_1_10);
    $z3 = 0.5 * $pakan_per_frekuensi;

    // R4: Dingin AND doc_11_20
    $μ_R4 = min($μ_dingin, $μ_doc_11_20);
    $z4 = 0.5 * $pakan_per_frekuensi;

    // R5: Normal AND doc_11_20
    $μ_R5 = min($μ_normal, $μ_doc_11_20);
    $z5 = $pakan_per_frekuensi;

    // R6: Panas AND doc_11_20
    $μ_R6 = min($μ_panas, $μ_doc_11_20);
    $z6 = 0.5 * $pakan_per_frekuensi;

    // R7: Dingin AND doc_21_30
    $μ_R7 = min($μ_dingin, $μ_doc_21_30);
    $z7 = 0.5 * $pakan_per_frekuensi;

    // R8: Normal AND doc_21_30
    $μ_R8 = min($μ_normal, $μ_doc_21_30);
    $z8 = $pakan_per_frekuensi;

    // R9: Panas AND doc_21_30
    $μ_R9 = min($μ_panas, $μ_doc_21_30);
    $z9 = 0.5 * $pakan_per_frekuensi;

    // **3. Defuzzifikasi (Sugeno - Weighted Average)**
    $numerator = ($μ_R1 * $z1) + ($μ_R2 * $z2) + ($μ_R3 * $z3) +
                 ($μ_R4 * $z4) + ($μ_R5 * $z5) + ($μ_R6 * $z6) +
                 ($μ_R7 * $z7) + ($μ_R8 * $z8) + ($μ_R9 * $z9);

    $denominator = $μ_R1 + $μ_R2 + $μ_R3 + $μ_R4 + $μ_R5 + $μ_R6 + $μ_R7 + $μ_R8 + $μ_R9;

    $z_akhir = $denominator > 0 ? $numerator / $denominator : 0;

    echo "Suhu: $suhu, Umur: $umur, Pakan: $pakan_per_frekuensi <br>";
    echo "μ_dingin: $μ_dingin, μ_normal: $μ_normal, μ_panas: $μ_panas <br>";
    echo "μ_doc_1_10: $μ_doc_1_10, μ_doc_11_20: $μ_doc_11_20, μ_doc_21_30: $μ_doc_21_30 <br>";
    echo "μ_R1: $μ_R1, z1: $z1, μ_R2: $μ_R2, z2: $z2, ...<br>";
    echo "Numerator: $numerator, Denominator: $denominator <br>";

// 4. Simpan hasil fuzzy ke database
$update_data = [
    'fuzzy_pakan' => $z_akhir
];

$jadwal_db = $data['jadwal'];

$this->db->where('tanggal', $data['tanggal']);
$this->db->where('jadwal', $jadwal_db); // ← pakai ini saja

$this->db->update('jadwal_udang', $update_data);

// DEBUG
echo $this->db->last_query();
die;

    return "Nilai fuzzy_pakan berhasil dihitung dan disimpan: " . $z_akhir;
}



    public function get_matching_jadwal($currentDate, $currentTime)
    {
        $this->db->select('*');
        $this->db->from('jadwal_udang');
        $this->db->where('tanggal', $currentDate);
        $this->db->where('jadwal', $currentTime);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Jika ada jadwal yang cocok, kembalikan data
        } else {
            return null; // Tidak ada jadwal yang cocok
        }
    }

    public function updateSuhu($suhu) {
        $currentTime = date('H:i');
        $currentDate = date('Y-m-d');

        $this->db->set('suhu', $suhu);
        $this->db->where('tanggal', $currentDate);
        $this->db->where("TIME_FORMAT(jadwal, '%H:%i') =", $currentTime);
        $this->db->update('jadwal_udang');

        // 🔥 langsung hitung fuzzy
        $this->hitung_fuzzy_pakan();
    }

        // public function getFuzzyPakan($tanggal, $jadwal) {
        //     $this->db->select('fuzzy_pakan');
        //     $this->db->from('jadwal_udang');
        //     $this->db->where('tanggal', $tanggal);
        //     $this->db->where('jadwal', $jadwal);
        //     $query = $this->db->get();
    
        //     if ($query->num_rows() > 0) {
        //         return $query->row()->fuzzy_pakan;
        //     }
        //     return null;
        // }
public function getFuzzyPakan($tanggal, $jadwal) {
    $this->db->select('fuzzy_pakan');
    $this->db->from('jadwal_udang');
    $this->db->where('tanggal', $tanggal);
    // Cocokkan hanya jam dan menit
    $this->db->where("DATE_FORMAT(jadwal, '%H:%i') =", $jadwal);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->fuzzy_pakan;
    }
    return null;
}

public function simpan_berat_akhir_by_datetime($tanggal, $jam_menit, $berat)
{
    $this->db->where('tanggal', $tanggal);
    $this->db->where('TIME_FORMAT(jadwal, "%H:%i") =', $jam_menit);
    
    return $this->db->update('jadwal_udang', [
        'berat_akhir' => $berat
    ]);
}

}

