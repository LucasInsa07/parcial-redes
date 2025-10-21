
let medios = [];
let movimientos = [];


function render() {
  const tbody = document.getElementById("tbDatos");
  tbody.innerHTML = ""; // limpia la tabla

  movimientos.forEach(m => {
    const medio = medios.find(x => x.cod_medio === m.cod_medio)?.descripcion || "";
    const row = document.createElement("tr");

    row.innerHTML = `
      <td>${m.IdentificativoOperacion}</td>
      <td class="hidden-sm">${m.DNI_deudor}</td>
      <td>${m.NombreDeldeudor}</td>
      <td>${m.NroCuota}</td>
      <td>${Number(m.Importe).toFixed(2)}</td>
      <td>${medio}</td>
      <td class="hidden-sm">${m.QR_comprobantePago}</td>
    `;

    tbody.appendChild(row);
  });
}


async function cargarJSON(url) {
  const respuesta = await fetch(url);
  if (!respuesta.ok) throw new Error("Error al cargar " + url);
  return await respuesta.json();
}


window.addEventListener("DOMContentLoaded", async () => {


  try {
    const dataMedios = await cargarJSON("medios-pagos.json");
    medios = dataMedios.MediosDePago;

    const selectMedio = document.getElementById("selectMedio");
    selectMedio.innerHTML = "";

    medios.forEach(m => {
      const option = document.createElement("option");
      option.value = m.cod_medio;
      option.textContent = m.descripcion;
      selectMedio.appendChild(option);
    });
  } catch (err) {
    console.error("Error cargando medios:", err);
  }


  document.getElementById("btnCargar").addEventListener("click", async () => {
    try {
      const dataMovs = await cargarJSON("movimientos-pagos.json");
      movimientos = dataMovs.MovimientosPago;
      render();
    } catch (err) {
      console.error("Error cargando movimientos:", err);
    }
  });


  document.getElementById("btnVaciar").addEventListener("click", () => {
    document.getElementById("tbDatos").innerHTML = "";
  });


  document.getElementById("btnFormulario").addEventListener("click", () => {
    document.getElementById("contenedor").className = "container contenedorPasivo";
    document.getElementById("ventanaModal").className = "ventanaModalPrendido";
  });

  // 5️⃣ Botón cerrar modal
  document.getElementById("cerrarModal").addEventListener("click", () => {
    document.getElementById("contenedor").className = "container contenedorActivo";
    document.getElementById("ventanaModal").className = "ventanaModalApagado";
  });

  // 6️⃣ Envío del formulario (guardar nuevo registro)
  document.getElementById("formMovimiento").addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const nuevo = Object.fromEntries(formData.entries());

    movimientos.push(nuevo); // lo agregamos al array
    document.getElementById("cerrarModal").click(); // cerramos modal
    render(); // actualizamos tabla
  });
});
