<?php

namespace App\Models;

use CodeIgniter\Model;

class CredencialTemporalModel extends Model
{
    protected $table = 'credenciales_temporales';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'usuario_id',
        'token_hash',
        'tipo',
        'expira_en'
    ];

    protected $useTimestamps = false;
}