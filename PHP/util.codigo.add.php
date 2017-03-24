<?php
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
                    <h3>Catalogo / Codigos / Agregar</h3>
                </div>
                <div class="panel-body">
                <a href='util.codigos.html' id="left" class='btn btn-success'>Regresar</a>
                <br><br>
                    <div id="grid1">
                        <div class="container">
                            <div class="row">
                            <form action="util.codigo.insert.html" method="post">
                                <table>
                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td>Codigo </td>
                                        <td><input type="text" size="50px" value="" name="codigo"></td>
                                    </div>   
                                    </tr>

                                    <tr>                                    
                                    <div class="col-lg-1 col-md-5">
                                        <td>Sistema </td>
                                        <td><input type="text" size="50px" value="" name="sistema"></td>
                                    </div>   
                                    </tr>

                                    <tr>                                    
                                    <div class="col-lg-1 col-md-5">
                                        <td>Habilitado </td>
                                        <td>
                                            <select name="habilitado">
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                    </div>   
                                    </tr>

                                    <tr>
                                    <div class="col-lg-1 col-md-5">
                                        <td> </td>
                                        <td><input type="submit" value="Guardar" name=""></td>
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