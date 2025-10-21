<?php
header("Content-Type: application/json; charset=UTF-8");
try {
    $json = file_get_contents("./medios-pagos.json");
    echo $json;
} catch (Exception $e) {
    $log = fopen("errores.log", "a");
    fwrite($log, date("Y-m-d H:i") . " Error cargando medios: " . $e->getMessage() . "\n");
    fclose($log);
    echo json_encode(["error" => "No se pudo leer medios-pagos.json"]);
}
?>
