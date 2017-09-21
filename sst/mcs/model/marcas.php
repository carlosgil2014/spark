<?php 
	require_once('../db/conectadb.php');

	class marcas
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
   			$consulta="SELECT idmarca,marca FROM tblmarcas ORDER BY marca";
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
   		public function informacion($idMarca){
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
   			$consulta="SELECT idmarca, marca FROM tblmarcas WHERE idmarca = '$idMarca'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($Marca){
			$Marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Marca))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($Marca)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblmarcas(marca) SELECT * FROM (SELECT '$Marca' AS Marca) AS tmp WHERE NOT EXISTS (SELECT marca FROM tblmarcas WHERE marca = '$Marca') LIMIT 1; ";
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
		public function actualizar($idMarca,$Marca){
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
			$Marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Marca))));
			$errores = 0;
			$errorResultado = "";
			if (empty($Marca)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			if($errores === 0){
				//$consulta = "UPDATE tblcomputadoras a_b SET a_b.Marca = '$computo' WHERE a_b.IdComputadoras = '$idComputadoras' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblcomputadoras) AS a_b_2 WHERE a_b_2.Marca = '$computo' AND a_b_2.IdComputadoras != '$idComputadoras') AS count); ";
				$consulta = "UPDATE tblmarcas SET marca='$Marca' where idmarca = '$idMarca'";
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
		
//funcion para la consulta de eliminar los registros
		public function eliminar($idMarca){
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
			$consulta="DELETE FROM tblmarcas WHERE idmarca = $idMarca";
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