<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar usuario | Básicos Mariano G.</title>

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
            margin-bottom: 45px;
        }

        .form {
            max-width: 520px;
        }

        .field {
            margin-bottom: 25px;
        }

        .field label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .field input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        .field input:focus {
            outline: none;
            border-color: #3459a8;
        }

        .help {
            font-size: 13px;
            color: #8290a7;
            margin-top: 9px;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
        }

        .button {
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
            border: 1px solid #3459a8;
            color: white;
        }

        .cancelButton {
            background: transparent;
            border: 1px solid #3459a8;
            color: #3459a8;
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
            data-es="Editar usuario"
            data-en="Edit User">
            Editar usuario
        </h1>

        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <form class="form"
              action="{{ site_url('admin/usuarios/' . $user['id'] . '/actualizar') }}"
              method="POST">

            <input type="hidden"
                   name="{{ csrf_token() }}"
                   value="{{ csrf_hash() }}">

            <div class="field">
                <label data-es="Nombre completo" data-en="Full Name">
                    Nombre completo
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $user['nombre']) }}"
                       minlength="3"
                       maxlength="100"
                       required>
            </div>

            <div class="field">
                <label data-es="Correo electrónico" data-en="Email Address">
                    Correo electrónico
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email', $user['email']) }}"
                       maxlength="150"
                       required>
            </div>

            <div class="field">
                <label data-es="Nueva contraseña" data-en="New Password">
                    Nueva contraseña
                </label>

                <input type="password"
                       name="password"
                       minlength="8">

                <p class="help"
                   data-es="Deja este campo vacío para conservar la contraseña actual."
                   data-en="Leave this field blank to keep the current password.">
                    Deja este campo vacío para conservar la contraseña actual.
                </p>
            </div>

            <div class="actions">

                <button type="submit"
                        class="button saveButton"
                        data-es="Guardar cambios"
                        data-en="Save Changes">
                    Guardar cambios
                </button>

                <a href="{{ site_url('admin/usuarios/' . $user['id']) }}"
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