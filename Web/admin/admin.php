<?php
include_once '../lib/lib.php';
include_once '../lib/admin-tools.php';

if (User::getLoggedUser()['tipo'] != 1) header("Location: ../main/index.php");

admin_operation();

View::start('Distribuciones latosas');
View::navigation();

echo <<<NEWUSER
<div class=panel><a href="../admin/create-user.php">Crear usuario</a></div>
<div class=clearfix></div>
NEWUSER;


$db = new DB();
$result = $db->execute_query("SELECT * FROM usuarios;");

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    $tableHead = array(
        "id" => "ID",
        "usuario" => "Usuario",
        "clave" => "Contraseña (MD5)",
        "nombre" => "Nombre",
        "tipo" => "Tipo",
        "poblacion" => "Población",
        "direccion" => "Dirección"
    );
    $userTypes = array(
        "1" => "Administrador",
        "2" => "Cliente",
        "3" => "Repartidor"
    );

    foreach ($result as $usuario) {
        if ($first) {
            echo "<table class='tablaHorizontal'><tr>";
            foreach ($usuario as $field => $value) {
                echo "<th>$tableHead[$field]</th>";
            }
            echo "<th>Acciones</th>";
            $first = false;
            echo "</tr>";
        }
        echo "<tr>";
        echo <<<TABLECONTENT
        <td>$usuario[id]</td>
        <td>$usuario[usuario]</td>
        <td>$usuario[clave]</td>
        <td>$usuario[nombre]</td>
        <td>$usuario[tipo]</td>
        <td>$usuario[poblacion]</td>
        <td>$usuario[direccion]</td>
        <td>
            <a href=../admin/modify-user.php?id=$usuario[id]>Modificar</a>
            <a href=../admin/admin.php?op=del&id=$usuario[id]>Eliminar</a>
        </td>
TABLECONTENT;
        echo "</tr>";
    }
    echo '</table>';
}

View::end();