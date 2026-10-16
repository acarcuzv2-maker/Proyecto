<?php

namespace App\Filters;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SesionRecordadaModel;

class AccesoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $sesionActual = session();

    if (! $sesionActual->get('sesion_activa')) {
        $claveGuardada = (string) service('request')->getCookie('sesion_recordada');
        if ($claveGuardada === '') {
            return redirect()->to(site_url('login'));
        }

        $archivoSesiones = new SesionRecordadaModel();

        $registroSesion = $archivoSesiones
            ->where('token_hash', hash('sha256', $claveGuardada))
            ->first();

        if (
            ! $registroSesion ||
            strtotime($registroSesion['expira_en']) <= time()
        ) {
            return redirect()->to(site_url('login'));
        }

        $archivoUsuarios = new UsuarioModel();

        $cuentaRecordada = $archivoUsuarios->find(
            $registroSesion['usuario_id']
        );

        if (
            ! $cuentaRecordada ||
            (int) $cuentaRecordada['activo'] !== 1
        ) {
            $archivoSesiones->delete($registroSesion['id']);

            return redirect()->to(site_url('login'));
        }

        $sesionActual->regenerate();

        $sesionActual->set([
            'cuenta_id' => $cuentaRecordada['id'],
            'cuenta_nombre' => $cuentaRecordada['nombre'],
            'cuenta_rol' => $cuentaRecordada['rol'],
            'sesion_activa' => true
        ]);

        $claveRenovada = bin2hex(random_bytes(32));

        $archivoSesiones->update($registroSesion['id'], [
            'token_hash' => hash('sha256', $claveRenovada)
        ]);

        $respuesta = redirect()->to(site_url('panel'));

        $respuesta->setCookie(
            'sesion_recordada',
            $claveRenovada,
            max(1, strtotime($registroSesion['expira_en']) - time()),
            '',
            '/',
            '',
            service('request')->isSecure(),
            true,
            'Lax'
        );

        return $respuesta;
    }
        $idCuenta = (int) $sesionActual->get('cuenta_id');

        if ($idCuenta <= 0) {
            $sesionActual->destroy();

            return redirect()->to(site_url('login'));
        }

        $archivoUsuarios = new UsuarioModel();

        $cuentaEncontrada = $archivoUsuarios->find($idCuenta);

        if (! $cuentaEncontrada || (int) $cuentaEncontrada['activo'] !== 1) {
            $sesionActual->destroy();

            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Tu cuenta ya no está activa.');
        }

        $sesionActual->set([
            'cuenta_nombre' => $cuentaEncontrada['nombre'],
            'cuenta_rol' => $cuentaEncontrada['rol']
        ]);

        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}