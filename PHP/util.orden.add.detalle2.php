<?php
require_once 'db/taller.php';
require_once 'db/tallerDetalle.php';
$id =  1;

$NewOrdenTaller = new TallerDetalle();
$OrdenTaller    = new Taller();
$clientes       = $NewOrdenTaller->selectAllAgencias();
$inventario     = $NewOrdenTaller->selectAllInvCatalogo();
$mecanico       = $NewOrdenTaller->selectAllMecanico();
$codReparacion  = $NewOrdenTaller->selectAllCodReparacion();
$inventario     = $NewOrdenTaller->selectAllInventario();
$OC             = $NewOrdenTaller->OC($_GET['id']);
$data           = $OrdenTaller->selectId($_GET['id']);
$detalle        = $NewOrdenTaller->selectAllId($_GET['id']);
$orden          = $OrdenTaller->selectOneOrdenById($_GET['id']);
$log_user       = $_SESSION['cache_datos_nombre_completo']['clave'];
$creada = 0;
//var_dump($orden);
//var_dump($detalle);

 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>

<script src="JS/jquery-1.10.2.min.js"></script>
<script>
$(document).ready(function() 
{   
	
jQuery.noConflict();
    //Abrir Orden de Trabajo
    $("#btn-abrir-ot").click(function(){
        var idOT        = $("#idOT").val();
        var pass_user   = $("#log_user").val(); 
        var pass_super  = $("#pass_supervisor").val();
        var data        ={idOT:idOT,loguer:pass_user,supervisor:pass_super};
        var sUrl        = 'PHP/db/data.php';
            $.ajax({
                url:sUrl,                
                dataType: "html",
                data:data,
                type: "POST",
                success: function(data)
                {       
                	alert(data)                ;
                    if(data==1)
                    {
                        window.location.href = 'util.orden.add.detalle.html?id='+idOT;    
                    } 
                    if(data==2){
                        alert("Password Incorrecto: :(");
                    }
                    if(data==3){
                        alert("Password Incorrecto: :(");
                    }
                },
                error:function(){ 
                    alert("Error de Consulta");                
                }
            });    
            //
        //window.setTimeout('util.orden.add.detalle.html?id='+idOT, 1000);                        
    });
});
</script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Orden Add</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    
    

</head>
<body>
<style>
#left{
  float: right;
  margin-right: 12px;
  margin-top:-50px;
  
}
</style>


<!-- Detail Grids - START -->
<div class="container">
    <div class="row">
        <div class="col-lg-11 col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Catalogo / Orden / Detalle</h3>
                    <a href='util.orden.taller.html' id="" class='btn btn-default'>Regresar</a>
                    <a href='#' data-toggle="modal" data-target="#abrirOT" class='btn btn-danger'>Reabrir</a>
                </div>
                <div class="panel-body">
                    <div id="grid1">
                        <div class="container">

                            <div class="row">
                                
                                
                                <div class="col-xs-12 col-md-3 col-lg-3 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Camion Detalle</div>
                                            <div class="panel-body">
                                                <strong>Nº Equipo : </strong>
                                                <?php echo $orden[0]['id_equipo']; ?><br>           
                                                <strong>Nº Orden : </strong>
                                                <?php echo $orden[0]['n_orden']; ?><br>
                                                <strong>Placa : </strong>
                                                <?php echo $orden[0]['Placa']; ?>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-lg-4 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Camion Detalle</div>
                                            <div class="panel-body">                      
                                                <strong>Cliente :</strong><br>
                                                <?php echo $orden[0]['nombreCliente']; ?>

                                                <br>
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
                        <form action="util.orden.add.item.html" method="post">
                            <div class="row ">
                                <div class="col-md-10">
                                    <div class="panel panel-default border">
                                        <div class="panel-heading">
                                            <h3 class="text-center">
                                            <strong>Orden de Trabajo # <?php echo $orden[0]['n_orden'] ?></strong></h3>
                                        </div>
                                        <div class="panel-body">
                                <div class="table-responsive">
                                 <table class="table table-condensed">
                                
                                <thead>
                                    <tr bgcolor="#A9A9A9">                                        
                                        <td class="text-left"><strong>Mecanico</strong></td>
                                        <td class="text-left"><strong>COD</strong></td>
                                        <td class="text-left"><strong>Reparacion</strong></td>
                                        <td class="text-left"><strong>Descripcion</strong></td>
                                        <td class="text-left"><strong>OC</strong></td>
                                        <td class="text-left"><strong>Descu</strong></td>
                                        <td width="10%" class="text-left"><strong>Valor</strong></td>
                                    </tr>
                                </thead>
                                <tbody>

                                

                                

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
                            <td class="text-left"><?php echo $detalleOrden['N_OrdenCompra'] ?></td>
                            <td class="text-left">$<?php echo number_format($detalleOrden['valorInicial'],2) ?></td>
                            <td class="text-left">$ <?php echo number_format($detalleOrden['valor'],2) ?></td>
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
                                        <td class="highrow text-left"><strong>Sub total</strong></td>
                                         <td class="highrow"></td>
                                        <td class="highrow text-left">
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
                                        <td class=""></td>
                                        <td class=""></td>
                                        <td class=""></td>
                                        <td class=""></td>
                                        
                                        
                                        <td colspan="1" class="text-left"><strong>Descuento</strong></td>
                                        
                                        <td class=" text-left">
                                            $<?php                                          
                                            echo number_format($abc,2);                                          
                                            
                                            ?>
                                        </td>
                                        <td class=""> - </td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        
                                        
                                        <td class="emptyrow text-left"><strong>Total</strong></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-left">
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
                                                <tr bgcolor='#A9A9A9'>
                                                    <td class="emptyrow" colspan='1'>
                                                        
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
                                                        
                                                    </td>
                                                </tr> 
                                                <tr bgcolor="#DCDCDC">                                        
                                                    <td class="text-left"></strong></td>
                                                    <td class="text-left"><strong>Fecha Compra</strong></td>
                                                    
                                                    <td class="text-left" colspan='2'><strong>Producto</strong></td>
                                                    <td class="text-right"><strong>Precio Unidad</strong></td>
                                                    <td class="text-right"><strong>Cantidad</strong></td>                                                    
                                                    <td class="text-right"><strong>Total</strong></td>
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
                                                    <td class="emptyrow" colspan='2'><?php echo $item['nombreRespuesto']; ?></td>
                                                    <td class="emptyrow text-right" colspan='1'>$ <?php echo $item['precioUnidad']; ?></td>
                                                    <td class="emptyrow text-right" colspan='1'><?php echo $item['cantidadRepuesto']; ?></td>
                                                    <td class="emptyrow text-right" colspan='1'>$ <?php echo number_format($item['precioUnidad']*$item['cantidadRepuesto'],2);?></td>
                                                                                                     
                                                </tr>
                                                <?php                                            
                                                }
                                                ?>
                                                <tr bgcolor="">                                        
                                                    <td class="highrow text-left" colspan='4'></strong></td>                                                                                                      
                                                    <td class="highrow text-right"><strong>Sub Totales</strong></td>                                                 
                                                    <td class="highrow text-right"><strong><?php //echo $totalItems; ?></strong></td>
                                                    <td class="highrow text-right" colspan='1'><strong>$ <?php echo number_format($totalMonto,2); ?></strong></td>
                                                     
                                                </tr>
                                                <tr bgcolor="">                                        
                                                    <td class="text-left" colspan='4'></strong></td> 
                                                                                              
                                                    <td class="text-right"><strong>IVA 13%</strong></td>                                                 
                                                    <td class="text-right"><strong><?php //echo $totalItems; ?></strong></td>
                                                    <td class="text-right" colspan='1'><strong>$ <?php $val_iva = ($totalMonto*0.13); echo(number_format($val_iva,2)); ?></strong></td>
                                                     
                                                </tr>
                                                <tr bgcolor="">                                        
                                                    <td class="text-left" colspan='4'></strong></td> 
                                                                                              
                                                    <td class="text-right"><strong>Total</strong></td>                                                 
                                                    <td class="text-right"><strong><?php echo $totalItems; ?></strong></td>
                                                    <td class="text-right" colspan='1'><strong>$ <?php echo number_format($totalMonto+$val_iva,2); ?></strong></td>
                                                     
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

<!-- BEGIN MODALS -->
          <div class="modal fade" id="abrirOT" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              <form action="" method="post" id="deleteOC">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Abrir</strong>  Orden de Trabajo ?</h4>
                </div>
                <div class="modal-body">
                    <div class="row tab">                        
                       <h3 class="text-center">Desea Reabrir la Orden de Trabajo
                       </h3> 
                       <div class="text-center">
                            Password Supervisor : <input type="password" id="pass_supervisor" name="pass_supervisor">
                       </div>    
                       <input type="hidden" value="<?php echo $_GET['id'] ?>" name="idOT" id="idOT">                      
                       <input type="hidden" value="<?php echo $log_user; ?>" name="log_user" id="log_user">
                    </div>             
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary btn-embossed" id='btn-abrir-ot' data-dismiss="modal">Reabrir</button>
                </div>
                </form>                
              </div>                
            </div>
</div>
<!-- END MODALS -->


    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script src="bootstrap/js/bootstrap.js"></script>
  
