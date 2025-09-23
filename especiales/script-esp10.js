let medios10 = [];
let movimientos10 = [];

function render10() {
    $("#tbEsp10").empty();
    movimientos10.forEach(m => {
        const medio = medios10.find(x => x.cod_medio === m.cod_medio)?.descripcion || "";
        $("#tbEsp10").append(`<tr><td>${m.IdentificativoOperacion}</td><td class="hidden-sm">${m.DNI_deudor}</td><td>${m.NombreDeldeudor}</td><td>${m.NroCuota}</td><td>${Number(m.Importe).toFixed(2)}</td><td>${medio}</td><td class="hidden-sm">${m.QR_comprobantePago}</td></tr>`);
    });
}

$(function() {
    $.getJSON("medios-pagos.json", d => medios10 = d.MediosDePago);
    
    $("#btnCargar10").click(() => {
        $.getJSON("movimientos-pagos.json", d => {
            movimientos10 = d.MovimientosPago;
            render10();
        });
    });
    
    $("#btnVaciar10").click(() => $("#tbEsp10").empty());
});