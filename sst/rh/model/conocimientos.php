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
		$consulta="SELECT h.idConocimiento, h.conocimiento,hi.nombreConocimiento FROM spartodo_rh.tblConocimientos h LEFT JOIN (SELECT hh.idConocimiento,hh.nombreConocimiento FROM spartodo_rh.tblConocimientosHistorial hh where hh.idConocimientosHistorial=(SELECT MAX(idConocimientosHistorial) FROM spartodo_rh.tblConocimientosHistorial WHERE idConocimiento=hh.idConocimiento)) hi ON hi.idConocimiento=h.idConocimiento";
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
			$consulta="SELECT c.idConocimiento,c.conocimiento,cc.nombreConocimiento FROM spartodo_rh.tblConocimientos c LEFT JOIN (SELECT ch.nombreConocimiento,ch.idConocimiento FROM spartodo_rh.tblConocimientosHistorial ch WHERE ch.idConocimientosHistorial=(SELECT MAX(idConocimientosHistorial) FROM spartodo_rh.tblConocimientosHistorial WHERE idConocimiento=ch.idConocimiento)) cc ON cc.idConocimiento=c.idConocimiento WHERE cc.idConocimiento='$id'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function historiales($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="SELECT thh.idConocimientosHistorial,thh.idConocimiento,thh.fecha,thh.idUsuario,thh.nombreConocimiento,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno FROM spartodo_rh.tblConocimientosHistorial thh LEFT JOIN spartodo_rh.tblConocimientos h ON h.idConocimiento=thh.idConocimiento LEFT JOIN spartodo_spar_bd.spar_empleados s ON s.empleados_numero_empleado=thh.idUsuario WHERE thh.idConocimiento='$id'";
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

	public function guardar($conocimiento,$usuario){
		$conocimiento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimiento))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if (empty($conocimiento)) {
			$errores ++;
			$errorResultado .= "El campo conocimiento no puede estar vacío. <br>";
		}if (empty($usuario)) {
			$errores ++;
			$errorResultado .= "El campo usuario no puede estar vacío. <br>";
		}
		
		
		if($errores === 0){
			$consulta = "INSERT INTO spartodo_rh.tblConocimientos(conocimiento) SELECT * FROM (SELECT '$conocimiento' AS conocimiento) AS tmp WHERE NOT EXISTS (SELECT conocimiento FROM spartodo_rh.tblConocimientos WHERE conocimiento = '$conocimiento') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
				$idConocimiento = $this->conexion->insert_id;
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
		  			$consulta2 = "INSERT INTO spartodo_rh.tblConocimientosHistorial (`idConocimiento`, `fecha`, `idUsuario`, `nombreConocimiento`) VALUES ($idConocimiento,'$hoy',$usuario,'$conocimiento');";
		  			$resultado2 = $this->conexion -> query($consulta2);
		  			if ($resultado2) {
						return "OK";
					}
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

	public function actualizar($id,$conocimiento,$usuario,$idConocimiento){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$conocimiento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimiento))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		if (empty($conocimiento)) {
			$errores ++;
			$errorResultado .= "El campo conocimiento no puede estar vacío. <br>";
		}
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblConocimientos a_b SET a_b.conocimiento = '$conocimiento' WHERE a_b.idConocimiento = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_rh.tblConocimientos) AS a_b_2 WHERE a_b_2.conocimiento = '$conocimiento' AND a_b_2.idConocimiento != '$id') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1){
			  		$consulta2 = "INSERT INTO spartodo_rh.tblConocimientosHistorial (`idConocimiento`, `fecha`, `idUsuario`, `nombreConocimiento`) VALUES ($idConocimiento,'$hoy',$usuario,'$conocimiento');";
			  		echo $consulta2;
		  			$resultado2 = $this->conexion -> query($consulta2);
					return "OK";
				}else{ 
					return "El campo conocimiento ya existe o no se actualizó ningún dato. <br>";	
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