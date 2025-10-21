<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DB_ListaOrdenaFiltra</title>
    <script>
        // --- Al cargar la página ---
        window.onload = async function () {
            alert("Cargando lista de medios de pago desde el servidor...");
            await cargarMedios();
        };

        // --- Cargar lista de medios en el select ---
        async function cargarMedios() {
            try {
                const respuesta = await fetch("./salidaJsonMedios.php");
                const data = await respuesta.json();
                alert("Medios recibidos: " + JSON.stringify(data));
                const select = document.getElementById("selectMedio");
                select.innerHTML = "<option value=''>-- Todos --</option>";
                data.MediosDePago.forEach(m => {
                    const opt = document.createElement("option");
                    opt.value = m.cod_medio;
                    opt.text = m.descripcion;
                    select.appendChild(opt);
                });
            } catch (error) {
                alert("Error al cargar medios: " + error);
            }
        }

        // --- Cargar movimientos ---
        async function cargarMovimientos() {
            const tbody = document.getElementById("tbodyMovimientos");
            tbody.innerHTML = "<tr><td colspan='7'>Esperando respuesta del servidor...</td></tr>";

            const params = new URLSearchParams();
            params.append("medio", document.getElementById("selectMedio").value);
            params.append("orden", document.getElementById("selectOrden").value);

            try {
                const resp = await fetch("./salidaJsonMovimientos.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: params
                });

                const data = await resp.json();
                alert("Movimientos recibidos: " + JSON.stringify(data));

                tbody.innerHTML = "";
                data.MovimientosPago.forEach(mov => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${mov.IdentificativoOperacion}</td>
                        <td>${mov.DNI_deudor}</td>
                        <td>${mov.NombreDeldeudor}</td>
                        <td>${mov.NroCuota}</td>
                        <td>${mov.Importe.toFixed(2)}</td>
                        <td>${mov.cod_medio}</td>
                        <td>${mov.QR_comprobantePago}</td>`;
                    tbody.appendChild(tr);
                });

                document.getElementById("txtCuenta").value = data.cuenta;
            } catch (error) {
                alert("Error al cargar movimientos: " + error);
            }
        }

        // --- Vaciar tabla ---
        function vaciarTabla() {
            document.getElementById("tbodyMovimientos").innerHTML = "";
            document.getElementById("txtCuenta").value = "0";
        }
    </script>
</head>

<body>
    <h2>Tablero de Pagos</h2>

    <label>Medio de pago:</label>
    <select id="selectMedio"></select>

    <label>Ordenar por:</label>
    <select id="selectOrden">
        <option value="IdentificativoOperacion">ID Operación</option>
        <option value="DNI_deudor">DNI</option>
        <option value="Importe">Importe</option>
    </select>

    <button onclick="cargarMovimientos()">Cargar Datos</button>
    <button onclick="vaciarTabla()">Vaciar Datos</button>

    <br><br>
    <label>Cantidad de registros:</label>
    <input type="text" id="txtCuenta" readonly>

    <hr>

    <table border="1" cellpadding="4" cellspacing="0" style="background-color:#f5f5dc;">
        <thead>
            <tr>
                <th>ID Operación</th>
                <th>DNI</th>
                <th>Nombre del Deudor</th>
                <th>Nro Cuota</th>
                <th>Importe</th>
                <th>Medio</th>
                <th>Comprobante</th>
            </tr>
        </thead>
        <tbody id="tbodyMovimientos">
            <tr><td colspan="7">Sin datos cargados.</td></tr>
        </tbody>
    </table>
</body>
</html>
