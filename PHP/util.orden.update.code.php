<?php
 require_once 'db/taller.php';
 $OrdenTaller = new Taller();
 //$persona->guardar();
 if(isset($_GET['id']) and $_GET['id']!="")
 {
    $count = $OrdenTaller->getCodigosID($_GET['id']);
 }
 if(isset($_POST['cod_reparacion'])){
    $OrdenTaller->updateCode($_POST);

    $path = "util.orden.codes.html?orden=".$_POST['cod_reparacion'];
    header('Location: '.$path);
 }
 //echo $persona->getNombre() . ' se ha guardado correctamente con el id: ' . $persona->getId();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title> Orden Taller</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

</head>
<script>
$(document).ready(function() 
{  
    //jQuery.noConflict(); 
    $("#getCode").click(function()
    {
        alert(123);
        //$("#nada").val("yes");
        
        //$('#updateCode').modal('show'); 
        
    });
});
</script>
<body>

<style>
#left{
  float: right;
  margin-right: 12px;
  
}
.searchable{

}
</style>
<script>
    $(document).ready(function() {
        $("body").addClass("searchable");
    });
</script>


<!-- Detail Grids - START -->
<div class="container">
    <div class="row">
        <div class="col-lg-11 col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Catalogo / Actualizar Codigo Taller  </h3>             
                </div>
                <div class="panel-body">
                <div class="row">
                <a href='util.orden.codes.html' id="left" class='btn btn-default'>Regresar</a>
                <br><br>
                </div>               

                <form action="#" method="POST">   
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <td>Cod Reparacion</td>
                                <td>Descripcion</td>
                                <td>Costo</td>
                                <td>Equipo</td>
                                <td>Placa</td>
                                <td>Habilitado</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" name="id_registro" value="<?php echo $count[0]['id_codigo'] ?>">
                                    <input type="text" name="cod_reparacion" value="<?php echo $count[0]['cod_reparacion'] ?>"></td>
                                <td>
                                    <textarea name="descripcion_reparacion" rows="1" cols="70"><?php echo $count[0]['descripcion_reparacion'] ?></textarea>
                                </td>
                                <td><input type="text" name="costo_reparacion" size="5px" value="<?php echo $count[0]['costo_reparacion'] ?>"></td>
                                <td><input type="text" name="equipo" size="5px" value="<?php echo $count[0]['equipo'] ?>"></td>
                                <td><input type="text" name="placa" size="10px" value="<?php echo $count[0]['placa'] ?>"></td>
                                <td>
                                    <select name="estado">
                                    <?php
                                    if($count[0]['habilitado']=="si")
                                    {
                                        ?><option value="si">Activo</option>
                                        <option value="no">Inactivo</option><?php
                                    }else
                                    {
                                        ?><option value="si">Activo</option>
                                        <option value="no">Inactivo</option><?php
                                    }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="emptyrow text-right">
                                    <input type="submit" value="Actualizar">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-5 col-md-5">           
                    </div>
                </div>
                </form>                
            </div>
        </div>
    </div>
    
</div>

<style>
.sui-cell {
    font-family:  Arial;
}
</style>

<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="PHP/all.min.css" />
<script type="text/javascript" src="PHP/shieldui-all.min.js"></script>
<script type="text/javascript" src="PHP/demo.js"></script>





</body>
</html>

<!-- BEGIN MODALS -->
          <div class="modal fade" id="" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
              <form action="" method="post" id="deleteOC">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>CODIGO</strong>  Orden Trabajo</h4>
                </div>
                <div class="modal-body">
                    <div class="row tab">                        
                       <h3 class="text-center">
                            <span id="idOrdenCompraDelete">XXX</span>
                       </h3>    
                       <input type="hidden" value="" name="idOC" id="idOC">
                    </div> 
                    <div class="row">
                        <div class="col-md-6">Sistema</div>
                        <div class="col-md-6">
                            <input type="text" name="nada" id="nada">
                        </div>
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