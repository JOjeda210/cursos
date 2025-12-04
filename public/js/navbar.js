// Ejecutar la inicialización del navbar de forma segura
(function() {
    'use strict';
    
    function initNavbar() {
        const token = localStorage.getItem("jwt_token");

        const publicLinks = document.getElementById("public-links");
        const privateLinks = document.getElementById("private-links");
        const logoutBtn = document.getElementById("logout-btn");
        const welcomeMessage = document.getElementById("welcome-message");
        const navbarToggler = document.getElementById("navbar-toggler");

        // Verificar que los elementos existan
        if (!publicLinks || !privateLinks || !navbarToggler) {
            console.warn('Navbar elements not found');
            return;
        }

        // Función para cerrar el menú
        const closeMenu = () => {
            publicLinks.classList.remove('active');
            privateLinks.classList.remove('active');
        };

        // Función para agregar eventos de cierre a los enlaces
        const attachCloseEvents = (container) => {
            if (navbarToggler && container) {
                const allLinks = container.querySelectorAll('a');
                allLinks.forEach(link => {
                    link.addEventListener('click', closeMenu);
                });
            }
        };

        // Toggle menú hamburguesa
        navbarToggler.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            publicLinks.classList.toggle('active');
            privateLinks.classList.toggle('active');
        });

        if (token) {
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                const idRol = payload.id_rol;
                const nombre = payload.nombre || '';
                const apellido = payload.apellido || '';

                // Mostrar mensaje de bienvenida
                if (welcomeMessage && nombre) {
                    welcomeMessage.textContent = `Bienvenido ${nombre} ${apellido} a tu aula`;
                    welcomeMessage.classList.remove('hidden');
                }

                publicLinks.classList.add("hidden");
                privateLinks.classList.remove("hidden");

                if (idRol === 1) {
                    privateLinks.innerHTML = `
                        <li><a href="/">Sobre nosotros</a></li>
                        <li><a href="/panel-instructor">Panel Instructor</a></li>
                        <li><a href="#" id="logout-btn-dynamic">Cerrar sesión</a></li>
                    `;
                } else if (idRol === 2) {
                    privateLinks.innerHTML = `
                        <li><a href="/catalogos">Cursos</a></li>
                        <li><a href="/promociones">Promociones</a></li>
                        <li><a href="/mis-cursos">Mis Cursos</a></li>
                        <li><a href="#" id="logout-btn-dynamic">Cerrar sesión</a></li>
                    `;
                }

                // Agregar evento al botón de logout dinámico
                const dynamicLogoutBtn = document.getElementById("logout-btn-dynamic");
                if (dynamicLogoutBtn) {
                    dynamicLogoutBtn.addEventListener("click", (e) => {
                        e.preventDefault();
                        localStorage.removeItem("jwt_token");
                        window.location.href = "/login";
                    });
                }

                // Agregar eventos de cierre de menú después de regenerar el HTML
                attachCloseEvents(privateLinks);

            } catch (error) {
                console.error('Error al decodificar token:', error);
                publicLinks.classList.remove("hidden");
                privateLinks.classList.add("hidden");
                attachCloseEvents(publicLinks);
            }
        } else {
            publicLinks.innerHTML = `
                <li><a href="/">Sobre nosotros</a></li>
                <li><a href="/catalogos">Cursos</a></li>
                <li><a href="/promociones">Promociones</a></li>
                <li><a href="/login">Login</a></li>
                <li><a href="/registro">Registro</a></li>
            `;
            publicLinks.classList.remove("hidden");
            privateLinks.classList.add("hidden");

            // Agregar eventos de cierre de menú después de regenerar el HTML
            attachCloseEvents(publicLinks);
        }

        if (logoutBtn) {
            logoutBtn.addEventListener("click", (e) => {
                e.preventDefault();
                localStorage.removeItem("jwt_token");
                window.location.href = "/login";
            });
        }
    }

    // Ejecutar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavbar);
    } else {
        // DOM ya está listo
        initNavbar();
    }
})();