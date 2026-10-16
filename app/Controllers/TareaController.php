<?php

namespace App\Controllers;

use App\Models\TareaModel;

class TareaController extends BaseController
{
    public function guardar()
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to('/login');
        }

        $idCuenta = session()->get('cuenta_id');

        if (! $idCuenta) {
            return redirect()->to('/login');
        }

        $tareaNueva = trim(
            (string) $this->request->getPost('descripcion')
        );

        $archivoTareas = new TareaModel();

        $guardado = $archivoTareas->insert([
            'usuario_id' => $idCuenta,
            'descripcion' => $tareaNueva
        ]);

        if ($guardado === false) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'No pudimos guardar la tarea.');
        }

        return redirect()
            ->to('/tareas')
            ->with('mensaje', '¡Tarea guardada correctamente!');
    }

    public function actualizar(int $idTarea)
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to('/login');
        }

        $idCuenta = session()->get('cuenta_id');

        if (! $idCuenta) {
            return redirect()->to('/login');
        }

        $archivoTareas = new \App\Models\TareaModel();

        $tareaEncontrada = $archivoTareas
            ->where('id', $idTarea)
            ->where('usuario_id', $idCuenta)
            ->first();

        if (! $tareaEncontrada) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'No encontramos esa tarea.');
        }

        $textoNuevo = trim(
            (string) $this->request->getPost('descripcion')
        );

        if (mb_strlen($textoNuevo) < 3 || mb_strlen($textoNuevo) > 500) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'La tarea debe tener entre 3 y 500 caracteres.');
        }

        $cambioListo = $archivoTareas->update($idTarea, [
            'descripcion' => $textoNuevo
        ]);

        if ($cambioListo === false) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'No pudimos actualizar la tarea.');
        }

        return redirect()
        ->to(site_url('tareas/detalles/' . $idTarea))
        ->with('mensaje', 'Tarea actualizada correctamente.');
    }
    public function eliminar(int $idTarea)
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to('/login');
        }

        $idCuenta = session()->get('cuenta_id');

        if (! $idCuenta) {
            return redirect()->to('/login');
        }

        $archivoTareas = new \App\Models\TareaModel();

        $tareaEncontrada = $archivoTareas
            ->where('id', $idTarea)
            ->where('usuario_id', $idCuenta)
            ->first();

        if (! $tareaEncontrada) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'No encontramos esa tarea.');
        }

        $tareaBorrada = $archivoTareas->delete($idTarea);

        if ($tareaBorrada === false) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'No pudimos eliminar la tarea.');
        }

        return redirect()
            ->to('/tareas')
            ->with('mensaje', 'Tarea eliminada correctamente.');
    }

    public function editar(int $id)
    {
        $tareas = new TareaModel();

        $tarea = $tareas
            ->where('id', $id)
            ->where('usuario_id', session()->get('cuenta_id'))
            ->first();

        if (!$tarea) {
            return redirect()
                ->to('/tareas')
                ->with('error', 'No se encontró la tarea.');
        }

        $plantillas = new \App\Libraries\Blade();

        return $plantillas->render('tareas.editar', [
            'tarea' => $tarea
        ]);
    }

    public function createTask()
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to(site_url('login'));
        }

        $blade = new \App\Libraries\Blade();

        return $blade->render('tasks.create_task');
    }

    public function taskDetails(int $id)
    {
        if (! session()->get('sesion_activa')) {
            return redirect()->to(site_url('login'));
        }

        $taskModel = new TareaModel();

        $task = $taskModel
            ->where('id', $id)
            ->where('usuario_id', session()->get('cuenta_id'))
            ->first();

        if (! $task) {
            return redirect()
                ->to(site_url('tareas'))
                ->with('error', 'No encontramos esa tarea.');
        }

        $blade = new \App\Libraries\Blade();

        return $blade->render('tasks.task_details', [
            'task' => $task
        ]);
    }
}
