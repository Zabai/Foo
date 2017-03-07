<?php
include_once '../lib/lib.php';
include_once '../lib/customer-tools.php';

if (!User::getLoggedUser()) header("Location: ../main/index.php");
customer_operation();

View::start('Distribuciones latosas');
View::navigation();

$db = new DB();
$result = $db->execute_query("SELECT * FROM bebidas;");

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    $tableHead["id"] = "ID";
    $tableHead["marca"] = "Nombre del producto";
    $tableHead["stock"] = "Stock";
    $tableHead["PVP"] = "Precio";

    echo "<form method='post' action='../main/table.php?op=new'>";
    foreach ($result as $drink) {
        if ($first) {
            echo "<table class='tablaHorizontal'><tr>";
            foreach ($drink as $field => $value) {
                echo "<th>$tableHead[$field]</th>";
            }
            echo "<th>Cantidad</th>";
            $first = false;
            echo "</tr>";
        }
        echo "<tr>";
        $index = 1;
        foreach ($drink as $value) {
            if ($index === 2) {
                $product = strtolower(str_replace(" ", "-", $value));
                echo "<td><a href=../main/product.php?product=$product>$value</a></td>";
            } else echo "<td>$value</td>";
            $index++;
        }
        echo "<td><input type='number' name='amount[]' value=0>";
        echo "<input type='hidden' name='id[]' value='$drink[id]'>";
        echo "<input type='hidden' name='PVP[]' value='$drink[PVP]'>";
        echo "</tr>";
    }
    echo '</table>';
    echo "<input type='submit' value='Crear pedido'>";
    echo "</form>";
}

View::end();