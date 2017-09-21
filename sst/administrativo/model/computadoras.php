<?php 
	require_once('../db/conectadb.php');

	class computadoras
	{
 		protected $acceso;
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT IdComputadoras,Marca FROM tblcomputadoras ORDER BY Marca";
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
//funcion para consultar la informacion
   		public function informacion($idComputadoras){
			$idComputadoras = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idComputadoras))));
   			$consulta="SELECT IdComputadoras, Marca FROM tblcomputadoras WHERE IdComputadoras = '$idComputadoras'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($computo){
			$computo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($computo))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($computo)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblcomputadoras(Marca) SELECT * FROM (SELECT '$computo' AS computo) AS tmp WHERE NOT EXISTS (SELECT Marca FROM tblcomputadoras WHERE Marca = '$computo') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "La Marca ya existe. <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}
//funcion para la consulta de actualizar la informacion
		public function actualizar($idComputadoras,$computo){
			$idComputadoras = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idComputadoras))));
			$computo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($computo))));
			$errores = 0;
			$errorResultado = "";
			if (empty($computo)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			if($errores === 0){
				//$consulta = "UPDATE tblcomputadoras a_b SET a_b.Marca = '$computo' WHERE a_b.IdComputadoras = '$idComputadoras' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblcomputadoras) AS a_b_2 WHERE a_b_2.Marca = '$computo' AND a_b_2.IdComputadoras != '$idComputadoras') AS count); ";
				$consulta = "UPDATE tblcomputadoras SET Marca='$computo' where IdComputadoras = '$idComputadoras'";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
				  	if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "La Marca ya existe o no se actualizó ningún dato. <br>";	
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			}
			else{
				return $errorResultado;
			}
		}
		//public function actualizar($idComputadoras,$computo){
		//	$idComputadoras= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idComputadoras))));
		//	$computo= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($computo))));
		//	$consulta = "UPDATE tblcomputadoras SET Marca='$computo' WHERE  IdComputadoras = '$idComputadoras'";
		//	$resultado= $this->conexion ->query($consulta);
		//	if($resultado){
		//	return "OK";
		//	     }
			     
		//return $this->conexion->errno . ":" . $this->conexion->error . "\n"; 
		
		//}

//funcion para la consulta de eliminar los registros
		public function eliminar($idComputadoras){
			$idComputadoras = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idComputadoras))));
			$consulta="DELETE FROM tblcomputadoras WHERE IdComputadoras = $idComputadoras";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		
		public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	
   }
?>