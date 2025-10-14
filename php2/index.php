<?php
// Minimal php2 index: only shows links to exercises (directories -> directory/index.php)

$dir = __DIR__;
$items = array_values(array_filter(scandir($dir), function($n){
    return $n !== '.' && $n !== '..' && strtolower($n) !== 'index.php';
}));

echo "<!doctype html><html lang=\"es\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width,initial-scale=1\"><title>PHP2</title></head><body>";
echo "<h1>PHP2 — Ejercicios</h1>";
if (empty($items)){
    echo "<p>No hay ejercicios.</p>";
} else {
    echo "<ul>";
    foreach ($items as $entry){
        $path = $dir . DIRECTORY_SEPARATOR . $entry;
        if (is_dir($path)){
            $href = rawurlencode($entry) . '/index.php';
            echo "<li><a href=\"$href\">$entry/</a></li>";
        } else {
            $href = rawurlencode($entry);
            echo "<li><a href=\"$href\">$entry</a></li>";
        }
    }
    echo "</ul>";
}
echo "<p><a href=\"/\">Volver al índice</a></p></body></html>";

?>
