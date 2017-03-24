<?php
require_once 'db/tallerDetalle.php';
$DeteItems = new TallerDetalle();


if(isset($_GET['id']))
{
	$Closed = $DeteItems->CloseOrden($_GET['id']);
}


if($Closed != 0)
{
	header('Location: '. 'util.orden.add.detalle2.html?id='.$_GET['id']);
}
?>