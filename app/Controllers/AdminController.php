<?php

namespace App\Controllers;

use App\Libraries\Blade;
use App\Models\UsuarioModel;

class AdminController extends BaseController
{
    public function usuarios()
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()
                ->to(site_url('panel'))
                ->with('error', 'No tienes permiso para entrar a esta sección.');
        }

        $ordenElegido = (string) $this->request->getGet('orden');

        if (! in_array($ordenElegido, ['recientes', 'antiguas'], true)) {
            $ordenElegido = 'recientes';
        }

        $direccion = $ordenElegido === 'antiguas' ? 'ASC' : 'DESC';

        $cuentas = new UsuarioModel();

        $listaCuentas = $cuentas
            ->select('id, nombre, email, rol, activo, creado_en')
            ->orderBy('creado_en', $direccion)
            ->orderBy('id', $direccion)
            ->findAll();

        $plantillas = new Blade();

        return $plantillas->render('admin.usuarios', [
            'listaCuentas' => $listaCuentas,
            'ordenElegido' => $ordenElegido
        ]);
    }

    public function crearUsuario()
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()->to(site_url('panel'));
        }

        $nombreNuevo = trim((string) $this->request->getPost('nombre'));
        $correoNuevo = strtolower(trim((string) $this->request->getPost('email')));
        $claveNueva = (string) $this->request->getPost('password');
        $claveConfirmada = (string) $this->request->getPost('confirmar_password');

        if (mb_strlen($nombreNuevo) < 3 || mb_strlen($nombreNuevo) > 100) {
            return redirect()
                ->to(site_url('admin/crear'))
                ->withInput()
                ->with('error', 'El nombre debe tener entre 3 y 100 caracteres.');
        }

        if (! filter_var($correoNuevo, FILTER_VALIDATE_EMAIL) || mb_strlen($correoNuevo) > 150) {
            return redirect()
                ->to(site_url('admin/crear'))
                ->withInput()
                ->with('error', 'Ingresa un correo electrónico válido.');
        }

        if (strlen($claveNueva) < 8) {
            return redirect()
                ->to(site_url('admin/crear'))
                ->withInput()
                ->with('error', 'La contraseña debe tener al menos 8 caracteres.');
        }

        if ($claveNueva !== $claveConfirmada) {
            return redirect()
                ->to(site_url('admin/crear'))
                ->withInput()
                ->with('error', 'Las contraseñas no coinciden.');
        }

        $archivoUsuarios = new UsuarioModel();

        $correoExistente = $archivoUsuarios
            ->where('email', $correoNuevo)
            ->first();

        if ($correoExistente) {
            return redirect()
                ->to(site_url('admin/crear'))
                ->withInput()
                ->with('error', 'Este correo electrónico ya está registrado.');
        }

        $resultado = $archivoUsuarios
            ->skipValidation(true)
            ->insert([
                'nombre' => $nombreNuevo,
                'email' => $correoNuevo,
                'password' => password_hash($claveNueva, PASSWORD_DEFAULT),
                'rol' => 'usuario',
                'activo' => 1
            ]);

        if ($resultado === false) {
            return redirect()
                ->to(site_url('admin/crear'))
                ->withInput()
                ->with('error', 'No pudimos crear el usuario.');
        }

        return redirect()
            ->to(site_url('admin/usuarios'))
            ->with('mensaje', 'Usuario creado correctamente.');
    }

    public function mostrarCrearUsuario()
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()->to(site_url('panel'));
        }

        $plantillas = new Blade();

        return $plantillas->render('admin.create_user');
    }

    public function userDetails(int $id)
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()->to(site_url('panel'));
        }

        $userModel = new UsuarioModel();
        $user = $userModel->find($id);

        if (! $user) {
            return redirect()
                ->to(site_url('admin/usuarios'))
                ->with('error', 'No encontramos al usuario.');
        }

        $blade = new Blade();

        return $blade->render('admin.user_details', [
            'user' => $user
        ]);
    }

    public function editUser(int $id)
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()->to(site_url('panel'));
        }

        $userModel = new UsuarioModel();
        $user = $userModel->find($id);

        if (! $user) {
            return redirect()
                ->to(site_url('admin/usuarios'))
                ->with('error', 'No encontramos al usuario.');
        }

        $blade = new Blade();

        return $blade->render('admin.edit_user', [
            'user' => $user
        ]);
    }

    public function updateUser(int $id)
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()->to(site_url('panel'));
        }

        $userModel = new UsuarioModel();
        $user = $userModel->find($id);

        if (! $user) {
            return redirect()
                ->to(site_url('admin/usuarios'))
                ->with('error', 'No encontramos al usuario.');
        }

        $name = trim((string) $this->request->getPost('nombre'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        if (mb_strlen($name) < 3 || mb_strlen($name) > 100) {
            return redirect()
                ->to(site_url('admin/usuarios/' . $id . '/editar'))
                ->withInput()
                ->with('error', 'El nombre debe tener entre 3 y 100 caracteres.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            return redirect()
                ->to(site_url('admin/usuarios/' . $id . '/editar'))
                ->withInput()
                ->with('error', 'Ingresa un correo electrónico válido.');
        }

        $existingUser = $userModel
            ->where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($existingUser) {
            return redirect()
                ->to(site_url('admin/usuarios/' . $id . '/editar'))
                ->withInput()
                ->with('error', 'Ese correo ya pertenece a otra cuenta.');
        }

        $data = [
            'nombre' => $name,
            'email' => $email
        ];

        if ($password !== '') {
            if (strlen($password) < 8) {
                return redirect()
                    ->to(site_url('admin/usuarios/' . $id . '/editar'))
                    ->withInput()
                    ->with('error', 'La contraseña debe tener al menos 8 caracteres.');
            }

            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $result = $userModel
            ->skipValidation(true)
            ->update($id, $data);

        if ($result === false) {
            return redirect()
                ->to(site_url('admin/usuarios/' . $id . '/editar'))
                ->withInput()
                ->with('error', 'No pudimos actualizar el usuario.');
        }

        if ($password !== '') {
            $rememberedSessions = new \App\Models\SesionRecordadaModel();

            $rememberedSessions
                ->where('usuario_id', $id)
                ->delete();
        }

        if ((int) session()->get('cuenta_id') === $id) {
            session()->set('cuenta_nombre', $name);
        }

        return redirect()
            ->to(site_url('admin/usuarios/' . $id))
            ->with('mensaje', 'Usuario actualizado correctamente.');
    }

    public function deleteUser(int $id)
    {
        if (
            ! session()->get('sesion_activa') ||
            session()->get('cuenta_rol') !== 'admin'
        ) {
            return redirect()->to(site_url('panel'));
        }

        if ((int) session()->get('cuenta_id') === $id) {
            return redirect()
                ->to(site_url('admin/usuarios/' . $id))
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $userModel = new UsuarioModel();
        $user = $userModel->find($id);

        if (! $user) {
            return redirect()
                ->to(site_url('admin/usuarios'))
                ->with('error', 'No encontramos al usuario.');
        }

        $database = db_connect();
        $database->transBegin();

        try {
            $database->table('tareas')
                ->where('usuario_id', $id)
                ->delete();

            $database->table('sesiones_recordadas')
                ->where('usuario_id', $id)
                ->delete();

            $deleted = $userModel->delete($id);

            if ($deleted === false || $database->transStatus() === false) {
                $database->transRollback();

                return redirect()
                    ->to(site_url('admin/usuarios/' . $id))
                    ->with('error', 'No pudimos eliminar la cuenta.');
            }

            $database->transCommit();

            $photo = $user['imagen_perfil'] ?? '';

            if ($photo !== '') {
                $photoPath = FCPATH . 'uploads/perfiles/' . basename($photo);

                if (is_file($photoPath)) {
                    unlink($photoPath);
                }
            }

            return redirect()
                ->to(site_url('admin/usuarios'))
                ->with('mensaje', 'Cuenta eliminada correctamente.');

        } catch (\Throwable $error) {
            $database->transRollback();

            log_message('error', 'Error al eliminar usuario: ' . $error->getMessage());

            return redirect()
                ->to(site_url('admin/usuarios/' . $id))
                ->with('error', 'No pudimos eliminar la cuenta.');
        }
    }
}