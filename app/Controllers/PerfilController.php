<?php

namespace App\Controllers;

use App\Libraries\Blade;
use App\Models\UsuarioModel;

class PerfilController extends BaseController
{
    public function mostrar()
    {
        $idCuenta = session()->get('cuenta_id');

        if (! session()->get('sesion_activa') || ! $idCuenta) {
            return redirect()->to('/login');
        }

        $archivoUsuarios = new UsuarioModel();

        $miCuenta = $archivoUsuarios->find($idCuenta);

        if (! $miCuenta) {
            return redirect()->to('/login');
        }

        $motorVistas = new Blade();

        return $motorVistas->render('perfil.inicio', [
            'miCuenta' => $miCuenta
        ]);
    }

    public function guardarCambios()
    {
        $idCuenta = session()->get('cuenta_id');

        if (! session()->get('sesion_activa') || ! $idCuenta) {
            return redirect()->to('/login');
        }

        $archivoUsuarios = new UsuarioModel();

        $miCuenta = $archivoUsuarios->find($idCuenta);

        if (! $miCuenta) {
            return redirect()->to('/login');
        }

        $nombreNuevo = trim((string) $this->request->getPost('nombre'));

        $correoNuevo = strtolower(
            trim((string) $this->request->getPost('email'))
        );

        $claveActual = (string) $this->request->getPost('password_actual');

        $claveNueva = (string) $this->request->getPost('password_nueva');

        $claveConfirmada = (string) $this->request->getPost('confirmar_password');

        if (mb_strlen($nombreNuevo) < 3 || mb_strlen($nombreNuevo) > 100) {
            return redirect()
                ->to('/perfil')
                ->with('error', 'El nombre debe tener entre 3 y 100 caracteres.');
        }

        if (! filter_var($correoNuevo, FILTER_VALIDATE_EMAIL) || mb_strlen($correoNuevo) > 150) {
            return redirect()
                ->to('/perfil')
                ->with('error', 'Ingresa un correo electrónico válido.');
        }

        if (! password_verify($claveActual, $miCuenta['password'])) {
            return redirect()
                ->to('/perfil')
                ->with('error', 'La contraseña actual no es correcta.');
        }

        $correoOcupado = $archivoUsuarios
            ->where('email', $correoNuevo)
            ->where('id !=', $idCuenta)
            ->first();

        if ($correoOcupado) {
            return redirect()
                ->to('/perfil')
                ->with('error', 'Ese correo ya pertenece a otra cuenta.');
        }

        $datosNuevos = [
            'nombre' => $nombreNuevo,
            'email' => $correoNuevo
        ];

        if ($claveNueva !== '') {
            if (strlen($claveNueva) < 8) {
                return redirect()
                    ->to('/perfil')
                    ->with('error', 'La contraseña nueva debe tener al menos 8 caracteres.');
            }

            if ($claveNueva !== $claveConfirmada) {
                return redirect()
                    ->to('/perfil')
                    ->with('error', 'Las contraseñas nuevas no coinciden.');
            }

            $datosNuevos['password'] = password_hash(
                $claveNueva,
                PASSWORD_DEFAULT
            );
        }


        $resultado = $archivoUsuarios->skipValidation(true)->update(
            $idCuenta,
            $datosNuevos
        );

        if ($resultado === false) {
            return redirect()
                ->to('/perfil')
                ->with('error', 'No pudimos guardar los cambios.');
        }
        if ($claveNueva !== '') {
            $archivoSesiones = new \App\Models\SesionRecordadaModel();

            $archivoSesiones
                ->where('usuario_id', $idCuenta)
                ->delete();
        }

        session()->set('cuenta_nombre', $nombreNuevo);

        return redirect()
            ->to('/perfil')
            ->with('mensaje', 'Tus datos fueron actualizados correctamente.');
    }

    public function guardarFoto()
        {

            $idCuenta = session()->get('cuenta_id');

            if (! session()->get('sesion_activa') || ! $idCuenta) {
                return redirect()->to('/login');
            }

            $archivoUsuarios = new UsuarioModel();
            $miCuenta = $archivoUsuarios->find($idCuenta);

            if (! $miCuenta) {
                return redirect()->to('/login');
            }

            $fotoRecibida = $this->request->getFile('foto');

            if (! $fotoRecibida || ! $fotoRecibida->isValid()) {
                return redirect()
                    ->to('/perfil')
                    ->with('error', 'Selecciona una fotografía válida.');
            }

            if ($fotoRecibida->getSize() > 2097152) {
                return redirect()
                    ->to('/perfil')
                    ->with('error', 'La fotografía no debe superar los 2 MB.');
            }

            $tipoFoto = $fotoRecibida->getMimeType();

            $formatosValidos = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            if (! isset($formatosValidos[$tipoFoto])) {
                return redirect()
                    ->to('/perfil')
                    ->with('error', 'Solo se permiten imágenes JPG, PNG o WEBP.');
            }

            $carpetaFotos = FCPATH . 'uploads/perfiles/';

            if (! is_dir($carpetaFotos) || ! is_writable($carpetaFotos)) {
                return redirect()
                    ->to('/perfil')
                    ->with('error', 'La carpeta de fotografías no está disponible.');
            }

            $nombreFoto = bin2hex(random_bytes(16)) . '.' . $formatosValidos[$tipoFoto];

            try {
                $fotoRecibida->move($carpetaFotos, $nombreFoto);

                $fotoAnterior = $miCuenta['imagen_perfil'] ?? '';

                $resultadoFoto = $archivoUsuarios
                    ->skipValidation(true)
                    ->update($idCuenta, [
                        'imagen_perfil' => $nombreFoto
                    ]);

                if ($resultadoFoto === false) {
                    @unlink($carpetaFotos . $nombreFoto);

                    return redirect()
                        ->to('/perfil')
                        ->with('error', 'No pudimos guardar tu fotografía.');
                }

                if ($fotoAnterior !== '') {
                    $rutaAnterior = $carpetaFotos . basename($fotoAnterior);

                    if (is_file($rutaAnterior)) {
                        unlink($rutaAnterior);
                    }
                }

                return redirect()
                    ->to('/perfil')
                    ->with('mensaje', 'Fotografía actualizada correctamente.');

            } catch (\Throwable $problemaFoto) {
                log_message('error', 'Error de fotografía: ' . $problemaFoto->getMessage());

                return redirect()
                    ->to('/perfil')
                    ->with('error', 'No pudimos subir la fotografía.');
            }
        }

        
        public function eliminarFoto()
    {
        $idCuenta = session()->get('cuenta_id');

        if (! session()->get('sesion_activa') || ! $idCuenta) {
            return redirect()->to('/login');
        }

        $archivoUsuarios = new UsuarioModel();
        $miCuenta = $archivoUsuarios->find($idCuenta);

        if (! $miCuenta) {
            return redirect()->to('/login');
        }

        $fotoAnterior = $miCuenta['imagen_perfil'] ?? '';

        if ($fotoAnterior === '') {
            return redirect()
                ->to('/perfil')
                ->with('error', 'No tienes una fotografía para eliminar.');
        }

        $resultado = $archivoUsuarios
            ->skipValidation(true)
            ->update($idCuenta, [
                'imagen_perfil' => null
            ]);

        if ($resultado === false) {
            return redirect()
                ->to('/perfil')
                ->with('error', 'No pudimos eliminar tu fotografía.');
        }

        $rutaFoto = FCPATH . 'uploads/perfiles/' . basename($fotoAnterior);

        if (is_file($rutaFoto)) {
            unlink($rutaFoto);
        }

        return redirect()
            ->to('/perfil')
            ->with('mensaje', 'Fotografía eliminada correctamente.');
    }

    }