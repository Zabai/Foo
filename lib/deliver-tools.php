<?php
include_once '../lib/lib.php';

function deliver_operation()
{
    if (!$_GET) return;
    switch ($_GET['op']) {
        case "asig":
            asign_order($_GET['id'], User::getLoggedUser()['id']);
            break;
        case "deli":
            delivering_order($_GET['id']);
            break;
        case "fini":
            finish_order($_GET['id']);
            break;
    }
}

function asign_order($orderID, $deliverID)
{
    $db = new DB();
    $db->execute_query("UPDATE pedidos SET idrepartidor=?, horaasignacion=? WHERE id=?;", array($deliverID, time(), $orderID));
}

function delivering_order($id)
{
    $db = new DB();
    $db->execute_query("UPDATE pedidos SET horareparto=? WHERE id=?;", array(time(), $id));
}

function finish_order($id)
{
    $db = new DB();
    $db->execute_query("UPDATE pedidos SET horaentrega=? WHERE id=?;", array(time(), $id));
}