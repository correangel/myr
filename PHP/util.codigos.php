<?php
 require_once 'db/taller.php';
 $OrdenTaller = new Taller();
 //$persona->guardar();
 if(isset($_GET['orden']) and $_GET['orden']!="")
 {
    $count = $OrdenTaller->selectOrdenID($_GET['orden']);
 }
 else
 {
    $count = $OrdenTaller->selectCodigos();  
 }
  
  //var_dump($count);
  
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

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
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
                    <h3>Catalogo / Codigos Taller  </h3>             
                </div>
                <div class="panel-body">

                <div class="row">
                    <div class="col-lg-5 col-md-5">
                    <form action="util.orden.taller.html" method="GET">
                        <input id="filter" type="text" size="40" name="orden" class="form-control" placeholder="Codigo / Sistema / Estado">
                        
                    </form>                        
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <a href='util.codigo.add.html' id="left" class='btn btn-success'>Agregar</a>
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
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
#codigo{
    float: right;
}
#codigo2{
    float: left;
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
                var estado="Habilitado";
                var urlCerrada = "util.codigo.update";
                var codDetalle = "util.codigo.reparacion";
                if(count[i]['habilitado']==0){
                    estado="Desabilitado";                   
                }
                data.push({
                    codigo: count[i]['codigo'],
                    sistema: count[i]['sistema'],                    
                    Estado:  estado,    
                    Detalle: "<a href='"+urlCerrada+".html?id="+count[i][0]+"' id='codigo'  class='btn btn-primary'>Actualizar</a><a href='"+codDetalle+".html?id="+count[i][0]+"' id='codigo2'  class='btn btn-primary'>Reparaciones</a>"                                       
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
                data: createFirstGridData(100)
            },
            paging: {
                pageSize: 50
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
                                data: createSecondGridData(10),
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
                { field: "codigo", width: "100px", title: "Codigo" },
                { field: "sistema", width: "100px", title: "Sistema" },
                { field: "Estado", width: "100px", title: "Estado" },
                { field: "Detalle", width: "100px", title: "Detalle" }
            ]
        });
    });
</script>
<!-- Detail Grids - END -->



</body>
</html>