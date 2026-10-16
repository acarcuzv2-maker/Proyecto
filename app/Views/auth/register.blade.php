<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>

        .botonesRegistro {
            display: flex;
            gap: 15px;
            margin-top: 28px;
        }

        .botonRegistro {
            flex: 1;
            width: auto;
            margin-top: 0;
        }

        .botonCancelar {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            background: transparent;
            color: #3459a8;
            border: 1px solid #3459a8;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }

        .botonCancelar:hover {
            background: #eaf0ff;
        }
        .registroPagina {
            width: 100%;
            max-width: 520px;
            margin: 65px 0 85px 7%;
            padding: 0 25px 0 0;
        }

        .registroPagina h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 43px;
            font-weight: 500;
            color: #26324a;
            margin: 0 0 40px;
        }

        .campo {
            margin-bottom: 23px;
        }

        .campo label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .campo input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            background: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #26324a;
            outline: none;
            transition: border-color 0.2s;
        }

        .campo input:focus {
            border-color: #3459a8;
        }

        .botonRegistro {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            background: #3459a8;
            color: white;
            border: none;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .botonRegistro:hover {
            background: #284785;
        }

        .mensaje {
            padding: 13px;
            margin-bottom: 25px;
            border-radius: 8px;
            background: #dcfce7;
            color: #166534;
            font-size: 14px;
            line-height: 1.6;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 750px) {
            .registroPagina {
                width: 86%;
                margin: 55px auto;
                padding: 0;
            }

            .registroPagina h1 {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="registroPagina">

        <h1 data-es="Registrarse" data-en="Sign Up">
            Registrarse
        </h1>

        @if(session()->getFlashdata('mensaje'))
            <div class="mensaje">
                {{ session()->getFlashdata('mensaje') }}
            </div>
        @endif

        @if(session()->getFlashdata('errores'))
            <div class="mensaje error">
                @foreach(session()->getFlashdata('errores') as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ site_url('registro') }}" method="POST">

            <input type="hidden"
                   name="{{ csrf_token() }}"
                   value="{{ csrf_hash() }}">

            <div class="campo">
                <label for="nombre"
                       data-es="Nombre completo"
                       data-en="Full name">
                    Nombre completo
                </label>

                <input type="text"
                       id="nombre"
                       name="nombre"
                       value="{{ old('nombre') }}"
                       autocomplete="name"
                       required>
            </div>

            <div class="campo">
                <label for="email"
                       data-es="Correo electrónico"
                       data-en="Email address">
                    Correo electrónico
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       autocomplete="email"
                       required>
            </div>

            <div class="campo">
                <label for="password"
                       data-es="Contraseña"
                       data-en="Password">
                    Contraseña
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       minlength="8"
                       autocomplete="new-password"
                       required>
            </div>

            <div class="campo">
                <label for="confirmar_password"
                       data-es="Confirmar contraseña"
                       data-en="Confirm password">
                    Confirmar contraseña
                </label>

                <input type="password"
                       id="confirmar_password"
                       name="confirmar_password"
                       minlength="8"
                       autocomplete="new-password"
                       required>
            </div>

            <div class="botonesRegistro">

                <button type="submit"
                        class="botonRegistro"
                        data-es="Registrarse"
                        data-en="Sign Up">
                    Registrarse
                </button>

                <a href="{{ site_url('/') }}"
                class="botonCancelar"
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