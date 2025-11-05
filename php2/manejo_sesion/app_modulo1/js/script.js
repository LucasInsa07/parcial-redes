const $ = (sel) => document.querySelector(sel);
const tbody = $("#tbodyDatos");
const total = $("#totalRegistros");
const estado = $("#estado");

// Modales
const modalAlta = $("#modalAlta");
const modalModi = $("#modalModi");

// Campos ALTA
const a_id=$("#a_id"), a_dni=$("#a_dni"), a_nom=$("#a_nom"),
      a_cuo=$("#a_cuo"), a_imp=$("#a_imp"), a_med=$("#a_med"), a_qr=$("#a_qr"),
      a_estado=$("#a_estado");

// Campos MODI
const m_id=$("#m_id"), m_dni=$("#m_dni"), m_nom=$("#m_nom"),
      m_cuo=$("#m_cuo"), m_imp=$("#m_imp"), m_med=$("#m_med"), m_qr=$("#m_qr"),
      m_estado=$("#m_estado");

// Botones
$("#btCargar").addEventListener("click", cargarDatos);
$("#btVaciar").addEventListener("click", vaciarTabla);
$("#btAlta").addEventListener("click", abrirAlta);

$("#a_cancel").addEventListener("click", ()=> cerrarModal(modalAlta));
$("#m_cancel").addEventListener("click", ()=> cerrarModal(modalModi));

$("#a_enviar").addEventListener("click", alta);
$("#m_enviar").addEventListener("click", modi);

// Inicial: poblar selects de medios para formularios
document.addEventListener("DOMContentLoaded", async () => {
  await poblarMedios(a_med);
  await poblarMedios(m_med);
});

function setEstado(msg, ok=true){
  estado.textContent = msg;
  estado.style.color = ok ? "#1b5e20" : "#b71c1c";
}

function vaciarTabla(){
  tbody.innerHTML = `<tr><td colspan="8">Sin datos cargados</td></tr>`;
  total.textContent = "Total: 0";
  setEstado("Tabla vacía");
}

async function cargarDatos(){
  tbody.innerHTML = `<tr><td colspan="8">Cargando...</td></tr>`;
  try{
    const r = await fetch("./traeMovimientos.php");
    const data = await r.json();
    renderTabla(data.movimientos || []);
    total.textContent = "Total: " + (data.cuenta ?? 0);
    setEstado("Datos cargados correctamente");
  }catch(e){
    tbody.innerHTML = `<tr><td colspan="8" style="color:#b71c1c">Error cargando datos</td></tr>`;
    setEstado("Error en fetch traeMovimientos.php", false);
  }
}

function renderTabla(rows){
  if(!rows.length){
    vaciarTabla();
    return;
  }
  tbody.innerHTML = "";
  rows.forEach(m => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${m.IdentificativoOperacion}</td>
      <td>${m.DNI_deudor}</td>
      <td>${m.NombreDeldeudor}</td>
      <td>${m.NroCuota}</td>
      <td>$${parseFloat(m.Importe).toFixed(2)}</td>
      <td>${m.medioDescripcion} (${m.cod_medio})</td>
      <td>${m.QR_comprobantePago || ""}</td>
      <td>
        <button onclick="abrirModi('${m.IdentificativoOperacion}','${m.DNI_deudor}','${escapeHtml(m.NombreDeldeudor)}','${m.NroCuota}','${m.Importe}','${m.cod_medio}','${m.QR_comprobantePago||""}')">Modi</button>
        <button class="vaciar" onclick="baja('${m.IdentificativoOperacion}')">Baja</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// === Helpers de UI ===
function abrirAlta(){
  limpiarAlta();
  abrirModal(modalAlta);
}
function abrirModi(id,dni,nom,cuo,imp,med,qr){
  m_id.value = id;
  m_dni.value = dni;
  m_nom.value = unescapeHtml(nom);
  m_cuo.value = cuo;
  m_imp.value = imp;
  m_med.value = med;
  m_qr.value  = qr;
  m_estado.textContent = "";
  abrirModal(modalModi);
}
function abrirModal(m){ m.classList.add("activa"); }
function cerrarModal(m){ m.classList.remove("activa"); }
function limpiarAlta(){
  a_id.value=a_dni.value=a_nom.value=a_cuo.value=a_imp.value=a_qr.value="";
  a_estado.textContent = "";
}

// === Poblar medios en selects ===
async function poblarMedios(select){
  try{
    const r = await fetch("./traeMedios.php");
    const data = await r.json();
    select.innerHTML = `<option value="" disabled selected>Seleccione...</option>`;
    (data.medios||[]).forEach(x=>{
      const opt = document.createElement("option");
      opt.value = x.cod_medio;
      opt.textContent = `${x.cod_medio} - ${x.descripcion}`;
      select.appendChild(opt);
    });
  }catch(e){
    setEstado("Error cargando medios", false);
  }
}

// === CRUD (fetch + FormData/URLSearchParams) ===
async function alta(){
  // Validación básica estilo profe
  if(!(a_id.value && a_dni.value && a_nom.value && a_cuo.value && a_imp.value && a_med.value)){
    a_estado.textContent = "Faltan datos obligatorios";
    a_estado.style.color = "#b71c1c";
    return;
  }
  const fd = new URLSearchParams();
  fd.append("IdentificativoOperacion", a_id.value.trim());
  fd.append("DNI_deudor", a_dni.value.trim());
  fd.append("NombreDeldeudor", a_nom.value.trim());
  fd.append("NroCuota", a_cuo.value.trim());
  fd.append("Importe", a_imp.value.trim());
  fd.append("cod_medio", a_med.value.trim());
  fd.append("QR_comprobantePago", a_qr.value.trim());

  try{
    const r = await fetch("./alta.php", { method:"POST", body: fd });
    const txt = await r.text();
    a_estado.textContent = txt;
    a_estado.style.color = "#1b5e20";
    await cargarDatos();
  }catch(e){
    a_estado.textContent = "Error en alta";
    a_estado.style.color = "#b71c1c";
  }
}

async function modi(){
  if(!(m_id.value && m_dni.value && m_nom.value && m_cuo.value && m_imp.value && m_med.value)){
    m_estado.textContent = "Faltan datos obligatorios";
    m_estado.style.color = "#b71c1c";
    return;
  }
  const fd = new URLSearchParams();
  fd.append("IdentificativoOperacion", m_id.value.trim());
  fd.append("DNI_deudor", m_dni.value.trim());
  fd.append("NombreDeldeudor", m_nom.value.trim());
  fd.append("NroCuota", m_cuo.value.trim());
  fd.append("Importe", m_imp.value.trim());
  fd.append("cod_medio", m_med.value.trim());
  fd.append("QR_comprobantePago", m_qr.value.trim());

  try{
    const r = await fetch("./modi.php", { method:"POST", body: fd });
    const txt = await r.text();
    m_estado.textContent = txt;
    m_estado.style.color = "#1b5e20";
    await cargarDatos();
  }catch(e){
    m_estado.textContent = "Error en modificación";
    m_estado.style.color = "#b71c1c";
  }
}

async function baja(id){
  if(!confirm(`¿Eliminar el movimiento ${id}?`)) return;
  const fd = new URLSearchParams();
  fd.append("IdentificativoOperacion", id);
  try{
    const r = await fetch("./baja.php", { method:"POST", body: fd });
    const txt = await r.text();
    setEstado(txt);
    await cargarDatos();
  }catch(e){
    setEstado("Error en baja", false);
  }
}

// Helpers XSS-safe para nombre con tildes/espacios
function escapeHtml(str){
  return (str||"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll(`"`,`&quot;`).replaceAll(`'`,`&#39;`);
}
function unescapeHtml(str){
  return (str||"").replaceAll("&lt;","<").replaceAll("&gt;",">").replaceAll("&quot;",`"`).replaceAll("&#39;", `'`).replaceAll("&amp;","&");
}
