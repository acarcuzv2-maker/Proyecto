<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile | Básicos Mariano G.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ base_url('css/navbar.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .perfil {
            padding: 70px 7% 90px;
            max-width: 1100px;
        }

        .titulo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 46px;
            font-weight: 500;
            color: #26324a;
            margin: 0 0 45px;
        }

        .fotografia {
            width: 210px;
            height: 210px;
            border-radius: 18px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf0ff;
            color: #3459a8;
            font-size: 75px;
            font-weight: 500;
        }

        .eliminarFoto {
            background: none;
            border: none;
            color: #b42338;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            cursor: pointer;
            margin-top: 15px;
            padding: 0;
        }

        .informacion {
            margin-top: 45px;
        }

        .dato {
            margin-bottom: 28px;
        }

        .dato label {
            display: block;
            color: #8290a7;
            font-size: 13px;
            margin-bottom: 9px;
        }

        .dato p {
            margin: 0;
            font-size: 17px;
            color: #26324a;
        }

        .acciones {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .boton {
            padding: 14px 22px;
            background: #3459a8;
            border: 1px solid #3459a8;
            color: white;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .boton:hover {
            background: #284785;
        }

        .botonSecundario {
            background: transparent;
            color: #3459a8;
        }

        .botonSecundario:hover {
            background: #eaf0ff;
        }

        .formulario {
            display: none;
            max-width: 520px;
            margin-top: 45px;
        }

        .formulario h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .campo input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            background: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        .campo input:focus {
            outline: none;
            border-color: #3459a8;
        }

        .botonesFormulario {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .botonesFormulario .boton {
            flex: 1;
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
    </style>
</head>

<body>

    @include('components.navbar')

    <main class="perfil">

        <h1 class="titulo"
            data-es="Mi perfil"
            data-en="My Profile">
            Mi perfil
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

        @if(!empty($miCuenta['imagen_perfil']))

            <img
                class="fotografia"
                src="{{ base_url('uploads/perfiles/' . rawurlencode($miCuenta['imagen_perfil'])) }}"
                alt="Fotografía de perfil"
            >

            <form action="{{ site_url('perfil/eliminar-foto') }}"
                  method="POST">

                <input type="hidden"
                       name="{{ csrf_token() }}"
                       value="{{ csrf_hash() }}">

                <button type="submit"
                        class="eliminarFoto"
                        data-es="Eliminar foto"
                        data-en="Remove Photo"
                        onclick="return confirm('¿Deseas eliminar tu fotografía?')">
                    Eliminar foto
                </button>

            </form>

        @else

            <div class="fotografia">
                {{ strtoupper(mb_substr($miCuenta['nombre'], 0, 1)) }}
            </div>

        @endif

        <div class="informacion">

            <div class="dato">
                <label data-es="Nombre" data-en="Name">
                    Nombre
                </label>

                <p>{{ $miCuenta['nombre'] }}</p>
            </div>

            <div class="dato">
                <label data-es="Correo electrónico" data-en="Email Address">
                    Correo electrónico
                </label>

                <p>{{ $miCuenta['email'] }}</p>
            </div>

        </div>

        <div class="acciones">

            <button type="button"
                    class="boton"
                    onclick="mostrarFormulario('editarPerfil')"
                    data-es="Editar perfil"
                    data-en="Edit Profile">
                Editar perfil
            </button>

            <button type="button"
                    class="boton botonSecundario"
                    onclick="mostrarFormulario('cambiarClave')"
                    data-es="Cambiar contraseña"
                    data-en="Change Password">
                Cambiar contraseña
            </button>

            <button type="button"
                    class="boton botonSecundario"
                    onclick="mostrarFormulario('cambiarFoto')"
                    data-es="Cambiar foto"
                    data-en="Change Photo">
                Cambiar foto
            </button>

        </div>

        <section id="editarPerfil" class="formulario">

            <h2 data-es="Editar perfil" data-en="Edit Profile">
                Editar perfil
            </h2>

            <form action="{{ site_url('perfil/guardar') }}" method="POST">

                <input type="hidden"
                       name="{{ csrf_token() }}"
                       value="{{ csrf_hash() }}">

                <div class="campo">
                    <label data-es="Nombre" data-en="Name">Nombre</label>

                    <input type="text"
                           name="nombre"
                           value="{{ $miCuenta['nombre'] }}"
                           minlength="3"
                           maxlength="100"
                           required>
                </div>

                <div class="campo">
                    <label data-es="Correo electrónico" data-en="Email Address">
                        Correo electrónico
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ $miCuenta['email'] }}"
                           maxlength="150"
                           required>
                </div>

                <div class="campo">
                    <label data-es="Contraseña actual" data-en="Current Password">
                        Contraseña actual
                    </label>

                    <input type="password"
                           name="password_actual"
                           required>
                </div>

                <div class="botonesFormulario">

                    <button type="submit"
                            class="boton"
                            data-es="Guardar cambios"
                            data-en="Save Changes">
                        Guardar cambios
                    </button>

                    <button type="button"
                            class="boton botonSecundario"
                            onclick="cerrarFormularios()"
                            data-es="Cancelar"
                            data-en="Cancel">
                        Cancelar
                    </button>

                </div>

            </form>

        </section>

        <section id="cambiarClave" class="formulario">

            <h2 data-es="Cambiar contraseña" data-en="Change Password">
                Cambiar contraseña
            </h2>

            <form action="{{ site_url('perfil/guardar') }}" method="POST">

                <input type="hidden"
                       name="{{ csrf_token() }}"
                       value="{{ csrf_hash() }}">

                <input type="hidden"
                       name="nombre"
                       value="{{ $miCuenta['nombre'] }}">

                <input type="hidden"
                       name="email"
                       value="{{ $miCuenta['email'] }}">

                <div class="campo">
                    <label data-es="Contraseña actual" data-en="Current Password">
                        Contraseña actual
                    </label>

                    <input type="password"
                           name="password_actual"
                           required>
                </div>

                <div class="campo">
                    <label data-es="Nueva contraseña" data-en="New Password">
                        Nueva contraseña
                    </label>

                    <input type="password"
                           name="password_nueva"
                           minlength="8"
                           required>
                </div>

                <div class="campo">
                    <label data-es="Confirmar contraseña" data-en="Confirm Password">
                        Confirmar contraseña
                    </label>

                    <input type="password"
                           name="confirmar_password"
                           minlength="8"
                           required>
                </div>

                <div class="botonesFormulario">

                    <button type="submit"
                            class="boton"
                            data-es="Guardar contraseña"
                            data-en="Save Password">
                        Guardar contraseña
                    </button>

                    <button type="button"
                            class="boton botonSecundario"
                            onclick="cerrarFormularios()"
                            data-es="Cancelar"
                            data-en="Cancel">
                        Cancelar
                    </button>

                </div>

            </form>

        </section>

        <section id="cambiarFoto" class="formulario">

            <h2 data-es="Cambiar foto" data-en="Change Photo">
                Cambiar foto
            </h2>

            <form action="{{ site_url('perfil/foto') }}"
                  method="POST"
                  enctype="multipart/form-data">

                <input type="hidden"
                       name="{{ csrf_token() }}"
                       value="{{ csrf_hash() }}">

                <div class="campo">
                    <label data-es="Seleccionar fotografía" data-en="Select Photo">
                        Seleccionar fotografía
                    </label>

                    <input type="file"
                           name="foto"
                           accept=".jpg,.jpeg,.png,.webp"
                           required>
                </div>

                <div class="botonesFormulario">

                    <button type="submit"
                            class="boton"
                            data-es="Guardar foto"
                            data-en="Save Photo">
                        Guardar foto
                    </button>

                    <button type="button"
                            class="boton botonSecundario"
                            onclick="cerrarFormularios()"
                            data-es="Cancelar"
                            data-en="Cancel">
                        Cancelar
                    </button>

                </div>

            </form>

        </section>

    </main>

    <script src="{{ base_url('js/language.js') }}"></script>

    <script>
        function mostrarFormulario(idFormulario) {
            document.querySelectorAll('.formulario').forEach(function (formulario) {
                formulario.style.display = 'none';
            });

            document.getElementById(idFormulario).style.display = 'block';
        }

        function cerrarFormularios() {
            document.querySelectorAll('.formulario').forEach(function (formulario) {
                formulario.style.display = 'none';
            });
        }
    </script>

</body>
</html>