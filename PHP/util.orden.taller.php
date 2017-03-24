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
    $count = $OrdenTaller->selectAll();  
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
.sui-columnheader{
    display: "yes";
}
</style>



<!-- Detail Grids - START -->
<div class="container">
    <div class="row">
        <div class="col-lg-11 col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><img src="icon/newspaper.png" width="60px" /> Catalogo / Ordenes Taller  </h3>              
                </div>
                <div class="panel-body">

                <div class="row">
                    <div class="col-lg-5 col-md-5">
                    <form action="util.orden.taller.html" method="GET">
                        <input id="filter" type="text" size="40" name="orden" class="form-control" placeholder="Orden #">
                        <input type="submit" value="Buscar">
                    </form>                        
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <a href='util.orden.add.html' id="left" class='btn btn-success'>Agregar</a>
                    </div>
                </div>
                <br>
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
                var estado="Abierta";
                var urlCerrada = "util.orden.add.detalle";                
                if(count[i]['estado']=="Y"){                    
                    estado="Cerrada";
                    urlCerrada = "util.orden.add.detalle2";

                }
                data.push({
                    NOrden: count[i]['n_orden'],
                    Equipo: count[i]['id_equipo'],
                    Placa:  count[i]['Placa'],
                    Cliente:  count[i]['nombreCliente'],  
                    FechaI:  count[i]['f_ingreso'],                    
                    FechaF:  count[i]['f_salida'], 
                    Estado:  estado,    
                    Detalle: "<a href='"+urlCerrada+".html?id="+count[i][0]+"'  class='btn btn-default'>Detalle</a>"                                       
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
                data: createFirstGridData(2000)
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
                    var secondGrid = $("#grid").swidget();
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
                { field: "NOrden", width: "100px", title: "#Orden" },
                { field: "Equipo", width: "100px", title: "Equipo" },
                { field: "Placa", title: "Placa" },
                { field: "Cliente", title: "Cliente" },
                { field: "FechaI", width: "200px", title: "Fecha Ingreso" },
                { field: "FechaF", width: "200px", title: "Fecha Fin" },
                { field: "Estado", width: "100px", title: "Estado" },
                { field: "Detalle", width: "100px", title: "Detalle" }
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
        //$('.panel-body').html(function(i, v) {
            //return v.replace(/Demo Version/g, '');    
        //});
        $("body").addClass("searchable");
    });
</script>