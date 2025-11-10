document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formLogin");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const correo = document.getElementById("correo").value.trim();
    const contrasena = document.getElementById("contrasena").value;

    if (!correo || !contrasena) {
      alert("⚠️ Por favor, completa todos los campos.");
      return;
    }

    // Simulación de verificación simple
    if (correo === "usuario@ejemplo.com" && contrasena === "1234") {
      alert("✅ Inicio de sesión exitoso. ¡Bienvenido de nuevo!");
      form.reset();
      // Redirección simulada
      window.location.href = "catalogo.html";
    } else {
      alert("❌ Credenciales incorrectas. Inténtalo de nuevo.");
    }
  });
});
