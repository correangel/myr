<?php
require_once 'db/taller.php';
$codigo = new Taller();

$count = $codigo->insertCodigo($_POST);

if($count == 1)
{
	header('Location: '. 'util.codigos.html');
}
