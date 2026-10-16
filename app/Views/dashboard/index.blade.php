<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        .bienvenida {
            padding: 110px 7% 60px;
            min-height: 75vh;
        }

        .contenido {
            max-width: 950px;
        }

        .frase {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(40px, 5.5vw, 72px);
            font-weight: 500;
            line-height: 1.25;
            letter-spacing: -1.5px;
            margin: 0 0 30px;
            color: #26324a;
        }

        .autor {
            font-size: 15px;
            color: #3459a8;
            font-weight: 600;
            letter-spacing: 1px;
            margin: 0;
        }

        @media (max-width: 750px) {
            .bienvenida {
                padding-top: 70px;
            }

            .frase {
                letter-spacing: -0.5px;
            }
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="bienvenida">

        <div class="contenido">

            <h1 class="frase"
                data-es="Saber no es suficiente, debemos aplicar. Querer no es suficiente, debemos hacer."
                data-en="Knowing is not enough, we must apply. Willing is not enough, we must do.">
                Saber no es suficiente, debemos aplicar.
                Querer no es suficiente, debemos hacer.
            </h1>

            <p class="autor">
                — Johann Wolfgang von Goethe
            </p>

        </div>

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

</body>
</html>