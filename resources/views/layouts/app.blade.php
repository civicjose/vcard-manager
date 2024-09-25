<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

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
