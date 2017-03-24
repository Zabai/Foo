<?php
include_once '../lib/lib.php';
View::start('Distribuciones latosas');
View::navigation();

$product = str_replace("-", " ", $_GET['product']);
if ($product != "agua artificial") $product = ucwords($product);
else $product = ucfirst($product);
View::productTable($product);

View::end();