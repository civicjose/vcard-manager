<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<<<<<<< HEAD
=======

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Administración</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('vcards.index') }}">vCards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('companies.index') }}">Empresas</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- Mostrar el nombre del usuario autenticado -->
                    <li class="nav-item">
                        <span class="nav-link">Hola, {{ Auth::user()->name }}</span>
                    </li>
                    <!-- Cerrar sesión -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Cerrar sesión</button>
                        </form>
                    </li>
                @endauth

                @guest
                    <!-- Enlaces para iniciar sesión y registrarse si no está autenticado -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
>>>>>>> 2736f2f813a1498ed8ccc38039a773e44d63b147

<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-gray-800 text-white w-64 h-screen flex-shrink-0 transition-transform transform -translate-x-full md:translate-x-0">
        <div class="p-4">
            <h1 class="text-xl font-bold">Administración</h1>
        </div>
        <nav class="mt-4">
            <a href="{{ route('vcards.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">vCards</a>
            <a href="{{ route('companies.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Empresas</a>
        </nav>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar este registro? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <div class="bg-white shadow-md p-4 flex justify-between items-center">
            <!-- Botón para el menú -->
            <button id="menu-btn" class="text-gray-800 focus:outline-none md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <h1 class="text-lg font-bold">@yield('title')</h1>
            <!-- Opciones adicionales como Logout, Perfil, etc. -->
        </div>

        <!-- Main Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Botón para abrir/cerrar el menú
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

    <!-- Vite Scripts -->
    @vite('resources/js/app.js')
</body>

</html>
=======
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let formToSubmit;

        // Capturar el evento de clic en los botones de eliminación
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevenir el envío inmediato del formulario
                formToSubmit = this.closest('form'); // Guardar el formulario que se quiere enviar
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show(); // Mostrar la ventana modal de confirmación
            });
        });

        // Confirmar eliminación y enviar el formulario
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (formToSubmit) {
                formToSubmit.submit(); // Enviar el formulario guardado
            }
        });
    </script>
</body>

</html>
>>>>>>> 2736f2f813a1498ed8ccc38039a773e44d63b147
