document.addEventListener("DOMContentLoaded", () => {
  console.log("Script de login cargado correctamente");

  const form = document.getElementById("formLogin");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const correo = document.getElementById("correo").value.trim();
    const pass = document.getElementById("contrasena").value;

    if (!correo || !pass) {
      alert(" Por favor, completa todos los campos.");
      return;
    }

    const data = {
      email: correo,
      password: pass,
    };

    try {
      const response = await fetch("http://plataforma-cursos-appsweb.test/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();
      console.log("Respuesta del servidor:", result);

      if (response.ok) {
        //  Login exitoso, guardar token
        const token = result.token;
        localStorage.setItem("auth_token", token);

        alert("✅ Inicio de sesión exitoso.");
        console.log(" Token guardado:", token); // Eliminar 

        // Redirigir al panel o inicio
        window.location.href = "/catalogos";
        //  Error en las credenciales o usuario
        const mensaje = result.error || "Credenciales incorrectas.";
        alert(` ${mensaje}`);
      }

    } catch (error) {
      console.error(" Error de conexión:", error);
      alert(" No se pudo conectar con el servidor.");
    }
  });
});
