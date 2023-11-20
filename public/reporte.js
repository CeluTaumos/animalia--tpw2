$(document).ready(function () {
  $("#reportarBtn").click(function () {
    var idPregunta = $("input[name='id']").val();
    var url = "/Partida/reportarPregunta?id=" + idPregunta;
    
    $.ajax({
      url: url,
      type: "GET",
      success: function () {
        // Lógica adicional después del éxito, si es necesario
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", xhr, status, error);
      }
    });
  });
});



// } else {
//   mensajeElemento.text("Hubo un problema: " + response.error);
// }

// $(document).ready(function () {
//   $("#reportarBtn").click(function (event) {
//     event.preventDefault(); // Evita el comportamiento predeterminado del formulario
 
//     var formData = $("#reportarForm").serialize();
 
//     $.ajax({
//       type: "POST",
//       url: "/Partida/reportarPregunta",
//       data: formData,
//       dataType: "json",
//       success: function (response) {
//         console.log(response); // Agrega esto para depuración
 
//         if (response.success) {
//           // Inserta el mensaje de éxito en el elemento <p>
//           mensajeElemento.text(response.message);
//         } else {
//           // Inserta el mensaje de error en el elemento <p>
//           mensajeElemento.text("Hubo un problema: " + response.error);
//         }
//       },
//       error: function (error) {
//         console.error("Error en la solicitud AJAX:", error);
//       },
//     });
//   });
// });
