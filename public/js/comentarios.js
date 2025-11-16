document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formComentario");
    const mensaje = document.getElementById("mensaje");

    form.addEventListener("submit", (e) => {
        const nombre = document.getElementById("nombre").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const comentario = document.getElementById("comentario").value.trim();
        const rating = document.getElementById("rating").value;

        mensaje.textContent = "";
        mensaje.classList.remove("error", "ok");

        // VALIDACIONES BÁSICAS
        if (nombre === "" || correo === "" || comentario === "" || rating === "") {
            e.preventDefault();
            mensaje.textContent = "⚠ Todos los campos son obligatorios.";
            mensaje.classList.add("error");
            return;
        }

        // Validar formato de correo
        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexCorreo.test(correo)) {
            e.preventDefault();
            mensaje.textContent = "⚠ El correo no es válido.";
            mensaje.classList.add("error");
            return;
        }

        // Si pasa todo → dejar enviar
        mensaje.textContent = "✨ Comentario enviado correctamente";
        mensaje.classList.add("ok");
    });
});
