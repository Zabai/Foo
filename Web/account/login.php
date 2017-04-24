<?php
include_once '../lib/lib.php';
View::start('Distribuciones latosas');
View::navigation();

echo <<<CONTENT
<div class="panel">
    <form id="login" method="post" action='../account/action.php?op=login'>
        <p>Usuario:</p>
        <input type="text" name="user" autofocus><br>
        <p>Contraseña:</p>
        <input type="password" name="password"><br><br>
        <div style="text-align: center">
        <input type="submit" value="Identificarse">
        </div>
    </form>
</div>

<div class="clearfix"></div>
CONTENT;

View::end();