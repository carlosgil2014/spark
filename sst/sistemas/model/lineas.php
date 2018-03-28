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
		$consulta="SELECT l.idLinea, l.linea,s.idSim,s.icc,sa.estatus FROM tblLineas l left join tblSim s on s.idSim=l.idSim LEFT JOIN ( SELECT a1.idLinea,a1.estatus FROM tblAsignaciones a1 where a1.idAsignaciones=(SELECT MAX(idAsignaciones) FROM tblAsignaciones where idLinea=a1.idLinea)) sa ON sa.idLinea=l.idLinea";
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
			$consulta="SELECT l.idLinea,l.linea,l.idSim as IDSIM,s.idSim,s.icc as ICC,s.tipo,s.estado from tblLineas l left join tblSim s on s.idSim=l.idSim WHERE l.idLinea=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function historial($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$consulta="SELECT ls.IdLineaSim,ls.idLinea,ls.idSim,ls.fechaRegistro,l.linea,s.icc FROM tblLineasSim ls left join tblLineas l on l.idLinea=ls.idLinea left join tblSim s on ls.idSim=s.idSim WHERE ls.idLinea=$id ORDER BY ls.fechaRegistro DESC";
		echo $consulta;
		$resultado = $this->conexion->query($consulta);
		$datos = array();
		if($resultado){
			while($filaTmp = $resultado->fetch_assoc()) {
				$datos[] =  $filaTmp;
			}
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}
	 

	public function desbloquear($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="SELECT l.idLinea,l.idLinea,l.linea from tblLineas l WHERE l.idLinea=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}
	public function actualizarDesbloqueo($idLinea,$folio){
		$idLinea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idLinea))));
		$folio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($folio))));
		$errores = 0;
		$errorResultado = "";
		if(empty($idLinea)) {
			$errores ++;
			$errorResultado .= "El linea no puede estar vacío. <br>";	
		}
		if(empty($folio)) {
			$errores ++;
			$errorResultado .= "El folio no puede estar vacío. <br>";	
		}

		if($errores === 0){
			$consulta = "INSERT INTO tblFoliosLineas fl (`folio`, `idLinea`) VALUES ('$folio','$idLinea') ";
			$resultado = $this->conexion -> query($consulta);
			$consulta1 = "UPDATE tblAsignaciones a SET a.estatus='Activa' where a.idLinea=(SELECT Max(idLinea) FROM tblAsignaciones WHERE idAsignaciones=a.idAsignaciones)";
			$resultado1 = $this->conexion -> query($consulta1);
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
			$consulta = "INSERT INTO tblLineas (linea,idSim) SELECT * FROM (SELECT '$linea' AS linea,'$sim' AS sim) AS tmp WHERE NOT EXISTS (SELECT linea FROM tblLineas WHERE linea = '$linea') LIMIT 1; ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$idLinea = $this->conexion->insert_id;
		  			$consulta = "INSERT INTO tblLineasSim(idLinea, idSim, fechaRegistro) VALUES ('$idLinea', '$sim', '$hoy')";
					$resultado = $this->conexion -> query($consulta);
					if($resultado){
		  				if($this->conexion->affected_rows === 1){
		  					return "OK";
		  				}
		  				else{
		  					return "Error al guardar en SIM.";
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

		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$linea,$sim,$compararSim,$idLinea){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$sim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($sim))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El campo linea no puede estar vacío. <br>";
		}
		$modificaciones = 0;

		if($errores === 0){
			if($sim != $compararSim) {
				$consulta2 = "INSERT INTO tblLineasSim(idLinea, idSim, fechaRegistro) VALUES ('$idLinea', '$sim', '$hoy')";
				$resultado2 = $this->conexion -> query($consulta2);
				$modificaciones = $modificaciones+1; 
			}
			$consulta = "UPDATE tblLineas a_b SET a_b.linea = '$linea',a_b.idSim = '$sim' WHERE a_b.idLinea = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblLineas) AS a_b_2 WHERE a_b_2.linea = '$linea' AND a_b_2.idLinea != '$id') AS count);";
			echo $consulta;
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1){
			  		$modificaciones = $modificaciones+1;
			  	}
			}
			if($resultado || $resultado2){
			  	if($modificaciones == 1 || $modificaciones >= 1){
					return "OK";
			  	}
				else {
					return "La SIM ya existe o no se actualizó ningún dato. <br>";	
				}
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
		$consulta="SELECT l.idLinea, l.linea, l.idSim FROM tblLineas l INNER join tblSim s on s.idSim=l.idSim where not exists (select a.idLinea from tblAsignaciones a where l.idLinea = a.idLinea)";
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