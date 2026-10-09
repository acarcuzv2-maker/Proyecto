<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | Página Escolar Básicos Mariano</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cajaAcceso {
            background: white;
            padding: 35px;
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
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
            margin-top: 18px;
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
            padding: 12px;
            margin-top: 25px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .avisoError {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .enlaces {
            text-align: center;
            margin-top: 20px;
        }

        .enlaces a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="cajaAcceso">

    <h2>Bienvenido de nuevo</h2>

    <p>Tareas Escolares</p>

    @if(session()->getFlashdata('error'))
        <div class="avisoError">
            {{ session()->getFlashdata('error') }}
        </div>
    @endif

    <form action="{{ site_url('login') }}" method="POST">

        <input
            type="hidden"
            name="{{ csrf_token() }}"
            value="{{ csrf_hash() }}"
        >

        <label>Correo electrónico</label>

        <input
            type="email"
            name="email"
            placeholder="Ingresa tu correo"
            required
        >

        <label>Contraseña</label>

        <input
            type="password"
            name="password"
            placeholder="Ingresa tu contraseña"
            required
        >

        <button type="submit">
            Iniciar sesión
        </button>

    </form>

    <div class="enlaces">
        <p>¿Todavía no tienes cuenta?</p>

        <a href="{{ site_url('registro') }}">
            Crear una cuenta
        </a>
    </div>

</div>

</body>
</html>