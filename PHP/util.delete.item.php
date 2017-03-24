<?php
require_once 'db/tallerDetalle.php';
$DeteItems = new TallerDetalle();

if(isset($_GET['id']))
{
	$Items = $DeteItems->deleteOrdenItems($_GET['id']);
	header('Location: '. 'util.orden.add.detalle.html?id='.$_GET['orden']);
}

if(isset($_GET['id1']) and isset($_GET['id2']))
{

	$Items = $DeteItems->deleteItemsOrdenCompra($_GET['id2']);
	header('Location: '. 'util.orden.add.detalle.html?id='.$_GET['id1']);
}

if(isset($_POST['idOC']))
{
	$Items = $DeteItems->deleteOrdenCompra($_POST);	
}