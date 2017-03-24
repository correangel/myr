<?php
require_once 'db/mecanico.php';
$persona = new Personaje();
$nombre = $_POST['nombre'];
$especialidad = $_POST['especialidad'];
$count = $persona->guardar($nombre,$especialidad);

if($count == 1)
{
	header('Location: '. 'util.mecanico.html');
}
