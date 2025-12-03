document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formRegistro");
    console.log(" Script de registro cargado correctamente");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const pass = document.getElementById("contrasena").value;
    const conf = document.getElementById("confirmar").value;

    // Validaciones básicas del front
    if (!nombre || !apellido || !correo || !pass || !conf) {
      alert("Por favor, completa todos los campos.");
      return;
    }

    if (pass !== conf) {
      alert(" Las contraseñas no coinciden.");
      return;
    }

    //  Datos a enviar al backend
    const data = {
      nombre: nombre,
      apellido: apellido,
      email: correo,
      password: pass,
      password_confirmation: conf,
    };

    try {
      const response = await fetch("/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      if (response.ok) {
        //  Registro exitoso
        alert(` Registro exitoso.\nBienvenido/a ${result.nombre} ${result.apellido}!`);
        console.log("Usuario registrado:", result);
        form.reset();

        // opcional: redirigir al login
        window.location.href = "/login";
      } else {
        //  Error devuelto por el backend
        const mensaje = result.message || result.error || "Error al registrar usuario.";
        alert(` ${mensaje}`);
        console.error("Respuesta del servidor:", result);
      }
    } catch (error) {
      //  Error de conexión o fetch
      alert(" Error de conexión con el servidor.");
      console.error("Error:", error);
    }
  });
});
