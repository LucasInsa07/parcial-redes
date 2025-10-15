<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Variables tipo objeto en PHP</title>
</head>
<body>

<h2>Variables tipo objeto en PHP. Objeto renglón de pedido</h2>

<p><span style="color:blue">$objRenglonPedido</span></p>

<?php
// 1️⃣ Creación de objeto individual
$objRenglonPedido = new stdClass();
$objRenglonPedido->codArt = "cp001";
$objRenglonPedido->descripcion = "jaguel 800 gr";
$objRenglonPedido->precioUnitario = 30;
$objRenglonPedido->cantidad = 2;

echo "<p>Código de artículo: " . $objRenglonPedido->codArt . "</p>";
echo "<p>Descripción del artículo: " . $objRenglonPedido->descripcion . "</p>";
echo "<p>Precio unitario: " . $objRenglonPedido->precioUnitario . "</p>";
echo "<p>Cantidad: " . $objRenglonPedido->cantidad . "</p>";

echo "<br>";
echo "<p>Tipo de <span style='color:blue'>\$objRenglonPedido</span>: " . gettype($objRenglonPedido) . "</p>";

// 2️⃣ Crear array de renglones
echo "<h3>Definamos arreglo de pedidos</h3>";
echo "<p><span style='color:blue'>\$renglonesPedido</span></p>";

$renglonesPedido = [];
array_push($renglonesPedido, $objRenglonPedido);

// Agrego un segundo pedido
$objRenglonPedido2 = new stdClass();
$objRenglonPedido2->codArt = "cp002";
$objRenglonPedido2->descripcion = "atun 800 gr";
$objRenglonPedido2->precioUnitario = 24;
$objRenglonPedido2->cantidad = 3;
array_push($renglonesPedido, $objRenglonPedido2);

echo "<p>Tipo de <span style='color:blue'>\$renglonesPedido</span>: " . gettype($renglonesPedido) . "</p>";

echo "<h3>Tabula <span style='color:blue'>\$renglonesPedido</span>. Recorrer el arreglo y tabular con HTML:</h3>";

echo "<table border='1' cellpadding='4' cellspacing='0'>";
echo "<tr><th>Código</th><th>Descripción</th><th>Precio Unitario</th><th>Cantidad</th></tr>";

foreach ($renglonesPedido as $renglon) {
    echo "<tr>";
    echo "<td>" . $renglon->codArt . "</td>";
    echo "<td>" . $renglon->descripcion . "</td>";
    echo "<td>" . $renglon->precioUnitario . "</td>";
    echo "<td>" . $renglon->cantidad . "</td>";
    echo "</tr>";
}
echo "</table>";

// 3️⃣ Cantidad de renglones
echo "<p>Cantidad de renglones: " . count($renglonesPedido) . "</p>";

// 4️⃣ Objeto contenedor con array y cantidad
$objRenglonesPedido = new stdClass();
$objRenglonesPedido->renglonesPedido = $renglonesPedido;
$objRenglonesPedido->cantidadDeRenglones = count($renglonesPedido);

echo "<h3>Producción de un objeto <span style='color:blue'>\$objRenglonesPedido</span> con dos atributos: array renglonesPedido y cantidadDeRenglones</h3>";
echo "<p>Cantidad de renglones: " . $objRenglonesPedido->cantidadDeRenglones . "</p>";

// 5️⃣ Codificación JSON
$jsonRenglones = json_encode($objRenglonesPedido);

echo "<h3>Producción de un JSON <span style='color:blue'>jsonRenglones</span>:</h3>";
echo "<p>$jsonRenglones</p>";
?>

</body>
</html>
