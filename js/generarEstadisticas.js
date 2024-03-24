$(document).ready(function() {
  $('.js-example-basic-multiple').select2({
    languaje: "es"
  }); // Inicializamos Select2 en todos los elementos con la clase js-example-basic-multiple

  // Verificar si el elemento "generarInforme" existe antes de añadir el event listener
  let generarInforme = document.getElementById("generarInforme");
  if (generarInforme) {
    generarInforme.addEventListener("click", () => {
      window.open('./generarEstadisticas3.php', '_blank');
    });
  }
});
