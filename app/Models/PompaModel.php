<?php

namespace App\Models;

use CodeIgniter\Model;

class PompaModel extends Model
{
    protected $table            = 'pompa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pompa', 'manual',];

    public function getPompa()
    {
        return $this->findAll();
    }
   
}