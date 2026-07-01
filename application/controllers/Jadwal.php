<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Controller: Jadwal.php

class Jadwal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_udang_model');
        $this->load->model('Data_udang_model');
        $this->load->model('Tb_jadwal_pakan_model');
        $this->load->model('Umur_udang_model');
    }

    public function index()
    {
        $data = ['page' => "Data_udang"];
        // Panggil fungsi perhitungan pakan harian
        $this->hitung_pakan_harian();

        // Ambil data untuk ditampilkan di view
        $data['data_udang'] = $this->Jadwal_udang_model->get_all_data_udang();

        $data['data_udang'] = $this->Jadwal_udang_model->get_data_udang_with_frekuensi_pakan();

        $data['jadwal_today'] = $this->Jadwal_udang_model->getTodayJadwal();

        // ==========================
        // Hitung selisih berat_akhir vs fuzzy_pakan
        // ==========================
        $data['selisih_berat_fuzzy'] = [];

        foreach ($data['jadwal_today'] as $jadwal) {
            if (!is_null($jadwal->berat_akhir) && !is_null($jadwal->fuzzy_pakan) && $jadwal->fuzzy_pakan != 0) {
                $selisih = $jadwal->berat_akhir - $jadwal->fuzzy_pakan;
                $selisih_percent = ($selisih / $jadwal->fuzzy_pakan) * 100;
            } else {
                $selisih = null;
                $selisih_percent = null;
            }

            $data['selisih_berat_fuzzy'][] = [
                'jadwal' => $jadwal->jadwal,
                'tanggal' => $jadwal->tanggal,
                'berat_akhir' => $jadwal->berat_akhir,
                'fuzzy_pakan' => $jadwal->fuzzy_pakan,
                'selisih' => $selisih,
                'selisih_percent' => $selisih_percent
            ];
        }

        
        $data['umur_udang_options'] = $this->Umur_udang_model->get_all_umur_udang();
        $data['data_udang'] = $this->Data_udang_model->get_all_data();
        $data['data_udang'] = $this->Data_udang_model->get_all_data_with_umur();

        // Mengambil data suhu, pakan_per_frekuensi, dan umur_udang yang sesuai dengan waktu saat ini
        $data['suhu_pakan_umur_data'] = $this->Jadwal_udang_model->get_suhu_pakan_and_umur_by_jadwal();
        

        // Ambil data udang dari model
        $data_udang = $this->Jadwal_udang_model->get_data_udang();

        foreach ($data_udang as &$udang) {
            // Tentukan frekuensi pakan berdasarkan umur_udang
            if ($udang['umur_udang'] >= 1 && $udang['umur_udang'] <= 10) {
                $frekuensi = 4;
            } elseif ($udang['umur_udang'] >= 11 && $udang['umur_udang'] <= 20) {
                $frekuensi = 6;
            } elseif ($udang['umur_udang'] >= 21 && $udang['umur_udang'] <= 30) {
                $frekuensi = 8;
            } else {
                $frekuensi = 0; // Default jika umur_udang tidak valid
            }

            // Hitung nilai pakan per frekuensi
            if ($frekuensi > 0 && isset($udang['pakan_harian'])) {
                $udang['pakan_per_frekuensi'] = $udang['pakan_harian'] / $frekuensi;

                // Simpan hasil ke tabel jadwal_udang
                $this->Jadwal_udang_model->update_pakan_per_frekuensi($udang['id_data'], $udang['pakan_per_frekuensi']);
            } else {
                $udang['pakan_per_frekuensi'] = 0; // Default jika tidak valid
            }
        }

        $data['data_udang'] = $data_udang;

        $this->load->view('jadwal_today/index', $data);
    }

    public function edit($id_jadwal_udang)
    {
        $data = ['page' => "Data_udang"];
        $data['jadwal'] = $this->Jadwal_udang_model->getById($id_jadwal_udang);
        if (!$data['jadwal']) {
            show_404();
        }
        $this->load->view('jadwal_today/edit', $data);
    }

    public function update($id_jadwal_udang)
    {
        $this->form_validation->set_rules('jadwal', 'Jadwal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id_jadwal_udang);
        } else {
            $data = [
                'jadwal' => $this->input->post('jadwal')
            ];
            $this->Jadwal_udang_model->update($id_jadwal_udang, $data);
            $this->session->set_flashdata('success', 'Jadwal berhasil diupdate.');
            redirect('Jadwal');
        }
    }

    public function delete($id_jadwal_udang)
    {
        $this->Jadwal_udang_model->delete($id_jadwal_udang);
        $this->session->set_flashdata('success', 'Jadwal berhasil dihapus.');
        redirect('Jadwal');
    }

    private function hitung_pakan_harian()
    {
        // Ambil semua data udang dari tabel data_udang
        $data_udang = $this->Jadwal_udang_model->get_all_data_udang();

        if (!$data_udang) {
            return; // Tidak ada data udang
        }

        foreach ($data_udang as $udang) {
            $populasi = $udang['populasi'];
            $umur_udang = $udang['umur_udang'];
            $id_data = $udang['id_data'];

            // Menghitung pakan berdasarkan umur
            $pakan_harian = ($populasi * 2) / 100;  // Pakan dasar untuk umur 1

            if ($umur_udang > 1) {
                // Hitung tambahan berdasarkan umur
                if ($umur_udang >= 2 && $umur_udang <= 10) {
                    $pakan_harian += (200 * ($umur_udang - 1)); // Tambah 200 setiap umur
                } elseif ($umur_udang >= 11 && $umur_udang <= 20) {
                    $pakan_harian += (200 * 9) + (400 * ($umur_udang - 10)); // Tambah 400 setiap umur
                } elseif ($umur_udang >= 21 && $umur_udang <= 30) {
                    $pakan_harian += (200 * 9) + (400 * 10) + (600 * ($umur_udang - 20)); // Tambah 600 setiap umur
                }
            }

            // Simpan hasil ke tabel data_udang
            $this->Jadwal_udang_model->update_pakan_harian($id_data, $pakan_harian);
        }
    }

    public function hitung_fuzzy()
    {
        // Ambil waktu sekarang (tanggal dan jam)
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');

        // Panggil model untuk mengecek apakah ada jadwal yang sesuai dengan waktu sekarang
        $this->load->model('Jadwal_udang_model');
        $matchingJadwal = $this->Jadwal_udang_model->get_matching_jadwal($currentDate, $currentTime);

        // Jika ada jadwal yang cocok, jalankan perhitungan fuzzy
        if ($matchingJadwal) {
            $result = $this->Jadwal_udang_model->hitung_fuzzy_pakan();
            echo $result; // Kirimkan hasil ke view
        } else {
            echo "No matching schedule found.";
        }

        // Redirect atau lakukan aksi lain jika diperlukan
        redirect('jadwal');
    }

    // // Fungsi untuk dijalankan secara otomatis oleh cron job atau trigger
    // public function hitung_fuzzy_automatis()
    // {
    //     $this->load->model('Jadwal_udang_model');
    //     $this->Jadwal_udang_model->hitung_fuzzy_automatis();
    // }
    public function hitung_fuzzy_automatis()
    {
        $url = 'http://pakanudang.fasterstronger.my.id/Jadwal/hitung_fuzzy';

        // Menggunakan cURL untuk melakukan request HTTP
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Anda bisa menambahkan kode lain untuk menangani response jika diperlukan
        return $response;
    }

   public function update_suhu() {
    header('Content-Type: application/json');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!isset($data['suhu']) || !isset($data['tanggal']) || !isset($data['jadwal'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Parameter suhu, tanggal, dan jadwal diperlukan.'
        ]);
        return;
    }

    $suhu = $data['suhu'];
    $tanggal = $data['tanggal'];
    $jadwal = $data['jadwal'];

    // ✅ update suhu
    $this->db->set('suhu', $suhu);
    $this->db->where('tanggal', $tanggal);
    $this->db->where("TIME_FORMAT(jadwal, '%H:%i') =", $jadwal);
    $this->db->update('jadwal_udang');

    // 🔥 WAJIB: HITUNG FUZZY
    $this->Jadwal_udang_model->hitung_fuzzy_pakan();

    echo json_encode([
        'status' => 'success',
        'message' => 'Suhu dan fuzzy berhasil diperbarui'
    ]);
}

    //  public function update_berat()
    // {
    //     header('Content-Type: application/json');
    //     date_default_timezone_set('Asia/Jakarta');

    //     $json = file_get_contents('php://input');
    //     $data = json_decode($json, true);

    //     if (!isset($data['berat'])) {
    //         echo json_encode(['status' => 'error', 'message' => 'Berat tidak dikirim']);
    //         return;
    //     }

    //     $tanggal = date('Y-m-d');
    //     $jadwal = date('H:i');
    //     $berat = $data['berat'];

    //     $result = $this->Jadwal_udang_model->update_berat_akhir($tanggal, $jadwal, $berat);

    //     echo json_encode($result);
    // }
    
    // public function get_fuzzy_pakan() {
    //     $tanggal = date('Y-m-d');
    //     $jadwal = date('H:i:s');

    //     $this->db->where('tanggal', $tanggal);
    //     $this->db->where('jadwal', $jadwal);
    //     $data = $this->db->get('jadwal_udang')->row();

    //     if ($data) {
    //         echo json_encode(['fuzzy_pakan' => $data->fuzzy_pakan]);
    //     } else {
    //         echo json_encode(['fuzzy_pakan' => 0]);
    //     }
    // }

public function getFuzzyPakan() {
    date_default_timezone_set('Asia/Jakarta');

    $tanggal = date('Y-m-d');
    $jam = date('H:i');

    // Ambil jadwal TERDEKAT KE DEPAN
    $this->db->select('*');
    $this->db->from('jadwal_udang');
    $this->db->where('tanggal', $tanggal);
    $this->db->where("TIME(jadwal) >=", $jam);
    $this->db->order_by('jadwal', 'ASC');
    $this->db->limit(1);

    $row = $this->db->get()->row();

    // 🔥 Jika tidak ada (semua jadwal hari ini sudah lewat)
    if (!$row) {
        $this->db->select('*');
        $this->db->from('jadwal_udang');
        $this->db->where('tanggal >=', $tanggal);
        $this->db->order_by('tanggal', 'ASC');
        $this->db->order_by('jadwal', 'ASC');
        $this->db->limit(1);

        $row = $this->db->get()->row();
    }

    if (!$row) {
        echo json_encode([
            'status' => 'error',
            'fuzzy_pakan' => 0,
            'jadwal' => $jam
        ]);
        return;
    }

    echo json_encode([
        'status' => 'success',
        'fuzzy_pakan' => $row->fuzzy_pakan,
        'jadwal' => date('H:i', strtotime($row->jadwal))
    ]);
}

public function simpan_berat()
{
    $berat = $this->input->get('berat');

    if (!$berat || !is_numeric($berat)) {
        echo json_encode([
            'status' => false,
            'message' => 'DATA TIDAK LENGKAP / BERAT TIDAK VALID'
        ]);
        return;
    }

    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d');
    // $jamMenit = date('H:i');
    $jamMenit = $this->input->get('waktu') ? $this->input->get('waktu') : date('H:i');

    $this->load->model('Jadwal_udang_model');

    $update = $this->Jadwal_udang_model
        ->simpan_berat_akhir_by_datetime($tanggal, $jamMenit, $berat);

    if ($update) {
        echo json_encode([
            'status' => true,
            'message' => 'Berat akhir tersimpan'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Gagal update data jadwal'
        ]);
    }
}

public function get_jadwal_today()
{
    $this->load->model('Jadwal_udang_model');

    $data = $this->Jadwal_udang_model->getTodayJadwal();

    echo json_encode($data);
}
    
}
