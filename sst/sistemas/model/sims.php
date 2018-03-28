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
		$consulta="SELECT s.idSim, s.icc, a.nombre AS almacen, s.tipo, s.estado  FROM tblSim s LEFT JOIN (SELECT s1.idSim, s1.idAlmacen FROM tblSimsAlmacen s1 WHERE s1.idSimAlmacen = (SELECT MAX(idSimAlmacen) FROM tblSimsAlmacen WHERE idSim = s1.idSim)) sa ON s.idSim = sa.idSim LEFT JOIN tblAlmacen a ON sa.idAlmacen = a.idAlmacen";
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

	public function informacion($idSim){
		$idSim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idSim)))));
		$consulta="SELECT s.idSim, s.icc, a.idAlmacen, s.estado, s.tipo, sa.estado AS estadoHistorial FROM tblSim s LEFT JOIN (SELECT s1.idSim, s1.idAlmacen, s1.estado FROM tblSimsAlmacen s1 WHERE s1.idSimAlmacen = (SELECT MAX(idSimAlmacen) FROM tblSimsAlmacen WHERE idSim = s1.idSim)) sa ON s.idSim = sa.idSim LEFT JOIN tblAlmacen a ON sa.idAlmacen = a.idAlmacen WHERE s.idSim = '$idSim'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function historial($idSim){
		$idSim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idSim)))));
		$consulta="SELECT a.nombre, sa.estado, sa.fechaRegistro, a.ubicacion, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno,' ', e.empleados_apellido_materno) AS usuario FROM tblSimsAlmacen sa LEFT JOIN tblAlmacen a ON sa.idAlmacen = a.idAlmacen LEFT JOIN tblUsuarios u ON sa.idUsuario = u.usuarios_id LEFT JOIN spartodo_spar_bd.spar_empleados e ON u.usuarios_empleados_id = e.empleados_id WHERE sa.idSim = '$idSim' ORDER BY sa.fechaRegistro DESC";
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

	public function guardar($icc, $almacen, $tipo, $idUsuario){
		$icc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($icc))));
		$almacen = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($almacen))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
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

		if(empty($tipo)) {
			$errores ++;
			$errorResultado .= "El tipo de SIM es incorrecto.";
		}

		if(!ctype_digit($idUsuario)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente.";
		}

		if($errores === 0){
			$consulta = "INSERT INTO tblSim(icc, tipo) SELECT * FROM (SELECT '$icc', '$tipo') AS tmp WHERE NOT EXISTS (SELECT icc FROM tblSim WHERE icc = '$icc') LIMIT 1; ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$idICC = $this->conexion->insert_id;
		  			$consulta = "INSERT INTO tblSimsAlmacen(idAlmacen, idSim, idUsuario, estado, fechaRegistro) VALUES ('$almacen', '$idICC', '$idUsuario', 'Activa', '$hoy')";
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
					return "El ICC ya existe en la base de datos.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($idSim, $icc, $almacen, $tipo, $estado, $idUsuario){

		$datosTmp = $this->informacion($idSim);
		$idSim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idSim)))));
		$icc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($icc))));
		$almacen = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($almacen))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
		$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
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

		if(empty($tipo)) {
			$errores ++;
			$errorResultado .= "El tipo de SIM es incorrecto.";
		}

		if(empty($estado)) {
			$errores ++;
			$errorResultado .= "El estado de la SIM es incorrecto.";
		}

		if(!ctype_digit($idUsuario)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente.";
		}

		if($errores === 0){
			$consulta = "UPDATE tblSim SET icc = '$icc', tipo = '$tipo' , estado = '$estado' WHERE idSim = '$idSim' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblSim) AS a_b_2 WHERE icc = '$icc' AND idSim != '$idSim') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
				if($estado != "Activa"){
					$resultado = $this->validarSimLinea($idSim);	
					if($resultado != "OK"){
						return $resultado;
					}
				}
				$simActualizado = $this->conexion->affected_rows;
				if($almacen != $datosTmp["idAlmacen"] || $estado != $datosTmp["estadoHistorial"]){
		  			$consulta = "INSERT INTO tblSimsAlmacen(idAlmacen, idSim, idUsuario, estado, fechaRegistro) VALUES ('$almacen', '$idSim', '$idUsuario', '$estado', '$hoy')";
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
				else{
					if($simActualizado === 1){
						return "Se actualizó correctamente la SIM.";
					}
					else
						return "El ICC ya existe o no se actualizó ningún dato.";
				}
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
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

	public function listarSimActivas(){
		$datos = array();
		$consulta="SELECT s.idSim,s.icc FROM tblSim s where not exists (select ls.idSim from tblLineas ls where s.idSim = ls.idSim) and s.estado='Activa'";
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

	public function validarSimLinea($idSim){
		$idSim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idSim))));
		$hoy = date("Y-m-d H:i:s");
		$consulta = "SELECT idLinea FROM tblLineas WHERE idSim = '$idSim'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			if($this->conexion->affected_rows === 1){
				$datosTmp = $resultado->fetch_assoc();
				$idLinea = $datosTmp["idLinea"];
				$consulta = "UPDATE tblLineas SET idSim = 0 WHERE idSim = '$idSim'";
				$resultado = $this->conexion->query($consulta);
				if($resultado){
					$consulta = "INSERT INTO tblLineasSim(idLinea, idSim, fechaRegistro) VALUES ('$idLinea', '0', '$hoy')";
					$resultado = $this->conexion->query($consulta);	
					if($resultado){
						return "OK";
					}
					else{
						return $this->conexion->errno . " : " . $this->conexion->error . "\n";
					}	
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return "OK";
			}
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function buscarICC($idLinea){
		$idLinea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idLinea))));
		$consulta="SELECT s.idSim,s.icc FROM tblSim s inner join tblLineas l on l.idSim=s.idSim where l.idLinea=$idLinea";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
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