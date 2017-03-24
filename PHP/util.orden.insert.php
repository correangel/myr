<?php


require_once 'db/tallerDetalle.php';
$orden = new TallerDetalle();

/*
$equipo = $_POST['equipo'];
$placa = $_POST['placa'];
$cliente = $_POST['cliente'];
$kilometraje = $_POST['kilometraje'];
$fechaI = $_POST['fechaI'];
$fechaF = $_POST['fechaF'];
*/

$count = $orden->insertOrden($_POST);

if($count != 0)
{
	header('Location: '. 'util.orden.add.detalle.html?id='.$count);
}
