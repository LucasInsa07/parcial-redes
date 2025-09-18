let medios = [];
let movimientos = [];

function render() {
    $("#tbDatos").empty();
    movimientos.forEach(m => {
        const medio = medios.find(x => x.cod_medio === m.cod_medio)?.descripcion || "";
        $("#tbDatos").append(`<tr><td>${m.IdentificativoOperacion}</td><td class="hidden-sm">${m.DNI_deudor}</td><td>${m.NombreDeldeudor}</td><td>${m.NroCuota}</td><td>${Number(m.Importe).toFixed(2)}</td><td>${medio}</td><td class="hidden-sm">${m.QR_comprobantePago}</td></tr>`);
    });
}

$(function() {
    $.getJSON("medios-pagos.json", d => {
        medios = d.MediosDePago;
        $("#selectMedio").empty();
        medios.forEach(m => $("#selectMedio").append(`<option value="${m.cod_medio}">${m.descripcion}</option>`));
    });
    
    $("#btnCargar").click(() => {
        $.getJSON("movimientos-pagos.json", d => {
            movimientos = d.MovimientosPago;
            render();
        });
    });
    
    $("#btnVaciar").click(() => $("#tbDatos").empty());
    
    $("#btnFormulario").click(() => {
        $("#contenedor").attr("class", "container contenedorPasivo");
        $("#ventanaModal").attr("class", "ventanaModalPrendido");
    });
    
    $("#cerrarModal").click(() => {
        $("#contenedor").attr("class", "container contenedorActivo");
        $("#ventanaModal").attr("class", "ventanaModalApagado");
    });
    
    $("#formMovimiento").submit(function(e) {
        e.preventDefault();
        const nuevo = Object.fromEntries(new FormData(this).entries());
        movimientos.push(nuevo);
        $("#cerrarModal").click();
        render();
    });
});