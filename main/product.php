<?php
include_once '../lib/lib.php';
View::start('Distribuciones latosas');
View::navigation();

$product = str_replace("-", " ", $_GET['product']);
$product = ucwords($product);
View::productTable($product);

View::end();