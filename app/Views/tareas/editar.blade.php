<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar tarea | Básicos Mariano G.</title>

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

        .form {
            max-width: 520px;
        }

        .field {
            margin-bottom: 30px;
        }

        .field label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #26324a;
            margin-bottom: 12px;
        }

        .field textarea {
            width: 100%;
            min-height: 180px;
            padding: 15px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            background: white;
            color: #26324a;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            resize: vertical;
        }

        .field textarea:focus {
            outline: none;
            border-color: #3459a8;
        }

        .actions {
            display: flex;
            gap: 15px;
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

        .saveButton {
            background: #3459a8;
            color: white;
            border: 1px solid #3459a8;
        }

        .saveButton:hover {
            background: #284785;
        }

        .cancelButton {
            background: transparent;
            color: #3459a8;
            border: 1px solid #3459a8;
        }

        .cancelButton:hover {
            background: #eaf0ff;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px 17px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="content">

        <h1 class="title"
            data-es="Editar tarea"
            data-en="Edit Task">
            Editar tarea
        </h1>

        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <form class="form"
              action="{{ site_url('tareas/actualizar/' . $tarea['id']) }}"
              method="POST">

            <input type="hidden"
                   name="{{ csrf_token() }}"
                   value="{{ csrf_hash() }}">

            <div class="field">

                <label for="description"
                       data-es="Descripción"
                       data-en="Description">
                    Descripción
                </label>

                <textarea
                    id="description"
                    name="descripcion"
                    minlength="3"
                    maxlength="500"
                    required>{{ old('descripcion', $tarea['descripcion']) }}</textarea>

            </div>

            <div class="actions">

                <button type="submit"
                        class="button saveButton"
                        data-es="Guardar cambios"
                        data-en="Save Changes">
                    Guardar cambios
                </button>

                <a href="{{ site_url('tareas/detalles/' . $tarea['id']) }}"
                   class="button cancelButton"
                   data-es="Cancelar"
                   data-en="Cancel">
                    Cancelar
                </a>

            </div>

        </form>

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

</body>
</html>