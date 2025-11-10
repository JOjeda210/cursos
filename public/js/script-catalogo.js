// Archivo: script.js
// Mensaje al hacer clic en un botón del catálogo

document.querySelectorAll('.btn-miaula').forEach(btn => {
  btn.addEventListener('click', () => {
    alert('✅ Te has inscrito en el curso.');
  });
});
