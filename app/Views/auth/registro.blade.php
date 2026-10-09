<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Página Escolar Básicos Mariano</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .contenedor {
            background: white;
            padding: 35px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e293b;
        }

        p {
            text-align: center;
            color: #64748b;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .mensaje {
            padding: 12px;
            margin-top: 15px;
            border-radius: 6px;
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .enlace {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h2>Crear cuenta</h2>
    <p>Básicos Mariano G</p>

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

        <label>Nombre completo</label>
        <input type="text"
               name="nombre"
               value="{{ old('nombre') }}"
               required>

        <label>Correo electrónico</label>
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               required>

        <label>Contraseña</label>
        <input type="password"
               name="password"
               minlength="8"
               required>

        <label>Confirmar contraseña</label>
        <input type="password"
               name="confirmar_password"
               minlength="8"
               required>

        <button type="submit">Registrarme</button>

    </form>

    <a class="enlace" href="{{ site_url('/') }}">
        Volver al inicio
    </a>

</div>

</body>
</html>