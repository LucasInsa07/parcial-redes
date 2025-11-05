<?php
session_start();

if (!isset($_SESSION['idSesion'])) {
    header('Location: ./formulario_login.html');
    exit();
}

echo "<h2>Bienvenido al sistema</h2>";
echo "<p>Usuario: " . $_SESSION['login'] . "</p>";
echo "<p>Contador de sesiones: " . $_SESSION['contador'] . "</p>";

echo "<p><button onclick=\"location.href='./app_modulo1/index.html'\">Ingresar a la aplicación</button></p>";
echo "<p><button onclick=\"location.href='./destruirSesion.php'\">Cerrar sesión</button></p>";
?>
