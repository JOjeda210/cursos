// public/js/inscribir.js
document.addEventListener("DOMContentLoaded", () => {
  // manejador delegado: sirve aunque se agreguen botones dinámicamente
  document.addEventListener("click", async (e) => {
    // si el click fue en un botón de inscribir (o en un hijo)
    const btn = e.target.closest(".btn-inscribir");
    if (!btn) return;

    // leer id desde el atributo data-curso-id
    const idCurso = btn.getAttribute("data-curso-id");
    if (!idCurso) {
      alert("No se encontró el id del curso.");
      return;
    }

    // tomar token JWT desde localStorage
    const token = localStorage.getItem("jwt_token");
    if (!token) {
      alert("Debes iniciar sesión para inscribirte.");
      window.location.href = "/login"; // o la ruta de login que uses
      return;
    }

    // proteger contra doble click
    if (btn.dataset.loading === "1") return;
    btn.dataset.loading = "1";
    const textoAnt = btn.innerText;
    btn.innerText = "Inscribiendo...";
    btn.disabled = true;

    try {
      const resp = await fetch("/api/enroll", {
        method: "POST",
        headers: {
          "Authorization": `Bearer ${token}`,
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify({ id_curso: idCurso })
      });

      // intentar leer JSON (si viene)
      let data = {};
      try { data = await resp.json(); } catch (e) { /* respuesta vacía o no JSON */ }

      if (resp.status === 201) {
        alert("Inscrito correctamente");
        btn.innerText = "Inscrito";
        btn.disabled = true;
      } else if (resp.status === 422) {
        // error de validación / negocio (ej. ya inscrito)
        const msg = data.error || data.mensaje || JSON.stringify(data);
        alert("" + msg);
        btn.innerText = textoAnt;
        btn.disabled = false;
        btn.dataset.loading = "0";
      } else if (resp.status === 401) {
        alert("Tu sesión expiró. Inicia sesión de nuevo.");
        localStorage.removeItem("jwt_token");
        window.location.href = "/login";
      } else {
        const msg = data.message || JSON.stringify(data) || "Error inesperado";
        alert("Error: " + msg);
        btn.innerText = textoAnt;
        btn.disabled = false;
        btn.dataset.loading = "0";
      }
    } catch (err) {
      console.error("Error de red:", err);
      alert("No se pudo conectar con el servidor. Revisa consola / CORS.");
      btn.innerText = textoAnt;
      btn.disabled = false;
      btn.dataset.loading = "0";
    }
  });
});
