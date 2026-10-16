<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $motorVistas = new \App\Libraries\Blade();

        return $motorVistas->render('welcome');
    }
}
