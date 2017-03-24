<?php
require_once 'db/taller.php';
$codigo = new Taller();

$count = $codigo->updateCodigo($_POST);

if($count == 1)
{
	header('Location: '. 'util.codigos.html');
}
