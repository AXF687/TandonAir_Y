<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeModel;

class ModeController extends BaseController
{
    protected $modeModel;

    public function __construct()
    {
        $this->modeModel = new ModeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Mode Pengaturan',
            'mode'  => $this->modeModel->getMode(),
        ];
        return view('mode/index', $data);
    }

    public function switchMode()
    {
        if ($this->request->isAJAX()) {
            $mode = $this->request->getVar('mode'); // Ambil mode dari request
            $this->modeModel->updateMode($mode);   // Update mode

            echo json_encode(['success' => 'Mode berhasil diubah menjadi ' . $mode]);
        } else {
            exit('404 Not Found');
        }
    }
}