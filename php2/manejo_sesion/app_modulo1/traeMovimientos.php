<?php
include("../manejoSesion.inc");
include("../conexion-db.php");

header('Content-Type: application/json; charset=utf-8');

try {
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
            ORDER BY m.IdentificativoOperacion";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $salida = new stdClass();
    $salida->movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida->cuenta = count($salida->movimientos);

    echo json_encode($salida, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error: ".$e->getMessage()]);
}
