<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Respuesta del servidor</title>
</head>
<body>

<h3>Valores pasados:</h3>

<?php
echo "Nombre = " . $_POST["nombre"] . "<br>";
echo "Apellido = " . $_POST["apellido"] . "<br>";
?>

<br>
<form action="index.html" method="get">
    <input type="submit" value="Volver">
</form>

</body>
</html>
