<?php

echo '<form action="" method="GET">';
echo '<p>Año: <input type="text" name="fecha_consolidado" value="'.date('Y').'" /> <input type="submit" value="Actualizar" /></p>';

$ano = db_codex(@$_GET['fecha_consolidado'] ?: date('Y'));
$cMes[] = array();
$otroMes =2;
for($mes = 1; $mes < 13; $mes++)
{
    $cMes[$mes] = 'SUM(IF( T.f_salida < DATE("'.$ano.'-'.$otroMes.'-01") 
    				AND T.f_salida >= DATE("'.$ano.'-'.$mes.'-01"), 1, 0))';
    $otroMes++;
}
//var_dump($cMes);
$c = 'SELECT  IF(id_cliente, (SELECT nombreCliente FROM myr_cliente_taller WHERE idCliente=id_cliente), "<b>Total</b>") AS "Agencia", '.$cMes[1].' AS  "Enero", '.$cMes[2].' AS  "Febrero", '.$cMes[3].' AS  "Marzo", '.$cMes[4].' AS  "Abril", '.$cMes[5].' AS  "Mayo", '.$cMes[6].' AS  "Junio", '.$cMes[7].' AS  "Julio", '.$cMes[8].' AS  "Agosto", '.$cMes[9].' AS  "Septiembre", '.$cMes[10].' AS  "Octubre", '.$cMes[11].' AS  "Noviembre", '.$cMes[12].' AS  "Diciembre" FROM  `myr_orden_taller` AS T WHERE YEAR(T.f_ingreso) = "'.$ano.'" and T.estado="Y" GROUP BY (T.id_cliente) WITH ROLLUP';
//echo $c;

$rIngresosMes = db_consultar($c);


$titulo = 'Total de Ordenes de Trabajo por mes - '.$ano.' - Datos al '.strftime('%A %e de %B');
echo '<h1>'. $titulo .'</h1>';
echo '<div class="exportable" rel="'.$titulo.'">';
echo db_ui_tabla($rIngresosMes,'class="tabla-estandar opsal_tabla_ancha opsal_tabla_borde_oscuro tabla-centrada"');
echo '</div>';


////////////////
echo '<br /><hr /><br />';

$cMes[] = array();
$otroMes =2;
for($mes = 1; $mes < 13; $mes++)
{
    $cMes[$mes] = 'CONCAT("$ ",FORMAT(SUM(IF( T.f_salida < DATE("'.$ano.'-'.$otroMes.'-01") 
    				AND T.f_salida >= DATE("'.$ano.'-'.$mes.'-01"), TD.valor, 0)),2))';
    $otroMes++;
}
//var_dump($cMes);
$c = 'SELECT  IF(id_cliente, (SELECT nombreCliente FROM myr_cliente_taller WHERE idCliente=id_cliente), "<b>Total</b>") AS "Agencia", '.$cMes[1].' AS  "Enero", '.$cMes[2].' AS  "Febrero", '.$cMes[3].' AS  "Marzo", '.$cMes[4].' AS  "Abril", '.$cMes[5].' AS  "Mayo", '.$cMes[6].' AS  "Junio", '.$cMes[7].' AS  "Julio", '.$cMes[8].' AS  "Agosto", '.$cMes[9].' AS  "Septiembre", '.$cMes[10].' AS  "Octubre", '.$cMes[11].' AS  "Noviembre", '.$cMes[12].' AS  "Diciembre" FROM  `myr_orden_taller` AS T
		join myr_orden_taller_detalle as TD
		on T.id_orden=TD.idOrdenTaller
 WHERE T.estado="Y"  GROUP BY (T.id_cliente) WITH ROLLUP';

$rIngresosMes = db_consultar($c);


$titulo = 'Total Monto de OT Por Mes - '.$ano.' - Datos al '.strftime('%A %e de %B');
echo '<h1>'. $titulo .'</h1>';
echo '<div class="exportable" rel="'.$titulo.'">';
echo db_ui_tabla($rIngresosMes,'class="tabla-estandar opsal_tabla_ancha opsal_tabla_borde_oscuro tabla-centrada"');
echo '</div>';


////////////////
echo '<br /><hr /><br />';


?>
