<?php 
class regiones
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT idRegion,region FROM tblRegiones";
		$resultado = $this->conexion->query($consulta);
		while ($filaTmp = $resultado->fetch_assoc()) {
			$datos [] = $filaTmp;
		}
		if($resultado){
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function informacion($idRegion){
		$idRegion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idRegion))));
			$consulta="SELECT idRegion, region FROM tblRegiones WHERE idRegion = '$idRegion'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($region){
		$region = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($region))));
		$errores = 0;
		$errorResultado = "";
		
		if (empty($region)) {
			$errores ++;
			$errorResultado .= "El campo region no puede estar vacío. <br>";
		}
		
		
		if($errores === 0){
			$consulta = "INSERT INTO tblRegiones(region) SELECT * FROM (SELECT '$region' AS region) AS tmp WHERE NOT EXISTS (SELECT region FROM tblRegiones WHERE region = '$region') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El region ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($idRegion,$region){
		$idRegion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idRegion))));
		$region = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($region))));
		$errores = 0;
		$errorResultado = "";
		if (empty($region)) {
			$errores ++;
			$errorResultado .= "El campo region no puede estar vacío. <br>";
		}
		if($errores === 0){
			$consulta = "UPDATE tblRegiones a_b SET a_b.region = '$region' WHERE a_b.idRegion = '$idRegion' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblRegiones) AS a_b_2 WHERE a_b_2.region = '$region' AND a_b_2.idRegion != '$idRegion') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La Region ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminar($idRegion){
		$idRegion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idRegion))));
		$consultarRegiones="SELECT * FROM tblRegiones r inner join tblEstados Es on r.idRegion=Es.region  where Es.region=$idRegion";
		$resultado = $this->conexion->query($consultarRegiones);
			if($resultado){
				if($this->conexion->affected_rows >= 1){
						return "No se puede eliminar esta región porque ya está asignada a un empleado.";
					}else{
						$consulta="DELETE FROM tblRegiones WHERE idRegion = $idRegion";
						$resultado2 = $this->conexion->query($consulta);
						return "OK";
						}
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}



		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}
		
	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>