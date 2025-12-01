<!-- Navegación del Panel de Instructor -->
<nav class="instructor-nav bg-white shadow-sm mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 me-4 text-primary fw-bold">
                    <i class="bi bi-mortarboard"></i> Panel Instructor
                </h5>
                <div class="nav-pills d-flex gap-2">
                    <a href="/panel-instructor" class="nav-link {{ Request::is('panel-instructor') ? 'active' : '' }}">
                        <i class="bi bi-collection"></i> Cursos
                    </a>
                    <a href="/panel-instructor/modulos" class="nav-link {{ Request::is('panel-instructor/modulos') ? 'active' : '' }}">
                        <i class="bi bi-folder"></i> Módulos
                    </a>
                    <a href="/panel-instructor/lecciones" class="nav-link {{ Request::is('panel-instructor/lecciones') ? 'active' : '' }}">
                        <i class="bi bi-book"></i> Lecciones
                    </a>
                    <a href="/panel-instructor/recursos" class="nav-link {{ Request::is('panel-instructor/recursos') ? 'active' : '' }}">
                        <i class="bi bi-paperclip"></i> Recursos
                    </a>
                </div>
            </div>
            <div class="nav-actions">
                <button onclick="irACursos()" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver a Cursos
                </button>
            </div>
        </div>
    </div>
</nav>

<style>
    .instructor-nav {
        border-bottom: 1px solid #dee2e6;
    }
    
    .nav-pills .nav-link {
        background: transparent;
        color: #6c757d;
        border-radius: 50px;
        padding: 8px 16px;
        text-decoration: none;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    
    .nav-pills .nav-link:hover {
        background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);
        color: white;
        border-color: transparent;
    }
    
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);
        color: white;
    }
    
    .nav-actions .btn {
        border-radius: 50px;
    }
</style>

<script>
    function irACursos() {
        window.location.href = '/panel-instructor';
    }
</script>