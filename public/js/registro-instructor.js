document.getElementById('registroInstructorForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    const mensajeDiv = document.getElementById('mensajeRegistro');

    mensajeDiv.innerHTML = '';

    if (password !== password_confirmation) {
        mensajeDiv.innerHTML = '<div class="alert alert-danger">Las contraseñas no coinciden</div>';
        return;
    }

    try {
        const response = await fetch('/api/register-instructor', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nombre,
                apellido,
                email,
                password,
                password_confirmation
            })
        });

        const data = await response.json();

        if (response.ok) {
            mensajeDiv.innerHTML = '<div class="alert alert-success">Registro exitoso. Redirigiendo al login...</div>';
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        } else {
            const errores = data.errors || {};
            let mensajeError = '<div class="alert alert-danger"><ul class="mb-0">';
            
            for (let campo in errores) {
                errores[campo].forEach(error => {
                    mensajeError += `<li>${error}</li>`;
                });
            }
            
            mensajeError += '</ul></div>';
            mensajeDiv.innerHTML = mensajeError;
        }
    } catch (error) {
        console.error('Error:', error);
        mensajeDiv.innerHTML = '<div class="alert alert-danger">Error al conectar con el servidor</div>';
    }
});
