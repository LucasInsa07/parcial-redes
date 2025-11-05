<?php
include("../manejoSesion.inc");
include("../conexion-db.php");

header('Content-Type: application/json; charset=utf-8');

try {
    // Recibir parámetros de ordenamiento
    $ordenParam = $_GET['orden'] ?? 'IdentificativoOperacion_ASC';
    $ordenPartes = explode('_', $ordenParam);
    $columna = $ordenPartes[0] ?? 'IdentificativoOperacion';
    $direccion = $ordenPartes[1] ?? 'ASC';

    // Validar columnas permitidas (seguridad)
    $columnasPermitidas = [
        'IdentificativoOperacion', 'DNI_deudor', 'NombreDeldeudor', 
        'NroCuota', 'Importe', 'cod_medio'
    ];

    if (!in_array($columna, $columnasPermitidas)) {
        $columna = 'IdentificativoOperacion';
    }

    $direccion = strtoupper($direccion) === 'DESC' ? 'DESC' : 'ASC';

    // Recibir parámetros de filtros
    $filtroID = $_GET['filtroID'] ?? '';
    $filtroDNI = $_GET['filtroDNI'] ?? '';
    $filtroNombre = $_GET['filtroNombre'] ?? '';
    $filtroCuota = $_GET['filtroCuota'] ?? '';
    $filtroImporte = $_GET['filtroImporte'] ?? '';

    // Construir WHERE dinámico
    $whereConditions = [];
    $params = [];

    if (!empty($filtroID)) {
        $whereConditions[] = "m.IdentificativoOperacion LIKE ?";
        $params[] = "%$filtroID%";
    }
    if (!empty($filtroDNI)) {
        $whereConditions[] = "m.DNI_deudor LIKE ?";
        $params[] = "%$filtroDNI%";
    }
    if (!empty($filtroNombre)) {
        $whereConditions[] = "m.NombreDeldeudor LIKE ?";
        $params[] = "%$filtroNombre%";
    }
    if (!empty($filtroCuota)) {
        $whereConditions[] = "m.NroCuota = ?";
        $params[] = $filtroCuota;
    }
    if (!empty($filtroImporte)) {
        $whereConditions[] = "m.Importe >= ?";
        $params[] = $filtroImporte;
    }

    $whereClause = count($whereConditions) > 0 ? "WHERE " . implode(" AND ", $whereConditions) : "";

    $sql = "SELECT 
                m.IdentificativoOperacion,
                m.DNI_deudor,
                m.NombreDeldeudor,
                m.NroCuota,
                m.Importe,
                m.cod_medio,
                p.descripcion AS medioDescripcion,
                m.QR_comprobantePago
            FROM movimientos_pago m
            INNER JOIN medios_de_pago p ON p.cod_medio = m.cod_medio
            $whereClause
            ORDER BY m.$columna $direccion";
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);

    $salida = new stdClass();
    $salida->movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida->cuenta = count($salida->movimientos);

    echo json_encode($salida, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error: ".$e->getMessage()]);
}
