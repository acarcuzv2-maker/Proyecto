<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        .recuperacion {
            width: 100%;
            max-width: 520px;
            margin: 85px 0 85px 7%;
            padding: 0 25px 0 0;
        }

        .recuperacion h1 {
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
        }

        .campo input:focus {
            border-color: #3459a8;
        }

        .botones {
            display: flex;
            gap: 15px;
            margin-top: 28px;
        }

        .botonEnviar,
        .botonCancelar {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .botonEnviar {
            background: #3459a8;
            color: white;
            border: none;
        }

        .botonEnviar:hover {
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

        .mensaje,
        .error {
            padding: 13px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
        }

        .mensaje {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 750px) {
            .recuperacion {
                width: 86%;
                margin: 55px auto;
                padding: 0;
            }

            .recuperacion h1 {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="recuperacion">

        <h1 data-es="Recuperar contraseña" data-en="Forgot Password">
            Recuperar contraseña
        </h1>

        @if(session()->getFlashdata('mensaje'))
            <div class="mensaje">
                {{ session()->getFlashdata('mensaje') }}
            </div>
        @endif

        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <form action="{{ site_url('recuperar') }}" method="POST">

            <input type="hidden"
                   name="{{ csrf_token() }}"
                   value="{{ csrf_hash() }}">

            <div class="campo">
                <label for="email"
                       data-es="Correo electrónico"
                       data-en="Email address">
                    Correo electrónico
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       autocomplete="email"
                       required>
            </div>

            <div class="botones">

                <button type="submit"
                        class="botonEnviar"
                        data-es="Enviar enlace"
                        data-en="Send Link">
                    Enviar enlace
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