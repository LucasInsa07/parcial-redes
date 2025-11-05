<?php
include("libreria.inc");

// Validar que los campos no estén vacíos
if (empty($_POST['login']) || empty($_POST['clave'])) {
    header('Location: ./formulario_login.html');
    exit();
}

$login = $_POST['login'];
$clave = $_POST['clave'];

$usuario = autenticacion($login, $clave);

if (!$usuario) {
    header('Location: ./formulario_login.html');
    exit();
}

session_start();
$_SESSION['idSesion'] = session_create_id();
$_SESSION['login'] = $usuario['loginDelUsuario'];
$_SESSION['contador'] = $usuario['contador'];

echo "<h2>Sesión iniciada correctamente</h2>";
echo "<p>ID de Sesión: " . $_SESSION['idSesion'] . "</p>";
echo "<p>Usuario: " . $_SESSION['login'] . "</p>";
echo "<p>Contador de sesiones: " . $_SESSION['contador'] . "</p>";

echo "<p><button onclick=\"location.href='./app_modulo1/index.html'\">Ingresar a la aplicación</button></p>";
echo "<p><button onclick=\"location.href='./destruirSesion.php'\">Terminar sesión</button></p>";
?>
