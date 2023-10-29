let tiempoInicial = 10;
let tiempoRestante = tiempoInicial;
const barraTiempo = document.getElementById("barraTiempo");
const tiempoRestanteSpan = document.getElementById("tiempoRestante");

function actualizarBarraTiempo() {
  const porcentajeTiempoRestante = (tiempoRestante / tiempoInicial) * 100;
  barraTiempo.style.width = porcentajeTiempoRestante + "%";
}

function actualizarContadorTiempo() {
  tiempoRestanteSpan.textContent = tiempoRestante + " segundos";
}

function reducirTiempo() {
  if (tiempoRestante > 0) {
    tiempoRestante--;
    actualizarBarraTiempo();
    actualizarContadorTiempo();
  } else {
    // Redirige a la vista de perdedor cuando se agote el tiempo
    window.location.href = "index.php?controller=Partida&method=pantallaPerdedor" //"view/pantallaPerdedorView.mustache"; // Reemplaza con la ruta correcta
  }
}

const interval = setInterval(reducirTiempo, 1000);

actualizarBarraTiempo();
actualizarContadorTiempo();
//window.location.href = "partida/pantallaPerdedor"