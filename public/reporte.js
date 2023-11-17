$(document).ready(function () {
    $("#reportarBtn").click(function () {
        var formData = $("#reportarForm").serialize();

        $.ajax({
            type: "POST",
            url: "/Partida/reportarPregunta",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text(response.message);
                    
                    // Redirige o renderiza la vista de la partida según tus necesidades
                    window.location.href = '/Partida/mostrarPantallaPartida';
                } else {
                    $("#mensaje").text("Hubo un problema: " + response.error);
                }
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });
});
