$(document).ready(function() {
    // Después de reportar la pregunta correctamente
    $.ajax({
        type: 'POST',
        url: '/Admin/reportarPregunta', // Ajusta la ruta según tu configuración
        data: { 'id': tu_id }, // Ajusta esto según tus necesidades
        dataType: 'json', // Espera una respuesta en formato JSON
        success: function(response) {
            if (response.success) {
                // Si el reporte fue exitoso, muestra el mensaje en el elemento <p> con la clase 'reporte'
                $('.reporte').text(response.message);
            } else {
                // Maneja cualquier otro caso de respuesta si es necesario
                console.log('Error en la respuesta AJAX');
            }
        },
        error: function() {
            console.log('Error en la solicitud AJAX');
        }
    });
});
