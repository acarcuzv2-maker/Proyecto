<?php

namespace App\Models;

use CodeIgniter\Model;

class TareaModel extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'usuario_id',
        'descripcion'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';

    protected $validationRules = [
        'usuario_id' => 'required|is_natural_no_zero',
        'descripcion' => 'required|min_length[3]'
    ];

    protected $validationMessages = [
        'descripcion' => [
            'required' => 'La descripción de la tarea es obligatoria.'
        ]
    ];
}