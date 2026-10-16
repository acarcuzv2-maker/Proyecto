<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CredencialTemporalModel;
use App\Libraries\Blade;
use App\Models\SesionRecordadaModel;

class AuthController extends BaseController
{
    public function registrar()
    {
        $motorVistas = new Blade();

        return $motorVistas->render('auth.register', [
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
        $correoSalida->setSubject('Activa tu cuenta - Basicos Mariano G');

        $correoSalida->setMessage(
            '<h2>¡Bienvenido a Básicos Mariano G!</h2>' .
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
        $plantillas = new \App\Libraries\Blade();

        return $plantillas->render('auth.login', [
            'titulo' => 'Iniciar sesión'
        ]);
    }

    public function comprobarAcceso()
    {
        $correoIngresado = strtolower(
            trim((string) $this->request->getPost('email'))
        );

        $claveIngresada = (string) $this->request->getPost('password');

        $archivoUsuarios = new UsuarioModel();

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
                ->to(site_url('login'))
                ->with('error', 'Correo o contraseña incorrectos.');
        }

        if ((int) $cuentaEncontrada['activo'] !== 1) {
            return redirect()
                ->to(site_url('login'))
                ->with('error', 'Debes activar tu cuenta desde el correo electrónico.');
        }

        session()->regenerate();

        session()->set([
            'cuenta_id' => $cuentaEncontrada['id'],
            'cuenta_nombre' => $cuentaEncontrada['nombre'],
            'cuenta_rol' => $cuentaEncontrada['rol'],
            'sesion_activa' => true
        ]);

        if ($this->request->getPost('recordarme') === '1') {
            $claveRecordada = bin2hex(random_bytes(32));

            $archivoSesiones = new SesionRecordadaModel();

            $resultadoGuardado = $archivoSesiones->insert([
                'usuario_id' => $cuentaEncontrada['id'],
                'token_hash' => hash('sha256', $claveRecordada),
                'expira_en' => date('Y-m-d H:i:s', time() + 604800)
            ]);

            if ($resultadoGuardado !== false) {
                $claveAnterior = (string) $this->request->getCookie('sesion_recordada');

                if ($claveAnterior !== '') {
                    $archivoSesiones = new SesionRecordadaModel();

                    $archivoSesiones
                        ->where('token_hash', hash('sha256', $claveAnterior))
                        ->delete();
                }

                $respuesta = redirect()->to(site_url('panel'));

                $respuesta->setCookie(
                    'sesion_recordada',
                    '',
                    -3600,
                    '',
                    '/',
                    '',
                    $this->request->isSecure(),
                    true,
                    'Lax'
                );

                return $respuesta;
            }
        }

        return redirect()->to(site_url('panel'));
    }

    public function cerrarSesion()
    {
        $claveGuardada = (string) $this->request->getCookie('sesion_recordada');

        if ($claveGuardada !== '') {
            $archivoSesiones = new SesionRecordadaModel();

            $archivoSesiones
                ->where('token_hash', hash('sha256', $claveGuardada))
                ->delete();
        }

        session()->destroy();

        $respuesta = redirect()->to(site_url('login'));

        $respuesta->setCookie(
            'sesion_recordada',
            '',
            -3600,
            '',
            '/',
            '',
            $this->request->isSecure(),
            true,
            'Lax'
        );

        return $respuesta;
    }
            
    public function pedirRecuperacion()
    {
        $motorVistas = new Blade();

        return $motorVistas->render('auth.forgot_password');
    }

    public function enviarRecuperacion()
    {
        $correoBuscado = strtolower(
            trim((string) $this->request->getPost('email'))
        );

        if (! filter_var($correoBuscado, FILTER_VALIDATE_EMAIL)) {
            return redirect()
                ->to('/recuperar')
                ->with('error', 'Ingresa un correo electrónico válido.');
        }

        $archivoUsuarios = new UsuarioModel();

        $cuentaEncontrada = $archivoUsuarios
            ->where('email', $correoBuscado)
            ->where('activo', 1)
            ->first();

        $avisoGeneral = 'Si el correo está registrado y activo, recibirás un enlace para recuperar tu contraseña.';

        if (! $cuentaEncontrada) {
            return redirect()
                ->to('/recuperar')
                ->with('mensaje', $avisoGeneral);
        }

        try {
            $archivoClaves = new CredencialTemporalModel();

            $archivoClaves
                ->where('usuario_id', $cuentaEncontrada['id'])
                ->where('tipo', 'recuperacion')
                ->delete();

            $claveNueva = bin2hex(random_bytes(32));

            $resultadoClave = $archivoClaves->insert([
                'usuario_id' => $cuentaEncontrada['id'],
                'token_hash' => hash('sha256', $claveNueva),
                'tipo' => 'recuperacion',
                'expira_en' => date('Y-m-d H:i:s', time() + 3600)
            ]);

            if ($resultadoClave === false) {
                throw new \RuntimeException('No se pudo guardar la clave temporal.');
            }

            $enlaceNuevo = site_url(
                'restablecer/' . rawurlencode($claveNueva)
            );

            $correoSalida = service('email');

            $correoSalida->setTo($correoBuscado);
            $correoSalida->setSubject('Recupera tu contraseña - Básicos Mariano G');

            $correoSalida->setMessage(
                '<h2>Recuperación de contraseña</h2>' .
                '<p>Recibimos una solicitud para cambiar tu contraseña.</p>' .
                '<p><a href="' . esc($enlaceNuevo, 'attr') . '">Crear nueva contraseña</a></p>' .
                '<p>Este enlace vence dentro de una hora.</p>' .
                '<p>Si no solicitaste este cambio, puedes ignorar el mensaje.</p>'
            );

            if (! $correoSalida->send()) {
                throw new \RuntimeException('No se pudo enviar el correo.');
            }
        } catch (\Throwable $problemaCorreo) {
            log_message(
                'error',
                'Recuperación de contraseña: ' . $problemaCorreo->getMessage()
            );
        }

        return redirect()
            ->to('/recuperar')
            ->with('mensaje', $avisoGeneral);
    }

    public function mostrarNuevaClave(string $claveRecibida)
    {
        $archivoClaves = new CredencialTemporalModel();

        $registroClave = $archivoClaves
            ->where('token_hash', hash('sha256', $claveRecibida))
            ->where('tipo', 'recuperacion')
            ->first();

        if (! $registroClave || strtotime($registroClave['expira_en']) <= time()) {
            return redirect()
                ->to('/recuperar')
                ->with('error', 'El enlace no es válido o ha vencido.');
        }

        $motorVistas = new Blade();

        return $motorVistas->render('auth.reset_password', [
            'claveRecibida' => $claveRecibida
        ]);
    }

    public function guardarNuevaClave()
    {
        $claveRecibida = (string) $this->request->getPost('clave_temporal');
        $contrasenaNueva = (string) $this->request->getPost('password');
        $confirmacionNueva = (string) $this->request->getPost('confirmar_password');

        $archivoClaves = new CredencialTemporalModel();

        $registroClave = $archivoClaves
            ->where('token_hash', hash('sha256', $claveRecibida))
            ->where('tipo', 'recuperacion')
            ->first();

        if (! $registroClave || strtotime($registroClave['expira_en']) <= time()) {
            return redirect()
                ->to('/recuperar')
                ->with('error', 'El enlace no es válido o ha vencido.');
        }

        if (strlen($contrasenaNueva) < 8) {
            return redirect()
                ->to('/restablecer/' . rawurlencode($claveRecibida))
                ->with('error', 'La contraseña debe tener al menos 8 caracteres.');
        }

        if ($contrasenaNueva !== $confirmacionNueva) {
            return redirect()
                ->to('/restablecer/' . rawurlencode($claveRecibida))
                ->with('error', 'Las contraseñas no coinciden.');
        }

        $archivoUsuarios = new UsuarioModel();

        $resultadoCambio = $archivoUsuarios->update(
            $registroClave['usuario_id'],
            [
                'password' => password_hash(
                    $contrasenaNueva,
                    PASSWORD_DEFAULT
                )
            ]
        );

        if ($resultadoCambio === false) {
            return redirect()
                ->to('/restablecer/' . rawurlencode($claveRecibida))
                ->with('error', 'No pudimos actualizar tu contraseña.');
        }

        $archivoSesiones = new \App\Models\SesionRecordadaModel();

        $archivoSesiones
            ->where('usuario_id', $registroClave['usuario_id'])
            ->delete();
        $archivoClaves->delete($registroClave['id']);

        return redirect()
            ->to('/login')
            ->with('mensaje', 'Tu contraseña fue actualizada. Ya puedes iniciar sesión.');
    }

}