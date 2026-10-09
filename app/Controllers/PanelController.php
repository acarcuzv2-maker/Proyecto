<?php

namespace App\Controllers;

use App\Libraries\Blade;

class PanelController extends BaseController
{
    public function inicio()
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to('/login');
        }

        $motorVistas = new Blade();

        return $motorVistas->render('panel.inicio', [
            'nombreCuenta' => session()->get('cuenta_nombre'),
            'rolCuenta' => session()->get('cuenta_rol')
        ]);
    }
}