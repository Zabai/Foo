<?php
include_once '../lib/lib.php';
include_once '../lib/customer-tools.php';
if (User::getLoggedUser()['tipo'] != 2) header("Location: ../main/index.php");

View::start('Distribuciones latosas');
View::navigation();

echo "<h2>Detalles del pedido: $_GET[id]</h2>";

echo <<<TABLEHEAD
<table class="tablaHorizontal">
    <tr>
        <th>Marca</th>
        <th>Unidades</th>
        <th>PVP</th>
        <th>Total</th>
    </tr>
TABLEHEAD;

$db = new DB();
$result = $db->execute_query("SELECT b.marca, l.unidades, l.PVP FROM bebidas as b join lineaspedido as l on l.idpedido=? and b.id=l.idbebida;", array($_GET['id']));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NUM);
    foreach ($result as $line) {
        $index = 1;
        echo "<tr>";
        foreach ($line as $value) {
            echo "<td>$value</td>";
            if ($index === 2) {
                $unidades = $value;
            }
            if ($index === 3) {
                $precio = $value;
            }
            $index++;
        }
        $total = $unidades * $precio;
        echo "<td>$total</td>";

        echo "</tr>";
    }
}

echo "</table>";
View::end();