<?php
if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];

    $md5 = md5($clave);
    $sha = sha1($clave);

    echo "<h2>Resultados de la encriptación</h2>";
    echo "<p><strong>Clave original:</strong> $clave</p>";
    echo "<p><strong>MD5 (128 bits = 16 pares hex):</strong> $md5</p>";
    echo "<p><strong>SHA-1 (160 bits = 20 pares hex):</strong> $sha</p>";
    echo "<br><a href=''>Volver</a>";
} else {
    // primera carga: mostrar el formulario
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Form to Encrypt</title>
</head>
<body>
  <h2>Encriptar una clave</h2>
  <form method="post" action="">
    <label>Ingrese clave:</label>
    <input type="text" name="clave" required>
    <button type="submit">Obtener encriptación</button>
  </form>
</body>
</html>
<?php
}
?>