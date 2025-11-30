// --- Recursos ---
function verRecursos(leccionId) {
    listaRecursos.innerHTML = "";
    recursosCard.classList.remove("d-none");
    leccionActualId = leccionId;

    // CORREGIDO: "lecciones" en lugar de "leccions"
    fetch(`${BASE_API}lecciones/${leccionId}/recursos`, { 
        headers: { Authorization: `Bearer ${token}` }
    })
        .then(res => res.json())
        .then(recursos => {
            listaRecursos.innerHTML = "";

            recursos.forEach(r => {
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.innerHTML = `
                    <div>
                        <strong>${r.nombre}</strong> — 
                        <a href="${r.url}" target="_blank">Ver</a>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary editarRecursoBtn" 
                            data-id="${r.id}" 
                            data-nombre="${r.nombre}" 
                            data-url="${r.url}">
                            Editar
                        </button>

                        <button class="btn btn-sm btn-danger eliminarRecursoBtn" 
                            data-id="${r.id}">
                            Eliminar
                        </button>
                    </div>
                `;
                listaRecursos.appendChild(li);
            });

            // Botón editar
            document.querySelectorAll(".editarRecursoBtn").forEach(btn => {
                btn.addEventListener("click", () => {
                    recursoIdInput.value = btn.dataset.id;
                    nombreRecursoInput.value = btn.dataset.nombre;
                    urlRecursoInput.value = btn.dataset.url;
                    guardarRecursoBtn.textContent = "Actualizar recurso";
                    cancelarRecursoBtn.classList.remove("d-none");
                });
            });

            // Botón eliminar
            document.querySelectorAll(".eliminarRecursoBtn").forEach(btn => {
                btn.addEventListener("click", () => {
                    if (!confirm("¿Deseas eliminar este recurso?")) return;

                    fetch(`${BASE_API}recursos/${btn.dataset.id}`, {
                        method: "DELETE",
                        headers: { Authorization: `Bearer ${token}` }
                    }).then(() => verRecursos(leccionId));
                });
            });
        });
}

guardarRecursoBtn.addEventListener("click", () => {
    const id = recursoIdInput.value;
    const nombre = nombreRecursoInput.value;
    const url = urlRecursoInput.value;

    if (!nombre || !url || !leccionActualId) {
        alert("Completa todos los campos");
        return;
    }

    // CORREGIDO: PUT para actualizar, POST para crear
    const method = id ? "PUT" : "POST";
    const urlApi = id 
        ? `${BASE_API}recursos/${id}` 
        : `${BASE_API}recursos`;

    fetch(urlApi, {
        method,
        headers: { 
            "Authorization": `Bearer ${token}`, 
            "Content-Type": "application/json" 
        },
        body: JSON.stringify({
            nombre,
            url,
            leccion_id: leccionActualId
        })
    }).then(() => {
        // Reset del formulario
        recursoIdInput.value = "";
        nombreRecursoInput.value = "";
        urlRecursoInput.value = "";
        guardarRecursoBtn.textContent = "Guardar recurso";
        cancelarRecursoBtn.classList.add("d-none");

        verRecursos(leccionActualId);
    });
});

cancelarRecursoBtn.addEventListener("click", () => {
    recursoIdInput.value = "";
    nombreRecursoInput.value = "";
    urlRecursoInput.value = "";
    guardarRecursoBtn.textContent = "Guardar recurso";
    cancelarRecursoBtn.classList.add("d-none");
});
