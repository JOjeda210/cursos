<div class="modal fade" id="modalComentario" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 20px;">

      <div class="modal-header">
        <h5 class="modal-title">Deja tu comentario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form id="formComentario" action="{{ route('comentarios.store') }}" method="POST">
          @csrf

          <label for="comentario">Comentario</label>
          <textarea id="comentario" name="comentario" rows="3" placeholder="Escribe tu opinión"></textarea>

          <label for="rating">Calificación (1–10)</label>
          <input type="number" id="rating" name="rating" min="1" max="10" placeholder="Ej. 8">

          <button type="submit" class="btn">Enviar</button>
        </form>

        <p id="mensaje" class="mensaje mt-2"></p>

      </div>

    </div>
  </div>
</div>
