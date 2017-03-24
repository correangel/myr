<?php
 require_once 'db/mecanico.php';
 $id =  $_GET['ID'];
 $persona = new Personaje('Rafael', 'Electrico');
 //$persona->guardar();
$count = $persona->selectId($id);



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
                <a href='util.mecanico.html' id="left" class='btn btn-success'>Regresar</a>
                <br><br>
                    <div id="grid1">

                     <div class="container">
                            <div class="row">
                            <form action="util.mecanico.actualizar.html" method="post">
                                <table>
                                <input type="hidden" name="id" value="<?php echo $count[0] ?>" name="id">
                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td>Nombre </td>
                                        <td><input type="text" size="50px" class="control-form" value="<?php echo $count[1] ?>" name="nombre"></td>
                                    </div>   
                                    </tr>

                                    <tr>                                    
                                    <div class="col-lg-1 col-md-5">
                                        <td>Especialidad </td>
                                        <td><input type="text" size="50px" class="control-form" value="<?php echo $count[2] ?>" name="especialidad">
                                        </td>
                                    </div>   
                                    </tr>
                                    
                                    <tr>                                    
                                    <div class="col-lg-1 col-md-5">
                                        <td>Habilitado </td>
                                        <td>
                                            <select name="estado">
                                                <?php
                                                if($count[3]=="si"){
                                                    ?>
                                                    <option value="si"><?php echo $count[3];  ?></option>
                                                    <option value="no">no</option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="no">no</option>
                                                    <option value="si">si</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </div>   
                                    </tr>

                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td> </td>
                                        <td><input type="submit" value="Actualizar"></td>
                                    </div>   
                                    </tr>
                                </table>
                            </form>
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



</body>
</html>