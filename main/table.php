<?php
include_once '../lib/lib.php';
include_once '../lib/customer-tools.php';

if (!User::getLoggedUser()) header("Location: ../main/index.php");

View::start('Distribuciones latosas');
View::navigation();

echo "<script src='../javascript/components.js'></script>";
echo "<script src='../json/actions.js'></script>";

$existOrder = exists_order();
if ($existOrder) {
    view_product_table();
    echo "<button id='create_line' onclick='create_line()'>Añadir al pedido</button>";
    view_cart_table();
    echo "<button id='finish_order' onclick='finish_order()'>Terminar pedido</button>";
} else {
    echo "<button id='show_create_order' onclick='show_create_order()'>Empezar pedido</button>";
}

echo "<div class='clearfix'></div>";
View::end();


/* --- Functions --- */
function view_product_table()
{
    $db = new DB();
    $result = $db->execute_query("SELECT * FROM bebidas;");

    if ($result) {
        $result->setFetchMode(PDO::FETCH_NAMED);
        $first = true;

        foreach ($result as $drink) {
            if ($first) {
                echo <<<HEAD
                <table class='tablaHorizontal'>
                    <caption>Productos</caption>
                    <tr>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Precio(&euro;)</th>
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
                <input type="hidden" name="id[]" value="{$drink['id']}">
                <input type="hidden" name="PVP[]" value="{$drink['PVP']}">
                <td name="marca"><a href="../main/product.php?product={$product}">{$drink['marca']}</a></td>
                <td>{$stock}</td>
                <td>{$drink['PVP']}</td>
                <td><input type=number name="amount[]" value=0 min=0 max=100></td>
            </tr>
BODY;
        }
        echo '</table>';
    }
}

function view_cart_table()
{
    $db = new DB();
    $result = $db->execute_query("SELECT * FROM lineaspedido 
                                    WHERE idpedido=(SELECT id FROM pedidos WHERE idcliente=? AND horacreacion=?)",
        array(User::getLoggedUser()['id'], 0));

    if ($result) {
        $result->setFetchMode(PDO::FETCH_NAMED);

        echo <<<HEAD
        <table id="lineTable" class="tablaHorizontal">
            <caption>Carrito</caption>
            <tr>
                <th>Bebida</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total(&euro;)</th>
                <th>Acciones</th>
            </tr>
HEAD;
        foreach ($result as $line) {
            $totalPrice = $line['PVP'] * $line['unidades'];
            echo <<<BODY
            <tr id="line{$line['id']}">
                <td>{$line['idbebida']}</td>
                <td>{$line['PVP']}</td>
                <td>{$line['unidades']}</td>
                <td>{$totalPrice}</td>
                <td><button id="delete_line" onclick="delete_line({$line['id']})">Eliminar</button></td>
            </tr>
BODY;
        }
        echo "</table>";
    }
}