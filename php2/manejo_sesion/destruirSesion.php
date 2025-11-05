<?php
session_start();
session_destroy();
header('Location: ./formulario_login.html');
exit();
?>
