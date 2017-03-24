<?php
$c = 'SELECT codigo_usuario, usuario FROM opsal_usuarios WHERE nivel="agencia" ORDER BY usuario ASC';
$r = db_consultar($c);

$agencia = '<table class="tabla-estandar opsal_tabla_ancha zebra opsal_tabla_borde_oscuro tabla-hover">';
$agencia .= '<tbody>';
if (mysqli_num_rows($r) > 0)
{
    while ($registro = mysqli_fetch_assoc($r))
    {
        $agencia .= sprintf('<tr><td>%s</td><td style="text-align:center;">%s</td></tr>',$registro['usuario'],
        	'<a href="'.PROY_URL.'administracion.html?modo=editar.agencia&objetivo='.$registro['codigo_usuario'].'">Modificar</a> | 
        	<a href="'.PROY_URL.'administracion.html?modo=tarifas&objetivo='.$registro['codigo_usuario'].'">Tarifas</a> | 
        	<a href="'.PROY_URL.'administracion.html?modo=edi&objetivo='.$registro['codigo_usuario'].'">EDI</a> | 
        	<a href="'.PROY_URL.'administracion.html?modo=agencias&submodo=eliminar&objetivo='.$registro['codigo_usuario'].'">Eliminar</a>');
    }
}
$agencia .= '</tbody>';
$agencia .= '<thead>';
$agencia .= '<tr><th>Agencia</th><th style="width:350px;">Herramientas</th></tr>';
$agencia .= '</thead>';
$agencia .= '<table>';
?>
<h1 class="opsal_titulo">Control de agencias</h1>
<?php echo $agencia; ?>
<a href="/myr/administracion.html?modo=agregar.agencia" class="boton">Agregar nueva agencia</a>