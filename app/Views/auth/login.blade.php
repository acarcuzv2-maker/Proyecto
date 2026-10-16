<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        .login {
            width: 100%;
            max-width: 520px;
            margin: 85px 0 85px 7%;
            padding: 0 25px 0 0;
        }

        .login h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 43px;
            font-weight: 500;
            color: #26324a;
            margin: 0 0 40px;
        }

        .descripcion {
            color: #718096;
            font-size: 15px;
            margin-bottom: 38px;
            line-height: 1.6;
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

        .recordarme {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
            cursor: pointer;
        }

        .recordarme input {
            margin: 3px 0 0;
            accent-color: #3459a8;
        }

        .botonLogin {
            width: 100%;
            padding: 14px;
            margin-top: 28px;
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

        .botonLogin:hover {
            background: #284785;
        }

        .enlaces {
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: #718096;
        }

        .enlaces a,
        .recuperar a {
            color: #3459a8;
            text-decoration: none;
            font-weight: 600;
        }

        .enlaces a:hover,
        .recuperar a:hover {
            text-decoration: underline;
        }

        .recuperar {
            text-align: right;
            margin-top: 16px;
            font-size: 13px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 25px;
        }

         @media (max-width: 750px) {
            .login {
                width: 86%;
                margin: 55px auto;
                padding: 0;
            }

            .login h1 {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="login">

        <h1 data-es="Iniciar sesión" data-en="Log In">
            Iniciar sesión
        </h1>

       
        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <form action="{{ site_url('login') }}" method="POST">

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

            <div class="campo">
                <label for="password"
                       data-es="Contraseña"
                       data-en="Password">
                    Contraseña
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       autocomplete="current-password"
                       required>
            </div>

            <label class="recordarme">
                <input type="checkbox"
                       name="recordarme"
                       value="1">

                <span data-es="Mantener mi sesión iniciada durante 7 días"
                      data-en="Keep me signed in for 7 days">
                    Mantener mi sesión iniciada durante 7 días
                </span>
            </label>

            <div class="recuperar">
                <a href="{{ site_url('recuperar') }}"
                   data-es="¿Olvidaste tu contraseña?"
                   data-en="Forgot your password?">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit"
                    class="botonLogin"
                    data-es="Iniciar sesión"
                    data-en="Log In">
                Iniciar sesión
            </button>

        </form>


    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

</body>
</html>