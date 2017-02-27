<?php
include_once '../lib.php';
View::start('Distribuciones latosas');
View::navigation();

echo <<<CONTENT
<form id="login" method="post" action=''>
    <p>Usuario:</p>
    <input id="user" type="text" name="user"><br>
    <p>Clave:</p>
    <input id="pass" type="password" name="password"><br><br>
    <input id="submit" class="submit" type="submit" value="Identificarse">
</form>
CONTENT;
User::login($_POST['user'], $_POST['password']);
View::end();