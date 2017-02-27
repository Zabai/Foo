<?php
include_once '../lib.php';
View::start('Distribuciones latosas');
View::navigation();
User::login($_POST['uname'], $_POST['psw']);

$db = new DB();
$result = $db->execute_query("SELECT * FROM bebidas;");

//Pruebas
echo "<h2>" . "EPOCH: " . time() . "</h2>";
echo "<h3>" . "Human: " . date("Y-m-d H:i:s", time()) . "</h2>";

//Ejemplo de lectura de tabla
if ($result) {
    echo '<h2>Ejemplo acceso a tabla</h2>';
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first=true;
    // Todo equivale a $res
    //$todo = $res->fetchAll();
    foreach ($result as $bebida) {
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