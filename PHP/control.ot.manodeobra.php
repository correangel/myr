<?php

echo '<form action="" method="GET">';
echo '<p>Mes: <input type="date" name="fecha_consolidado" value="'.date('Y').'" /> <input type="submit" value="Actualizar" /></p>';

$ano = db_codex(@$_GET['fecha_consolidado'] ?: date('Y'));

if(isset($_GET['fecha_consolidado']))
{
	$fecha = date_create($_GET['fecha_consolidado']);
	//$fecha =  '"'.$fecha.'"';
	$mes = date_format($fecha,"m");

	$NombreMes="";
	
	switch ($mes) {
		case '01': $NombreMes="Enero"; break;
		case '02': $NombreMes="Febrero";break;
		case '03': $NombreMes="Marzo";break;
		case '04': $NombreMes="Abril";break;
		case '05': $NombreMes="Mayo";break;
		case '06': $NombreMes="Junio";break;
		case '07': $NombreMes="Julio";break;
		case '08': $NombreMes="Agosto";break;
		case '09': $NombreMes="Septiembre";break;
		case '10': $NombreMes="Octubre";break;
		case '11': $NombreMes="Noviembre";break;
		case '12': $NombreMes="Diciembre";break;
	}
	
echo '<br /><hr /><br />';

// SUMARISADO
$d = 'select 
	DATE_FORMAT(OT.f_salida, "%M") AS Mes,			
	CT.nombreLegal AS Cliente,
	FORMAT(sum(CR.costo_reparacion - OTD.valorInicial),2) AS Costo
	
	from myr_orden_taller as OT 
	JOIN myr_cliente_taller as CT ON OT.id_cliente=CT.idCliente
	JOIN myr_orden_taller_detalle as OTD ON OT.id_orden=OTD.idOrdenTaller
	JOIN myr_mecanico AS MEC ON MEC.id_mecanico=OTD.idMecanico
	JOIN myr_codigos_reparaciones AS CR ON CR.cod_reparacion=OTD.idCodTrabajo
	JOIN myr_codigos AS COD on COD.id_codigo=CR.cod_sistema
	WHERE DATE_FORMAT(OT.f_salida, "%m-%Y")=DATE_FORMAT("'.$_GET['fecha_consolidado'].'", "%m-%Y")
	group by CT.idCliente
	order by OT.n_orden
	';

	$rIngresosMes = db_consultar($d);


$titulo = 'TOTAL MANO DE OBRA POR LINEA - '.$NombreMes.' '.strftime('%A %e de %B');
echo '<h1>'. $titulo .'</h1>';
echo '<div class="exportable" rel="'.$titulo.'">';
echo db_ui_tabla($rIngresosMes,'class="tabla-estandar opsal_tabla_ancha opsal_tabla_borde_oscuro tabla-centrada"');
echo '</div><br><hr>';


// Sumatoria por OT y Linea
$e = 'select 

	DATE_FORMAT(OT.f_salida, "%M") AS Mes,			
	CT.nombreLegal AS Cliente,
	OT.n_orden as OT,
 	FORMAT((sum(OTD.valor)),2) AS Costo
 	

	FROM myr_orden_taller AS OT
	JOIN myr_cliente_taller AS CT ON OT.id_cliente=CT.idCliente
	JOIN myr_orden_taller_detalle AS OTD ON OT.id_orden=OTD.idOrdenTaller
	WHERE DATE_FORMAT(OT.f_salida, "%m-%Y")=DATE_FORMAT("'.$_GET['fecha_consolidado'].'", "%m-%Y")
	group by OT.n_orden
	order by CT.idCliente
	';

	$rIngresosMes = db_consultar($e);


$titulo = 'TOTAL MANO DE OBRA POR OT - '.$NombreMes.' '.strftime('%A %e de %B');
echo '<h1>'. $titulo .'</h1>';
echo '<div class="exportable" rel="'.$titulo.'">';
echo db_ui_tabla($rIngresosMes,'class="tabla-estandar opsal_tabla_ancha opsal_tabla_borde_oscuro tabla-centrada"');
echo '</div><br><hr>';


//var_dump($cMes);
$c = 'select 
	DATE_FORMAT(OT.f_salida, "%M") AS Mes,
	DATE_FORMAT(OT.f_ingreso, "%d-%b-%Y") AS Ingreso,
	DATE_FORMAT(OT.f_salida, "%d-%b-%Y") AS Salida,
	DATEDIFF(OT.f_salida,OT.f_ingreso)as Dias,
	OT.n_orden AS OTMYR,
	CT.nombreLegal AS Cliente,
	OT.Placa AS Placa,
	OT.id_equipo AS Equipo,
	MEC.nombre_mecanico AS Mecanico,
	COD.sistema As Sistema,
	CR.cod_reparacion as Codigo,
	CR.descripcion_reparacion AS Descripcion,
	FORMAT((CR.costo_reparacion - OTD.valorInicial),2) AS Costo
	
	from myr_orden_taller as OT 
	JOIN myr_cliente_taller as CT ON OT.id_cliente=CT.idCliente
	JOIN myr_orden_taller_detalle as OTD ON OT.id_orden=OTD.idOrdenTaller
	JOIN myr_mecanico AS MEC ON MEC.id_mecanico=OTD.idMecanico
	JOIN myr_codigos_reparaciones AS CR ON CR.cod_reparacion=OTD.idCodTrabajo
	JOIN myr_codigos AS COD on COD.id_codigo=CR.cod_sistema
	WHERE DATE_FORMAT(OT.f_salida, "%m-%Y")=DATE_FORMAT("'.$_GET['fecha_consolidado'].'", "%m-%Y")
	order by OT.n_orden
	';
	//echo $c;

$rIngresosMes = db_consultar($c);


$titulo = 'MANO DE OBRA - '.$NombreMes.' '.strftime('%A %e de %B');
echo '<h1>'. $titulo .'</h1>';
echo '<div class="exportable" rel="'.$titulo.'">';
echo db_ui_tabla($rIngresosMes,'class="tabla-estandar opsal_tabla_ancha opsal_tabla_borde_oscuro tabla-centrada"');
echo '</div>';




}


?>
