<?php
include_once '../lib/lib.php';

function admin_operation()
{
    if (!$_GET) return;
    switch ($_GET['op']) {
        case "mod":
            modifyUser($_GET['id']);
            break;
        case "del":
            deleteUser($_GET['id']);
            break;
        default:
            break;
    }
}

function createUser($userData)
{
    $db = new DB();
    $db->execute_query("INSERT INTO usuarios(usuario, clave, nombre, tipo, poblacion, direccion)
                        VALUES (?, ?, ?, ?, ?, ?);", $userData);
}

function modifyUser($userData)
{
    $db = new DB();
    foreach ($userData as $value) $params[] = $value;
    $params[] = $userData[0];
    $db->execute_query("UPDATE usuarios SET id=?, usuario=?, clave=?, nombre=?, tipo=?, poblacion=?, direccion=? WHERE id=?;",
        $params);
}

function deleteUser($id)
{
    $db = new DB();
    $db->execute_query("DELETE FROM usuarios WHERE id=?", array($id));
}