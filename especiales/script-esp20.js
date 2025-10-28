let medios = [];
let movimientos = [];

function render() {
  const tbody = document.getElementById("tbDatos");
  tbody.innerHTML = "";

  movimientos.forEach(m => {
    const medio = medios.find(x => x.cod_medio === m.cod_medio)?.descripcion || "";
    const fila = document.createElement("tr");

    fila.innerHTML = `
      <td>${m.IdentificativoOperacion}</td>
      <td class="hidden-sm">${m.DNI_deudor}</td>
      <td>${m.NombreDeldeudor}</td>
      <td>${m.NroCuota}</td>
      <td>$ ${Number(m.Importe).toFixed(2)}</td>
      <td>${medio}</td>
      <td class="hidden-sm">
        <img src="./img/${m.QR_comprobantePago}" alt="QR" class="qr" />
      </td>
    `;

    tbody.appendChild(fila);
  });
}

// ----------------------------------------------------
// Carga los datos desde las variables globales
// ----------------------------------------------------
function cargarDatos() {

  medios = MediosDePago.MediosDePago;
  movimientos = MovimientosPago.MovimientosPago;

  render();
}

// ----------------------------------------------------
// Vacía la tabla de datos
// ----------------------------------------------------
function vaciarDatos() {
  const tbody = document.getElementById("tbDatos");
  tbody.innerHTML = "";
}

// ----------------------------------------------------
// Abre la ventana modal (formulario)
// ----------------------------------------------------
function abrirFormulario() {
  document.getElementById("contenedor").className = "container contenedorPasivo";
  document.getElementById("ventanaModal").className = "ventanaModalPrendido";
}

// ----------------------------------------------------
// Cierra la ventana modal
// ----------------------------------------------------
function cerrarFormulario() {
  document.getElementById("contenedor").className = "container contenedorActivo";
  document.getElementById("ventanaModal").className = "ventanaModalApagado";
}

// ----------------------------------------------------
// Agrega un nuevo movimiento desde el formulario
// ----------------------------------------------------
function guardarMovimiento(e) {
  e.preventDefault();

  const form = e.target;
  const nuevo = {
    IdentificativoOperacion: form.idOperacion.value,
    DNI_deudor: form.dni.value,
    NombreDeldeudor: form.nombre.value,
    NroCuota: form.cuota.value,
    Importe: parseFloat(form.importe.value) || 0,
    cod_medio: form.cod_medio.value,
    QR_comprobantePago: form.qr.value
  };

  movimientos.push(nuevo);
  cerrarFormulario();
  render();
}

// ----------------------------------------------------
// Inicialización de eventos
// ----------------------------------------------------
window.addEventListener("DOMContentLoaded", () => {
  alert("Ejercicio ESP20 - Programación en Ambiente de Redes");

  // eventos de los botones
  document.getElementById("btnCargar").addEventListener("click", cargarDatos);
  document.getElementById("btnVaciar").addEventListener("click", vaciarDatos);
  document.getElementById("btnFormulario").addEventListener("click", abrirFormulario);
  document.getElementById("cerrarModal").addEventListener("click", cerrarFormulario);

  // envío del form
  const form = document.getElementById("formMovimiento");
  if (form) form.addEventListener("submit", guardarMovimiento);
});
