<?php
include_once '../lib/lib.php';

$result = new stdClass();
$result->message = "";

try {
    $json = file_get_contents("php://input");
    $obj = json_decode($json);
    switch ($obj->op) {
        case "create":
            create_order($obj->town, $obj->address);
            $result->message = "Pedido creado correctamente";
            break;
        case "add":
            $lines = create_line($obj);
            $result->message = "Se añadieron los productos correctamente";
            $result->lines = $lines;
            break;
        case "delete":
            delete_line($obj->id);
            $result->message = "Se borraron los productos correctamente";
            break;
        case "finish":

            $result->message = "Pedido finalizado";
            break;
        default:
            break;
    }
    //$result->message = "AJAX CORRECTO";
} catch (Exception $e) {
    $result->message = $e->getMessage(); //En caso de error se envia la información de error al navegador
}

header('Content-type: application/json');
echo json_encode($result);

/* --- Functions --- */

function create_order($town, $address)
{
    $db = new DB();
    $db->execute_query("INSERT INTO pedidos(idcliente, horacreacion, poblacionentrega, direccionentrega) 
      VALUES (?, ?, ?, ?);", array(User::getLoggedUser()['id'], 0, $town, $address));
}

function create_line($json)
{
    $db = new DB();
    $lines = "";

    // ID Pedido
    $orderID = $db->execute_query("SELECT id FROM pedidos WHERE idcliente=? AND horacreacion=?;",
        array(User::getLoggedUser()['id'], 0))->fetchColumn(0);

    for ($i = 0; $i < count($json->lines); $i++) {
        if ($json->lines[$i]->amount == 0) continue;

        $lineID = exists_line($db, $orderID, $json->lines[$i]->id);
        if ($lineID == 0)
            $db->execute_query("INSERT INTO lineaspedido(idpedido, idbebida, unidades, PVP) VALUES (?, ?, ?, ?);",
                array($orderID, $json->lines[$i]->id, $json->lines[$i]->amount, $json->lines[$i]->pvp));
        else
            $db->execute_query("UPDATE lineaspedido SET unidades=? WHERE id=?",
                array($json->lines[$i]->amount, $lineID));

        $lines .= strval(exists_line($db, $orderID, $json->lines[$i]->id)) . "-";
    }
    return $lines;
}

function exists_line($db, $orderID, $drinkID)
{
    $result = $db->execute_query("SELECT id FROM lineaspedido WHERE idpedido=? AND idbebida=?;",
        array($orderID, $drinkID))->fetchColumn(0);
    if (count($result) > 0) return $result;
    return 0;
}

function delete_line($id)
{
    $db = new DB();
    $db->execute_query("DELETE FROM lineaspedido WHERE id=?", array($id));
}

function finish_order()
{
    $db = new DB();
    $db->execute_query("UPDATE pedidos SET horacreacion=? WHERE idcliente=? AND horacreacion=?;",
        array(time(), User::getLoggedUser()['id'], 0));
}
?>