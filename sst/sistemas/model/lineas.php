<?php 
class lineas
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT l.idLinea, l.linea FROM tblLineas l";
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
			$consulta="SELECT l.idLinea,l.linea,l.almacen FROM tblLineas l WHERE l.idLinea=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($linea,$sim){
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($linea))));
		$sim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($sim))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El linea no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO tblLineas (linea) SELECT * FROM (SELECT '$linea' AS linea) AS tmp WHERE NOT EXISTS (SELECT linea FROM tblLineas WHERE linea = '$linea') LIMIT 1; ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$idLinea = $this->conexion->insert_id;
		  			$consulta = "INSERT INTO TblLineasSim(idLinea, idSim, fechaRegistro) VALUES ('$idLinea', '$sim', '$hoy')";
					$resultado = $this->conexion -> query($consulta);
					if($resultado){
		  				if($this->conexion->affected_rows === 1){
		  					return "OK";
		  				}
		  				else{
		  					return "Error al guardar en almacén.";
		  				}
					}
		  		}
				else 
					return "La SIM ya existe.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}

		if($errores === 0){
			$consulta = "INSERT INTO tblLineas (linea,almacen) SELECT * FROM (SELECT '$linea' AS linea,'$tipo' AS tipo) AS tmp WHERE NOT EXISTS (SELECT linea FROM tblLineas WHERE linea = '$linea') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La linea ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$linea,$tipo){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$errores = 0;
		$errorResultado = "";
		if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El campo linea no puede estar vacío. <br>";
		}if (empty($tipo)) {
			$errores ++;
			$errorResultado .= "El campo tipo no puede estar vacío. <br>";
		}
		if($errores === 0){
			$consulta = "UPDATE tblLineas a_b SET a_b.linea = '$linea',a_b.almacen = '$tipo' WHERE a_b.idLinea = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblLineas) AS a_b_2 WHERE a_b_2.linea = '$linea' AND a_b_2.idLinea != '$id') AS count);";
			//echo $consulta;
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La linea ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminar($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$consulta="DELETE FROM tblLineas WHERE idLinea=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarLineas(){
		$datos = array();
		$consulta="SELECT l.idLinea as id,l.linea from tblLineas l where not exists (select a.idLinea from tblAsignaciones a where a.idLinea = l.idLinea)";
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