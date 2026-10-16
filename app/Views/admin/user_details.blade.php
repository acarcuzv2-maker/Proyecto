<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalles del usuario | Básicos Mariano G.</title>

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

        .information {
            margin-bottom: 30px;
        }

        .information label {
            display: block;
            color: #8290a7;
            font-size: 13px;
            margin-bottom: 9px;
        }

        .information p {
            margin: 0;
            font-size: 17px;
            color: #26324a;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 50px;
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

        .editButton {
            background: #3459a8;
            color: white;
            border: 1px solid #3459a8;
        }

        .deleteButton {
            background: transparent;
            color: #b42338;
            border: 1px solid #e9b6bf;
        }

        .message {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .backButton {
            background: transparent;
            color: #3459a8;
            border: 1px solid #3459a8;
        }

        .backButton:hover {
            background: #eaf0ff;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="content">

        <h1 class="title"
            data-es="Detalles del usuario"
            data-en="User Details">
            Detalles del usuario
        </h1>

        @if(session()->getFlashdata('mensaje'))
            <div class="message">
                {{ session()->getFlashdata('mensaje') }}
            </div>
        @endif

        @if(session()->getFlashdata('error'))
            <div class="error">
                {{ session()->getFlashdata('error') }}
            </div>
        @endif

        <div class="information">
            <label data-es="Nombre" data-en="Name">Nombre</label>
            <p>{{ $user['nombre'] }}</p>
        </div>

        <div class="information">
            <label data-es="Correo electrónico" data-en="Email Address">
                Correo electrónico
            </label>
            <p>{{ $user['email'] }}</p>
        </div>

        <div class="information">
            <label data-es="Tipo de cuenta" data-en="Account Type">
                Tipo de cuenta
            </label>

            <p>
                {{ $user['rol'] === 'admin' ? 'Administrador' : 'Usuario' }}
            </p>
        </div>

        <div class="information">
            <label data-es="Estado" data-en="Status">Estado</label>
            <p>{{ (int) $user['activo'] === 1 ? 'Activo' : 'Inactivo' }}</p>
        </div>

        <div class="information">
            <label data-es="Fecha de creación" data-en="Creation Date">
                Fecha de creación
            </label>

            <p>
                {{ !empty($user['creado_en']) ? date('d/m/Y H:i', strtotime($user['creado_en'])) : '—' }}
            </p>
        </div>

        <div class="information">
            <label data-es="Última actualización" data-en="Last Updated">
                Última actualización
            </label>

            <p>
                {{ !empty($user['actualizado_en']) ? date('d/m/Y H:i', strtotime($user['actualizado_en'])) : '—' }}
            </p>
        </div>

        <div class="actions">

            <a href="{{ site_url('admin/usuarios/' . $user['id'] . '/editar') }}"
               class="button editButton"
               data-es="Editar usuario"
               data-en="Edit User">
                Editar usuario
            </a>
            <a href="{{ site_url('admin/usuarios') }}"
            class="button backButton"
            data-es="Volver a usuarios"
            data-en="Back to Users">
                Volver a usuarios
            </a>

            @if((int) $user['id'] !== (int) session()->get('cuenta_id'))

                <form action="{{ site_url('admin/usuarios/' . $user['id'] . '/eliminar') }}"
                      method="POST"
                      onsubmit="return confirm('¿Estás seguro de eliminar esta cuenta? Esta acción no se puede deshacer.')">

                    <input type="hidden"
                           name="{{ csrf_token() }}"
                           value="{{ csrf_hash() }}">

                    <button type="submit"
                            class="button deleteButton"
                            data-es="Eliminar cuenta"
                            data-en="Delete Account">
                        Eliminar cuenta
                    </button>

                </form>

            @endif

        </div>

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

</body>
</html>