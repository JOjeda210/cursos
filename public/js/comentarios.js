document.addEventListener("DOMContentLoaded", () => {
    // Escuchar submit en cualquier formulario de comentarios
    document.addEventListener("submit", async (e) => {
        // Verificar si es un formulario de comentarios
        if (!e.target.id || !e.target.id.startsWith("formComentario")) {
            return;
        }

        e.preventDefault();

        const form = e.target;
        const cursoId = form.querySelector('input[name="id_curso"]')?.value;
        const comentarioField = form.querySelector('textarea[name="comentario"]');
        const ratingField = form.querySelector('input[name="rating"]');
        
        // Buscar el mensaje en el modal-body más cercano
        const modalBody = form.closest('.modal-body');
        const mensaje = modalBody ? modalBody.querySelector('.mensaje') : null;

        if (!comentarioField || !ratingField || !mensaje) {
            console.error("Campos del formulario no encontrados", {
                comentarioField: !!comentarioField,
                ratingField: !!ratingField,
                mensaje: !!mensaje,
                modalBody: !!modalBody
            });
            return;
        }

        const comentario = comentarioField.value.trim();
        const rating = ratingField.value;

        // Limpiar mensaje anterior
        mensaje.textContent = "";
        mensaje.classList.remove("error", "ok");

        // VALIDACIONES BÁSICAS
        if (comentario === "" || rating === "") {
            mensaje.textContent = "Todos los campos son obligatorios.";
            mensaje.classList.add("error");
            return;
        }

        if (!cursoId) {
            mensaje.textContent = "No se especificó el curso.";
            mensaje.classList.add("error");
            return;
        }

        // Obtener token JWT
        const token = localStorage.getItem("jwt_token");
        if (!token) {
            mensaje.textContent = "Debes iniciar sesión para comentar.";
            mensaje.classList.add("error");
            setTimeout(() => {
                window.location.href = "/login";
            }, 2000);
            return;
        }

        // Deshabilitar botón de envío
        const btnSubmit = form.querySelector('button[type="submit"]');
        const textoOriginal = btnSubmit.textContent;
        btnSubmit.disabled = true;
        btnSubmit.textContent = "Enviando...";

        try {
            const response = await fetch("http://plataforma-cursos-appsweb.test/api/comentarios", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    id_curso: parseInt(cursoId),
                    contenido: comentario
                })
            });

            const data = await response.json();

            if (response.ok) {
                mensaje.textContent = (data.mensaje || "Comentario enviado correctamente");
                mensaje.classList.add("ok");
                
                // Limpiar formulario
                comentarioField.value = "";
                ratingField.value = "";

                // Cerrar modal después de 2 segundos
                setTimeout(() => {
                    const modalElement = form.closest('.modal');
                    if (modalElement) {
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) modal.hide();
                    }
                }, 2000);

            } else if (response.status === 401) {
                mensaje.textContent = "⚠ Tu sesión expiró. Redirigiendo al login...";
                mensaje.classList.add("error");
                localStorage.removeItem("jwt_token");
                setTimeout(() => {
                    window.location.href = "/login";
                }, 2000);

            } else {
                mensaje.textContent = "⚠ " + (data.error || data.mensaje || "Error al enviar el comentario");
                mensaje.classList.add("error");
            }

        } catch (error) {
            console.error("Error al enviar comentario:", error);
            mensaje.textContent = "⚠ Error de conexión. Intenta de nuevo.";
            mensaje.classList.add("error");

        } finally {
            // Rehabilitar botón
            btnSubmit.disabled = false;
            btnSubmit.textContent = textoOriginal;
        }
    });
});
