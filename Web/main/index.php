<?php
include_once '../lib/lib.php';
View::start('Distribuciones latosas');
View::navigation();

echo <<<CONTENT
<div id="panelInfo">
    <div class="panel">
        <h3>Información sobre Distribuciones Latosas</h3>
        <p>En Distribuciones Latosas nos encargamos de distribuir las mejores marcas a todo el archipiélago canario en el sector de la bebida.</p>
        <p>Nuestros valores vienen marcados por una experiencia de 8 años dando el mejor servicio a nuestros clientes.</p>
        <p>Los tres almacenes de Distribuciones Latosas están dotados de amplios espacios organizados para ofrecer un servicio rápido y eficiente.</p>
    </div>
</div>

<div class="clearfix"></div>
CONTENT;

View::end();