<?php 
class sims
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT s.idSim, s.icc FROM tblSim s";
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
			$consulta="SELECT s.idSim, s.icc FROM tblSim s where s.idSim=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($icc, $almacen){
		$icc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($icc))));
		$almacen = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($almacen))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if(empty($icc) || strlen($icc) != 20 || (!preg_match("/[0-9]{19}F/", $icc) && !preg_match("/[0-9]{19}f/", $icc))) {
			$errores ++;
			$errorResultado .= "El ICC es incorrecto.";
		}
		if(empty($almacen)) {
			$errores ++;
			$errorResultado .= "El almacén es incorrecto.";
		}

		if($errores === 0){
			$consulta = "INSERT INTO tblSim(icc) SELECT * FROM (SELECT '$icc') AS tmp WHERE NOT EXISTS (SELECT icc FROM tblSim WHERE icc = '$icc') LIMIT 1; ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$idICC = $this->conexion->insert_id;
		  			$consulta = "INSERT INTO tblSimsAlmacen(idAlmacen, idSim, fechaRegistro) VALUES ('$almacen', '$idICC', '$hoy')";
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
					return "El ICC ya existe.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$sim){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$sim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($sim))));
		$errores = 0;
		$errorResultado = "";
		if (empty($sim)) {
			$errores ++;
			$errorResultado .= "El sim  no puede estar vacío. <br>";
		}if (empty($id)) {
			$errores ++;
			$errorResultado .= "El id no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "UPDATE tblSim a_b SET a_b.icc = '$sim' WHERE a_b.idSim = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblSim) AS a_b_2 WHERE a_b_2.icc = '$sim' AND a_b_2.idSim != '$id') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$idICC = $this->conexion->insert_id;
		  			$consulta = "INSERT INTO TblLineasSim( `idLinea`, `idSim`, `fechaRegistro`) VALUES ('$almacen', '$idICC','$hoy')";
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
					return "El ICC ya existe.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}



		if($errores === 0){
			$consulta = "UPDATE tblSim a_b SET a_b.icc = '$sim' WHERE a_b.idSim = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblSim) AS a_b_2 WHERE a_b_2.icc = '$sim' AND a_b_2.idSim != '$id') AS count); ";
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
		$consulta="DELETE FROM tblSim  WHERE  `idSim`=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarSim(){
		$datos = array();
		$consulta="SELECT s.idSim as id,s.icc from tblSim s where not exists (select a.idSim from tblAsignaciones a where a.idSim = s.idSim)";
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