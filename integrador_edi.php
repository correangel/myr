<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once (__PHPDIR__ . "vital.php");

/*
 * Estados:
 * 0 = pendiente de integrar
 * 1 = integrado exitosamente
 * 2 = fallo de integracion, reintentar
 * 3 = fallo de integracion, abortar
 * 9 = se omitio en el momento de la ejecucion porque no se necesitaba EDI
 */

function oedi_estado($codigo_orden_edi, $estado, $log) {
    echo "Orden EDI: {$codigo_orden_edi}, Estado: {$estado}, Log: {$log}";
    $DATOS_OEDI = array();
    $DATOS_OEDI['estado'] = $estado;
    db_actualizar_datos('opsal_ordenes_edi', $DATOS_OEDI, "codigo_orden_edi = '{$codigo_orden_edi}'");
    edi_log($codigo_orden_edi, $log);
}

// Primero obtenemos el siguiente movimiento que necesite ser integrado
$c = 'SELECT codigo_orden_edi, codigo_orden, codigo_movimiento, fechatiempo, edi_raw, estado FROM opsal_ordenes_edi oe WHERE oe.estado IN (0,2) ORDER BY oe.estado ASC LIMIT 1';
$r = db_consultar($c);

if (mysqli_num_rows($r) == 0) {
    echo 'Nada que integrar, terminando.'.PHP_EOL;
    return false;
}

$DATOS_OEDI = db_fetch($r);
//var_dump($DATOS_OEDI);

$codigo_orden_edi = $DATOS_OEDI['codigo_orden_edi'];

$c = 'SELECT `codigo_orden`, `codigo_contenedor`, `tipo_contenedor`, `ISO`, `codigo_agencia`, `codigo_posicion`, `nivel`, `clase`, `tara`, `chasis`, `chasis_egreso`, `transportista_ingreso`, `transportista_egreso`, `buque_ingreso`, `buque_egreso`, `cheque_ingreso`, `cheque_egreso`, `cepa_salida`, `arivu_ingreso`, `arivu_referencia`, `observaciones_egreso`, `observaciones_ingreso`, `destino`, `estado`, `fechatiempo_ingreso`, `fechatiempo_egreso`, `ingresado_por`, `egresado_por`, `sucio`, `tipo_salida`, `eir_ingreso`, `eir_egreso`, `ingreso_con_danos`, `cliente_ingreso`, `chofer_ingreso`, `chofer_egreso`, `booking_number`, `booking_number_ingreso` FROM `opsal_ordenes` LEFT JOIN `opsal_tipo_contenedores` USING (tipo_contenedor) WHERE `codigo_orden` = "' . $DATOS_OEDI['codigo_orden'] . '"';
$r = db_consultar($c);

if (mysqli_num_rows($r) == 0) {
    oedi_estado($codigo_orden_edi, 3, 'ERROR: order is missing');
    return false;
}

$DATOS = db_fetch($r);
var_dump($DATOS);

$c = 'SELECT `codigo_usuario`, `activo`, `unb_ver`, `ung`,`sender_id`, `receiver_id`, `metodo`, `usuario`, `contrasena`, `host`, `dir_work`, `dir_out`, `dir_in`, `loc165` FROM `edi` WHERE codigo_usuario="' . $DATOS['codigo_agencia'] . '"';
$r = db_consultar($c);
$EDI = db_fetch($r);

var_dump($EDI);

if ($EDI == NULL) {
   oedi_estado($codigo_orden_edi, 9, 'Unrecoverable: EDI connection not set. Skipping.');
}

if ($EDI['metodo'] == 'ftp') {
    // establecer una conexión básica
    $conn_id = ftp_connect($EDI['host']);

    if (FALSE === $conn_id) {
        oedi_estado($codigo_orden_edi, 2, 'TEMP ERROR: FTP can not be contacted. Retrying in a minute.');
        return false;
    }

    ftp_pasv($conn_id, true);

    // iniciar una sesión con nombre de usuario y contraseña
    $login_result = ftp_login($conn_id, $EDI['usuario'], $EDI['contrasena']);
    if (FALSE === $login_result) {
        oedi_estado($codigo_orden_edi, 2, 'TEMP ERROR: FTP credentials not working. Retrying in a minute.');
        return false;
    }


    $fp = fopen('php://temp', 'r+');

    if (FALSE === $fp) {
        oedi_estado($codigo_orden_edi, 2, 'TEMP ERROR: fopen failed for temp file.');
        return false;
    }

    fwrite($fp, $DATOS_OEDI['edi_raw']);

    $nombre_archivo = date('Ymd_His_') . uniqid('', true) . '_' . $DATOS['codigo_contenedor'] . '.edi';

    // Subir el original
    rewind($fp);
    $result_chdir = ftp_chdir($conn_id, $EDI['dir_out']);

    if (FALSE === $result_chdir) {
        oedi_estado($codigo_orden_edi, 2, "TEMP ERROR: chdir error, verify that dir '{$EDI['dir_out']}' exists.");
        return false;
    }

    $upload = ftp_fput($conn_id, $nombre_archivo, $fp, FTP_ASCII);

    if (FALSE === $result_chdir) {
        oedi_estado($codigo_orden_edi, 2, "TEMP ERROR: ftp_put error, verify that remote is writable and has disk space.");
        return false;
    }
    
    // cerrar la conexión ftp 
    ftp_close($conn_id);
    
    oedi_estado($codigo_orden_edi, 1, "EDI file succesfully processed and stored in remote FTP.");
} else {
  echo 'SFTP not supported'.PHP_EOL;
}