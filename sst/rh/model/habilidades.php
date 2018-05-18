<?php 
class habilidades
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT h.idHabilidades, h.habilidad,hi.nombreHabilidad FROM spartodo_rh.tblHabilidades h LEFT JOIN (SELECT hh.idHabilidad,hh.nombreHabilidad FROM spartodo_rh.tblHabilidadesHistorial hh where hh.idHabilidadesHistorial=(SELECT MAX(idHabilidadesHistorial) FROM spartodo_rh.tblHabilidadesHistorial WHERE idHabilidad=hh.idHabilidad)) hi ON hi.idHabilidad=h.idHabilidades";
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
			$consulta="SELECT h.idHabilidades,h.habilidad,hh.nombreHabilidad FROM spartodo_rh.tblHabilidades h LEFT JOIN (SELECT thh.nombreHabilidad,thh.idHabilidad FROM spartodo_rh.tblHabilidadesHistorial thh WHERE thh.idHabilidadesHistorial=(SELECT MAX(idHabilidadesHistorial) FROM spartodo_rh.tblHabilidadesHistorial WHERE idHabilidad=thh.idHabilidad)) hh ON hh.idHabilidad=h.idHabilidades WHERE h.idHabilidades='$id'";
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
			$consulta="SELECT thh.idHabilidadesHistorial,thh.idHabilidad,thh.fecha,thh.idUsuario,thh.nombreHabilidad,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno FROM spartodo_rh.tblHabilidadesHistorial thh LEFT JOIN spartodo_rh.tblHabilidades h ON h.idHabilidades=thh.idHabilidad LEFT JOIN spartodo_spar_bd.spar_empleados s ON s.empleados_numero_empleado=thh.idUsuario WHERE thh.idHabilidad='$id'";
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

	public function guardar($habilidad,$usuario){
		$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if (empty($habilidad)) {
			$errores ++;
			$errorResultado .= "El campo habilidad no puede estar vacío. <br>";
		}
		
		
		if($errores === 0){	
//Facilidad de palabra,Ejecucion de servicio en PDV
			$consulta = "INSERT INTO spartodo_rh.tblHabilidades(habilidad) SELECT * FROM (SELECT '$habilidad' AS habilidad) AS tmp WHERE NOT EXISTS (SELECT habilidad FROM spartodo_rh.tblHabilidades WHERE habilidad = '$habilidad') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
				$idHabilidad = $this->conexion->insert_id;
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
		  			$consulta2 = "INSERT INTO spartodo_rh.tblHabilidadesHistorial (`idHabilidad`, `fecha`, `idUsuario`, `nombreHabilidad`) VALUES ($idHabilidad,'$hoy',$usuario,'$habilidad');";
		  			$resultado2 = $this->conexion -> query($consulta2);
					if ($resultado2) {
						return "OK";
					}
				else 
					return "El habilidad ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$habilidad,$usuario,$idHabilidad){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		if (empty($habilidad)) {
			$errores ++;
			$errorResultado .= "El campo habilidad no puede estar vacío. <br>";
		}
		$modificaciones = 0;
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblHabilidades a_b SET a_b.habilidad = '$habilidad' WHERE a_b.idHabilidades = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_rh.tblHabilidades) AS a_b_2 WHERE a_b_2.habilidad = '$habilidad' AND a_b_2.idHabilidades != '$id') AS count);";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1){
			  		$consulta2 = "INSERT INTO spartodo_rh.tblHabilidadesHistorial (`idHabilidad`, `fecha`, `idUsuario`, `nombreHabilidad`) VALUES ($idHabilidad,'$hoy',$usuario,'$habilidad');";
					$resultado2 = $this->conexion -> query($consulta2);
					return "OK";
				}else{
					return "La campo habilidad ya existe o no se actualizó ningún dato. <br>";
				}		
			}else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminar($id){
		$idRegion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
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