<?php 
class proyectos
	{
 		protected $conexion;

		public function __construct() 
		{ 
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT idclientes, nombreComercial ,cp FROM tblClientes c ORDER BY nombreComercial";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos [] = $filaTmp;
			}
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function cargarProyectos($idCliente){
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
   			$datos = array();
   			$consulta="SELECT p.idProyecto, p.nombre FROM tblProyectos p WHERE p.idCliente = '$idCliente' ORDER BY p.nombre";
   			 echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   }
?>