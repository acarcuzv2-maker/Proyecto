<header class="navbar">

    <div class="navIzquierda">

        <a href="{{ site_url('/') }}" class="marca">
            Básicos Mariano G.
        </a>

        <div class="idiomas">

            <button type="button" id="ingles" onclick="cambiarIdioma('en')">
                English
            </button>

            <button type="button" id="espanol" onclick="cambiarIdioma('es')">
                Español
            </button>

        </div>

    </div>

    <nav class="navDerecha">

        @if(session()->get('sesion_activa'))

            <span class="saludo">
                <span data-es="Hola," data-en="Hello,">Hola,</span>
                {{ session()->get('cuenta_nombre') }}
            </span>

            <a href="{{ site_url('perfil') }}"
               data-es="Perfil"
               data-en="Profile">
                Perfil
            </a>

            <a href="{{ site_url('tareas') }}"
            data-es="Tareas"
            data-en="Tasks">
                Tareas
            </a>

            @if(session()->get('cuenta_rol') === 'admin')

                <a href="{{ site_url('admin/usuarios') }}"
                   data-es="Usuarios"
                   data-en="Users">
                    Usuarios
                </a>

            @endif

            <form action="{{ site_url('salir') }}" method="POST">

                <input type="hidden"
                       name="{{ csrf_token() }}"
                       value="{{ csrf_hash() }}">

                <button type="submit"
                        class="botonSalir"
                        data-es="Cerrar sesión"
                        data-en="Log Out">
                    Cerrar sesión
                </button>

            </form>

        @else

            <a href="{{ site_url('registro') }}"
               class="registro"
               data-es="Registrarse"
               data-en="Sign Up">
                Registrarse
            </a>

            <a href="{{ site_url('login') }}"
               data-es="Iniciar sesión"
               data-en="Log In">
                Iniciar sesión
            </a>

        @endif

    </nav>

</header>