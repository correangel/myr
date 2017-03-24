<?php
require_once 'db/taller.php';
require_once 'db/tallerDetalle.php';
$id =  $_GET['ID'];
$OrdenTaller = new Taller();
$OrdenTallerDetalle = new TallerDetalle();
//$persona->guardar();
$data = $OrdenTaller->selectId($id);
$detalle = $OrdenTallerDetalle->selectAllId($id);
//var_dump($detalle);




 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Orden Detalle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
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
                    <a href='util.orden.taller.html' id="left" class='btn btn-success'>Regresar</a>
                </div>
                <div class="panel-body">
                    <div id="grid1">
                        <div class="container">

                            <div class="row">
                                <div class="col-xs-12 col-md-2 col-lg-2 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Camion Detalle</div>
                                            <div class="panel-body">
                                                <strong>Nº De Equipo : </strong>
                                                <?php echo $data['id_equipo'] ?><br>           
                                                <strong>Placa : </strong>
                                                <?php echo $data['Placa'] ?>   
                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-lg-2 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Camion Detalle</div>
                                            <div class="panel-body">                      
                                                <strong>Cliente :</strong>
                                                <?php echo $data['id_cliente'] ?><br>
                                                <strong>Kilometraje :</strong>
                                                <?php echo $data['kilometraje'] ?>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-lg-2">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Fechas Detalles</div>
                                            <div class="panel-body">
                                                <strong>Fecha Ingreso : </strong>
                                                <?php $date = date_create($data['f_ingreso']); ?>
                                                <?php echo date_format($date, 'Y-m-d'); ?><br>           
                                                <strong>Hora Ingreso : </strong>
                                                <?php echo date_format($date, 'H:i:s'); ?>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-lg-2">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Fechas Detalles</div>
                                            <div class="panel-body">

                                                <strong>Fecha Salida :</strong>
                                                 <?php $salida = date_create($data['f_salida']); ?>
                                                <?php echo date_format($salida, 'Y-m-d'); ?><br>
                                                
                                                <strong>Hora Salida : </strong>
                                                <?php echo date_format($salida, 'H:i:s'); ?><br>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-10">
                                    <div class="panel panel-default border">
                                        <div class="panel-heading">
                                            <h3 class="text-center">
                                            <strong>Orden de Trabajo de Taller #<?php echo $data['n_orden'] ?></strong></h3>
                                        </div>
                                        <div class="panel-body">
                                <div class="table-responsive">
                                 <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>F.I</strong></td>
                                        <td class="text-right"><strong>H.I</strong></td>
                                        <td class="text-right"><strong>Mecanico</strong></td>
                                        <td class="text-right"><strong>Cod.T</strong></td>
                                        <td class="text-right"><strong>Desc.</strong></td>
                                        <td class="text-right"><strong>F.F</strong></td>
                                        <td class="text-right"><strong>H.F</strong></td>
                                        <td class="text-right"><strong>#Orden C</strong></td>
                                        <td class="text-right"><strong>#CCF</strong></td>
                                        <td class="text-right"><strong>Prov</strong></td>
                                        <td class="text-right"><strong>Valor$</strong></td>
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
                                    foreach ($detalle as $detalleOrden)
                                    { 
                                        $a = $detalleOrden['valor'];
                                        $Subtotal[$contador] =  $a;   
                                            
                                        $dateI = date_create($detalleOrden['F_I']); 
                                        $dateF = date_create($detalleOrden['F_F']);         
                                    ?>
                                        <tr>
                                            <td><?php echo date_format($dateI, 'Y-m-d') ?></td>
                                            <td><?php echo date_format($dateI, 'H:i:s') ?></td>
                                            <td><?php echo $detalleOrden['nombre_mecanico'] ?></td>
                            <td class="text-right"><?php echo $detalleOrden['idCodTrabajo'] ?></td>
                            <td class="text-right"><?php echo $detalleOrden['descripcionTrabajo'] ?></td>
                                            
                            <td class="text-right"><?php echo date_format($dateF, 'Y-m-d') ?></td>
                            <td class="text-right"><?php echo date_format($dateF, 'H:i:s') ?></td>
                            <td class="text-right"><?php echo $detalleOrden['N_OrdenCompra'] ?></td>
                            <td class="text-right"><?php echo $detalleOrden['N_CCF'] ?></td>
                            <td class="text-right"><?php echo $detalleOrden['Proveedor'] ?></td>
                            <td class="text-right"><?php echo $detalleOrden['valor'] ?></td>
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
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow text-center"><strong>Sub total</strong></td>
                                        <td class="highrow text-right">
                                            $<?php
                                            $cont=1;
                                            $total = 0.0;
                                            foreach ($Subtotal as $value) {

                                                $total += (double)$value;
                                                $cont++;
                                            }
                                            echo $total; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"><i class="fa fa-barcode iconbig"></i></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        
                                        <td class="emptyrow text-center"><strong>Total</strong></td>
                                        <td class="emptyrow text-right">
                                        $<?php
                                            $cont=1;
                                            $total = 0.0;
                                            foreach ($Subtotal as $value) {
                                                $total += (double)$value;
                                                $cont++;
                                            }
                                            echo $total; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    
                                    //echo gettype($Subtotal);
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