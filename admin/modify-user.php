<?php
include_once '../lib/lib.php';
include_once '../lib/admin-tools.php';
if (User::getLoggedUser()['tipo'] != 1) header("Location: ../main/index.php");

modify_user();

View::start('Distribuciones latosas');
View::navigation();

$db = new DB();
$res = $db->execute_query("SELECT * FROM usuarios WHERE id=?", array($_GET['id']));
if ($res) {
    $res->setFetchMode(PDO::FETCH_NAMED);
    foreach ($res as $user) {
        echo <<<MODIFY
        <div class="panel">
            <form id="login" method="post" action='../admin/modify-user.php'>
                <input type="hidden" name="id" value=$user[id]>
                
                <p>Usuario:</p>
                <input type="text" name="user" value=$user[usuario]><br>
                
                <p>Contraseña:</p>
                <input type="password" name="password" value=$user[clave]><br>
                <input type="hidden" name="oldPassword" value=$user[clave]>
                
                <p>Nombre:</p>
                <input type="text" name="name" value=$user[nombre]><br>
                
                <p>Tipo:</p>
                <input type="text" name="type" value=$user[tipo]><br>
                
                <p>Población:</p>
                <input type="text" name="town" value=$user[poblacion]><br>
                
                <p>Dirección:</p>
                <input type="text" name="direction" value=$user[direccion]><br><br>
                
                <div style="text-align: center">
                <input type="submit" value="Modificar Usuario">
                </div>
            </form>
        </div>
        
        <div class="clearfix"></div>
MODIFY;
    }
}

View::end();

function modify_user()
{
    if (!$_POST) return;

    if ($_POST['password'] === $_POST['oldPassword'])
        modifyUser(array(
            $_POST['id'],
            $_POST['user'],
            $_POST['oldPassword'],
            $_POST['name'],
            $_POST['type'],
            $_POST['town'],
            $_POST['direction']
        ));
    else
        modifyUser(array(
            $_POST['id'],
            $_POST['user'],
            md5($_POST['password']),
            $_POST['name'],
            $_POST['type'],
            $_POST['town'],
            $_POST['direction']
        ));
    header("Location: ../admin/admin.php");
}