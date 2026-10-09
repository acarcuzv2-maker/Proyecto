<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nombre',
        'email',
        'password',
        'rol',
        'activo',
        'imagen_perfil'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';

    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[150]',
        'password' => 'required|min_length[8]'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es obligatorio.'
        ],
        'email' => [
            'required' => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Ingresa un correo electrónico válido.'
        ],
        'password' => [
            'required' => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 8 caracteres.'
        ]
    ];
}