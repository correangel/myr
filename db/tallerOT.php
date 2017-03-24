<?php
 require_once 'db.php';
 class TalleOT {
   private $id;
   private $nombre;
   private $especialidad;
  
   const TABLA = 'myr_orden_taller_detalle';
   const TABLA2 = 'myr_orden_taller';
   const COD_TRABAJOS = 'myr_codigos_reparaciones';
   public function __construct() {
   
      
   }
   

   public function guardar($nombre,$especialidad){
      $conexion = new Conexion();
         $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre_mecanico, especialidad_mecanico) VALUES(:nombre, :descripcion)');
         $consulta->bindParam(':nombre', $nombre);
         $consulta->bindParam(':descripcion', $especialidad);
         $consulta->execute();
         $this->id = $conexion->lastInsertId();
         $conexion = null;
         return 1;
   }
   public function selectAll(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectAllId($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('
            SELECT * FROM ' . self::TABLA . ' JOIN myr_mecanico as M 
            ON M.id_mecanico='.self::TABLA.'.idMecanico 
            JOIN '.self::COD_TRABAJOS.' as C
            ON '.self::TABLA.'.idCodTrabajo=C.cod_reparacion
            where idOrdenTaller = :id ');        
      $consulta->bindParam(':id', $id);
      $consulta->execute();        
      $registros = $consulta->fetchAll();      
      return $registros; 
   }

// Consulta de la Reparacion
public function getCostoReparacion($idCodTrabajo){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM '.self::COD_TRABAJOS.'  where cod_reparacion="'.$idCodTrabajo.'"');        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros;
}
// ***************************

// INSERTA LOS ITEMS DE CADA ORDEN 
   public function insertOrdenItems($items,$costo){
      $conexion = new Conexion();
      $fecha_i = $items['fecha_i'];
      $hora_i  = $items['hora_i'];
      $fecha_horai= $fecha_i.' '.$hora_i.':00';

      $fecha_f = $items['fecha_f'];
      $hora_f  = $items['hora_f'];
      $fecha_horaf= $fecha_f.' '.$hora_f.':00';

      $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' 
         (idOrdenTaller,F_I, idMecanico,idCodTrabajo,descripcionTrabajo,F_F,N_OrdenCompra,N_CCF,Proveedor,valor) 
         VALUES(:idOrdenTaller, :fecha_horai, :mecanico, :codReparacion, :descripcion, :fecha_horaf,:NordenCompra, :ccf,:proveedor,:costo)');
         $consulta->bindParam(':idOrdenTaller', $items['idOrdenTaller']);         
         $consulta->bindParam(':mecanico',      $items['mecanico']);
         $consulta->bindParam(':codReparacion', $items['cod_detalle']);
         $consulta->bindParam(':descripcion',   $items['descripcion']);
         $consulta->bindParam(':fecha_horai',   $fecha_horai);
         $consulta->bindParam(':fecha_horaf',   $fecha_horaf);
         $consulta->bindParam(':NordenCompra',  $items['NordenCompra']);
         $consulta->bindParam(':ccf',           $items['ccf']);
         $consulta->bindParam(':proveedor',     $items['proveedor']);
         $consulta->bindParam(':costo',         $costo);  
         
         $consulta->execute();
         $this->id = $conexion->lastInsertId();
         $conexion = null;
         return $this->id; 
   }
// ***************************



// Delete Item orden ********************
   public function deleteOrdenItems($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('DELETE FROM '.self::TABLA.' 
                                       where idOrdenTallerDetalle='.$id );        
      $consulta->execute();        
      //$registros = $consulta->fetchAll();
      return 1; 
   }
   // End Delete *************************

   // Close Orden********************************************
   public function CloseOrden($id){
      $yes="Y";
      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::TABLA2 .' SET estado = :estado WHERE id_orden ='.$id);
      $consulta->bindParam(':estado', $yes);           
      $consulta->execute();
      return 1;
   }
   // *******************************************************


   public function updateMecanico($id,$nombre,$especialidad){
      
      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre_mecanico = :nombre, especialidad_mecanico = :especialidad WHERE id_mecanico = :id');
      $consulta->bindParam(':id', $id);
      $consulta->bindParam(':nombre', $nombre);
      $consulta->bindParam(':especialidad', $especialidad);      
      $consulta->execute();
      return true;
   }

   // Funciones para agregar Nuevas Ordenes

   public function selectAllAgencias(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM opsal_usuarios where nivel="agencia"' );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectAllInvCatalogo(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM myr_codigos where habilitada=1' );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectAllMecanico(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM myr_mecanico where habilitado="si"');        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectAllCodReparacion(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM myr_codigos where habilitado=1');        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectAllInventario(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM inv_inventariable as I join inv_proveedor as P
                                    ON I.proveedor=P.id_proveedor where habilitada="si"');        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }

   // Insertando Nueva orden en 

   public function insertOrden($data){
      $conexion = new Conexion();
      $estado = "N";
         $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA2 .' 
         (n_orden,id_equipo, Placa,id_cliente,kilometraje,f_ingreso,f_salida,estado) 
         VALUES(:ordenId, :equipoId, :placa, :cliente, :kilometraje, :f_inicio,:f_fin, :estado)');
         $consulta->bindParam(':ordenId', $data['orden']);
         $consulta->bindParam(':equipoId',  $data['equipo']);
         $consulta->bindParam(':placa',  $data['placa']);
         $consulta->bindParam(':cliente',  $data['cliente']);
         $consulta->bindParam(':kilometraje',  $data['kilometraje']);
         $consulta->bindParam(':f_inicio',  $data['fechaI']);
         $consulta->bindParam(':f_fin',  $data['fechaF']);
         $consulta->bindParam(':estado',  $estado);
         $consulta->execute();
         $this->id = $conexion->lastInsertId();
         $conexion = null;
         
         return $this->id;
   }
   public function selectNewOrden($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM myr_orden_taller where id_orden='.$id );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }








   // Buscar Oren en Patio
   public function selectOrden($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM opsal_ordenes where codigo_orden='.$id );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }

     

   


 }
?>