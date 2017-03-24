<?php
	require_once 'db.php';

  if(isset($_POST['id_orden_compra1'])){
    updateItemOrdenTrabajo($_POST);

  }
	if(isset($_POST['id']))
  {    	
      cod_reparacion($_POST['id']);        
  }
  if(isset($_POST['costo']))
  {     
      costo($_POST['costo']);        
  }
  if(isset($_POST['password']))
  {     
      check_pass($_POST['password'],$_POST['user']);        
  }
  if(isset($_POST['numero_orden_taller']))
  {     
      saveOrdenCompra();        
  }
  if(isset($_POST['nombre_repusto']))
  {     
      saveItemOC();        
  }
  //Delete OC Pre-Validada
  if(isset($_POST['idOC']))
  {     
      deleteOrdenCompra($_POST);        
  }
  //Abrir OT
  if(isset($_POST['idOT']))
  {
    validar($_POST);    
  }



  function updateItemOrdenTrabajo($data){
    var_dump($data);
    $conexion = new Conexion();
    $consulta = $conexion->prepare('UPDATE myr_orden_taller_detalle SET N_OrdenCompra = :OC WHERE idOrdenTallerDetalle='.$data['id_orden_compra1']);
    $consulta->bindParam(':OC', $data['orden_compra']);       
    $consulta->execute();
  }
  //Eliminar Orden de Compras
   function deleteOrdenCompra($id)
   {
    
    $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT OC.idOrdenCompra FROM myr_orden_compra AS OC JOIN myr_orden_taller_detalle AS OTD ON OC.idOrdenCompra=OTD.N_OrdenCompra where OC.numeroOrdenCompra=:idOC');         
        $consulta->bindParam(':idOC',   $id['idOC']);     
        $consulta->execute();        
        $registros1 = $consulta->fetchAll();
        $total = count($registros1);
        if($total==0)
        {          

          $consulta3 = $conexion->prepare('SELECT idOrdenCompra FROM myr_orden_compra where numeroOrdenCompra="'.$_POST['idOC'].'"' );
          $consulta3->execute();
          $idOrdenCompra = $consulta3->fetchAll();

          $consulta = $conexion->prepare('DELETE FROM myr_orden_compra where numeroOrdenCompra="'.$_POST['idOC'].'"' );
          $consulta->execute();          

          $consulta2 = $conexion->prepare('DELETE FROM myr_orden_compra_item where idOrdenCompra='.$idOrdenCompra[0]['idOrdenCompra']);
          $consulta2->execute();
          echo 1;          
        }
        else{
          echo 2;
        }
   }

  function validar($id){
    // Abrir OT
      $pass_superv_encryp  = sha1($id['supervisor']);
      $pass_user_log       = $id['loguer'];
      //Evalua que el usuario logueado sea distinto al supervisor
      if($pass_superv_encryp!=$pass_user_log)
      {
         $conexion = new Conexion();
         $consulta = $conexion->prepare('SELECT usuario,clave FROM opsal_usuarios where clave="'.$pass_superv_encryp.'" and nivel="jefatura"');   
         $consulta->execute();        
         $registros = $consulta->fetchAll();
         $total = count($registros);

         if($total>=1)
         {
            $yes="N";
            $conexion = new Conexion();
            $consulta = $conexion->prepare('UPDATE myr_orden_taller SET estado = :estado WHERE id_orden='.$id['idOT']);            
            $consulta->bindParam(':estado', $yes);   
            $consulta->execute();
            echo 1;
            exit();
         }else{
            echo 2;
         }         
      }
      else{
         echo 3;
      }
   
  }
  //Guarda los Item de las Ordenes de Compras
  function  saveItemOC()
  {
      $conexion = new Conexion();
      $consulta = $conexion->prepare('INSERT INTO myr_orden_compra_item (idOrdenCompra,nombreRespuesto,precioUnidad,cantidadRepuesto) VALUES(:id_orden, :nombre_repusto,:precio_unidad,:cantidad_repusto)');
      $consulta->bindParam(':nombre_repusto',   $_POST['nombre_repusto']);
      $consulta->bindParam(':precio_unidad',    $_POST['precio_unidad']);
      $consulta->bindParam(':cantidad_repusto', $_POST['cantidad_repusto']);
      $consulta->bindParam(':id_orden',         $_POST['id_orden']);      
      $consulta->execute();
      //$this->id = $conexion->lastInsertId();
      $conexion = null;
      return 1;
  }


  
  //Save Orden Compra
  function  saveOrdenCompra()
  {
      //var_dump($_POST);
      $conexion = new Conexion();
      $consulta = $conexion->prepare('INSERT INTO myr_orden_compra (idOrdenTaller,idProveedor, numeroOrdenCompra,idSupervisorCompra) VALUES(:idOrdenTaller, :proveedor,:numeroOrdenCompra,:idSupervisorCompra)');
      $consulta->bindParam(':idOrdenTaller', $_POST['numero_orden_taller']);
      $consulta->bindParam(':proveedor', $_POST['proveedor']);
      $consulta->bindParam(':numeroOrdenCompra', $_POST['numero_orden']);
      $consulta->bindParam(':idSupervisorCompra', $_POST['cliente']);
      $consulta->execute();
      //$this->id = $conexion->lastInsertId();
      $conexion = null;
      return 1;
  }
  //Validar Password para modificar precios de OT
  function check_pass($clave,$user){
      $pass = sha1($clave);
      if($pass != $user){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM opsal_usuarios where clave="'.$pass.'"' );
        $consulta->execute();        
        $registros = $consulta->fetchAll();     
        if($registros){          
          echo 1;
        }
        else{          
          echo 0;
        }
      }
      else
      {
        echo 0;
      }
      //echo json_encode($registros);
   } 
  // Retornar de funcion AJAX
   	function cod_reparacion($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM myr_codigos_reparaciones where cod_reparacion="'.$id.'" and habilitado="si"' );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();

      echo json_encode($registros);
   } 

    function costo($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT costo_reparacion FROM myr_codigos_reparaciones where cod_reparacion="'.$id.'"' );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      echo json_encode($registros);
   } 


?>