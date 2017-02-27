<?php
include_once '../lib.php';
View::header('Distribuciones latosas');
View::navigation();

$db = new DB();
$res = $db->execute_query("SELECT * FROM bebidas;");

//Pruebas
echo "<h2>" . "EPOCH: " . time() . "</h2>";
echo "<h3>" . "Human: " . date("Y-m-d H:i:s", time()) . "</h2>";

//Ejemplo de lectura de tabla
if($res){
    echo '<h2>Ejemplo acceso a tabla</h2>';
    $res->setFetchMode(PDO::FETCH_NAMED);
    $first=true;
    // Todo equivale a $res
    //$todo = $res->fetchAll();
    foreach($res as $bebida){
        if($first){
            echo "<table><tr>";
            foreach($bebida as $field=>$value){
                echo "<th>$field</th>";
            }
            $first = false;
            echo "</tr>";
        }
        echo "<tr>";
        foreach($bebida as $value){
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo '</table>';
}
View::end();