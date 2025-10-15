<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Variables de Servidor</title>
</head>
<body>

<h2>Variables de servidor</h2>

<table border="1" cellpadding="4" cellspacing="0" style="background-color:#f5f5dc;">
    <tr><td><span style="color:blue">SERVER_ADDR</span></td><td><?php echo $_SERVER['SERVER_ADDR']; ?></td></tr>
    <tr><td><span style="color:blue">SERVER_PORT</span></td><td><?php echo $_SERVER['SERVER_PORT']; ?></td></tr>
    <tr><td><span style="color:blue">SERVER_NAME</span></td><td><?php echo $_SERVER['SERVER_NAME']; ?></td></tr>
    <tr><td><span style="color:blue">HTTP_HOST</span></td><td><?php echo $_SERVER['HTTP_HOST']; ?></td></tr>
    <tr><td><span style="color:blue">DOCUMENT_ROOT</span></td><td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td></tr>
</table>

<h2>Variables de cliente</h2>

<table border="1" cellpadding="4" cellspacing="0" style="background-color:#f5f5dc;">
    <tr><td><span style="color:blue">REMOTE_ADDR</span></td><td><?php echo $_SERVER['REMOTE_ADDR']; ?></td></tr>
    <tr><td><span style="color:blue">REMOTE_PORT</span></td><td><?php echo $_SERVER['REMOTE_PORT']; ?></td></tr>
</table>

<h2>Variables de Requerimiento</h2>

<table border="1" cellpadding="4" cellspacing="0" style="background-color:#f5f5dc;">
    <tr><td><span style="color:blue">SCRIPT_NAME</span></td><td><?php echo $_SERVER['SCRIPT_NAME']; ?></td></tr>
    <tr><td><span style="color:blue">REQUEST_METHOD</span></td><td><?php echo $_SERVER['REQUEST_METHOD']; ?></td></tr>
    <tr><td><span style="color:blue">REQUEST_URI</span></td><td><?php echo $_SERVER['REQUEST_URI']; ?></td></tr>
    <tr><td><span style="color:blue">QUERY_STRING</span></td><td><?php echo $_SERVER['QUERY_STRING']; ?></td></tr>
</table>

<h2>TODAS</h2>
<?php
foreach ($_SERVER as $clave => $valor) {
    echo "<p>$clave = $valor</p>";
}
?>

</body>
</html>
