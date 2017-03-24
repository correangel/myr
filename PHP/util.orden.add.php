<?php
require_once 'db/taller.php';
require_once 'db/tallerDetalle.php';
$id =  1;



$NewOrdenTaller = new TallerDetalle();
$clientes       = $NewOrdenTaller->selectAllAgencias();
$inventario     = $NewOrdenTaller->selectAllInvCatalogo();
$mecanico       = $NewOrdenTaller->selectAllMecanico();
$codReparacion  = $NewOrdenTaller->selectAllCodReparacion();
$inventario     = $NewOrdenTaller->selectAllInventario();
if(isset($_GET['ID'])){
    $id_orden = $_GET['ID'];
}else
{
    $id_orden=0;
}
$orden          = $NewOrdenTaller->selectOrden($id_orden);
//var_dump($orden);
if($orden){
    $contenedor =  $orden[0]['codigo_contenedor'];
    $agencia = $orden[0]['codigo_agencia'];
}else
{
    $contenedor = "";
}

if(isset($_GET['id']))
{
    $creada = $_GET['id'];    
}
else
{
    $creada = 0;
}

 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Orden Add</title>
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
                    <h3>Catalogo / Orden / Nueva</h3>
                    <a href='util.orden.taller.html' id="left" class='btn btn-success'>Regresar</a>
                </div>
                <div class="panel-body">
                    <div id="grid1">
                        <div class="container">

                            <div class="row">
                                <form action="util.orden.insert.html" method="post">
                                <input type="hidden" value="<?php echo $id_orden;  ?>" name="orden">
                                <div class="col-xs-12 col-md-3 col-lg-3 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Camion Detalle</div>
                                            <div class="panel-body">
                                                <table>
                                                    <tr>
                                                        <td><strong>Nº Equipo</strong></td>
                                                        <td><input type="text" name="equipo" value="<?php echo $contenedor  ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nº Orden</strong></td>
                                                        <td><input type="text" name="orden" value=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Placa</strong></td>
                                                        <td><input type="text" name="placa"> </td>
                                                    </tr>
                                                </table>                                                
                                                
                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-lg-3 pull-left">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Camion Detalle</div>
                                            <div class="panel-body">                      
                                                <strong>Cliente :</strong><br>
                                                <select name="cliente">
                                                <?php
                                                foreach ($clientes as $value) {
                                                    if($value['idCliente'] == $orden[0]['codigo_agencia'])
                                                    {
                                                    ?>
                                                        <option value="<?php echo $value['idCliente'] ?>"><?php echo $value['nombreCliente'] ?></option>
                                                    <?php
                                                    }
                                                }


                                                foreach ($clientes as $value) {
                                                    if($value['idCliente'] != $orden[0]['codigo_agencia'])
                                                    {
                                                    ?>
                                                    <option value="<?php echo $value['idCliente'] ?>"><?php echo $value['nombreCliente'] ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?></select><br>
                                                <strong>Kilometraje :</strong><br>
                                                <input type="text" name="kilometraje">
                                                
                                            </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-lg-4">
                                    <div class="panel panel-default height">
                                        <div class="panel-heading">Fechas Detalles</div>
                                            <div class="panel-body">
                                            <table>
                                                <tr>
                                                    <td><strong>Fecha Ingreso : </strong></td>
                                                    <td><input type="date" value="<?php echo date("Y-m-d") ?>" name="fechaI"></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Fecha Salida :</strong></td>
                                                    <td><input type="date" value="<?php echo date("Y-m-d") ?>" name="fechaF"></td>
                                                </tr>
                                            </table>                                                
                                                
                                            </div>
                                        </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-md-10 col-lg-10 text-right">
                                    <input type="submit" value="Guardar" class="btn btn-primary">
                                </div>
                            </div>

                            
                            </form><!-- Fin Form -->
                        <?php
                        if($creada ==1)
                        {
                        ?>
                            <div class="row ">
                                <div class="col-md-10">
                                    <div class="panel panel-default border">
                                        <div class="panel-heading">
                                            <h3 class="text-center">
                                            <strong>Nueva Orden de Trabajo </strong></h3>
                                        </div>
                                        <div class="panel-body">
                                <div class="table-responsive">
                                 <table class="table table-condensed">
                                <thead>
                                    <tr>                                        
                                        <td class="text-left"><strong>Mecanico</strong></td>
                                        <td class="text-right"><strong>Cod.T</strong></td>
                                        <td class="text-right"><strong>Desc.</strong></td>                                      
                                        <td class="text-right"><strong>#CCF</strong></td>
                                        <td class="text-right"><strong>Prov</strong></td>
                                        <td class="text-right"><strong>Valor$</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <tr>                                    
                                    <td class="text-left">
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
                                    <td class="text-right">
                                    <select name="codReparacion">
                                        <?php
                                        foreach ($codReparacion as $value) {
                                            ?>
                                            <option value="<?php echo $value['id_codigo'] ?>"><?php echo $value['cod_reparacion'] ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </td>
                                    <td class="text-right">
                                        <input type="text" name="descripcion">
                                    </td>
                                                
                                
                                <td class="text-right">
                                    <select name="producto">
                                            <?php
                                            foreach ($inventario as $value) {
                                                ?>
                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] ?></option>
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </td>
                            
                                <td class="text-right">
                                    <select name="proveedor">
                                            <?php
                                            foreach ($inventario as $value) {
                                                ?>
                                                <option value="<?php echo $value['proveedor'] ?>"><?php echo $value['proveedor'] ?></option>
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </td>
                                <td class="text-right">
                                    <input type="submit" class='btn btn-success' value="Agregar">
                                </td>

                                </tr>
                                    <tr>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow text-center"><strong>Sub total</strong></td>
                                        <td class="highrow text-right">
                                            $
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"><i class="fa fa-barcode iconbig"></i></td>
                                        
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        
                                        
                                        <td class="emptyrow"></td>
                                        
                                        <td class="emptyrow text-center"><strong>Total</strong></td>
                                        <td class="emptyrow text-right">
                                        $
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                                </div>
                                </div>
                                </div>
                                </div>
                            </div>
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