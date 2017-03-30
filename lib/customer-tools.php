<?php
include_once '../lib/lib.php';

function exists_order()
{
    $db = new DB();
    $result = $db->execute_query("SELECT id FROM pedidos WHERE idcliente=? AND horacreacion=?;",
        array(User::getLoggedUser()['id'], 0));

    if (count($result->fetchAll()) > 0) return 1;
    return 0;
}