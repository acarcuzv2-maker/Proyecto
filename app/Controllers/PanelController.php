<?php

namespace App\Controllers;

use App\Libraries\Blade;
use App\Models\TareaModel;

class PanelController extends BaseController
{
    public function inicio()
    {
        $motorVistas = new Blade();

        return $motorVistas->render('dashboard.index', [
            'nombreCuenta' => session()->get('cuenta_nombre'),
            'rolCuenta' => session()->get('cuenta_rol')
        ]);
    }

    public function tareas()
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to(site_url('login'));
        }

        $sort = (string) $this->request->getGet('orden');
        $search = trim((string) $this->request->getGet('buscar'));

        if (! in_array($sort, ['recientes', 'antiguas'], true)) {
            $sort = 'recientes';
        }

        $direction = $sort === 'antiguas' ? 'ASC' : 'DESC';

        $taskModel = new TareaModel();

        $taskModel->where('usuario_id', session()->get('cuenta_id'));

        if ($search !== '') {
            $taskModel->like('descripcion', $search);
        }

        $tasks = $taskModel
            ->orderBy('creado_en', $direction)
            ->orderBy('id', $direction)
            ->findAll();

        $blade = new Blade();

        return $blade->render('tasks.index', [
            'nombreCuenta' => session()->get('cuenta_nombre'),
            'rolCuenta' => session()->get('cuenta_rol'),
            'misTareas' => $tasks,
            'ordenElegido' => $sort,
            'busqueda' => $search
        ]);
    }
}