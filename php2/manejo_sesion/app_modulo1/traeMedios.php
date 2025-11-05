<?php
include("../manejoSesion.inc");
include("../conexion-db.php");

header('Content-Type: application/json; charset=utf-8');

try {
    $sql = "SELECT cod_medio, descripcion FROM medios_de_pago ORDER BY cod_medio";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $salida = new stdClass();
    $salida->medios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida->cuenta = count($salida->medios);

    echo json_encode($salida, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error: ".$e->getMessage()]);
}
