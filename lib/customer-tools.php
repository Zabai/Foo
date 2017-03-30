<?php
include_once '../lib/lib.php';

function exists_order()
{
    $db = new DB;
    $result = $db->execute_query("SELECT id FROM pedidos WHERE idcliente=? AND idrepartidor=?", array(User::getLoggedUser()['id'], -1));
    if ($result == null) return true;
    return false;
}