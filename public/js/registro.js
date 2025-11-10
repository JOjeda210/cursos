document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formRegistro");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const pass = document.getElementById("contrasena").value;
    const conf = document.getElementById("confirmar").value;

    if (!nombre || !apellido || !correo || !pass || !conf) {
      alert("⚠️ Por favor, completa todos los campos.");
      return;
    }

    if (pass !== conf) {
      alert("❌ Las contraseñas no coinciden.");
      return;
    }

    alert(`✅ Registro exitoso.\nBienvenido/a ${nombre} ${apellido}!`);
    form.reset();
  });
});
