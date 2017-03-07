<?php
include_once '../lib/lib.php';
include_once '../lib/customer-tools.php';

if (User::getLoggedUser()['tipo'] != 2) header("Location: ../main/index.php");

View::start('Distribuciones latosas');
View::navigation();

echo "<h2>Mis pedidos</h2>";
$db = new DB();
$result = $db->execute_query("SELECT * FROM pedidos WHERE idcliente=?;", array(User::getLoggedUser()['id']));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    $head = tableDictionary();

    foreach ($result as $order) {
        if ($first) {
            echo "<table class='tablaHorizontal'><tr>";
            foreach ($order as $field => $value) {
                echo "<th>$head[$field]</th>";
            }
            echo "<th>Acciones</th>";
            $first = false;
            echo "</tr>";
        }

        echo "<tr>";
        $index = 1;
        foreach ($order as $value) {
            if ($index === 5) echo "<td>" . date("Y-m-d H:i:s", $value) . "</td>";
            else echo "<td>$value</td>";
            $index++;
        }
        echo "<td><a href='../customer/order-details.php?id=$order[id]'>Ver detalles</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

View::end();

function tableDictionary()
{
    $tableHead["id"] = "ID Pedido";
    $tableHead["idcliente"] = "ID Cliente";
    $tableHead["poblacionentrega"] = "Población Entrega";
    $tableHead["direccionentrega"] = "Dirección entrega";
    $tableHead["horacreacion"] = "Hora creación";
    $tableHead["idrepartidor"] = "ID repartidor";
    $tableHead["horaasignacion"] = "Hora asignación";
    $tableHead["horareparto"] = "Hora reparto";
    $tableHead["horaentrega"] = "Hora entrega";
    $tableHead["PVP"] = "Precio";

    return $tableHead;
}