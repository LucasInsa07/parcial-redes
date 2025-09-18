$(function(){
 $.getJSON("medios-pagos.json",d=>d.MediosDePago.forEach(m=>$("#selectMedio15").append(`<option value="${m.cod_medio}">${m.descripcion}</option>`)));
 $("#btnAbrirModal15").click(()=>{$("#contenedor15").attr("class","container contenedorPasivo");$("#modal15").attr("class","ventanaModalPrendido");alert(`Viewport: ${window.innerWidth}px`);});
 $("#cerrarModal15").click(()=>{$("#contenedor15").attr("class","container contenedorActivo");$("#modal15").attr("class","ventanaModalApagado");});
 $("#form15").submit(e=>{e.preventDefault();alert("Guardado demo");$("#cerrarModal15").click();});
});