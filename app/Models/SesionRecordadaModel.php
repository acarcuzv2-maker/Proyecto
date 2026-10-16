<?php

namespace App\Models;

use CodeIgniter\Model;

class SesionRecordadaModel extends Model
{
    protected $table = 'sesiones_recordadas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'usuario_id',
        'token_hash',
        'expira_en'
    ];

    protected $useTimestamps = false;
}