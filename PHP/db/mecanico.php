<?php
 require_once 'db.php';
 class Personaje {
   private $id;
   private $nombre;
   private $especialidad;
  
   const TABLA = 'myr_mecanico';
   const PROVEEDOR = 'myr_orden_proveedor';
   public function getId_mecanico() {
      return $this->id;
   }
   public function getNombre_mecanico() {
      return $this->nombre;
   }
   public function getEspecialidad_mecanico() {
      return $this->especialidad;
   }
   public function setNombre($nombre) {
      $this->nombre = $nombre;
   }
   public function setDescripcion($descripcion) {
      $this->descripcion = $descripcion;
   }
   public function __construct() {
      /*
      $this->nombre = $nombre;
      $this->descripcion = $descipcion;
      $this->id = $id;*/
   }
   public function updateProveedor($data){

      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::PROVEEDOR .' SET nombreCliente=:nombreCliente, nombreLegal=:nombreLegal,consumidorFinal=:consumidorFinal,creditoFiscal=:creditoFiscal,estado=:estado WHERE idCliente = :id');
         $consulta->bindParam(':nombreCliente', $data['nombreCorto']);
         $consulta->bindParam(':nombreLegal', $data['nombreLegal']);
         $consulta->bindParam(':consumidorFinal', $data['consumidorFinal']);
         $consulta->bindParam(':creditoFiscal', $data['creditoFiscal']);
         $consulta->bindParam(':estado', $data['estado']);   
         $consulta->bindParam(':id', $data['idProveedor']);
      $consulta->execute();
      return true;
   }


   public function getProveedor($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::PROVEEDOR .' where idCliente='.$id );
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }

   public function insertNew($data){
      $estado="Y";
      $conexion = new Conexion();
         $consulta = $conexion->prepare('INSERT INTO ' . self::PROVEEDOR .' (nombreCliente, nombreLegal,consumidorFinal,creditoFiscal,estado) VALUES(:nombreCliente, :nombreLegal,:consumidorFinal,:creditoFiscal,:estado)');
         $consulta->bindParam(':nombreCliente', $data['nombreCorto']);
         $consulta->bindParam(':nombreLegal', $data['nombreLegal']);
         $consulta->bindParam(':consumidorFinal', $data['consumidorFinal']);
         $consulta->bindParam(':creditoFiscal', $data['creditoFiscal']);
         $consulta->bindParam(':estado', $estado);
         $consulta->execute();         
         $conexion = null;
         return 1;
   }
   public function guardar($nombre,$especialidad){
      $habilitado="si";
      $conexion = new Conexion();
         $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre_mecanico, especialidad_mecanico,habilitado) VALUES(:nombre, :descripcion,:habilitado)');
         $consulta->bindParam(':nombre', $nombre);
         $consulta->bindParam(':descripcion', $especialidad);
         $consulta->bindParam(':habilitado', $habilitado);
         $consulta->execute();
         $this->id = $conexion->lastInsertId();
         $conexion = null;
         return 1;
   }
   public function selectProveedor(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::PROVEEDOR );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectAll(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectId($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' where id_mecanico = :id ');        
      $consulta->bindParam(':id', $id);
      $consulta->execute();        
      $registros = $consulta->fetch();
      return $registros; 
   }
   public function updateMecanico($id,$nombre,$especialidad,$estado){

      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre_mecanico = :nombre, especialidad_mecanico = :especialidad, habilitado= :habilitado WHERE id_mecanico = :id');
      $consulta->bindParam(':id', $id);
      $consulta->bindParam(':nombre', $nombre);
      $consulta->bindParam(':especialidad', $especialidad);      
      $consulta->bindParam(':habilitado', $estado);   
      $consulta->execute();
      return true;
   }
 }
?>