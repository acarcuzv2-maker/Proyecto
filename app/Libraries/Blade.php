<?php

namespace App\Libraries;

use eftec\bladeone\BladeOne;

class Blade
{
    private BladeOne $blade;

    public function __construct()
    {
        $vistas = APPPATH . 'Views';
        $cache = WRITEPATH . 'cache/blade';

        if (!is_dir($cache)) {
            mkdir($cache, 0775, true);
        }

        $this->blade = new BladeOne(
            $vistas,
            $cache,
            BladeOne::MODE_AUTO
        );
    }

    public function render(string $vista, array $datos = []): string
    {
        return $this->blade->run($vista, $datos);
    }
}