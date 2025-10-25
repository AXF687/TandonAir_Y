<?php

namespace App\Models;

use CodeIgniter\Model;

class KendaliModel extends Model
{
    protected $table            = 'kendalirelay';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['relay'];
}
