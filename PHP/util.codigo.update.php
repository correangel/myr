<?php
 require_once 'db/taller.php';
 $codigo = new Taller();
 $id =  $_GET['id'];
 
 //$persona->guardar();
$count = $codigo->selectCodigoId($id);

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
                    <h3>Catalogo / Codigos / Actualizar</h3>
                </div>
                <div class="panel-body">
                <a href='util.codigos.html' id="left" class='btn btn-success'>Regresar</a>
                <br><br>
                    <div id="grid1">

                     <div class="container">
                            <div class="row">
                            <form action="util.codigo.actualizar.html" method="post">
                                <table>
        <input type="hidden" name="id_codigo" value="<?php echo $count[0]['id_codigo']?>" name="id">
                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td>Codigo </td>
                                        <td><input type="text" size="50px" class="control-form" value="<?php echo $count[0]['codigo'] ?>" name="codigo"></td>
                                    </div>   
                                    </tr>

                                    <tr>                                    
                                    <div class="col-lg-1 col-md-5">
                                        <td>Sistema </td>
                                        <td><input type="text" size="50px" class="control-form" value="<?php echo $count[0]['sistema'] ?>" name="sistema">
                                        </td>
                                    </div>   
                                    </tr>
                                    
                                    <tr>                                    
                                    <div class="col-lg-1 col-md-5">
                                        <td>Habilitado </td>
                                        <td>
                                            <select name="habilitado">
                                                <?php
                                                if($count[0]['habilitado']==1){
                                                    ?>
                                                    <option value="1">Si</option>
                                                    <option value="0">No</option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
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