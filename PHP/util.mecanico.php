<?php
 require_once 'db/mecanico.php';
 $persona = new Personaje('Rafael', 'Electrico');
 //$persona->guardar();
  $count = $persona->selectAll();

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
                    <h3><img src="icon/ereader.png" width="60px" /> Catalogo / Lista Mecanicos</h3>
                </div>
                <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <input id="filter" type="text" size="40" class="form-control" placeholder="Filtrar...">
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <a href='util.mecanico.add.html' id="left" class='btn btn-default'>Agregar</a>
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
                data.push({
                    id: count[i][0],
                    Nombre: count[i][1],
                    Especialidad:  count[i][2],
                    Habilitado:  count[i][3],
                    Actualizar: "<a href='util.mecanico.buscar.html?ID="+count[i][0]+"'  class='btn btn-default'>Actualizar</a>"                                       
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
                { field: "id", width: "70px", title: "ID" },
                { field: "Nombre", title: "Nombre" },
                { field: "Especialidad", title: "Especialidad" },
                { field: "Habilitado", title: "Habilitado" },
                { field: "Actualizar", width: "100px", title: "Actualizar" }
            ]
        });
    });
</script>
<!-- Detail Grids - END -->



</body>
</html>

<script>
    $(document).ready(function() {     
        $("#filter").keyup(function(){
            $(".sui-columnheader").css("display", "table-row")
        });    
        $("a[target^='_blank']").hide();
        $('.panel-body').html(function(i, v) {
            //return v.replace(/Demo Version/g, '');    
        });
        $("body").addClass("searchable");
    });
</script>