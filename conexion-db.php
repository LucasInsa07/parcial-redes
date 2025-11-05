<?php
$host = "sql201.infinityfree.com"; // reemplazá con tu host exacto
$dbname = "if0_40328063_tpfinal"; // reemplazá con el tuyo
$user = "if0_40328063"; // reemplazá con el tuyo
$password = "Vl9thlBIsE"; // la que anotaste

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $user, $password);
    echo "<h2 style='color:green'>✅ Conexión exitosa a la base de datos.</h2>";
} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Error: " . $e->getMessage() . "</h2>";
}
?>
