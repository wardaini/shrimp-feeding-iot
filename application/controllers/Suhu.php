<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suhu extends CI_Controller {

    public function update_suhu_realtime()
    {
        // Ambil input dari request JSON
        $input = json_decode($this->input->raw_input_stream, true);

        if (isset($input['suhu'])) {
            $suhu = $input['suhu'];

            // Load model untuk update database
            $this->load->model('Suhu_model');

            // Simpan data suhu ke database
            $result = $this->Suhu_model->update_suhu($suhu);

            if ($result) {
                // Kirim respons sukses
                echo json_encode(['status' => 'success', 'message' => 'Suhu updated']);
            } else {
                // Kirim respons gagal
                echo json_encode(['status' => 'error', 'message' => 'Failed to update suhu']);
            }
        } else {
            // Input tidak valid
            echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        }
    }

    // ambil data suhu terakhir
    public function get_latest() {
        $query = $this->db->order_by('id', 'DESC')->limit(1)->get('suhu_realtime');
        $data = $query->row();

        echo json_encode($data);
    }

}
