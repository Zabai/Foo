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
        <th>ID Bebida</th>
        <th>Unidades</th>
        <th>PVP</th>
    </tr>
TABLEHEAD;

$db = new DB();
$result = $db->execute_query("SELECT idbebida,unidades,PVP FROM lineaspedido WHERE idpedido=?;", array($_GET['id']));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NUM);

    foreach ($result as $line) {
        echo "<tr>";
        foreach ($line as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
}

echo "</table>";
View::end();