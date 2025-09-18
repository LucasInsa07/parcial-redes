$(function(){
 $.getJSON("medios-pagos.json",d=>{d.MediosDePago.forEach(m=>$("#selectMedio05").append(`<option value="${m.cod_medio}">${m.descripcion}</option>`))});
 $("#form05").submit(e=>{e.preventDefault();alert("Formulario enviado (demo)");});
});