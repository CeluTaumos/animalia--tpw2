function reportarPregunta(idPregunta) {
    $.ajax({
        url: "/Partida/reportarPregunta",
        type: "GET",
        data: { id: idPregunta },
        success: function (data) {
            // La solicitud fue exitosa, puedes manejar la respuesta aquí
            console.log(data);
        },
        error: function () {
            // Hubo un error en la solicitud
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

