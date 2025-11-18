<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos (Laravel)</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/Miscursos.css') }}">
</head>

<body class="gradient-bg">

    <section class="banner-section text-center py-5">
        <div class="container">
            <h1>Mis Cursos</h1>
            <p>Accede a todos los cursos en los que estás inscrito</p>
        </div>
    </section>

    <section class="cursos-section py-5">
        <div class="container">
            <h2 class="text-center mb-2">Cursos Activos</h2>
            <p class="descripcion text-center mb-5">Continúa tu aprendizaje en los cursos que has adquirido</p>

            <div class="row g-4 justify-content-center" id="cursos-container">
            </div>
        </div>
    </section>
    
    <div class="modal fade" id="modalPython" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    <header class="course-header text-white py-5">
                        <div class="container">
                            <a href="#" class="btn btn-back mb-4" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i> Volver a Mis Cursos</a>
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <h1 class="course-title display-4">Programación en Python</h1>
                                    <div class="course-meta d-flex gap-4 mb-4">
                                        <span><i class="bi bi-book"></i> 20 lecciones</span>
                                        <span><i class="bi bi-clock"></i> 10 horas de contenido</span>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <img src="{{ asset('img/python.png') }}" class="img-fluid course-hero-img" alt="Curso de Python">
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="course-content-section py-5">
                        <div class="container">
                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <a href="#" class="btn btn-primary-gradient"><i class="bi bi-check-circle-fill"></i> Marcar como completada</a>
                                        <a href="#" class="btn btn-light-gray">Siguiente lección <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="lesson-card p-4 p-md-5 mb-4">
                                        <h2 class="mb-3">Sobre esta lección</h2>
                                        <p class="text-secondary mb-4">Aprende los fundamentos de Python, el lenguaje de programación más popular y versátil del mundo. Exploraremos desde la sintaxis básica hasta la creación de programas funcionales.</p>
                                        <p class="text-secondary mb-4">Este curso está diseñado para principiantes sin experiencia previa en programación, pero también es útil para quienes desean reforzar sus conocimientos en Python o migrar desde otros lenguajes.</p>
                                        <h3 class="h5 mb-3">Recursos descargables</h3>
                                        <ul class="resource-list list-unstyled d-grid gap-2">
                                            <li><a href="#"><i class="bi bi-file-earmark-pdf"></i> Guía de instalación de Python (PDF)</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-zip"></i> Código fuente de ejemplos de la lección 1</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-text"></i> Hoja de trucos de Python (Cheatsheet)</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="curriculum-card p-4">
                                        <h2 class="h4 mb-4">Contenido del Curso</h2>
                                        <div class="accordion" id="accordionPython">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePythonOne" aria-expanded="true"><span>Módulo 1: Introducción a Python</span><small>2 lecciones</small></button></h2>
                                                <div id="collapsePythonOne" class="accordion-collapse collapse show" data-bs-parent="#accordionPython">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="Python">
                                                            <li class="lesson-item active" data-lesson-id="Python-1-1"><i class="bi bi-check-circle-fill status-icon completed"></i><div class="info"><span>1.1 Qué es Python y por qué usarlo</span><small>5:30</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="Python-1-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.2 Instalación y entorno de desarrollo</span><small>8:15</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePythonTwo" aria-expanded="false"><span>Módulo 2: Variables y Tipos de Datos</span><small>3 lecciones</small></button></h2>
                                                <div id="collapsePythonTwo" class="accordion-collapse collapse" data-bs-parent="#accordionPython">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="Python-2">
                                                            <li class="lesson-item" data-lesson-id="Python-2-1"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.1 Números y operadores</span><small>7:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="Python-2-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.2 Cadenas de texto (Strings)</span><small>10:20</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="Python-2-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.3 Booleanos y valores nulos</span><small>6:40</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUIUX" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                     <header class="course-header text-white py-5">
                        <div class="container">
                            <a href="#" class="btn btn-back mb-4" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i> Volver a Mis Cursos</a>
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <h1 class="course-title display-4">Diseño UI/UX</h1>
                                    <div class="course-meta d-flex gap-4 mb-4">
                                        <span><i class="bi bi-book"></i> 13 lecciones</span>
                                        <span><i class="bi bi-clock"></i> 8 horas de contenido</span>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <img src="{{ asset('img/uiux.png') }}" class="img-fluid course-hero-img" alt="Diseño UI/UX">
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="course-content-section py-5">
                        <div class="container">
                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <a href="#" class="btn btn-primary-gradient"><i class="bi bi-check-circle-fill"></i> Marcar como completada</a>
                                        <a href="#" class="btn btn-light-gray">Siguiente lección <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="lesson-card p-4 p-md-5 mb-4">
                                        <h2 class="mb-3">Sobre esta lección</h2>
                                        <p class="text-secondary mb-4">En este curso, te sumergirás en el fascinante mundo del Diseño de Experiencia de Usuario (UX) y Diseño de Interfaz de Usuario (UI). Aprenderás a crear productos digitales que no solo lucen bien, sino que también son intuitivos, fáciles de usar y satisfacen las necesidades de los usuarios.</p>
                                        <p class="text-secondary mb-4">Cubriremos desde la investigación de usuarios y la creación de prototipos, hasta la implementación de principios de diseño visual y pruebas de usabilidad.</p>
                                        <h3 class="h5 mb-3">Recursos descargables</h3>
                                        <ul class="resource-list list-unstyled d-grid gap-2">
                                            <li><a href="#"><i class="bi bi-file-earmark-pdf"></i> Glosario de términos UI/UX (PDF)</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-zip"></i> Plantillas de Wireframes y Mockups</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-text"></i> Ejercicios prácticos de ideación</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="curriculum-card p-4">
                                        <h2 class="h4 mb-4">Contenido del Curso</h2>
                                        <div class="accordion" id="accordionUIUX">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUIUXOne" aria-expanded="true"><span>Módulo 1: Introducción al UI/UX</span><small>3 lecciones</small></button></h2>
                                                <div id="collapseUIUXOne" class="accordion-collapse collapse show" data-bs-parent="#accordionUIUX">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="UIUX">
                                                            <li class="lesson-item active" data-lesson-id="UIUX-1-1"><i class="bi bi-check-circle-fill status-icon completed"></i><div class="info"><span>1.1 ¿Qué es UI/UX y su importancia?</span><small>5:30</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="UIUX-1-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.2 El proceso de diseño UX</span><small>8:15</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="UIUX-1-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.3 Herramientas de diseño</span><small>4:45</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUIUXTwo" aria-expanded="false"><span>Módulo 2: Investigación de Usuarios</span><small>3 lecciones</small></button></h2>
                                                <div id="collapseUIUXTwo" class="accordion-collapse collapse" data-bs-parent="#accordionUIUX">
                                                    <div class="accordion-body">
                                                         <ul class="lesson-list list-unstyled" data-course-id="UIUX-2">
                                                            <li class="lesson-item" data-lesson-id="UIUX-2-1"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.1 Creación de User Personas</span><small>12:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="UIUX-2-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.2 Mapas de empatía</span><small>9:10</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="UIUX-2-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.3 Entrevistas y encuestas</span><small>15:00</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMarketing" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    <header class="course-header text-white py-5">
                        <div class="container">
                            <a href="#" class="btn btn-back mb-4" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i> Volver a Mis Cursos</a>
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <h1 class="course-title display-4">Marketing Digital</h1>
                                    <div class="course-meta d-flex gap-4 mb-4">
                                        <span><i class="bi bi-book"></i> 15 lecciones</span>
                                        <span><i class="bi bi-clock"></i> 7 horas de contenido</span>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <img src="{{ asset('img/marketing.png') }}" class="img-fluid course-hero-img" alt="Curso de Marketing">
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="course-content-section py-5">
                         <div class="container">
                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <a href="#" class="btn btn-primary-gradient"><i class="bi bi-check-circle-fill"></i> Marcar como completada</a>
                                        <a href="#" class="btn btn-light-gray">Siguiente lección <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="lesson-card p-4 p-md-5 mb-4">
                                        <h2 class="mb-3">Sobre esta lección</h2>
                                        <p class="text-secondary mb-4">Aprende a crear estrategias de marketing efectivas en el mundo digital. Cubriremos todo sobre SEO, SEM, marketing en redes sociales y email marketing para hacer crecer cualquier negocio.</p>
                                        <h3 class="h5 mb-3">Recursos descargables</h3>
                                        <ul class="resource-list list-unstyled d-grid gap-2">
                                            <li><a href="#"><i class="bi bi-file-earmark-pdf"></i> Guía de términos de Marketing (PDF)</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-text"></i> Plantilla de calendario de contenidos</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="curriculum-card p-4">
                                        <h2 class="h4 mb-4">Contenido del Curso</h2>
                                        <div class="accordion" id="accordionMarketing">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMktOne" aria-expanded="true"><span>Módulo 1: Fundamentos de SEO</span><small>3 lecciones</small></button></h2>
                                                <div id="collapseMktOne" class="accordion-collapse collapse show" data-bs-parent="#accordionMarketing">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="Marketing">
                                                            <li class="lesson-item active" data-lesson-id="Mkt-1-1"><i class="bi bi-check-circle-fill status-icon completed"></i><div class="info"><span>1.1 Qué es el SEO</span><small>6:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="Mkt-1-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.2 SEO On-Page vs Off-Page</span><small>10:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="Mkt-1-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.3 Investigación de Palabras Clave</span><small>12:00</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExcel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                     <header class="course-header text-white py-5">
                        <div class="container">
                            <a href="#" class="btn btn-back mb-4" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i> Volver a Mis Cursos</a>
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <h1 class="course-title display-4">Excel Avanzado</h1>
                                    <div class="course-meta d-flex gap-4 mb-4">
                                        <span><i class="bi bi-book"></i> 25 lecciones</span>
                                        <span><i class="bi bi-clock"></i> 12 horas de contenido</span>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <img src="{{ asset('img/excel.png') }}" class="img-fluid course-hero-img" alt="Curso de Excel">
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="course-content-section py-5">
                         <div class="container">
                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <a href="#" class="btn btn-primary-gradient"><i class="bi bi-check-circle-fill"></i> Marcar como completada</a>
                                        <a href="#" class="btn btn-light-gray">Siguiente lección <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="lesson-card p-4 p-md-5 mb-4">
                                        <h2 class="mb-3">Sobre esta lección</h2>
                                        <p class="text-secondary mb-4">Lleva tus habilidades de Excel al siguiente nivel. Aprende a manipular grandes volúmenes de datos, crear dashboards interactivos y automatizar tareas repetitivas con macros y VBA.</p>
                                        <h3 class="h5 mb-3">Recursos descargables</h3>
                                        <ul class="resource-list list-unstyled d-grid gap-2">
                                            <li><a href="#"><i class="bi bi-file-earmark-spreadsheet"></i> Libro de trabajo con datos de práctica</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-pdf"></i> Lista de atajos de teclado (PDF)</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="curriculum-card p-4">
                                        <h2 class="h4 mb-4">Contenido del Curso</h2>
                                        <div class="accordion" id="accordionExcel">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExcelOne" aria-expanded="true"><span>Módulo 1: Tablas Dinámicas</span><small>5 lecciones</small></button></h2>
                                                <div id="collapseExcelOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExcel">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="Excel">
                                                            <li class="lesson-item active" data-lesson-id="Excel-1-1"><i class="bi bi-check-circle-fill status-icon completed"></i><div class="info"><span>1.1 Creación de Tablas Dinámicas</span><small>10:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="Excel-1-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.2 Segmentación de datos (Slicers)</span><small>8:00</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMySQL" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    <header class="course-header text-white py-5">
                        <div class="container">
                            <a href="#" class="btn btn-back mb-4" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i> Volver a Mis Cursos</a>
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <h1 class="course-title display-4">Bases de Datos con MySQL</h1>
                                    <div class="course-meta d-flex gap-4 mb-4">
                                        <span><i class="bi bi-book"></i> 18 lecciones</span>
                                        <span><i class="bi bi-clock"></i> 9 horas de contenido</span>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <img src="{{ asset('img/mysql.png') }}" class="img-fluid course-hero-img" alt="Curso de MySQL">
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="course-content-section py-5">
                         <div class="container">
                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <a href="#" class="btn btn-primary-gradient"><i class="bi bi-check-circle-fill"></i> Marcar como completada</a>
                                        <a href="#" class="btn btn-light-gray">Siguiente lección <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="lesson-card p-4 p-md-5 mb-4">
                                        <h2 class="mb-3">Sobre esta lección</h2>
                                        <p class="text-secondary mb-4">Aprende a diseñar, consultar y administrar bases de datos relacionales. MySQL es la base de datos de código abierto más popular del mundo, esencial para cualquier desarrollador web o analista de datos.</p>
                                        <h3 class="h5 mb-3">Recursos descargables</h3>
                                        <ul class="resource-list list-unstyled d-grid gap-2">
                                            <li><a href="#"><i class="bi bi-file-earmark-pdf"></i> Guía de instalación de MySQL (PDF)</a></li>
                                            <li><a href="#"><i class="bi bi-filetype-sql"></i> Script de base de datos de ejemplo</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="curriculum-card p-4">
                                        <h2 class="h4 mb-4">Contenido del Curso</h2>
                                        <div class="accordion" id="accordionMySQL">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSQLOne" aria-expanded="true"><span>Módulo 1: Consultas Básicas (SELECT)</span><small>4 lecciones</small></button></h2>
                                                <div id="collapseSQLOne" class="accordion-collapse collapse show" data-bs-parent="#accordionMySQL">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="MySQL">
                                                            <li class="lesson-item active" data-lesson-id="MySQL-1-1"><i class="bi bi-check-circle-fill status-icon completed"></i><div class="info"><span>1.1 La sentencia SELECT</span><small>5:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="MySQL-1-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.2 Filtrando con WHERE</span><small>7:30</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="MySQL-1-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.3 Ordenando con ORDER BY</span><small>4:00</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalJS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    <header class="course-header text-white py-5">
                        <div class="container">
                            <a href="#" class="btn btn-back mb-4" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i> Volver a Mis Cursos</a>
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <h1 class="course-title display-4">JavaScript Moderno</h1>
                                    <div class="course-meta d-flex gap-4 mb-4">
                                        <span><i class="bi bi-book"></i> 30 lecciones</span>
                                        <span><i class="bi bi-clock"></i> 15 horas de contenido</span>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4 mt-lg-0">
                                    <img src="{{ asset('img/javascript.png') }}" class="img-fluid course-hero-img" alt="Curso de JavaScript">
                                </div>
                            </div>
                        </div>
                    </header>
                    <main class="course-content-section py-5">
                         <div class="container">
                            <div class="row g-4 g-lg-5">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        <a href="#" class="btn btn-primary-gradient"><i class="bi bi-check-circle-fill"></i> Marcar como completada</a>
                                        <a href="#" class="btn btn-light-gray">Siguiente lección <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                    <div class="lesson-card p-4 p-md-5 mb-4">
                                        <h2 class="mb-3">Sobre esta lección</h2>
                                        <p class="text-secondary mb-4">Domina el lenguaje de la web. Este curso cubre todo, desde los fundamentos de la sintaxis de JavaScript hasta temas avanzados como ES6+, asincronía (promesas, async/await) y manipulación del DOM.</p>
                                        <h3 class="h5 mb-3">Recursos descargables</h3>
                                        <ul class="resource-list list-unstyled d-grid gap-2">
                                            <li><a href="#"><i class="bi bi-file-earmark-pdf"></i> Referencia de ES6+ (PDF)</a></li>
                                            <li><a href="#"><i class="bi bi-file-earmark-zip"></i> Proyectos de práctica</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="curriculum-card p-4">
                                        <h2 class="h4 mb-4">Contenido del Curso</h2>
                                        <div class="accordion" id="accordionJS">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJSOne" aria-expanded="true"><span>Módulo 1: Manipulación del DOM</span><small>4 lecciones</small></button></h2>
                                                <div id="collapseJSOne" class="accordion-collapse collapse show" data-bs-parent="#accordionJS">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="JS">
                                                            <li class="lesson-item active" data-lesson-id="JS-1-1"><i class="bi bi-check-circle-fill status-icon completed"></i><div class="info"><span>1.1 Qué es el DOM</span><small>8:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="JS-1-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.2 Seleccionando elementos</span><small>10:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="JS-1-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.3 Modificando elementos</span><small>9:30</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="JS-1-4"><i class="bi bi-circle status-icon"></i><div class="info"><span>1.4 Eventos (Listeners)</span><small>12:00</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJSTwo" aria-expanded="false"><span>Módulo 2: JavaScript Asíncrono</span><small>3 lecciones</small></button></h2>
                                                <div id="collapseJSTwo" class="accordion-collapse collapse" data-bs-parent="#accordionJS">
                                                    <div class="accordion-body">
                                                        <ul class="lesson-list list-unstyled" data-course-id="JS-2">
                                                            <li class="lesson-item" data-lesson-id="JS-2-1"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.1 Promesas</span><small>15:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="JS-2-2"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.2 Async/Await</span><small>12:00</small></div></li>
                                                            <li class="lesson-item" data-lesson-id="JS-2-3"><i class="bi bi-circle status-icon"></i><div class="info"><span>2.3 Fetch API</span><small>14:00</small></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/mis_cursos.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.addEventListener('click', function(event) {
                const currentLesson = event.target.closest('.lesson-item');
                if (!currentLesson) return;

                const lessonListElement = currentLesson.closest('.lesson-list');
                if (!lessonListElement) return;

                const courseId = lessonListElement.dataset.courseId;
                if (!courseId) return;

                const courseLessons = document.querySelectorAll(`.lesson-list[data-course-id="${courseId}"] .lesson-item`);
                
                courseLessons.forEach(item => {
                    item.classList.remove('active');
                });

                currentLesson.classList.add('active');

                const icon = currentLesson.querySelector('.status-icon');
                if (icon) {
                    icon.classList.remove('bi-circle');
                    icon.classList.add('bi-check-circle-fill', 'completed');
                }
            });
        });
    </script>
</body>
</html>