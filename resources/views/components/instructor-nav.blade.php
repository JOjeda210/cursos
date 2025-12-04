<!-- Navegación del Panel de Instructor -->
<nav class="instructor-nav bg-white shadow-sm mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3 flex-wrap">
            <div class="d-flex align-items-center w-100">
                <h5 class="mb-0 me-4 text-primary fw-bold">
                    <i class="bi bi-mortarboard"></i> Panel Instructor
                </h5>
                <button class="instructor-nav-toggler ms-auto d-md-none" id="instructor-nav-toggler" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            <div class="instructor-nav-content w-100" id="instructor-nav-content">
                <div class="nav-pills d-flex gap-2 flex-wrap my-3 my-md-0">
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
                <div class="nav-actions mt-3 mt-md-0">
                    <button onclick="irACursos()" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver a Cursos
                    </button>
                </div>
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

    /* Botón hamburguesa del instructor */
    .instructor-nav-toggler {
        background: transparent;
        border: 2px solid #7e22ce;
        font-size: 28px;
        cursor: pointer;
        padding: 5px 10px;
        transition: all 0.3s ease;
        color: #7e22ce;
        border-radius: 8px;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .instructor-nav-toggler:hover {
        transform: scale(1.1);
        background: rgba(126, 34, 206, 0.1);
    }

    .instructor-nav-toggler:active {
        transform: scale(0.95);
    }

    /* Responsividad */
    @media (max-width: 768px) {
        .instructor-nav-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }

        .instructor-nav-content.active {
            max-height: 500px;
        }

        .nav-pills {
            flex-direction: column;
            width: 100%;
        }

        .nav-pills .nav-link {
            width: 100%;
            text-align: center;
        }

        .nav-actions {
            width: 100%;
        }

        .nav-actions .btn {
            width: 100%;
        }
    }

    @media (min-width: 769px) {
        .instructor-nav-toggler {
            display: none;
        }

        .instructor-nav-content {
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            max-height: none !important;
        }
    }
</style>

<script>
    function irACursos() {
        window.location.href = '/panel-instructor';
    }

    // Toggle menú del instructor - Ejecutar inmediatamente y también en DOMContentLoaded
    (function() {
        function initInstructorNav() {
            const instructorToggler = document.getElementById('instructor-nav-toggler');
            const instructorContent = document.getElementById('instructor-nav-content');

            console.log('Instructor Nav Init:', { 
                toggler: !!instructorToggler, 
                content: !!instructorContent 
            });

            if (instructorToggler && instructorContent) {
                // Remover eventos anteriores si existen
                const newToggler = instructorToggler.cloneNode(true);
                instructorToggler.parentNode.replaceChild(newToggler, instructorToggler);
                
                newToggler.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Toggle clicked!');
                    instructorContent.classList.toggle('active');
                });

                // Cerrar menú al hacer click en un enlace
                const navLinks = instructorContent.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        instructorContent.classList.remove('active');
                    });
                });
            }
        }

        // Ejecutar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initInstructorNav);
        } else {
            initInstructorNav();
        }
    })();
</script>