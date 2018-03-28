<?php 
class conocimientos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT idConocimiento, conocimiento FROM spartodo_rh.tblConocimientos";
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

	public function informacion($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="SELECT idConocimiento, conocimiento FROM spartodo_rh.tblConocimientos WHERE idConocimiento = '$id'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($conocimiento){
		$conocimiento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimiento))));
		$errores = 0;
		$errorResultado = "";
		
		if (empty($conocimiento)) {
			$errores ++;
			$errorResultado .= "El campo conocimiento no puede estar vacío. <br>";
		}
		
		
		if($errores === 0){
			$consulta = "INSERT INTO spartodo_rh.tblConocimientos(conocimiento) SELECT * FROM (SELECT '$conocimiento' AS conocimiento) AS tmp WHERE NOT EXISTS (SELECT conocimiento FROM spartodo_rh.tblConocimientos WHERE conocimiento = '$conocimiento') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El conocimiento ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$conocimiento){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$conocimiento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimiento))));
		$errores = 0;
		$errorResultado = "";
		if (empty($conocimiento)) {
			$errores ++;
			$errorResultado .= "El campo conocimiento no puede estar vacío. <br>";
		}
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblConocimientos a_b SET a_b.conocimiento = '$conocimiento' WHERE a_b.idConocimiento = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_rh.tblConocimientos) AS a_b_2 WHERE a_b_2.conocimiento = '$conocimiento' AND a_b_2.idConocimiento != '$id') AS count); ";
			echo $consulta;
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El campo conocimiento ya existe o no se actualizó ningún dato. <br>";	
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