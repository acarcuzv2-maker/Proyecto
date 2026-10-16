<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tareas | Básicos Mariano G.</title>

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
            margin: 0 0 18px;
        }

        .description {
            color: #8290a7;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .searchForm {
            display: flex;
            gap: 12px;
            max-width: 650px;
            margin-bottom: 30px;
        }

        .searchInput {
            flex: 1;
            padding: 13px 15px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            background: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        .searchInput:focus {
            outline: none;
            border-color: #3459a8;
        }

        .controls {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 40px;
        }

        .button {
            display: inline-block;
            padding: 13px 20px;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .primaryButton {
            background: #3459a8;
            color: white;
            border: 1px solid #3459a8;
        }

        .primaryButton:hover {
            background: #284785;
        }

        .secondaryButton {
            background: transparent;
            color: #3459a8;
            border: 1px solid #3459a8;
        }

        .secondaryButton:hover {
            background: #eaf0ff;
        }

        .activeButton {
            background: #eaf0ff;
        }

        .taskList {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .task {
            padding: 23px 0;
            border-bottom: 1px solid #dce4f0;
        }

        .task:first-child {
            border-top: 1px solid #dce4f0;
        }

        .taskLink {
            color: #26324a;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.7;
            text-decoration: none;
            overflow-wrap: anywhere;
            white-space: pre-wrap;
        }

        .taskLink:hover {
            color: #3459a8;
        }

        .taskDate {
            display: block;
            color: #8290a7;
            font-size: 12px;
            margin-top: 12px;
        }

        .message,
        .error {
            padding: 14px 17px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .message {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            padding: 35px 0;
            color: #8290a7;
            font-size: 14px;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="content">

        <h1 class="title"
            data-es="Mis tareas"
            data-en="My Tasks">
            Mis tareas
        </h1>

        <p class="description"
           data-es="Organiza y consulta tus tareas registradas."
           data-en="Organize and view your saved tasks.">
            Organiza y consulta tus tareas registradas.
        </p>

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

        <form class="searchForm"
              action="{{ site_url('tareas') }}"
              method="GET">

            <input type="hidden"
                   name="orden"
                   value="{{ $ordenElegido }}">

            <input type="text"
                   class="searchInput"
                   name="buscar"
                   value="{{ $busqueda }}"
                   placeholder="Buscar tareas por palabra clave..."
                   data-placeholder-es="Buscar tareas por palabra clave..."
                   data-placeholder-en="Search tasks by keyword...">

            <button type="submit"
                    class="button primaryButton"
                    data-es="Buscar"
                    data-en="Search">
                Buscar
            </button>

        </form>

        <div class="controls">

            <a href="{{ site_url('tareas') . '?orden=recientes&buscar=' . urlencode($busqueda) }}"
               class="button secondaryButton {{ $ordenElegido === 'recientes' ? 'activeButton' : '' }}"
               data-es="Más recientes"
               data-en="Newest First">
                Más recientes
            </a>

            <a href="{{ site_url('tareas') . '?orden=antiguas&buscar=' . urlencode($busqueda) }}"
               class="button secondaryButton {{ $ordenElegido === 'antiguas' ? 'activeButton' : '' }}"
               data-es="Más antiguas"
               data-en="Oldest First">
                Más antiguas
            </a>

            <a href="{{ site_url('tareas/nueva') }}"
               class="button primaryButton"
               data-es="Agregar nueva tarea"
               data-en="Add New Task">
                Agregar nueva tarea
            </a>

        </div>

        @if(count($misTareas) > 0)

            <ul class="taskList">

                @foreach($misTareas as $task)

                    <li class="task">

                        <a href="{{ site_url('tareas/detalles/' . $task['id']) }}"
                           class="taskLink">
                            {{ $task['descripcion'] }}
                        </a>

                        <small class="taskDate">

                            <span data-es="Agregada el:"
                                  data-en="Added on:">
                                Agregada el:
                            </span>

                            {{ date('d/m/Y', strtotime($task['creado_en'])) }}

                            <span data-es="a las"
                                  data-en="at">
                                a las
                            </span>

                            {{ date('H:i', strtotime($task['creado_en'])) }}

                        </small>

                    </li>

                @endforeach

            </ul>

        @else

            <div class="empty"
                 data-es="No encontramos tareas con esos criterios."
                 data-en="No tasks matched your search.">
                No encontramos tareas con esos criterios.
            </div>

        @endif

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updatePlaceholder() {
                const language = localStorage.getItem('idioma') || 'es';

                document.querySelectorAll('[data-placeholder-es]').forEach(function (field) {
                    field.placeholder = language === 'en'
                        ? field.dataset.placeholderEn
                        : field.dataset.placeholderEs;
                });
            }

            updatePlaceholder();

            document.getElementById('ingles')?.addEventListener('click', updatePlaceholder);
            document.getElementById('espanol')?.addEventListener('click', updatePlaceholder);
        });
    </script>

</body>
</html>