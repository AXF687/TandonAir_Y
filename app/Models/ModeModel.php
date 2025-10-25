<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeModel extends Model
{
    protected $table            = 'mode';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mode'];

    public function getMode()
    {
        return $this->find(1); // Ambil data mode dengan ID 1
    }

    public function updateMode($mode)
    {
        return $this->update(1, ['mode' => $mode]); // Update mode dengan ID 1
    }
}