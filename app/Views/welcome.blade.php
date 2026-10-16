<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Básicos Mariano G.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: #f8faff;
            color: #26324a;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e8edf5;
            padding: 20px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
        }

        .navIzquierda,
        .navDerecha {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .marca {
            font-size: 20px;
            font-weight: 700;
            color: #3459a8;
            text-decoration: none;
            margin-right: 20px;
        }

        .idiomas {
            display: flex;
            align-items: center;
            gap: 18px;
            font-family: 'DM Sans', sans-serif;
        }

        .idiomas button {
            border: none;
            background: transparent;
            color: #53627c;
            font-family: inherit;
            font-size: 14px;
            cursor: pointer;
            padding: 5px 0;
        }

        .idiomas button:hover,
        .idiomas button.activo {
            color: #3459a8;
        }

        .idiomas button.activo {
            font-weight: 700;
        }

        .navDerecha a {
            text-decoration: none;
            color: #53627c;
            font-size: 14px;
            font-weight: 500;
        }

        .navDerecha a:hover {
            color: #3459a8;
        }

        .registro {
            background: #3459a8;
            color: white !important;
            padding: 11px 19px;
            border-radius: 8px;
        }

        .bienvenida {
            padding: 110px 7% 60px;
            min-height: 75vh;
        }

        .contenido {
            max-width: 850px;
        }

        .frase {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(40px, 5.5vw, 72px);
            font-weight: 500;
            line-height: 1.25;
            letter-spacing: -1.5px;
            margin: 0 0 30px;
        }

        .autor {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: #3459a8;
            font-weight: 600;
            letter-spacing: 1px;
            margin: 0;
        }

        footer {
            padding: 25px 7%;
            color: #94a3b8;
            font-size: 13px;
        }

        @media (max-width: 750px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .navIzquierda {
                flex-wrap: wrap;
                gap: 15px;
            }

            .navDerecha {
                gap: 20px;
            }

            .marca {
                margin-right: 0;
            }

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
                data-es="No importa cuán despacio vayas, mientras no te detengas."
                data-en="It does not matter how slowly you go, as long as you do not stop.">
                No importa cuán despacio vayas, mientras no te detengas.
            </h1>

            <p class="autor">
                — Confucio
            </p>

        </div>

    </main>

    <cript src="{{ base_url('js/language.js') }}"></script>

</body>
</html>