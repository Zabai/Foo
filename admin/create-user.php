<?php
include_once '../lib/lib.php';
include_once '../lib/admin-tools.php';

if (User::getLoggedUser()['tipo'] != 1) header("Location: ../main/index.php");


create_user();

View::start('Distribuciones latosas');
View::navigation();

echo "<script src='../javascript/components.js'></script>";
echo "<script src='../json/actions.js'></script>";

echo <<<CREATE
<div class="panel">
    <form id="login" method="post" action='../admin/create-user.php'>
        <p>Usuario:</p>
        <p id='alert1' hidden>Necesita 4 caracteres</p>
        <input id='nickname' type="text" name="user" onchange="tt()"><br>
        
        <p>Contraseña:</p>
        <input type="password" name="password"><br>
        
        <p>Nombre:</p>
        <p id='alert2' hidden>Necesita 4 caracteres</p>
        <input id='username' type="text" name="name"><br>
        
        <p>Tipo:</p>
        <p id='alert3' hidden>Seleccione un rol</p>
        <select id="rol" name="type" onchange="check_rol()">
                <option value="0"> Elige una opción </option>
                <option value="1">Administrador</option>
                <option value="3">Repartidor</option>
                <option value="2">Cliente</option>
        </select>
        
		<div id="location">
			<p>Población:</p>
			<input type="text" name="town"><br>
			
			<p>Dirección:</p>
			<input type="text" name="direction"><br><br>			
		</div>
		
        <div style="text-align: center">
        <input type="button" onclick="check_form()" value="Crear Usuario">
        </div>
    </form>
</div>

<div class="clearfix"></div>
CREATE;

echo "<script>check_rol()</script>";
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