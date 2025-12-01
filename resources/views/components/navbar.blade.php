<nav class="navbar">
    <div class="nav-container">

        <!-- LOGO -->
        <a href="/" class="logo">MiPlataforma</a>

        <!-- MENSAJE DE BIENVENIDA -->
        <div class="welcome-message hidden" id="welcome-message" style="color: white; font-weight: 500; margin-left: 20px;"></div>

        <!-- LINKS CUANDO NO ESTÁ LOGUEADO -->
        <ul class="nav-links" id="public-links">
            <li><a href="/">Sobre nosotros</a></li>
            <li><a href="/catalogos">Catálogo de cursos</a></li>
            <li><a href="/promociones">Promociones</a></li>
            <li><a href="/login">Login</a></li>
            <li><a href="/registro">Registro</a></li>
        </ul>

        <!-- LINKS CUANDO SÍ ESTÁ LOGUEADO -->
        <ul class="nav-links hidden" id="private-links">
            <li><a href="/">Sobre nosotros</a></li>
            <li><a href="/catalogos">Catálogo de cursos</a></li>
            <li><a href="/promociones">Promociones</a></li>
            <li><a href="/cursos-privados">Mis cursos</a></li>
            <li><a href="#" id="logout-btn">Cerrar sesión</a></li>
        </ul>

    </div>
</nav>

<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

<script src="{{ asset('js/navbar.js') }}" defer></script>
