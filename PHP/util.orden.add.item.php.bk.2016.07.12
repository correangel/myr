<?php
require_once 'db/tallerDetalle.php';
$Items = new TallerDetalle();

//var_dump($_POST);
//var_dump($_SESSION);
//exit();
if(isset($_POST))
{
	$id = $Items->insertOrdenItems($_POST);
}


if($id != 0)
{
	header('Location: '. 'util.orden.add.detalle.html?id='.$_POST['idOrdenTaller']);
}
