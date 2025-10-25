<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PompaModel;

class PompaController extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('pompa');
    }

    public function index()
    {
        $data = [
            'title' => 'Pompa',
            'dataPompa' => $this->PompaModel->where('id', 1)->findAll()
        ];

        return view('pompa/index', $data);

        $modeModel = new ModeModel();
        $mode = $modeModel->getMode();

        if ($mode->mode === 'Manual') {
            return redirect()->to(base_url('manual')); // Redirect ke manual jika mode Manual
        } elseif ($mode->mode === 'Auto') {
            return redirect()->to(base_url('pompa')); // Redirect ke auto jika mode Auto
        }
    }

    public function cekpompa()
    {
        $data = [
            'dataPompa' => $this->PompaModel->where('id', 1)->findAll()
        ];
        return view('pompa/cekpompa', $data);
    }

    public function getPompa()
    {
        $db = \Config\Database::connect();
        $data = [];
        $query = $db->query("SELECT * FROM pompa WHERE id = 1");

        $row = $query->getRowArray();
        $data[] = $row; //tampilkan seluruh data array, jika menampilkan perkolom $data[] = $row['suhu'];

        echo json_encode($data);
    }

    public function update($pompa)
    {
        $request = \Config\Services::request();
        $path = $request->getPath();

        $segments = explode('/', $path);

        $segment1 = $segments[1];
        // $segment2 = $segments[2];

        $updateData = array(
            'pompa' => $segment1,
            // 'kelembaban' => $segment2,
        );

        $this->builder->where('id', 1);
        $this->builder->update($updateData);
        return redirect()->to(base_url('pompa'));
    }

    public function ganti()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM pompa WHERE id = $id");
            $manual = $query->getRow()->manual;

            if ($manual == 0) {
                $data = [
                    'manual'  => '1',
                ];
                $this->builder->where('id', $id);
                $this->builder->update($data);
                $result = [
                    'success' => 'Relay OFF'
                ];
            } else {
                $data = [
                    'manual'  => '0',
                ];
                $this->builder->where('id', $id);
                $this->builder->update($data);
                $result = [
                    'success' => 'Relay ON'
                ];
            }

            echo json_encode($result);
        } else {
            exit('404 Not Found!');
        }
    }
}
