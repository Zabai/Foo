<?php
include_once '../lib.php';
View::start('Distribuciones latosas');
View::navigation();

echo <<<CONTENT
<div class="panel">
    <h3>Contacta con nosotros</h3>
    <p>Email: distlato@distlatos.es</p>
    <p>Teléfono: 902-522-632-800</p>
    <p>Dirección: Calle el Cortijo de San Gregorio, 17, 35018 Las Palmas de Gran Canaria, Las Palmas</p>
</div>

<div class="clearfix"></div>
CONTENT;

View::end();