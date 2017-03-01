<?php
include_once '../lib.php';
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

    foreach ($result as $bebida) {
        if ($first) {
            echo "<table id='tablaProductos'><tr>";
            foreach ($bebida as $field => $value) {
                echo "<th>$tableHead[$field]</th>";
            }
            $first = false;
            echo "</tr>";
        }
        echo "<tr>";
        $index = 1;
        foreach ($bebida as $value) {
            if ($index === 2) {
                $product = strtolower(str_replace(" ", "-", $value));
                echo "<td><a href=../main/product.php?product=$product>$value</a></td>";
            } else echo "<td>$value</td>";
            $index++;
        }
        echo "</tr>";
    }
    echo '</table>';
}

View::end();