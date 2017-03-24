<?php
header('Content-Type: application/json');

// Ruta del archivo de configuracion y personalizacion
require_once('config.php');
require_once (__PHPDIR__ . "vital.php");

$respuesta = array();
$respuesta['resultado'] = '';
$respuesta['codigo_orden'] = '';

if (isset($_POST['guardar'])) 
{
    $codigo_agencia = $_POST['codigo_agencia'];

    if (empty($codigo_agencia)) {
        $respuesta['resultado'] = 'detalle: no hay codigo de agencia';
        echo json_encode($respuesta);
        return;
    }

    // Obtengamos el codigo_posicion (punto inicial para el caso de los de 40, 45 y 48)
    //$_POST = 'pocision_columna','posicion_fila','posicion_nivel'
    $c_posicion = 'SELECT codigo_posicion FROM opsal_posicion WHERE x2="' . $_POST['posicion_columna'] . '" AND y2="' . $_POST['posicion_fila'] . '"';
    $r_posicion = db_consultar($c_posicion);
    if (mysqli_num_rows($r_posicion) > 0) {
        $b_posicion = mysqli_fetch_assoc($r_posicion);
        $codigo_posicion = $b_posicion['codigo_posicion'];
    }

    // Normalización de datos
    $_POST['codigo_contenedor'] = strtoupper($_POST['codigo_contenedor']);
    $_POST['tipo_contenedor'] = $_POST['tipo_contenedor'] . $_POST['tamano_contenedor'];

    $DATOS = array_intersect_key($_POST, array_flip(array('codigo_contenedor', 'cheque_ingreso', 'clase', 'tipo_contenedor', 'codigo_agencia', 'codigo_placa', 'tara', 'chasis', 'transportista_ingreso', 'buque_ingreso', 'cepa_salida', 'arivu_ingreso', 'observaciones_ingreso', 'arivu_referencia', 'fechatiempo_ingreso', 'eir_ingreso', 'ingreso_con_danos', 'cliente_ingreso', 'chofer_ingreso', 'ano_fabricacion', 'booking_number_ingreso', 'ingreso_marchamo', 'BL', 'puerto_procedencia', 'buque_arribo_estimado', 'ship_type', 'codigo_patio','ot_numero')));
    $DATOS['estado'] = 'dentro';
    $nivelVal = ($_POST['chasis_ingreso']=='Chasis') ? 6 : $_POST['posicion_nivel'];
    $DATOS['nivel'] = $nivelVal;
    $DATOS['codigo_posicion'] = $codigo_posicion;
    $DATOS['ingresado_por'] = _F_usuario_cache('codigo_usuario');
    $DATOS['codigo_patio'] = 1;
    $DATOS['ot_numero'] = $_POST['ot_numero'];
    if (isset($_POST['codigo_patio']) && is_numeric($_POST['codigo_patio'])) {
        $DATOS['codigo_patio'] = $_POST['codigo_patio'];
    }

    $codigo_orden = db_agregar_datos('opsal_ordenes', $DATOS);

    if ($codigo_orden > 0) {
        // Agregamos una estiba
        unset($DATOS);
        $DATOS['motivo'] = 'estiba';
        $DATOS['cobrar_a'] = $codigo_agencia;
        $DATOS['codigo_posicion'] = $codigo_posicion;
        $DATOS['codigo_orden'] = $codigo_orden;
        $DATOS['fechatiempo'] = $_POST['fechatiempo_ingreso'];
        $DATOS['nivel'] = $_POST['posicion_nivel'];
        $DATOS['codigo_usuario'] = _F_usuario_cache('codigo_usuario');
        $DATOS['cheque'] = $_POST['cheque_ingreso'];

        $respuesta['codigo_orden'] = db_agregar_datos('opsal_movimientos', $DATOS);
        $respuesta['resultado'] = 'ok';
        
        enviar_edi($codigo_orden);
        registrar('Nuevo contenedor (ID: <b>' . $codigo_orden . '</b>) en <b>' . $_POST['posicion_columna'] . '-' . $_POST['posicion_fila'] . '-' . $_POST['posicion_nivel'] . '</b>', 'ingreso', $codigo_orden);
        
        echo json_encode($respuesta);
        return;
    }
}
//---------- Insertando posicion de cabezal en Taller
elseif (isset($_POST['guardar']) and $_POST['chasis_ingreso']==1) 
{
    //var_dump($_POST);
    $codigo_agencia = $_POST['codigo_agencia'];

    if (empty($codigo_agencia)) 
    {
        $respuesta['resultado'] = 'detalle: no hay codigo de agencia';
        echo json_encode($respuesta);
        return;
    }

    // Obtengamos el codigo_posicion (punto inicial para el caso de los de 40, 45 y 48)
    $c_posicion = 'SELECT codigo_posicion FROM opsal_posicion WHERE x2="' . $_POST['posicion_columna'] . '" AND y2="' . $_POST['posicion_fila'] . '"';
    $r_posicion = db_consultar($c_posicion);
    if (mysqli_num_rows($r_posicion) > 0) {
        $b_posicion = mysqli_fetch_assoc($r_posicion);
        $codigo_posicion = $b_posicion['codigo_posicion'];
    }

    // Normalización de dato
     $_POST['tipo_contenedor'] ='TLL20';

    $DATOS = array_intersect_key($_POST, array_flip(array('tipo_contenedor','codigo_agencia','observaciones_ingreso', 'cliente_ingreso','codigo_patio')));
    $DATOS['estado'] = 'dentro';
    $DATOS['nivel'] = 1;
    $DATOS['codigo_posicion'] = $codigo_posicion;
    $DATOS['ingresado_por'] = _F_usuario_cache('codigo_usuario');
    $DATOS['codigo_patio'] = 1;
    if (isset($_POST['codigo_patio']) && is_numeric($_POST['codigo_patio'])) {
        $DATOS['codigo_patio'] = $_POST['codigo_patio'];
    }

    $codigo_orden = db_agregar_datos('opsal_ordenes', $DATOS);

    if ($codigo_orden > 0) {
        // Agregamos una estiba
        unset($DATOS);
        $DATOS['id_cliente'] = $_POST['codigo_agencia'];
        $DATOS['f_ingreso'] = $_POST['fechatiempo_ingreso'];
        $DATOS['f_salida'] = $_POST['fechatiempo_salida'];
        $DATOS['kilometraje'] = $_POST['kilometraje'];
        $DATOS['id_equipo'] = $_POST['n_equipo'];
        $DATOS['n_orden'] = $codigo_orden;
        $DATOS['Placa'] = $_POST['codigo_placa'];
        $DATOS['estado'] = 'N';

        $respuesta['codigo_orden_taller'] = db_agregar_datos('myr_orden_taller', $DATOS);
        if ($respuesta['codigo_orden_taller'] !="" and !empty($respuesta['codigo_orden_taller'])) 
        {
            $respuesta['resultado'] = 'okT';
        }
        echo json_encode($respuesta);
        return;
    }
}

?>