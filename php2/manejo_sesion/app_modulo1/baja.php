<?php
include("../manejoSesion.inc");
include("../conexion-db.php");

header('Content-Type: text/plain; charset=utf-8');

$respuesta = "Respuesta del servidor a la BAJA\n";

try {
    $id = $_POST['IdentificativoOperacion'] ?? '';
    $respuesta .= "ID a eliminar: $id\n";

    $sql = "DELETE FROM movimientos_pago WHERE IdentificativoOperacion = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $respuesta .= "Preparación y ejecución OK.\n";
    echo $respuesta;

} catch (PDOException $e) {
    echo $respuesta . "Error: " . $e->getMessage();
}
