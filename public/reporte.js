document.addEventListener("DOMContentLoaded", function () {
  const reportarBtn = document.getElementById("reportarBtn");
  const mensajeElement = document.getElementById("mensaje");

  reportarBtn.addEventListener("click", function (event) {
      event.preventDefault();

      const idPregunta = document.querySelector('input[name="id"]').value;

    
      reportarPregunta(idPregunta);
  });

  function reportarPregunta(idPregunta) {
     
      const xhr = new XMLHttpRequest();


      xhr.open("GET", "controller/Partida/reportarPregunta?id=" + idPregunta, true);


  
      xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 400) {
              
              mensajeElement.textContent = "Pregunta reportada correctamente";
              console.log("Pregunta reportada correctamente");
          } else {
        
              mensajeElement.textContent = "Error en el reporte";
              console.error("Error al reportar la pregunta");
          }
      };


      xhr.onerror = function () {
          mensajeElement.textContent = "Error de red al intentar reportar la pregunta";
          console.error("Error de red al intentar reportar la pregunta");
      };

      xhr.send();
  }
});
