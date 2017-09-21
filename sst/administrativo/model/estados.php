<?php 
class estados
	{
 		protected $conexion;

		public function __construct() 
		{
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar($pais){
   			$datos = array();
			$pais = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($pais))));
   			$consulta = "SELECT e.idestado, e.nombre FROM tblEstados e LEFT JOIN tblPaises p ON e.idpais = p.idpais WHERE p.nombre = '$pais'";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

		public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	
   }
?>