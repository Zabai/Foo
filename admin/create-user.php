<?php
include_once '../lib/lib.php';
include_once '../lib/admin-tools.php';

if (User::getLoggedUser()['tipo'] != 1) header("Location: ../main/index.php");


create_user();

View::start('Distribuciones latosas');
View::navigation();

echo <<<CREATE
<div class="panel">
    <form id="login" method="post" action='../admin/create-user.php'>
        <p>Usuario:</p>
        <input type="text" name="user"><br>
        
        <p>Contraseña:</p>
        <input type="password" name="password"><br>
        
        <p>Nombre:</p>
        <input type="text" name="name"><br>
        
        <p>Tipo:</p>
        <select name="type">
                <option> Elige una opción </option>
                <option value="1"," >Administrador</option>
                <option value="3",>Repartidor</option>
                <option value="2">Cliente</option>
                </select>
        
        <p>Población:</p>
        <input type="text" name="town"><br>
        
        <p>Dirección:</p>
        <input type="text" name="direction"><br><br>
        
        <div style="text-align: center">
        <input type="submit" value="Crear Usuario">
        </div>
    </form>
</div>

<div class="clearfix"></div>
CREATE;

View::end();

function create_user()
{
    if (!$_POST) return;
    createUser(array(
        $_POST['user'],
        md5($_POST['password']),
        $_POST['name'],
        $_POST['type'],
        $_POST['town'],
        $_POST['direction']
    ));
    header("Location: ../admin/admin.php");
}