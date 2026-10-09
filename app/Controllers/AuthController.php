<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CredencialTemporalModel;
use App\Libraries\Blade;

class AuthController extends BaseController
{
    public function registrar()
    {
        $motorVistas = new Blade();

        return $motorVistas->render('auth.registro', [
            'titulo' => 'Crear cuenta'
        ]);
    }

    public function guardarRegistro()
    {
        $datosRegistro = [
            'nombre' => trim((string) $this->request->getPost('nombre')),
            'email' => strtolower(trim((string) $this->request->getPost('email'))),
            'password' => (string) $this->request->getPost('password'),
            'confirmar_password' => (string) $this->request->getPost('confirmar_password')
        ];

        $reglasRegistro = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[usuarios.email]',
            'password' => 'required|min_length[8]',
            'confirmar_password' => 'required|matches[password]'
        ];

        if (! $this->validateData($datosRegistro, $reglasRegistro)) {
            return redirect()
                ->to('/registro')
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $cuentaNueva = [
            'nombre' => $datosRegistro['nombre'],
            'email' => $datosRegistro['email'],
            'password' => password_hash(
                $datosRegistro['password'],
                PASSWORD_DEFAULT
            ),
            'rol' => 'usuario',
            'activo' => 0
        ];

        $archivoUsuarios = new UsuarioModel();

        $resultadoGuardado = $archivoUsuarios->insert($cuentaNueva);

        if ($resultadoGuardado === false) {
            return redirect()
                ->to('/registro')
                ->withInput()
                ->with('errores', $archivoUsuarios->errors());
        }

        $idCuenta = (int) $resultadoGuardado;

        try {
            $claveTemporal = $this->crearClaveActivacion($idCuenta);

            $correoEnviado = $this->mandarActivacion(
                $datosRegistro['email'],
                $claveTemporal
            );
        } catch (\Throwable $problemaCorreo) {
            log_message('error', 'Error de activación: ' . $problemaCorreo->getMessage());

            $correoEnviado = false;
        }

        if (! $correoEnviado) {
            return redirect()
                ->to('/registro')
                ->with(
                    'mensaje',
                    'Tu cuenta fue creada, pero no pudimos enviar el correo de activación.'
                );
        }

        return redirect()
            ->to('/registro')
            ->with(
                'mensaje',
                'Tu cuenta fue creada. Revisa tu correo electronico!.'
            );
    }
        
    private function crearClaveActivacion(int $idCuenta): string
    {
        $claveTemporal = bin2hex(random_bytes(32));

        $archivoClaves = new CredencialTemporalModel();

        $archivoClaves->insert([
            'usuario_id' => $idCuenta,
            'token_hash' => hash('sha256', $claveTemporal),
            'tipo' => 'activacion',
            'expira_en' => date('Y-m-d H:i:s', time() + 3600)
        ]);

        return $claveTemporal;
    }

    private function mandarActivacion(string $correoDestino, string $claveTemporal): bool
    {
        $enlaceActivacion = site_url(
            'activar/' . rawurlencode($claveTemporal)
        );

        $correoSalida = service('email');

        $correoSalida->setTo($correoDestino);
        $correoSalida->setSubject('Activa tu cuenta - Organizador Escolar');

        $correoSalida->setMessage(
            '<h2>¡Bienvenido al Organizador Escolar!</h2>' .
            '<p>Para activar tu cuenta, entra al siguiente enlace:</p>' .
            '<p><a href="' . esc($enlaceActivacion, 'attr') . '">Activar mi cuenta</a></p>' .
            '<p>Este enlace vence dentro de una hora.</p>'
        );

        return $correoSalida->send();
    }

    public function activarCuenta(string $claveTemporal)
    {
        $archivoClaves = new CredencialTemporalModel();
        $archivoUsuarios = new UsuarioModel();

        $huellaClave = hash('sha256', $claveTemporal);

        $registroClave = $archivoClaves
            ->where('token_hash', $huellaClave)
            ->where('tipo', 'activacion')
            ->first();

        if (! $registroClave) {
            return redirect()
                ->to('/registro')
                ->with('errores', [
                    'activacion' => 'El enlace de activación no es válido.'
                ]);
        }

        if (strtotime($registroClave['expira_en']) <= time()) {
            $archivoClaves->delete($registroClave['id']);

            return redirect()
                ->to('/registro')
                ->with('errores', [
                    'activacion' => 'El enlace venció.'
                ]);
        }

        $archivoUsuarios->update($registroClave['usuario_id'], [
            'activo' => 1
        ]);

        $archivoClaves->delete($registroClave['id']);

        return redirect()
            ->to('/registro')
            ->with(
                'mensaje',
                '¡Cuenta activada correctamente! Ya puedes iniciar sesión.'
            );
    }

        public function iniciarSesion()
    {
        $motorVistas = new \App\Libraries\Blade();

        return $motorVistas->render('auth.login', [
            'titulo' => 'Iniciar sesión'
        ]);
    }

    public function comprobarAcceso()
    {
        $correoIngresado = strtolower(
            trim((string) $this->request->getPost('email'))
        );

        $claveIngresada = (string) $this->request->getPost('password');

        $archivoUsuarios = new \App\Models\UsuarioModel();

        $cuentaEncontrada = $archivoUsuarios
            ->where('email', $correoIngresado)
            ->first();

        if (
            ! $cuentaEncontrada ||
            ! password_verify(
                $claveIngresada,
                $cuentaEncontrada['password']
            )
        ) {
            return redirect()
                ->to('/login')
                ->with('error', 'Correo o contraseña incorrectos.');
        }

        if ((int) $cuentaEncontrada['activo'] !== 1) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Debes activar tu cuenta desde el correo electrónico.'
                );
        }

        session()->regenerate();

        session()->set([
            'cuenta_id' => $cuentaEncontrada['id'],
            'cuenta_nombre' => $cuentaEncontrada['nombre'],
            'cuenta_rol' => $cuentaEncontrada['rol'],
            'sesion_activa' => true
        ]);

        return redirect()->to('/panel');
    }

    public function cerrarSesion()
    {
        // Eliminamos los datos de autenticación.
        session()->destroy();

        return redirect()->to('/login');
    }

        
}