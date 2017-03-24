<?php
 require_once 'db/mecanico.php';
 $id =  $_GET['ID'];
 $proveedor = new Personaje('Rafael', 'Electrico');
 //$persona->guardar();
if(isset($_POST['nombreCorto']))
{
    $count = $proveedor->updateProveedor($_POST);
    $path = "util.orden.proveedor.html";
    header('Location: '.$path);
}
$count = $proveedor->getProveedor($id);

 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Detail Grids Template | PrepBootstrap</title>
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
  
}
</style>


<!-- Detail Grids - START -->
<div class="container">
    <div class="row">
        <div class="col-lg-11 col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Catalogo / Mecanicos / Actualizar</h3>
                </div>
                <div class="panel-body">
                <a href='util.orden.proveedor.html' id="left" class='btn btn-default'>Regresar</a>
                <br><br>
                    <div id="grid1">

                     <div class="container">
                            <form action="" method="post">
                                <table border="0" width="100%">
                                    <div class="row">
                                    <tr>                                        
                                        <div class="col-lg-1 col-md-5">             
                                            <td class="text-right">Nombre Corto </td>
                                            <td><input type="text" size="50px" name="nombreCorto" value="<?php echo $count[0]['nombreCliente']; ?>"></td>
                                            <input type="hidden" size="50px" name="idProveedor" value="<?php echo $count[0]['idCliente']; ?>">
                                        </div>                                         
                                    </tr>
                                    </div>                                     
                                    
                                    <div class="row">
                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Nombre Legal </td>
                                        <td><input type="text" size="50px" name="nombreLegal" value="<?php echo $count[0]['nombreLegal']; ?>"></td>
                                    </div>
                                    </tr>
                                    </div>
                                    
                                   <div class="row">
                                   <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Consumidor Final </td>
                                        <td><input type="text" size="50px" name="consumidorFinal" value="<?php echo $count[0]['consumidorFinal']; ?>" ></td>
                                    </div>
                                    </tr>
                                    </div>
                                    
                                   <div class="row">
                                   <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Credito Fiscal</td>
                                        <td><input type="text" size="50px" name="creditoFiscal" value="<?php echo $count[0]['creditoFiscal']; ?>"></td>
                                    </div>
                                    </tr>
                                    </div>

                                    <div class="row">
                                   <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Estado</td>
                                        <td>
                                            <select name="estado">
                                                <?php
                                                if($count[0]['estado']=='Y'){
                                                    ?>
                                                    <option value="Y">Activo</option>
                                                    <option value="N">Inactivo</option>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <option value="N">Inactivo</option>
                                                    <option value="Y">Activo</option>                                                    
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </div>
                                    </tr>
                                    </div>                                  

                                   <div class="row">
                                    <div class="col-lg-1 col-md-5">
                                        <td> </td>
                                        <td><input type="submit" value="Actualizar" name=""></td>
                                    </div> 
                                    </div>  
                                    
                                </table>
                            </form>
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



</body>
</html>