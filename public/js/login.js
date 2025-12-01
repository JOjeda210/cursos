document.addEventListener("DOMContentLoaded", () => {
  console.log("Script de login cargado correctamente");

  const form = document.getElementById("formLogin");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const correo = document.getElementById("correo").value.trim();
    const pass = document.getElementById("contrasena").value;

    if (!correo || !pass) {
      alert("Por favor, completa todos los campos.");
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
        // Login exitoso, guardar token con el nombre correcto
        const token = result.token;
        
        console.log("Token recibido del servidor:", token);
        console.log("Longitud del token:", token.length);
        
        // Decodificar y mostrar el payload
        try {
          const payload = JSON.parse(atob(token.split('.')[1]));
          console.log("Payload del token:", payload);
        } catch (e) {
          console.error("Error al decodificar token:", e);
        }
        
        localStorage.setItem("jwt_token", token);
        console.log("Token guardado en localStorage");

        alert("✅ Inicio de sesión exitoso.");

        // Redirigir a mis cursos
        window.location.href = "/mis-cursos";
      } else {
        // Error en las credenciales o usuario
        const mensaje = result.error || "Credenciales incorrectas.";
        alert(`❌ ${mensaje}`);
      }

    } catch (error) {
      console.error("Error de conexión:", error);
      alert("⚠ No se pudo conectar con el servidor.");
    }
  });
});
