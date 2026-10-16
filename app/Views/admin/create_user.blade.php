<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear usuario | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .contenido {
            padding: 75px 7% 90px;
            max-width: 1100px;
        }

        .titulo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 46px;
            font-weight: 500;
            color: #26324a;
            margin: 0 0 18px;
        }

        .descripcion {
            color: #8290a7;
            font-size: 14px;
            margin-bottom: 45px;
        }

        .formulario {
            max-width: 520px;
        }

        .campo {
            margin-bottom: 25px;
        }

        .campo label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #26324a;
            margin-bottom: 10px;
        }

        .campo input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            background: white;
            color: #26324a;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        .campo input:focus {
            outline: none;
            border-color: #3459a8;
        }

        .acciones {
            display: flex;
            gap: 15px;
            margin-top: 35px;
        }

        .boton {
            display: inline-block;
            padding: 14px 23px;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .botonGuardar {
            background: #3459a8;
            color: white;
            border: 1px solid #3459a8;
        }

        .botonGuardar:hover {
            background: #284785;
        }

        .botonCancelar {
            background: transparent;
            color: #3459a8;
            border: 1px solid #3459a8;
        }

        .botonCancelar:hover {
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

    <main class="contenido">

        <h1 class="titulo"
            data-es="Crear usuario"
            data-en="Create User">
            Crear usuario
        </h1>

        <p class="descripcion"
           data-es="Completa los siguientes datos para registrar una nueva cuenta."
           data-en="Complete the following information to register a new account.">
            Completa los siguientes datos para registrar una nueva cuenta.
        </p>

        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <form class="formulario"
              action="{{ site_url('admin/crear') }}"
              method="POST">

            <input type="hidden"
                   name="{{ csrf_token() }}"
                   value="{{ csrf_hash() }}">

            <div class="campo">
                <label data-es="Nombre completo"
                       data-en="Full Name">
                    Nombre completo
                </label>

                <input type="text"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    minlength="3"
                    maxlength="100"
                    required>
            </div>

            <div class="campo">
                <label data-es="Correo electrónico"
                       data-en="Email Address">
                    Correo electrónico
                </label>

                <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    maxlength="150"
                    required>
            </div>

            <div class="campo">
                <label data-es="Contraseña"
                       data-en="Password">
                    Contraseña
                </label>

                <input type="password"
                       name="password"
                       minlength="8"
                       required>
            </div>

            <div class="campo">
                <label data-es="Repetir contraseña"
                       data-en="Repeat Password">
                    Repetir contraseña
                </label>

                <input type="password"
                       name="confirmar_password"
                       minlength="8"
                       required>
            </div>

            <div class="acciones">

                <button type="submit"
                        class="boton botonGuardar"
                        data-es="Guardar usuario"
                        data-en="Save User">
                    Guardar usuario
                </button>

                <a href="{{ site_url('admin/usuarios') }}"
                   class="boton botonCancelar"
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