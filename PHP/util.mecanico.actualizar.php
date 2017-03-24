<?php
require_once 'db/mecanico.php';
$persona = new Personaje();
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$especialidad = $_POST['especialidad'];
$estado = $_POST['estado'];
$count = $persona->updateMecanico($id,$nombre,$especialidad,$estado);

if($count == 1)
{
	header('Location: '. 'util.mecanico.html');
}
