<?php 

require_once("../db/conectadb.php");

class municipiosLocalidades{

		protected $acceso;
		protected $conexion;

  		public function __construct() 
  		{
  			$this->acceso = new accesoDB(); 
   		 	$this->conexion = $this->acceso->conDB();
     	}	

     	public function listarMunicipios($estado){
     	
     		if(isset($_POST["estado"])){
         		 
         		 $estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
                    

	             $consulta = "SELECT lada,nombre,municipio,localidad FROM tblLadas  INNER JOIN tblEstados ON estado=idestado WHERE nombre='$estado' GROUP BY municipio";
	             
	             $resultado = $this->conexion->query($consulta);

	             if($resultado){
	             return $resultado;
	             }
	        }     

     	}


     	public function listarLocalidades($municipio){
     	
     		if(isset($_POST["municipio"])){
         		 
         		 $municipio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($municipio))));
                    

	             $consulta = "SELECT lada,nombre,municipio,localidad FROM tblLadas  INNER JOIN tblEstados ON estado=idestado WHERE municipio='$municipio'";
	             
	             $resultado = $this->conexion->query($consulta);

	             if($resultado){
	             return $resultado;
	             }
	        }     

     	}


}     	



?>