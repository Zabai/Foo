<?php
include_once '../lib/lib.php';
include_once '../lib/deliver-tools.php';

if (User::getLoggedUser()['tipo'] != 3) header("Location: ../main/index.php");
deliver_operation();

View::start('Distribuciones latosas');
View::navigation();

echo "<h2>Pedidos sin asignar</h2>";
$db = new DB();
$result = $db->execute_query("SELECT * FROM pedidos WHERE idrepartidor IS NULL AND horacreacion>?;", array(0));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    foreach ($result as $order) {
        if ($first) {
            echo <<<HEAD
			<table class='tablaHorizontal'>
				<tr>
					<th>Cliente</th>
					<th>Población</th>
					<th>Dirección</th>
					<th>Hora creación</th>
					<th>Acciones</th>
				</tr>
HEAD;
            $first = false;
        }

        $cDate = date("Y-m-d H:i:s", $order['horacreacion']);
        echo <<<CONTENT
		<tr>
			<td>{$order['idcliente']}</td>
			<td>{$order['poblacionentrega']}</td>
			<td>{$order['direccionentrega']}</td>
			<td>{$cDate}</td>
			<td><a href='../deliver/deliver.php?op=asig&id={$order['id']}'>Asignar</a></td>
		</tr>
CONTENT;
    }
    echo "</table><hr>";
}


echo "<h2>Pedidos asignados</h2>";
$result = $db->execute_query("SELECT * FROM pedidos WHERE idrepartidor=? AND horareparto=?;", array(User::getLoggedUser()['id'], 0));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    foreach ($result as $order) {
        if ($first) {
            echo <<<HEAD
			<table class='tablaHorizontal'>
				<tr>
					<th>Cliente</th>
					<th>Población</th>
					<th>Dirección</th>
					<th>Hora creación</th>
					<th>Hora asignación</th>
					<th>Acciones</th>
				</tr>
HEAD;
            $first = false;
        }

        $cDate = date("Y-m-d H:i:s", $order['horacreacion']);
        $aDate = date("Y-m-d H:i:s", $order['horaasignacion']);
        echo <<<CONTENT
		<tr>
			<td>{$order['idcliente']}</td>
			<td>{$order['poblacionentrega']}</td>
			<td>{$order['direccionentrega']}</td>
			<td>{$cDate}</td>
			<td>{$aDate}</td>
			<td><a href='../deliver/deliver.php?op=deli&id={$order['id']}'>En reparto</a></td>
		</tr>
CONTENT;
    }
    echo "</table><hr>";
}

echo "<h2>Pedidos en reparto</h2>";
$result = $db->execute_query("SELECT * FROM pedidos WHERE idrepartidor=? AND horareparto>? AND horaentrega=?;", array(User::getLoggedUser()['id'], 0, 0));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    foreach ($result as $order) {
        if ($first) {
            echo <<<HEAD
			<table class='tablaHorizontal'>
				<tr>
					<th>Cliente</th>
					<th>Población</th>
					<th>Dirección</th>
					<th>Hora creación</th>
					<th>Hora reparto</th>
					<th>Acciones</th>
				</tr>
HEAD;
            $first = false;
        }

        $cDate = date("Y-m-d H:i:s", $order['horacreacion']);
        $dDate = date("Y-m-d H:i:s", $order['horareparto']);
        echo <<<CONTENT
		<tr>
			<td>{$order['idcliente']}</td>
			<td>{$order['poblacionentrega']}</td>
			<td>{$order['direccionentrega']}</td>
			<td>{$cDate}</td>
			<td>{$dDate}</td>
			<td><a href='../deliver/deliver.php?op=fini&id={$order['id']}'>Entregado</a></td>
		</tr>
CONTENT;
    }
    echo "</table><hr>";
}

echo "<h2>Pedidos entregados</h2>";
$db = new DB();
$result = $db->execute_query("SELECT * FROM pedidos WHERE idrepartidor=? AND horaentrega>?;", array(User::getLoggedUser()['id'], 0));

if ($result) {
    $result->setFetchMode(PDO::FETCH_NAMED);
    $first = true;

    foreach ($result as $order) {
        if ($first) {
            echo <<<HEAD
			<table class='tablaHorizontal'>
				<tr>
					<th>Cliente</th>
					<th>Población</th>
					<th>Dirección</th>
					<th>Hora creación</th>
					<th>Hora entrega</th>
				</tr>
HEAD;
            $first = false;
        }

        $cDate = date("Y-m-d H:i:s", $order['horacreacion']);
        $fDate = date("Y-m-d H:i:s", $order['horaentrega']);
        echo <<<CONTENT
		<tr>
			<td>{$order['idcliente']}</td>
			<td>{$order['poblacionentrega']}</td>
			<td>{$order['direccionentrega']}</td>
			<td>{$cDate}</td>
			<td>{$fDate}</td>
		</tr>
CONTENT;
    }
    echo "</table><hr>";
}

View::end();