<?php
 require_once 'db/taller.php';
 $OrdenTaller = new Taller();
 //$persona->guardar();
 if(isset($_GET['orden']) and $_GET['orden']!="")
 {
    $count = $OrdenTaller->getCodigosID($_GET['orden']);
 }
 else
 {
    $count = $OrdenTaller->getCodigos();  
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
                    <h3><img src="icon/vote-1.png" width="60px" /> Catalogo / Codigos Taller  </h3>
                </div>
                <div class="panel-body">

                <div class="row">
                    <div class="col-lg-5 col-md-5">
                    <form action="util.orden.codes.html" method="GET">
                        <input id="filter" type="text" size="40" name="orden" class="form-control" placeholder="Orden #">
                        <input type="submit" value="Buscar">                        
                        
                    </form>                        
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <a href='util.orden.add.code.html' id="left" class='btn btn-default'>Agregar</a>
                    </div>
                </div>
                <br><br>
                    <div id="grid1"></div>
                </div>
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

<script type="text/javascript">
    jQuery(function ($) {
        function createFirstGridData() {
            var data = [];
            var js_data = '<?php echo json_encode($count); ?>';
            var count = JSON.parse(js_data);            
            for (var i = 0; i < count.length; i++) {
                var estado="Inactivo";
                var urlCerrada = "util.orden.update.code";
                if(count[i]['habilitado']=="si"){
                    estado="Activo";                   
                }
                data.push({                    
                    Codigo:     count[i]['cod_reparacion'],
                    Descripcion:count[i]['descripcion_reparacion'],
                    Costo:      count[i]['costo_reparacion'],  
                    Equipo:     count[i]['equipo'],                    
                    Placa:      count[i]['placa'], 
                    Estado:     estado,    
                    Detalle: "<a href='"+urlCerrada+".html?id="+count[i]['cod_reparacion']+"'  class='btn btn-default'>Detalle</a>"                                   
                });
            }
            return data;
        }

        function createSecondGridData(count) {
            var data = [];
            for (var i = 0; i < count; i++) {
                for (var j = 0; j < count; j++) {
                    data.push({
                        id: j + i,
                        productsCount: (j + i + i),
                        parentID: i
                    });
                }
            }
            return data;
        }

        $("#grid1").shieldGrid({
            dataSource: {
                data: createFirstGridData(50)
            },
            paging: {
                pageSize: 20
            },
            selection: {
                type: "row",
                multiple: false
            },
            events: {
                selectionChanged: function (e) {
                    $("#hint").hide();

                    var selectedItemID = $("#grid1").swidget().contentTable.find(".sui-selected").get(0).cells[0].innerHTML;
                    var secondGrid = $("#grid2").swidget();
                    if (secondGrid) {
                        secondGrid.dataSource.filter.value = selectedItemID;
                        secondGrid.refresh();
                    }
                    else {
                        $("#grid2").shieldGrid({
                            dataSource: {
                                data: createSecondGridData(1000),
                                filter: { path: "id", filter: "eq", value: selectedItemID }
                            },
                            paging: true,
                            columns: [
                                { field: "id", width: "100px", title: "ID" },
                                { field: "productsCount", title: "Products Count" },
                                { field: "parentID", title: "Parent ID" }
                            ]
                        });
                    }
                }
            },
            columns: [                
                { field: "Codigo",      width: "50px",  title: "Codigo" },
                { field: "Descripcion", width: "370px", title: "Descripcion" },
                { field: "Costo",       width: "50px",  title: "Costo" },
                { field: "Equipo",      width: "50px",  title: "Equipo" },
                { field: "Placa",       width: "80px",  title: "Placa" },
                { field: "Estado",      width: "50px",  title: "Estado" },
                { field: "Detalle",     width: "100px", title: "Detalle" }
            ]
        });
    });
</script>
<!-- Detail Grids - END -->



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

<script>
    $(document).ready(function() {      
        $("#filter").keyup(function(){

            $(".sui-columnheader").css("display", "table-row")
        });   
        $("a[target^='_blank']").remove();
        $('.panel-body').html(function(i, v) {            
            //return v.remove(/Demo/gi, ""); 
        });
        //var replaced = $(".panel-body").html().replace('Demo Version',"<b>Yes</b>");
        //replaced.appendTo('#Content');
        //$(".panel-body").html(replaced);

    });
</script>