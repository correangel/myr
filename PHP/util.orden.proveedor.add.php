<?php
 require_once 'db/mecanico.php';
 $proveedor = new Personaje('Rafael', 'Electrico');
 //$persona->guardar();
  

  if(isset($_POST['nombreCorto']))
  {
    $count = $proveedor->insertNew($_POST);
    $path = "util.orden.proveedor.html";
    header('Location: '.$path);
  }

 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title> Mecanicos</title>
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
                    <h3>Catalogo / Agregar Proveedor </h3>
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
                                            <td><input type="text" size="50px" value="" name="nombreCorto"></td>
                                        </div>                                         
                                    </tr>
                                    </div>                                     
                                    
                                    <div class="row">
                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Nombre Legal </td>
                                        <td><input type="text" size="50px" value="" name="nombreLegal"></td>
                                    </div>
                                    </tr>
                                    </div>
                                    
                                   <div class="row">
                                   <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Consumidor Final </td>
                                        <td><input type="text" size="50px" value="" name="consumidorFinal"></td>
                                    </div>
                                    </tr>
                                    </div>
                                    
                                   <div class="row">
                                   <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td class="text-right">Credito Fiscal</td>
                                        <td><input type="text" size="50px" value="" name="creditoFiscal"></td>
                                    </div>
                                    </tr>
                                    </div>                                    

                                   <div class="row">
                                    <div class="col-lg-1 col-md-5">
                                        <td> </td>
                                        <td><input type="submit" value="Guardar" name=""></td>
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