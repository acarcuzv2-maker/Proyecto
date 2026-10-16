<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Usuarios | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .usuarios {
            padding: 75px 7% 90px;
            max-width: 1200px;
        }

        .titulo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 46px;
            font-weight: 500;
            color: #26324a;
            margin: 0 0 18px;
        }

        .totalUsuarios {
            color: #8290a7;
            font-size: 14px;
            margin-bottom: 40px;
        }

        .ordenamiento {
            display: flex;
            gap: 12px;
            margin-bottom: 35px;
        }

        .botonOrden {
            padding: 12px 20px;
            border: 1px solid #3459a8;
            border-radius: 9px;
            background: transparent;
            color: #3459a8;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .botonOrden:hover {
            background: #eaf0ff;
        }

        .botonActivo {
            background: #3459a8;
            color: white;
        }

        .botonActivo:hover {
            background: #284785;
        }

        .tablaUsuarios {
            width: 100%;
            border-collapse: collapse;
        }

        .tablaUsuarios th {
            text-align: left;
            padding: 17px 15px;
            font-size: 13px;
            font-weight: 600;
            color: #53627c;
            border-bottom: 1px solid #dce4f0;
        }

        .tablaUsuarios td {
            padding: 22px 15px;
            font-size: 14px;
            color: #26324a;
            border-bottom: 1px solid #dce4f0;
        }

        .tablaUsuarios th:first-child,
        .tablaUsuarios td:first-child {
            padding-left: 0;
        }

        .activo {
            color: #15803d;
            font-weight: 600;
        }

        .inactivo {
            color: #b42338;
            font-weight: 600;
        }

        .mensaje,
        .error {
            padding: 14px 17px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .mensaje {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .crearUsuario {
            margin-bottom: 35px;
        }

        .formularioUsuario {
            display: none;
            max-width: 520px;
            margin-bottom: 45px;
        }

        .formularioUsuario h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 29px;
            font-weight: 500;
            color: #26324a;
            margin-bottom: 30px;
        }

        .campoUsuario {
            margin-bottom: 22px;
        }

        .campoUsuario label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .campoUsuario input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            background: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        .campoUsuario input:focus {
            outline: none;
            border-color: #3459a8;
        }

        .botonesUsuario {
            display: flex;
            gap: 14px;
            margin-top: 30px;
        }

        .botonUsuario {
            padding: 13px 22px;
            background: #3459a8;
            border: 1px solid #3459a8;
            border-radius: 9px;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .botonCancelar {
            background: transparent;
            color: #3459a8;
        }

        .botonUsuario:hover {
            opacity: 0.9;
        }

        .enlaceCrear {
            display: inline-block;
            text-decoration: none;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="usuarios">

        <h1 class="titulo"
            data-es="Usuarios"
            data-en="Users">
            Usuarios
        </h1>

        <p class="totalUsuarios">
            <span data-es="Usuarios registrados:"
                  data-en="Registered users:">
                Usuarios registrados:
            </span>

            {{ count($listaCuentas) }}
        </p>

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

        <div class="ordenamiento">

            <a href="{{ site_url('admin/usuarios') }}?orden=recientes"
               class="botonOrden {{ $ordenElegido === 'recientes' ? 'botonActivo' : '' }}"
               data-es="Más recientes"
               data-en="Newest First">
                Más recientes
            </a>

            <a href="{{ site_url('admin/usuarios') }}?orden=antiguas"
               class="botonOrden {{ $ordenElegido === 'antiguas' ? 'botonActivo' : '' }}"
               data-es="Más antiguas"
               data-en="Oldest First">
                Más antiguas
            </a>

        </div>

      <div class="crearUsuario">
        <a href="{{ site_url('admin/crear') }}"
        class="botonUsuario enlaceCrear"
        data-es="Crear usuario"
        data-en="Create User">
            Crear usuario
        </a>
    </div>


        <table class="tablaUsuarios">

            <thead>
                <tr>
                    <th>ID</th>

                    <th data-es="Nombre" data-en="Name">
                        Nombre
                    </th>

                    <th data-es="Correo electrónico" data-en="Email Address">
                        Correo electrónico
                    </th>

                    <th data-es="Rol" data-en="Role">
                        Rol
                    </th>

                    <th data-es="Estado" data-en="Status">
                        Estado
                    </th>

                    <th data-es="Fecha de creación" data-en="Date Created">
                        Fecha de creación
                    </th>
                </tr>
            </thead>

            <tbody>

                @forelse($listaCuentas as $cuenta)

                    <tr>

                        <td>{{ $cuenta['id'] }}</td>

                        <td>
                            <a href="{{ site_url('admin/usuarios/' . $cuenta['id']) }}"
                            style="color:#3459a8;text-decoration:none;font-weight:600;">
                                {{ $cuenta['nombre'] }}
                            </a>
                        </td>

                        <td>{{ $cuenta['email'] }}</td>

                        <td>
                            @if($cuenta['rol'] === 'admin')
                                <span data-es="Administrador"
                                      data-en="Administrator">
                                    Administrador
                                </span>
                            @else
                                <span data-es="Usuario"
                                      data-en="User">
                                    Usuario
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($cuenta['activo'] == 1)
                                <span class="activo"
                                      data-es="Activo"
                                      data-en="Active">
                                    Activo
                                </span>
                            @else
                                <span class="inactivo"
                                      data-es="Inactivo"
                                      data-en="Inactive">
                                    Inactivo
                                </span>
                            @endif
                        </td>

                        <td>
                            @if(!empty($cuenta['creado_en']))
                                {{ date('d/m/Y H:i', strtotime($cuenta['creado_en'])) }}
                            @else
                                —
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6"
                            data-es="No hay usuarios registrados."
                            data-en="No registered users.">
                            No hay usuarios registrados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>
 

</body>
</html>