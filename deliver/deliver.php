<?php
include_once '../lib/lib.php';
include_once '../lib/deliver-tools.php';

if (User::getLoggedUser()['tipo'] != 3) header("Location: ../main/index.php");

deliver_operation();

View::start('Distribuciones latosas');
View::navigation();

echo "<h2>Pedidos asignados</h2>";
$db = new DB();
$result = $db->execute_query("SELECT * FROM pedidos WHERE idrepartidor=? AND horaentrega=?;", array(User::getLoggedUser()['id'], 0));

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
            if ($index === 5 || $index === 7 || $index === 8 || $index === 9)
                echo "<td>" . date("Y-m-d H:i:s", $value) . "</td>";
            else
                echo "<td>$value</td>";
            $index++;
        }
        if ($order['horareparto'] == 0) echo "<td><a href='../deliver/deliver.php?op=deli&id=$order[id]'>En reparto</a></td>";
        else echo "<td><a href='../deliver/deliver.php?op=fini&id=$order[id]'>Entregado</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h2>Pedidos sin asignar</h2>";
$result = $db->execute_query("SELECT * FROM pedidos WHERE idrepartidor IS NULL;");

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

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
        echo "<td><a href='../deliver/deliver.php?op=asig&id=$order[id]'>Asignar</a></td>";
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