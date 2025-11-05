<?php
include("../manejoSesion.inc");
include("../conexion-db.php");

header('Content-Type: text/plain; charset=utf-8');

$respuesta = "Respuesta del servidor al ALTA\n";

try {
    // Lectura de entradas (POST)
    $id = $_POST['IdentificativoOperacion'] ?? '';
    $dni = $_POST['DNI_deudor'] ?? '';
    $nom = $_POST['NombreDeldeudor'] ?? '';
    $cuo = $_POST['NroCuota'] ?? '';
    $imp = $_POST['Importe'] ?? '';
    $med = $_POST['cod_medio'] ?? '';
    $qr  = $_POST['QR_comprobantePago'] ?? '';

    $respuesta .= "Entradas:\nID:$id DNI:$dni Nombre:$nom Cuota:$cuo Importe:$imp Medio:$med QR:$qr\n";

    $sql = "INSERT INTO movimientos_pago
            (IdentificativoOperacion, DNI_deudor, NombreDeldeudor, NroCuota, Importe, cod_medio, QR_comprobantePago)
            VALUES (:id, :dni, :nom, :cuo, :imp, :med, :qr)";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id',  $id);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':cuo', $cuo);
    $stmt->bindParam(':imp', $imp);
    $stmt->bindParam(':med', $med);
    $stmt->bindParam(':qr',  $qr);

    $stmt->execute();
    $respuesta .= "Preparación y ejecución OK.\n";
    echo $respuesta;

} catch (PDOException $e) {
    echo $respuesta . "Error: " . $e->getMessage();
}
