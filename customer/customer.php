<?php
include_once '../lib/lib.php';
include_once '../lib/customer-tools.php';

if (User::getLoggedUser()['tipo'] != 2) header("Location: ../main/index.php");

View::start('Distribuciones latosas');
View::navigation();

echo "<h2>Mis pedidos</h2>";
$db = new DB();
$result = $db->execute_query("SELECT p.horaentrega, p.horareparto, p.horaasignacion,p.id, p.idcliente, u.usuario, p.poblacionentrega, p.direccionentrega, p.horacreacion, p.pvp FROM pedidos as p join usuarios as u ON p.idcliente=? and u.id=p.idcliente;", array(User::getLoggedUser()['id']));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);

    echo <<<TABLEHEAD
    <table class="tablaHorizontal">
    <tr>
        <th>Usuario</th>
        <th>Poblacion entrega</th>
        <th>Direccion entrega</th>
        <th>Hora creacion</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
TABLEHEAD;
    foreach ($result as $order) {

        echo "<tr>";
        $index = 1;
        foreach ($order as $value) {
            if ($index < 6) {
                $index++;
            } else {
                if ($index === 9) echo "<td>" . date("Y-m-d H:i:s", $value) . "</td>";
                else echo "<td>$value</td>";
                $index++;
            }
        }
        if (strcmp($order['horaentrega'], '0') != 0) {
            echo "<td>Entregado</td>";
        } elseif (strcmp($order['horareparto'], '0') != 0) {
            echo "<td>En reparto</td>";
        } elseif (strcmp($order['horaasignacion'], '0') != 0) {
            echo "<td>Asignado</td>";
        } else if (strcmp($order['horacreacion'], '0') != 0) {
            echo "<td>Sin asignar</td>";
        } else echo "<td>Sin terminar</td>";
        echo "<td><a href='../customer/order-details.php?id=$order[id]'>Ver detalles</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

View::end();
