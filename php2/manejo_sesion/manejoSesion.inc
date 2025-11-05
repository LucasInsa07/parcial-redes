<?php
session_start();

if (!isset($_SESSION['idSesion'])) {
    header('Location: ../formulario_login.html');
    exit();
}
?>
