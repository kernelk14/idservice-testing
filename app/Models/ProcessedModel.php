<?php

namespace App\Models;

use CodeIgniter\Model;

class ProcessedModel extends Model
{
    protected $table            = 'processed';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['userId', 'processed_by'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'processed_at';
    protected $updatedField  = '';
    protected $deletedField  = '';
}
