<?php
 require_once 'db.php';
 class Taller {
   private $id;
   private $nombre;
   private $especialidad;
  
   const TABLA = 'myr_orden_taller';
   const USUARIO = 'opsal_usuarios';
   const CODIGOS = 'myr_codigos';
   const CODIGOS_REPARACION = 'myr_codigos_reparaciones';
   const CODIGOS_SISTEMAS = 'myr_codigos';
   const CLIENTES = 'myr_cliente_taller';
   const PROVEEDOR = 'myr_orden_proveedor';
   
   public function __construct() {
   }

   
   public function insertNewCode($data){
      $conexion = new Conexion();
         $consulta = $conexion->prepare('INSERT INTO ' . self::CODIGOS_REPARACION .' (cod_sistema, cod_reparacion,descripcion_reparacion,costo_reparacion,equipo,placa,habilitado) VALUES(:cod_sistema, :cod_reparacion,:descripcion_reparacion,:costo_reparacion,:equipo,:placa,:estado)');
         $consulta->bindParam(':cod_sistema',            $data['cod_sistema']);      
         $consulta->bindParam(':cod_reparacion',         $data['cod_reparacion']);
         $consulta->bindParam(':descripcion_reparacion', $data['descripcion_reparacion']);      
         $consulta->bindParam(':costo_reparacion',       $data['costo_reparacion']);   
         $consulta->bindParam(':equipo',                 $data['equipo']);
         $consulta->bindParam(':placa',                  $data['placa']);
         $consulta->bindParam(':estado',                 $data['estado']);
         $consulta->execute();         
         $conexion = null;
         return 1;
   }

   public function getCodigosSistemas(){      
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::CODIGOS_SISTEMAS);     
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }

   
   public function updateCode($code){   
      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::CODIGOS_REPARACION .' SET cod_reparacion = :cod_reparacion, descripcion_reparacion = :descripcion_reparacion, costo_reparacion=:costo_reparacion,equipo=:equipo,placa=:placa,habilitado=:estado  WHERE id_codigo = :id_registro');      
      $consulta->bindParam(':id_registro',            $code['id_registro']);      
      $consulta->bindParam(':cod_reparacion',         $code['cod_reparacion']);
      $consulta->bindParam(':descripcion_reparacion', $code['descripcion_reparacion']);      
      $consulta->bindParam(':costo_reparacion',       $code['costo_reparacion']);   
      $consulta->bindParam(':equipo',                 $code['equipo']);
      $consulta->bindParam(':placa',                  $code['placa']);
      $consulta->bindParam(':estado',                 $code['estado']);
      $consulta->execute();
      return $consulta; 
   }

   public function getCodigosID($id){      
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::CODIGOS_REPARACION .' where cod_reparacion LIKE "'.$id.'%"');     
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }

   public function getCodigos(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::CODIGOS_REPARACION .' order by id_codigo asc');        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
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
   public function selectCodigos(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::CODIGOS);        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectCodigoId($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::CODIGOS .' where id_codigo='.$id);
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function updateCodigo($data){
      
      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::CODIGOS .' SET codigo = :codigo, sistema = :sistema, habilitado = :habilitado WHERE id_codigo = :id_codigo');
      $consulta->bindParam(':codigo', $data['codigo']);
      $consulta->bindParam(':sistema', $data['sistema']);
      $consulta->bindParam(':habilitado', $data['habilitado']);      
      $consulta->bindParam(':id_codigo', $data['id_codigo']);   
      $consulta->execute();
      return true;
   }
   public function insertCodigo($data){
      $conexion = new Conexion();
         $consulta = $conexion->prepare('INSERT INTO ' . self::CODIGOS .' (codigo, sistema,habilitado) VALUES(:codigo, :sistema, :habilitado)');
         $consulta->bindParam(':codigo', $_POST['codigo']);
         $consulta->bindParam(':sistema', $_POST['sistema']);
         $consulta->bindParam(':habilitado', $_POST['habilitado']);
         $consulta->execute();
         $this->id = $conexion->lastInsertId();
         $conexion = null;
         return 1;
   }
   public function selectAll(){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT '. self::TABLA .'.* ,C.nombreCliente FROM ' . self::TABLA . ' JOIN '. self::CLIENTES .' as C ON C.idCliente='.self::TABLA.'.id_cliente order by '.self::TABLA.'.estado="N" desc'  );
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }


   public function selectCodigoReparacion($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::CODIGOS_REPARACION . ' where cod_sistema ='.$id  );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   
   public function selectOrdenID($orden){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' JOIN '. self::USUARIO .' as U ON U.codigo_usuario='.self::TABLA.'.id_cliente where n_orden='.$orden  );        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectOneOrdenById($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' JOIN '. self::CLIENTES .' as P ON P.idCliente='.self::TABLA.'.id_cliente where '. self::TABLA .'.id_orden ='.$id);        
      $consulta->execute();        
      $registros = $consulta->fetchAll();
      return $registros; 
   }
   public function selectId($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' where id_orden = :id ');        
      $consulta->bindParam(':id', $id);
      $consulta->execute();        
      $registros = $consulta->fetch();
      return $registros; 
   }
   public function updateMecanico($id,$nombre,$especialidad){
      
      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre_mecanico = :nombre, especialidad_mecanico = :especialidad WHERE id_mecanico = :id');
      $consulta->bindParam(':id', $id);
      $consulta->bindParam(':nombre', $nombre);
      $consulta->bindParam(':especialidad', $especialidad);      
      $consulta->execute();
      return true;
   }
 }
?>