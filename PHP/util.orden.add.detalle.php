<?php
require_once 'db/taller.php';
require_once 'db/tallerDetalle.php';
$id =  1;

$NewOrdenTaller = new TallerDetalle();
$OrdenTaller    = new Taller();

$clientes       = $NewOrdenTaller->selectAllAgencias();
$inventario     = $NewOrdenTaller->selectAllInvCatalogo();
$mecanico       = $NewOrdenTaller->selectAllMecanico();
$codReparacion  = $NewOrdenTaller->getCostoReparacion();
$inventario     = $NewOrdenTaller->selectAllInventario();
$usuarios       = $NewOrdenTaller->getCliente();
$proveedor      = $NewOrdenTaller->getProveedor();
$data           = $OrdenTaller->selectId($_GET['id']);
$detalle        = $NewOrdenTaller->selectAllId($_GET['id']);
$OC             = $NewOrdenTaller->OC($_GET['id']);
$ClientesTaller = $NewOrdenTaller->ClienteTaller();
$orden          = $NewOrdenTaller->selectNewOrden($_GET['id']);
$creada         = 0;
$log_user       = $_SESSION['cache_datos_nombre_completo']['clave'];

 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>

<script src="JS/jquery-1.10.2.min.js"></script>
<script>

$(document).ready(function() {
    jQuery.noConflict();

    $(".credenciales").hide();

    $("#btn_descuento").click(function(){
        $(".credenciales").show();
    });


    //Validar Credenciales para descontar montos...................................
    $("#btn-validar").click(function(){
        var pass_user   = $("#log_user").val();             
        var password    = $("#supervisor").val();        
        
            var data    = { password:password,user:pass_user};      
            var sUrl    = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "html",
                data:data,
                type: "POST",
                success: function(data)
                {   
                   
                   if(data=="0")
                   {
                        alert("Credenciales Invalida");
                   }
                   else
                   {
                        $("#descuento").attr('readonly', true);
                        $("#supervisor").attr('readonly', true);
                        $("#btn_descuento").hide();
                        $("#btn-validar").hide();
                        
                        
                   }
                                      
                }                 
            }); 
    });
    // *******************************************************************************




    var costo = $("#cod_reparacion").attr("value"); 
    var codigo1 = $("#cod_reparacion option:selected" ).text();
    $("#costo").text(costo);
    $("#codigo").val(codigo1);

            
        var data = { id:codigo1};
            var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:data,
                type: "POST",
                success: function(data)
                {   
                    $("#descripcion_reparacion").empty();
                    $.each(data, function(index) {
                        $("#descripcion_reparacion").text(data[index].descripcion_reparacion);
                        });
                }                 
            });
    
    $("#cod_reparacion").change(function()
    { 
        var costo = $(this).attr("value");
        
        var cod = $("#cod_reparacion option:selected" ).text();         
        var data = { id:cod};
        $("#costo").text(costo);
        var codigo1 = $("#cod_reparacion option:selected" ).text();
        $("#codigo").val(codigo1);
                
        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:data,
                type: "POST",
                success: function(data)
                {   
                    $("#descripcion_reparacion").empty();
                    $.each(data, function(index) {
                        $("#descripcion_reparacion").text(data[index].descripcion_reparacion);
                        });
                }                 
            });
    });

    //Buscar la Descripcion por el Codigo
    $("#buscarCode").click(function(){
        var cod = $("#CodigoBuscar").val().toUpperCase();
        var data = { id:cod};
        
        var codigo1 = $("#cod_reparacion option:selected" ).text();
        $("#codigo").val(codigo1);
                
        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:data,
                type: "POST",
                success: function(data)
                {                       
                    if(data==""){
                        alert("Codigo "+cod+" Inactivo o No Existe");
                    }
                    $("#descripcion_reparacion").empty();
                    $("#costo").empty();
                    $.each(data, function(index) {
                        $("#costo").text(data[index].costo_reparacion);
                        $("#valorNew").val(data[index].costo_reparacion);
                        $("#descripcion_reparacion").text(data[index].descripcion_reparacion);
                        });
                }                 
            });

    });

    $("#cod_detalle").change(function(){
        var id = $(this).attr("value");
        var data = { costo:id};       


        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:data,
                type: "POST",
                success: function(data)
                {   
                    $("#costo").val("");
                    $.each(data, function(index) {
                        $("#costo").val(data[index].costo_reparacion);
                        });
                    
                }                 
            }); 
    });

    //Save Orden de Compra
    $("#btbOC").click(function(){

        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:$('#saveOC').serialize(),
                type: "POST",
                success: function(data)
                {
                    window.setTimeout('location.reload()', 1000);                    
                }                 
            }); 
    });

    //Save Orden de Compra
    $("#btnROC").click(function(){
        $('#agregarItemOT').css('width', '750px');
        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:$('#saveRepuestoOC').serialize(),
                type: "POST",
                success: function(data)
                {
                    window.setTimeout('location.reload()', 1000);                    
                }                 
            }); 
    });

    //Save item de la OT
    $("#btnAgegarCodigo").click(function(){

        var sUrl = 'util.orden.add.item.html';
            $.ajax({
                url:sUrl,                
                dataType: "json",
                data:$('#saveItemOT').serialize(),
                type: "POST",
                success: function(data)
                {
                    
                }                 
            }); 
            window.setTimeout('location.reload()', 1000);                    
    });

    //Delete Orden de Compra
    $("#btn-delete-oc").click(function(){

        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "html",
                data:$('#deleteOC').serialize(),
                type: "POST",
                success: function(data)
                {
                    if(data==1)
                    {
                        alert("Orden de Compra Eliminada");
                        window.setTimeout('location.reload()', 1000);
                    }
                    if(data==2)
                    {
                        alert("La Orden de Compra Esta Asociada a Una OT. No se Puede Eliminar");
                    }
                }                 
            });    
        //window.setTimeout('location.reload()', 1000);                        
    });


    $("a#EliminarOC").click(function(){
        var id_orden_compra = $(this).attr("name");
        $("#idOrdenCompraDelete").text(id_orden_compra);
        $("#idOC").val(id_orden_compra);
        

    });

    $("a#btn-agregarROC").click(function(){
        var idOrden = $(this).attr("name");
        $("#id_orden").val(idOrden);

    });

    $("a#AddOC").click(function(){
        var idOC1 = $(this).attr("class");
        
        $("#id_orden_compra1").val(idOC1);

    });


    $("#btnSaveOC").click(function(){        
        var sUrl = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                                
                data:$('#saveItemOC').serialize(),
                type: "POST",
                success: function(data)
                {
                    window.setTimeout('location.reload()', 1000);                    
                }                 
            }); 
    });


    
});
</script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Orden Add</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

    
    
</head>
<body>
<style>
#left{
  float: right;
  margin-right: 12px;
  margin-top:-50px;
  
}
.modal.large {
    width: 100%; /* respsonsive width */
    margin-left:-40%; /* width/2) */ 
}
.delete{
    border:1px solid black;
}

</style>

<!-- Detail Grids - START -->
<div class="container">
    <div class="row">
        <div class="col-lg-11 col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3> Orden / Detalle</h3>
                    <a href='util.orden.taller.html' id="left" class='btn btn-success'>Regresar</a>
                    <a href='util.orden.cerrar.html?id=<?php echo $orden[0]['id_orden']  ?>' class='btn btn-danger'>Cerrar Orden</a>                    
                </div>
                <div class="panel-body">
                    <div id="grid1">
                        <div class="container">

                            <div class="row">
                                
                                
                                <div class="col-xs-12 col-md-3 col-lg-3 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Detalle</div>
                                            <div class="panel-body">
                                            <table>
                                                <tr>
                                                    <td><strong>Nº Equipo - </strong></td>
                                                    <td> <?php echo $orden[0]['id_equipo']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nº Orden - </strong></td>
                                                    <td><?php echo $orden[0]['n_orden']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nº Placa - </strong></td>
                                                    <td><?php echo $orden[0]['Placa']; ?></td>
                                                </tr>
                                            </table>

                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-lg-4 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Detalle</div>
                                            <div class="panel-body">                      
                                                <strong>Cliente :</strong><br>
                       
                                                <?php
                                                
                                                foreach ($clientes as $value) {
                                                    if($value['idCliente'] == $orden[0]['id_cliente'])
                                                    {
                                                    ?>
                                                        <?php echo $value['nombreCliente'] ?>
                                                    <?php
                                                    }
                                                }                                                
                                                ?><br>
                                                <strong>Kilometraje :</strong>
                                                <?php echo $orden[0]['kilometraje']; ?>
                                                
                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-lg-3">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Fechas Detalles</div>
                                            <div class="panel-body">
                                                <strong>Fecha Ingreso : </strong><br>
                                                <?php echo $orden[0]['f_ingreso']; ?>
                                                <br>
                                                <strong>Fecha Salida :</strong>
                                                <br>
                                                <?php echo $orden[0]['f_salida']; ?>
                                                
                                                
                                            </div>
                                        </div>
                                </div>

                                
                            </div>

                        <?php
                        if($creada ==0)
                        {
                        ?>
                        <form action="util.orden.add.item.html" name="myForm" method="post" onsubmit="return validateForm()">
                            <div class="row ">
                                <div class="col-md-10">
                                    <div class="panel panel-default border">
                                        <div class="panel-heading">
                                            <h3 class="text-center">
                                            <strong>Orden de Trabajo # <?php echo $orden[0]['n_orden'] ?></strong>
                                            </h3>
                                            <a href='#' data-toggle="modal" data-target="#agregarItemOT" class='btn btn-default'>Agregar Item Orden Trabajo</a>
                                        </div>
                                        <div class="panel-body">
                                <div class="table-responsive">
                                <!-- Aqui estaba el form de Items -->
                                <table border=0 class="table table-condensed">
                                <tbody>
                                    <tr bgcolor="#A9A9A9">                                        
                                        <td class="text-left"><strong>Mecanico</strong></td>
                                        <td class="text-left"><strong>Cod</strong></td>
                                        <td class="text-left"><strong>Reparacion</strong></td>
                                        <td class="text-left"><strong>Descripcion</strong></td>
                                        <td class="text-left"><strong>O.C</strong></td>                                                                                
                                        <td class="text-left"><strong>Descuento</strong></td>
                                        <td class="text-left"><strong>Valor</strong></td>
                                        <td class="text-left"><strong></strong></td>
                                    </tr>
                                


                                <?php                                  
                                    $SubTotal = 0.00;                                    
                                    settype($SubTotal, 'double');                                    
                                    $a = 0.0;                                    
                                    settype($a, 'double');                                    
                                    $contador =1;                                    
                                    $otro;
                                    $abc = 0.00;
                                    settype($abc, 'double');  
                                    foreach ($detalle as $detalleOrden)
                                    { 
                                        $a = $detalleOrden['valor'];
                                        $Subtotal[$contador] =  $a; 
                                        $abc += $detalleOrden['valorInicial'];
                                        $dateI = date_create($detalleOrden['F_I']); 
                                        $dateF = date_create($detalleOrden['F_F']);         
                                    ?>
                                    
                                        <tr>                                           
                            <td><?php echo $detalleOrden['nombre_mecanico'] ?></td>
                            <td><?php echo $detalleOrden['idCodTrabajo'] ?></td>
                            <td class="text-left"><?php echo $detalleOrden['descripcion_reparacion'] ?></td>                                                        
                            <td class="text-left"><?php echo $detalleOrden['descripcionTrabajo'] ?></td>
                            <td class="text-left">
                                <?php 
                                    if($detalleOrden['N_OrdenCompra']!="")
                                    {
                                        echo $detalleOrden['N_OrdenCompra']; 
                                    }
                                    else{
                                        ?>
                                        <a href='#' data-toggle="modal" data-target="#agregarOC" name"" id="AddOC" class='<?php echo $detalleOrden['idOrdenTallerDetalle']; ?>'>Add</a>
                                        <?php
                                    }  
                                ?>
                            </td>                                                        
                            <td class="text-left">$<?php echo number_format($detalleOrden['valorInicial'],2) ?></td>
                            <td class="text-left">$<?php echo number_format($detalleOrden['valor'],2) ?></td>
                            <td class="text-left"><a href="util.delete.item.html?id=<?php echo $detalleOrden['idOrdenTallerDetalle'] ?>&orden=<?php echo $orden[0]['id_orden'] ?>">X</a></td>
                                        </tr>
                                    <?php
                                    $contador++;                                    
                                    }
                                ?>




                                    <tr>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>                                                                                
                                        <td class="highrow"></td>
                                        <td colspan="2" class="highrow text-left"><strong>Sub total</strong></td>
                                        
                                        
                                        
                                        <td class="highrow text-right">
                                            $<?php
                                            if(isset($Subtotal))
                                            {
                                            $cont=1;
                                            $total = 0.0;

                                            foreach ($Subtotal as $value) {

                                                $total += (double)$value;
                                                $cont++;
                                            }
                                            echo number_format($total,2);                                           
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>                                        
                                        <td class="highrow"></td>
                                        
                                        <td colspan="1" class="highrow text-left"><strong>Descuento</strong></td>
                                        
                                        <td class="highrow text-left">
                                            $<?php                                          
                                            echo number_format($abc,2);                                          
                                            
                                            ?>
                                        </td>
                                        <td class="highrow"> - </td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>                                        

                                        <td class="emptyrow text-left"><strong>Total</strong></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-right">
                                        $<?php
                                            if(isset($Subtotal))
                                            {
                                            $cont=1;
                                            $total = 0.0;
                                            foreach ($Subtotal as $value) {

                                                $total += (double)$value;
                                                $cont++;
                                            }
                                            echo number_format($total-$abc,2); 
                                            }
                                            ?>
                                        </td>
                                    </tr>                                                                          
                                </tbody>
                                </table>
                                </div>
                                </div>

                                </div>

                                </div>
                                <div class="container">
                                    <div class="row">        
                                        <div class="col-md-10">
                                            <div class="panel panel-default border">
                                                <div class="panel-heading">
                                                    <h3 class="text-center">
                                                        <strong>Ordenes de Compras</strong>
                                                    </h3>
                                                    <a href='#' data-toggle="modal" data-target="#agregarOrdenCompra" class='btn btn-default'>Agregar Orden Compra</a>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table border=0 class="table table-condensed">
                                                        <tbody>
                                                            <?php
                                            $contador=1;
                                            foreach ($OC as $OrdenCompra) 
                                            {                                           
                                            ?>
                                                <tr bgcolor='#f09f47'>
                                                    <td class="emptyrow" colspan='1'>
                                                        <a href="#" data-toggle="modal" data-target="#agregarItemOC" name="<?php echo $OrdenCompra['idOrdenCompra']  ?>" id="btn-agregarROC" class="btn btn-default">Agregar Item</a>
                                                    </td>
                                                    <td class="emptyrow" colspan='3'>
                                                        <h4>
                                                        <?php
                                                        echo "Orden de Compra # ". $OrdenCompra['numeroOrdenCompra'];
                                                        ?>
                                                        </h4>
                                                    </td>
                                                    <td class="emptyrow" colspan='2'>P: <?php echo $OrdenCompra['nombreCliente'] ?></td>
                                                    <td class="emptyrow text-right" colspan='1'>
                                                        <a href="#" id="EliminarOC" data-toggle="modal" name="<?php echo $OrdenCompra['numeroOrdenCompra']; ?>" data-target="#EliminarOrdenCompra" class="btn btn-danger delete">Eliminar</a>
                                                    </td>
                                                </tr> 
                                                <tr bgcolor="#DCDCDC">                                        
                                                    <td class="text-left"></strong></td>
                                                    <td class="text-left"><strong>Fecha Compra</strong></td>                                                    
                                                    <td class="text-left" colspan='1'><strong>Producto</strong></td>
                                                    <td class="text-right"><strong>Precio Unidad</strong></td>
                                                    <td class="text-right"><strong>Cantidad</strong></td>  

                                                    <td class="text-right" colspan='2'><strong>Total</strong></td>
                                                    
                                                </tr>  
                                                <?php
                                                $getItems = $NewOrdenTaller->getItems($OrdenCompra['idOrdenCompra']);
                                                $totalItems=0;
                                                $totalMonto=0;
                                                foreach ($getItems as $item) 
                                                {
                                                    $totalItems+=$item['cantidadRepuesto'];
                                                    $totalMonto+=$item['precioUnidad']*$item['cantidadRepuesto'];
                                                ?>                                      
                                                <tr>
                                                    <td class="emptyrow" colspan='1'></td>
                                                    <td class="emptyrow" colspan='1'><?php echo $item['fechaItemOrdenCompra']; ?></td>                                                    
                                                    <td class="emptyrow" colspan=''><?php echo $item['nombreRespuesto']; ?></td>
                                                    <td class="emptyrow text-right" colspan='1'>$ <?php echo number_format($item['precioUnidad'],2); ?></td>
                                                    <td class="emptyrow text-right" colspan='1'><?php echo $item['cantidadRepuesto']; ?></td>
                                                    <td class="emptyrow text-right" colspan='2'>$ <?php echo number_format($item['precioUnidad']*$item['cantidadRepuesto'],2);?></td>
                                                    <td class="emptyrow" colspan='1'><a href="util.delete.item.html?id1=<?php echo $orden[0]['id_orden']  ?>&&id2=<?php echo $item['idItemOrdenCompra'] ?>">X</a></td>                                                    
                                                </tr>
                                                <?php                                            
                                                }
                                                ?>
                                                <tr bgcolor="">                                        
                                                    <td class="highrow emptyrow text-left" colspan='3'></strong></td> 
                                                                                              
                                                    <td class="highrow text-right"><strong>Sub Total</strong></td>                                                 
                                                    <td class="highrow text-right"><strong><?php //echo $totalItems; ?></strong></td>
                                                    <td class="highrow text-right" colspan='2'><strong>$ <?php echo number_format($totalMonto,2); ?></strong></td>
                                                     
                                                </tr>
                                                <tr bgcolor="">                                        
                                                    <td class="text-left" colspan='3'></strong></td> 
                                                                                              
                                                    <td class="text-right"><strong>IVA 13%</strong></td>                                                 
                                                    <td class="text-right"><strong><?php //echo $totalItems; ?></strong></td>
                                                    <td class="text-right" colspan='2'><strong>$ <?php $val_iva = ($totalMonto*0.13); echo(number_format($val_iva,2)); ?></strong></td>
                                                     
                                                </tr>
                                                <tr bgcolor="">                                        
                                                    <td class="text-left" colspan='3'></strong></td> 
                                                                                              
                                                    <td class="text-right"><strong>Total</strong></td>                                                 
                                                    <td class="text-right"><strong><?php echo $totalItems; ?></strong></td>
                                                    <td class="text-right" colspan='2'><strong>$ <?php echo number_format($totalMonto+$val_iva,2); ?></strong></td>
                                                     
                                                </tr>
                                                <?php
                                                $$totalItems=0;
                                                $totalMonto=0;
                                            }
                                            ?>
                                                        </tbody>
                                                        </table>              
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.abc{
    width: 400px;

}

</style>

<!-- BEGIN MODALS -->
          <div class="modal fade" id="agregarOrdenCompra" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              <form action="" method="post" id="saveOC">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>CREAR</strong>  Orden Compra</h4>
                </div>
                <div class="modal-body abc">
                    <div class="row tab">                        
                        <br>
                        <br>
                        <div class="col-md-6 titulos">
                        <span>Orden Taller</span>                           
                        </div>
                        <div class="col-md-6">                            
                            <input type="text" value="<?php echo $orden[0]['id_orden']  ?>" id="numero_orden_taller" readonly name="numero_orden_taller">
                        </div>
                    </div>
                    <div class="row tab">                        
                        <div class="col-md-6 titulos">
                        <span>Numero Orden  de Compra</span>                           
                        </div>
                        <div class="col-md-6">                            
                            <input type="text" required="yes" value="" id="numero_orden" name="numero_orden">
                        </div>
                    </div>  
                    <div class="row tab">                        
                        <div class="col-md-6 titulos">                           
                        <span>Nombre Supervisor</span>
                        </div>
                        <div class="col-md-6">                            
                            <select name="cliente" id="cliente">
                                <?php
                                foreach ($usuarios as $usuario)
                                {                             
                                ?>
                                    <option value="<?php echo $usuario['codigo_usuario']; ?>">
                                        <?php echo $usuario['nombre']; ?>              
                                    </option>
                                <?php       
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row tab">                        
                        <div class="col-md-6 titulos">                           
                        <span>Proveedor Taller</span>
                        </div>
                        <div class="col-md-6">                            
                            <select name="proveedor" id="proveedor">
                                <?php
                                foreach ($proveedor as $proveedores)
                                {                             
                                ?>
                                    <option value="<?php echo $proveedores['idCliente']; ?>">
                                        <?php echo $proveedores['nombreLegal']; ?>              
                                    </option>
                                <?php       
                                }
                                ?>
                            </select>
                        </div>
                    </div>          
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-embossed" id='btbOC' data-dismiss="modal">Guardar Orden</button>
                </div>
                </form>                
              </div>                
            </div>
</div>
<!-- END MODALS -->


<!-- BEGIN MODALS -->
          <div class="modal fade" id="agregarItemOC" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              <form action="" method="post" id="saveRepuestoOC">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Agregar</strong>  Respuestos a la Orden de Compra</h4>
                </div>
                <div class="modal-body">
                    <div class="row tab">                        
                        <br>
                        <br>
                        <div class="col-md-1 titulos"></div>
                        <div class="col-md-4 titulos">
                        <span>Nombre Respuesto</span>                           
                        </div>
                        <div class="col-md-7">                            
                            <input type="text" value="" id="nombre_repusto" name="nombre_repusto">
                        </div>
                    </div>
                    <div class="row tab">          
                        <div class="col-md-1 titulos"></div>              
                        <div class="col-md-4 titulos">
                        <span>Precio Unidad</span>                           
                        </div>
                        <div class="col-md-7">                            
                            <input type="text" value="" id="precio_unidad" name="precio_unidad">
                        </div>
                    </div>
                    <div class="row tab">          
                        <div class="col-md-1 titulos"></div>              
                        <div class="col-md-4 titulos">
                        <span>Cantidad</span>                           
                        </div>
                        <div class="col-md-7">                            
                            <input type="text" value="" id="cantidad_repusto" name="cantidad_repusto">
                        </div>
                    </div> 
                    
                        
                            <input type="hidden" readonly="yes" value="" id="id_orden" name="id_orden">
                               
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-embossed" id='btnROC' data-dismiss="modal">Guardar Orden</button>
                </div>
                </form>                
              </div>                
            </div>
</div>
<!-- END MODALS -->


<!-- BEGIN MODALS -->
          <div class="modal fade" id="agregarItemOT" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog unoDemo">
              <div class="modal-content">
              <form action="" method="post" id="saveItemOT">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Agregar</strong>  Reparacion a la O.T.</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-condensed">
                                <tbody>
                                <tr>
                                    <td class="text-left"><strong>Nombre Mecanico</strong></td>
                                    <td class="text-left">
                                        <input type="hidden" name="idOrdenTaller" value="<?php echo $orden[0]['id_orden']  ?>">
                                        <select name="mecanico">
                                        <?php
                                        foreach ($mecanico as $value) {
                                            ?>
                                            <option value="<?php echo $value['id_mecanico'] ?>"><?php echo $value['nombre_mecanico'] ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </td>                                    
                                </tr>

                                <tr>
                                    <td class="text-left"><strong>Codigo de Trabajo</strong></td>
                                    <td class="text-left">
                                        <select name="codReparacion" id="cod_reparacion">
                                        <?php
                                        foreach ($codReparacion as $value) {
                                            ?>
        <option value="<?php echo $value['costo_reparacion'] ?>"><?php echo $value['cod_reparacion'] ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                        
                                        <input type="text"  name="CodigoBuscar" value="" id="CodigoBuscar">
                                        <a href="#" class="btn btn-default" id="buscarCode">Busar</a>
                                    </td>
                                </tr>


                                <tr>
                                    <td class="text-left"><strong>Detalle Reparacion</strong></td>
                                    <td class="text-left">
                                        <span name="descripcion_reparacion" id="descripcion_reparacion"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-left"><strong>Costo Reparacion</strong></td>
                                    <td class="text-left">
                                       <span name="costo" id="costo"></span>
                                       <input type="hidden" name="codigo" id="codigo">
                                       <input type="hidden" name="valorNew" id="valorNew">
                                    </td>
                                </tr>
                                
                                <tr>
                                    
                                    <td class="text-left"><strong>Descuento</strong></td>
                                    <td class="text-left">                                       
                                       <input type="text" value="" class="credenciales" name="descuento" id="descuento">
                                        <input type="hidden" value="<?php echo $log_user; ?>" name="log_user" id="log_user">
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="text-left"><strong>Supervisor</strong></td>
                                    <td class="text-left">
                                        <input type="password" value="" class="credenciales" name="supervisor" id="supervisor">
                                        <a href="#" id="btn-validar"  class="credenciales">Validar Acceso</a>        
                                    </td>
                                </tr>
                                

                                <tr>
                                    <td class="text-left"><strong>Descripcion</strong></td>
                                    <td class="text-left">
                                        <textarea name="descripcion" rows="2" cols="50"></textarea>                                      
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><strong>Orden Compra</strong></td>
                                    <td class="text-left">
                                        <input type="text" value="" name="NordenCompra" >
                                    </td>
                                </tr>

                                

                                <tr>                                    
                                    <td class="text-left"></td>                               
                                    <td class="text-left">                                        
                                        <a href="#" id="btn_descuento" class="btn btn-success">Aplicar Descuento</a>
                                    </td>                               
                                </tr>
                                <tr>
                                    <td class="text-left" colspan="">
                                        <span><b>Fecha Hora Inicio</b></span><br>
                                        <input type="date" name="fecha_i" value="<?php echo date("Y-m-d"); ?>">
                                        <input type="time" name="hora_i" value="<?php echo date("h:i"); ?>">
                                        
                                    </td>

                                    <td class="text-left">
                                        <span><b>Fecha Hora Fin</b></span><br>
                                        <input type="date" name="fecha_f" value="<?php echo date("Y-m-d"); ?>">
                                        <input type="time" name="hora_f" value="<?php echo date("h:i"); ?>">
                                    </td>
                                </tr>

                                </tbody>
                                </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-embossed" id='btnAgegarCodigo' data-dismiss="modal">Guardar Item</button>
                </div>
                </form>                
              </div>                
            </div>
</div>
<!-- END MODALS -->


<!-- BEGIN MODALS -->
          <div class="modal fade" id="EliminarOrdenCompra" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              <form action="" method="post" id="deleteOC">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Eliminar</strong>  Orden Compra</h4>
                </div>
                <div class="modal-body">
                    <div class="row tab">                        
                       <h3 class="text-center">Desea Eliminar la Orden de Compra # <span id="idOrdenCompraDelete"></span>
                       </h3>    
                       <input type="hidden" value="" name="idOC" id="idOC">
                    </div>             
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-embossed" id='btn-delete-oc' data-dismiss="modal">Eliminar Orden</button>
                </div>
                </form>                
              </div>                
            </div>
</div>
<!-- END MODALS -->


<style>
.ot{
    width: 500px;
}
.unoDemo{
    width: 80%;
}
.sui-cell {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
</style>
<style>
.height {
    min-height: 150px;
    border:1px solid grey;
}
.border{
    border:1px solid grey;   
}
.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>



</body>
</html>

<script>
$(document).ready(function() {
      
});
</script>

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src="bootstrap/js/bootstrap.js"></script>


<!-- BEGIN MODALS -->
          <div class="modal fade" id="agregarOC" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              <form action="" method="post" id="saveItemOC">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Agregar</strong> Número Orden Compra...</h4>
                </div>
                <div class="modal-body">
                    <div class="row tab">                        
                        <br>
                        <br>
                        <div class="col-md-1 titulos"></div>
                        <div class="col-md-4 titulos">
                        <span></span>                           
                        </div>
                        <div class="col-md-7">                            
                            <input type="hidden" value="" id="id_orden_compra1" name="id_orden_compra1">
                        </div>
                    </div>
                    <div class="row tab">          
                        <div class="col-md-1 titulos"></div>              
                        <div class="col-md-4 titulos">
                        <span># Orden de Compra</span>                           
                        </div>
                        <div class="col-md-7">                            
                            <input type="text" value="" id="valor_orden_compra1" name="orden_compra">
                        </div>
                    </div>

                    
                        
                            <input type="hidden" readonly="yes" value="" id="id_orden" name="id_orden">
                               
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-embossed" id='btnSaveOC' data-dismiss="modal">Guardar</button>
                </div>
                </form>                
              </div>                
            </div>
</div>
<!-- END MODALS -->