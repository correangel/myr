<?php
$options_transportista = $options_agencia = $options_cheque = '';

$c = 'SELECT ct.idCliente as "id", ct.nombreCliente as "name" FROM myr_cliente_taller ct WHERE ct.estado = "Y" ORDER BY ct.idCliente ASC';
$r = db_consultar($c);

$options_agencia = '<option selected="selected" value="">Seleccione una</option>';
if (mysqli_num_rows($r) > 0) {
    while ($registro = mysqli_fetch_assoc($r)) {
        $options_agencia .= '<option value="' . $registro['id'] . '">' . $registro['name'] . '</option>';
    }
}

$c = 'SELECT nombre FROM cheques WHERE flag_activo=1 ORDER BY nombre ASC';
$r = db_consultar($c);
$options_cheques = '<option selected="selected" value="">Seleccione uno</option>';
if (@mysqli_num_rows($r) > 0) {
    while ($registro = mysqli_fetch_assoc($r)) {
        $options_cheques .= '<option value="' . $registro['nombre'] . '">' . $registro['nombre'] . '</option>';
    }
}
?>
<form id="frm_ingreso_contenedores" action="/contenedores.html?modo=ingreso" method="post" autocomplete="off">
    <table class="tabla-estandar opsal_tabla_ancha">
        <tbody>
            <tr><td>Cliente</td><td><select id="codigo_agencia" name="codigo_agencia"><?php echo $options_agencia; ?></select></td></tr>
            <tr><td>Fecha ingreso</td><td><input type="text" class="calendariocontiempo" value="" id="fechatiempo_ingreso" name="fechatiempo_ingreso" /></td></tr>
            <tr><td>Fecha Salida</td><td><input type="text" class="calendariocontiempo" value="" id="fechatiempo_salida" name="fechatiempo_salida" /></td></tr>
             <tr><td>Posición</td><td>
                    <table class="opsal_tabla_ancha tabla-estandar tabla-centrada">
                        <tbody>
                            <tr><th>Col.</th><th>Fila</th><th>Nivel</th></tr>
                            <tr>
                                <td><input style="width:20px;" type="text" value="" name="posicion_columna" id="posicion_columna" class="posicion" /></td>
                                <td><input style="width:20px;" type="text" value="" name="posicion_fila" id="posicion_fila"  class="posicion" /></td>
                                <td><input style="width:20px;" type="text" value="" name="posicion_nivel" id="posicion_nivel"  class="posicion" readonly="readonly" /></td>
                            </tr>
                        </tbody>
                    </table>
                </td></tr>
            <tr><td>Kilometraje</td><td><input type="text" value="" id="kilometraje" name="kilometraje" /></td></tr>
            <tr><td>No. Equipo</td><td><input type="text" value="" id="n_equipo" name="n_equipo" /></td></tr>
            <tr><td>No. Orden</td><td><input type="text" value="" id="n_orde" name="n_orde" /></td></tr>
            <tr><td>Placa</td><td><input type="text" value="" id="codigo_placa" name="codigo_placa" /></td></tr>
            <tr><td>Ubicar Equipo</td><td><input type="checkbox" value="1" id="chasis_ingreso" name="chasis_ingreso" checked /></td></tr>    
            <tr><td>Observaciones</td><td><textarea name="observaciones_ingreso"></textarea></td></tr>
        </tbody>
    </table>
    <input type="hidden" name="guardar" value="guardar" />
    <input type="submit" id="ingresar_contenedor" value="Ingresar contenedor" /> <span id="indicador_de_envio"></span>
</form>
<?php
$r = db_consultar('SELECT buque_ingreso FROM `opsal_ordenes` WHERE buque_ingreso<>"" GROUP BY buque_ingreso');
$tagsBuque = array();
while ($f = db_fetch($r))
    $tagsBuque[] = $f['buque_ingreso'];

$tagsCliente = array();
$r = db_consultar('SELECT cliente_ingreso FROM `opsal_ordenes` WHERE cliente_ingreso<>"" GROUP BY cliente_ingreso');
$tagsDestino = array();
while ($f = db_fetch($r))
    $tagsCliente[] = $f['cliente_ingreso'];

$r = db_consultar('SELECT cheque_ingreso FROM `opsal_ordenes` WHERE cheque_ingreso<>"" GROUP BY cheque_ingreso');
$tagsCheque = array();
while ($f = db_fetch($r))
    $tagsCheque[] = $f['cheque_ingreso'];

$r = db_consultar('SELECT transportista_ingreso FROM `opsal_ordenes` WHERE transportista_ingreso<>"" GROUP BY transportista_ingreso');
$tagsTransportista = array();
while ($f = db_fetch($r))
    $tagsTransportista[] = $f['transportista_ingreso'];

$r = db_consultar('SELECT chofer_ingreso FROM `opsal_ordenes` WHERE chofer_ingreso<>"" GROUP BY chofer_ingreso');
$tagsChofer = array();
while ($f = db_fetch($r))
    $tagsChofer[] = $f['chofer_ingreso'];
?>
<script type="text/javascript">
    cubicaje = 0;
    afinidad = 20;

    color = 'black';
    setInterval(function () {
        var elementos = $('#contenedor_visual');
        elementos.css('background-color', color);
        color = (color == 'black' ? '#00FAFF' : 'black');
        elementos.css('color', color);
    }, 500);


    function cambiarCursor(valor) {
        cubicaje = valor;
        $('#opsal_mapa #contenedor_mapa table').css('cursor', 'url("<?php echo PROY_URL ?>IMG/cursor/' + cubicaje + '.gif") 6 9,crosshair');
    }

    function obtenerDatosExtras() {
        var cadena = '';
        if (typeof $("#codigo_patio").val() !== 'undefined') {
            cadena = '&codigo_patio=' + $("#codigo_patio").val();
        }

        return cadena;
    }

    $(function () {

        
        $('#frm_ingreso_contenedores').submit(function (event) {
            event.preventDefault();

            if (!Date.parseExact($("#fechatiempo_ingreso").val(), "yyy-MM-dd HH:mm:ss"))
            {
                alert("El formato de la fecha de ingreso parece incorrecto.");
                return false;
            }

        
            if ($("#posicion_columna").val() == "" || $("#posicion_fila").val() == "" || $("#posicion_nivel").val() == "")
            {
                alert("Verifique la posición ingresada.");
                return false;
            }

            $("#indicador_de_envio").html('<img src="<?php echo PROY_URL ?>IMG/general/cargando.gif" />');

            $("#ingresar_contenedor").attr('disabled', 'disabled');

            //$("#contenedor_mapa").html('<p>Guardando datos...</p><br /><img src="/IMG/general/cargando.gif" />');

            $("#contenedor_visual").css('left', 0).css('top', 0).css('height', 0).css('width', 0);

            $.post('ajax.ingreso.php', $('#frm_ingreso_contenedores').serialize() + obtenerDatosExtras(), function (datos) {
                if (datos.resultado == 'ok') {
                    if ($("#ot_numero").val() != "" && confirm('Desea agregar datos de orden de trabajo #' + $("#ot_numero").val() + '?')) {
                        window.location = "<?php echo PROY_URL; ?>orden.trabajo.html?ID=" + datos.codigo_orden;
                        return;
                    }


                    iniciar_mapa({codigo_patio: $("#codigo_patio").val()});
                    $('#frm_ingreso_contenedores')[0].reset();
                } 
                else if(datos.resultado == 'okT')
                {
                    window.location = "<?php echo PROY_URL; ?>contenedores.html?modo=patio";
                        return;
                }   
                else 
                {
                    alert('ERROR: ' + datos.resultado);
                    location.reload();
                }
            }, 'json');

            return false;
        });

        $("#contenedor_mapa").bind('mapa_iniciado', function () {
            cambiarCursor(20);
            $("#indicador_de_envio").empty();
            $("#codigo_contenedor").focus();
            $("#ingresar_contenedor").removeAttr('disabled');
        });

        $('#opsal_mapa #contenedor_mapa table td').live('click', function () {

            if (parseInt($(this).attr('nivel')) > 4)
            {
                alert('No se puede ubicar un contenedor en 6 nivel. Modo estricto esta activado.');
                return false;
            }

            if ($(this).attr('afinidad') != 'libre' && $(this).attr('afinidad') != afinidad)
            {
                alert('No se puede ubicar un contenedor de ' + afinidad + ' pies sobre uno de ' + $(this).attr('afinidad') + ' pies. Modo estricto esta activado.');
                return false;
            }

            if ($(this).hasClass('contenedor_zona_muerta'))
            {
                alert('No se puede ubicar el contenedor en este punto. Modo estricto esta activado.');
                return false;
            }



            var x = $(this).attr('x');
            var y = $(this).attr('y');

            $("#posicion_columna").val($(this).attr('col'));
            $("#posicion_fila").val($(this).attr('fila'));
            $("#posicion_nivel").val((parseInt($(this).attr('nivel')) + 1));

            referencia = $('#' + x + '_' + y);


            // Búsquemos que la cola no se monte sobre otro contenedor
            /*
             if (cubicaje > 20) {
             if ($('#'+x+'_'+(parseInt(y)-1)).attr('nivel') != '0') {
             alert('No se puede ubicar el contenedor en este punto. La cola del contenedor queda sobre otro bloque.');
             return false;
             }
             }
             
             if (cubicaje > 40) {
             if ($('#'+x+'_'+(parseInt(y)-2)).attr('nivel') != '0') {
             alert('No se puede ubicar el contenedor en este punto. La cola del contenedor queda sobre otro bloque.');
             return false;
             }
             }
             */

            //console.log('Ubicando contenedor de ' + cubicaje + ' pies³ en '+ x + ',' + y + '['+referencia.position().left+','+referencia.position().top+']');            

            $("#contenedor_visual").css('left', (referencia.position().left)).css('top', (referencia.position().top)).css('height', ((19 * (cubicaje / 20)) + 1) + 'px').css('width', '18px');
        });

        $("#ingreso_con_danos").buttonset();
        $("#ship_type").buttonset();
        $("#tamano_contenedor input[type='radio']").button();
        $("#tipo_contenedor input[type='radio']").button();

        $('#tamano_contenedor input[type="radio"],#tipo_contenedor input[type="radio"]').change(function () {
            $("#contenedor_visual").css('left', 0).css('top', 0).css('height', 0).css('width', 0);
            $("#posicion_columna").val('');
            $("#posicion_fila").val('');
            $("#posicion_nivel").val('');

            afinidad = $('#tipo_contenedor input[type="radio"]:checked').val() + $('#tamano_contenedor input[type="radio"]:checked').val();
            cambiarCursor($('#tamano_contenedor input[type="radio"]:checked').attr('rel'));
        });

        $('.posicion').change(function () {
            $('#opsal_mapa #contenedor_mapa table td[col="' + $('#posicion_columna').val() + '"][fila="' + $('#posicion_fila').val() + '"]').trigger('click');
        });

        $("#codigo_contenedor").blur(function () {
            // Verifiquemos que no este doble-ingresando este contenedor.
            if (/[\D]{4}\d{7}/.test($("#codigo_contenedor").val())) {
                $("#codigo_contenedor").val($("#codigo_contenedor").val().toUpperCase());
                $.post('ajax.seguro.php', {accion: 'verificar_doble_ingreso', contenedor: $("#codigo_contenedor").val()}, function (data) {
                    if (data.cantidad > 0)
                    {
                        alert("ERROR: parece que este contenedor ya esta ingresado en el patio.\nUtilice la opción de búsqueda para verificarlo");
                    }
                }, 'json');
            }
        });

    });
</script>
