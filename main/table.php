<?php
include_once '../lib/lib.php';
include_once '../lib/customer-tools.php';

if (!User::getLoggedUser()) header("Location: ../main/index.php");

View::start('Distribuciones latosas');
View::navigation();

echo "<script src='../javascript/components.js'></script>";
echo "<script src='../json/actions.js'></script>";
echo "<button id='show_create_order' onclick='show_create_order()'>Crear pedido</button>";

$existOrder = exists_order();

if ($existOrder) {
    view_product_table();
    view_cart_table();
}

View::end();


/* --- Functions --- */
function view_product_table()
{
    $db = new DB();
    $result = $db->execute_query("SELECT * FROM bebidas;");

    if ($result) {
        $result->setFetchMode(PDO::FETCH_NAMED);
        $first = true;

        $tableHead["id"] = "ID";
        $tableHead["marca"] = "Nombre del producto";
        $tableHead["stock"] = "Stock";
        $tableHead["PVP"] = "Precio";

        foreach ($result as $drink) {
            if ($first) {
                echo <<<HEAD
                <table class='tablaHorizontal'>
                    <tr>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
HEAD;
                $first = false;
            }
            if ($drink['stock'] > 0) $stock = "Sí";
            else $stock = "No";
            $product = strtolower(str_replace(" ", "-", $drink['marca']));
            echo <<<BODY
            <tr>
                <td><a href="../main/product.php?product={$product}">{$drink['marca']}</a></td>
                <td>{$stock}</td>
                <td>{$drink['PVP']}</td>
                <td><input type=number min=0 max=100></td>
            </tr>
BODY;
        }
        echo '</table>';
    }
}

function view_cart_table()
{
    $db = new DB();
    $result = $db->execute_query("SELECT * FROM lineaspedido WHERE ");
}