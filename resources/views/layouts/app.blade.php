<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VIP2Cars - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #ffffff;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #100E24;
            color: #fff;
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar h4 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .sidebar .menu-item {
            margin-bottom: 0.5rem;
        }
        .sidebar .menu-item > a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            color: #fff;
            text-decoration: none;
            border-radius: 0.25rem;
        }
        .sidebar .menu-item > a:hover {
            background-color: #1a1735;
        }
        .sidebar .submenu {
            margin-left: 1rem;
            margin-top: 0.25rem;
            display: none;
            flex-direction: column;
        }
        .sidebar .submenu a {
            padding: 0.25rem 1rem;
            font-size: 0.9rem;
            color: #ddd;
        }
        .sidebar .submenu a:hover {
            color: #fff;
            background-color: #2a2640;
            border-radius: 0.25rem;
        }

        /* Content */
        .content {
            margin-left: 260px;
            padding: 2rem;
        }

    </style>
</head>
<body>

<div class="sidebar">
    <h4>VIP2Cars</h4>

    <!-- Clientes -->
    <div class="menu-item">
        <a href="#" onclick="toggleSubmenu('submenuClientes')">
            <span><i class="bi bi-people-fill me-2"></i> Clientes</span>
            <i class="bi bi-chevron-down"></i>
        </a>
        <div class="submenu" id="submenuClientes">
            <a href="{{ route('clientes.index') }}"><i class="bi bi-list me-1"></i> Listado</a>          
        </div>
    </div>

    <!-- Vehículos -->
    <div class="menu-item">
        <a href="#" onclick="toggleSubmenu('submenuVehiculos')">
            <span><i class="bi bi-car-front-fill me-2"></i> Vehículos</span>
            <i class="bi bi-chevron-down"></i>
        </a>
        <div class="submenu" id="submenuVehiculos">
            <a href="{{ route('vehiculos.index') }}"><i class="bi bi-list me-1"></i> Listado</a>           
        </div>
    </div>

    <!-- Encuesta -->
    <div class="menu-item">
        <a href="#" onclick="toggleSubmenu('submenuEncuesta')">
            <span><i class="bi bi-journal-text me-2"></i> Encuesta</span>
            <i class="bi bi-chevron-down"></i>
        </a>
        <div class="submenu" id="submenuEncuesta">
            <a href="{{ route('cliente_vehiculo.index') }}"><i class="bi bi-list me-1"></i> Listado</a>
        </div>
    </div>
</div>

<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.style.display = submenu.style.display === 'flex' ? 'none' : 'flex';
    }
</script>

</body>
</html>