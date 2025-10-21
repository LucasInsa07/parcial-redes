<?php
header("Content-Type: application/json; charset=UTF-8");

$medio = $_POST["medio"] ?? "";
$orden = $_POST["orden"] ?? "IdentificativoOperacion";

try {
    $jsonData = json_decode(file_get_contents("./movimientos-pagos.json"), true);
    $movimientos = $jsonData["MovimientosPago"];

    // Filtrado
    if ($medio != "") {
        $movimientos = array_filter($movimientos, fn($m) => $m["cod_medio"] == $medio);
    }

    // Ordenamiento
    usort($movimientos, fn($a, $b) => $a[$orden] <=> $b[$orden]);

    // Objeto de salida
    $obj = new stdClass();
    $obj->MovimientosPago = array_values($movimientos);
    $obj->cuenta = count($movimientos);

    echo json_encode($obj, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    $log = fopen("errores.log", "a");
    fwrite($log, date("Y-m-d H:i") . " Error procesando movimientos: " . $e->getMessage() . "\n");
    fclose($log);
    echo json_encode(["error" => "Error en el servidor"]);
}
?>
