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
            break;
        default:
            break;
    }
    $result->message = "Satisfactorio";
} catch (Exception $e) {
    $result->message = $e->getMessage(); //En caso de error se envia la información de error al navegador
}

header('Content-type: application/json');
echo json_encode($result);

function create_order($town, $address)
{
    $db = new DB();
    $db->execute_query("INSERT INTO pedidos(idcliente, horacreacion, poblacionentrega, direccionentrega)
                        VALUES (?, ?, ?, ?);", array(User::getLoggedUser()['id'], 0, $town, $address));
}

function create_line($id, $quantity)
{

}

?>