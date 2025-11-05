<?php
function autenticacion($login, $clave)
{
    include("conexion-db.php");

    // Encriptamos la clave recibida
    $clave_encriptada = hash('sha256', $clave);

    // OJO con los nombres de columna
    $sql = "SELECT * FROM usuarios 
            WHERE loginDelUsuario = :login AND clave = :password";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $clave_encriptada);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $nuevoContador = $usuario['contador'] + 1;

        // Actualizo contador
        $update = $dbh->prepare("UPDATE usuarios SET contador = :nuevoContador WHERE idUsuario = :id");
        $update->bindParam(':nuevoContador', $nuevoContador);
        $update->bindParam(':id', $usuario['idUsuario']);
        $update->execute();

        $usuario['contador'] = $nuevoContador;
        return $usuario;
    } else {
        return false;
    }
}
?>
