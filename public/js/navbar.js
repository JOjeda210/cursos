document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem("token");

    const publicLinks = document.getElementById("public-links");
    const privateLinks = document.getElementById("private-links");
    const logoutBtn = document.getElementById("logout-btn");

    // Si hay token → está logueado
    if (token) {
        publicLinks.classList.add("hidden");
        privateLinks.classList.remove("hidden");
    } else {
        publicLinks.classList.remove("hidden");
        privateLinks.classList.add("hidden");
    }

    // Cerrar sesión
    if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
            localStorage.removeItem("token");
            window.location.href = "/login";
        });
    }
});
