<?php
include_once '../lib/lib.php';

function customer_operation()
{
    if (!$_GET) return;
    switch ($_GET['op']) {
        case "new":
            create_order();
            break;
        case "see":
            break;
        default:
            break;
    }
}

function create_order()
{
    $totalCost = 0.0;
    for ($i = 0; $i < sizeof($_POST['id']); $i++) {
        $totalCost += $_POST['PVP'][$i] * $_POST['amount'][$i];
    }

    $user = User::getLoggedUser();
    $time = time();

    $db = new DB();
    $db->execute_query("INSERT INTO pedidos(idcliente, poblacionentrega, direccionentrega, horacreacion, PVP) 
                        VALUES (?, ?, ?, ?, ?);", array($user['id'], $user['poblacion'], $user['direccion'], $time, $totalCost));

    $id = $db->execute_query("SELECT id FROM pedidos WHERE idcliente=? AND horacreacion=?;", array($user['id'], $time))->fetchColumn(0);

    for ($i = 0; $i < sizeof($_POST['id']); $i++) {
        if ($_POST['amount'][$i] != 0) create_lineOrder($id, $_POST['id'][$i], $_POST['amount'][$i], $_POST['PVP'][$i]);
    }
}

function create_lineOrder($id, $drinkID, $amount, $price)
{
    $db = new DB();
    $db->execute_query("INSERT INTO lineaspedido(idpedido, idbebida, unidades, PVP) VALUES (?, ?, ?, ?);",
        array($id, $drinkID, $amount, $price));
}