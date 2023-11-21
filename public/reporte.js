function reportarPregunta(idPregunta) {
  $.ajax({
      url: "/Partida/reportarPregunta",
      type: "GET",
      data: { id: idPregunta },
      success: function (data) {
          // La solicitud fue exitosa, actualiza el mensaje
          $("#mensaje").text("Pregunta reportada correctamente");
          console.log("Pregunta reportada correctamente");
      },
      error: function () {
          // Hubo un error en la solicitud, actualiza el mensaje de error
          $("#mensaje").text("Error al reportar la pregunta");
          console.error("Error al reportar la pregunta");
      }
  });
}

// Ejemplo de uso
$(document).ready(function () {
  const reportarBtn = $("#reportarBtn");

  reportarBtn.click(function (event) {
      event.preventDefault();

      const idPregunta = $('input[name="id"]').val();

      reportarPregunta(idPregunta);
  });
});
