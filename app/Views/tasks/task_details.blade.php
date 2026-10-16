<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalles de la tarea | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .content {
            padding: 75px 7% 90px;
            max-width: 1100px;
        }

        .title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 46px;
            font-weight: 500;
            color: #26324a;
            margin: 0 0 45px;
        }

        .information {
            margin-bottom: 30px;
        }

        .information label {
            display: block;
            color: #8290a7;
            font-size: 13px;
            margin-bottom: 9px;
        }

        .information p {
            margin: 0;
            color: #26324a;
            font-size: 17px;
            line-height: 1.7;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 50px;
        }

        .button {
            display: inline-block;
            padding: 14px 23px;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .editButton {
            background: #3459a8;
            color: white;
            border: 1px solid #3459a8;
        }

        .backButton {
            background: transparent;
            color: #3459a8;
            border: 1px solid #3459a8;
        }

        .deleteButton {
            background: transparent;
            color: #b42338;
            border: 1px solid #e9b6bf;
        }

        .message {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="content">

        <h1 class="title"
            data-es="Detalles de la tarea"
            data-en="Task Details">
            Detalles de la tarea
        </h1>

        @if(session()->getFlashdata('mensaje'))
            <div class="message">
                {{ session()->getFlashdata('mensaje') }}
            </div>
        @endif

        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <div class="information">
            <label data-es="ID de la tarea" data-en="Task ID">
                ID de la tarea
            </label>

            <p>{{ $task['id'] }}</p>
        </div>

        <div class="information">
            <label data-es="Descripción" data-en="Description">
                Descripción
            </label>

            <p>{{ $task['descripcion'] }}</p>
        </div>

        <div class="information">
            <label data-es="Fecha de creación" data-en="Creation Date">
                Fecha de creación
            </label>

            <p>
                {{ !empty($task['creado_en']) ? date('d/m/Y H:i', strtotime($task['creado_en'])) : '—' }}
            </p>
        </div>

        <div class="information">
            <label data-es="Última actualización" data-en="Last Updated">
                Última actualización
            </label>

            <p>
                {{ !empty($task['actualizado_en']) ? date('d/m/Y H:i', strtotime($task['actualizado_en'])) : '—' }}
            </p>
        </div>

        <div class="actions">

            <a href="{{ site_url('tareas/editar/' . $task['id']) }}"
               class="button editButton"
               data-es="Editar tarea"
               data-en="Edit Task">
                Editar tarea
            </a>

            <a href="{{ site_url('tareas') }}"
               class="button backButton"
               data-es="Volver a tareas"
               data-en="Back to Tasks">
                Volver a tareas
            </a>

            <form action="{{ site_url('tareas/eliminar/' . $task['id']) }}"
                  method="POST"
                  onsubmit="return confirm('¿Deseas eliminar esta tarea?')">

                <input type="hidden"
                       name="{{ csrf_token() }}"
                       value="{{ csrf_hash() }}">

                <button type="submit"
                        class="button deleteButton"
                        data-es="Eliminar tarea"
                        data-en="Delete Task">
                    Eliminar tarea
                </button>

            </form>

        </div>

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

</body>
</html>