<?php 
class consultas
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function historialLinea($linea){
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($linea))));
		$datos = array();
		$errores = 0;
		$errorResultado = "";
		
		if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El campo búsqueda (línea) no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta="SELECT l.idLinea, l.linea, CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS empleado,'' AS departamento, '' AS region, '' AS estado, ma.marca, mo.modelo, a.fecha, c.imei,s.icc FROM tblLineas l LEFT JOIN tblAsignaciones a ON l.idLinea = a.idLinea LEFT JOIN tblSim s ON l.idSim = s.idSim LEFT JOIN tblCelurares c ON a.idCel = c.idCelular LEFT JOIN tblModelos mo ON c.idModelo = mo.idModelo LEFT JOIN tblMarcas ma ON mo.idMarca = ma.idMarca LEFT JOIN spar_empleados e ON a.idEmpleado = e.empleados_id WHERE l.linea = '$linea' ORDER BY a.fecha DESC";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($resultado->num_rows > 0){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos [] = $filaTmp;
					}
					return $datos;
				}
				else{
					return "No existen datos con la línea $linea";
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

	public function historialImei($imei){
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$datos = array();
		$errores = 0;
		$errorResultado = "";
		
		if (empty($imei)) {
			$errores ++;
			$errorResultado .= "El campo búsqueda (IMEI) no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta="SELECT l.idLinea, l.linea, CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS empleado,'' AS departamento, '' AS region, '' AS estado, ma.marca, mo.modelo, a.fecha, c.imei,s.icc FROM tblLineas l LEFT JOIN tblAsignaciones a ON l.idLinea = a.idLinea LEFT JOIN tblSim s ON l.idSim = s.idSim LEFT JOIN tblCelurares c ON a.idCel = c.idCelular LEFT JOIN tblModelos mo ON c.idModelo = mo.idModelo LEFT JOIN tblMarcas ma ON mo.idMarca = ma.idMarca LEFT JOIN spar_empleados e ON a.idEmpleado = e.empleados_id WHERE c.imei = '$imei' ORDER BY a.fecha DESC";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($resultado->num_rows > 0){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos [] = $filaTmp;
					}
					return $datos;
				}
				else{
					return "No existen datos con el IMEI $imei";
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

	public function historialSim($icc){
		$icc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($icc))));
		$datos = array();
		$errores = 0;
		$errorResultado = "";
		
		if (empty($icc)) {
			$errores ++;
			$errorResultado .= "El campo búsqueda (ICC) no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta="SELECT l.idLinea, l.linea, CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS empleado,'' AS departamento, '' AS region, '' AS estado, ma.marca, mo.modelo, a.fecha, c.imei,s.icc FROM tblLineas l LEFT JOIN tblAsignaciones a ON l.idLinea = a.idLinea LEFT JOIN tblSim s ON l.idSim = s.idSim LEFT JOIN tblCelurares c ON a.idCel = c.idCelular LEFT JOIN tblModelos mo ON c.idModelo = mo.idModelo LEFT JOIN tblMarcas ma ON mo.idMarca = ma.idMarca LEFT JOIN spar_empleados e ON a.idEmpleado = e.empleados_id WHERE s.icc = '$icc' ORDER BY a.fecha DESC";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($resultado->num_rows > 0){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos [] = $filaTmp;
					}
					return $datos;
				}
				else{
					return "No existen datos con la ICC $icc";
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

	public function historialEmpleado($idEmpleado){
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$datos = array();
		$errores = 0;
		$errorResultado = "";
		
		if (!ctype_digit($idEmpleado) || $idEmpleado < 0) {
			$errores ++;
			$errorResultado .= "El empleado es erróneo. <br>";
		}

		if($errores === 0){
			$consulta="SELECT l.idLinea, l.linea, CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS empleado,'' AS departamento, '' AS region, '' AS estado, ma.marca, mo.modelo, a.fecha, c.imei,s.icc FROM tblLineas l LEFT JOIN tblAsignaciones a ON l.idLinea = a.idLinea LEFT JOIN tblSim s ON l.idSim = s.idSim LEFT JOIN tblCelurares c ON a.idCel = c.idCelular LEFT JOIN tblModelos mo ON c.idModelo = mo.idModelo LEFT JOIN tblMarcas ma ON mo.idMarca = ma.idMarca LEFT JOIN spar_empleados e ON a.idEmpleado = e.empleados_id WHERE e.empleados_id = '$idEmpleado' ORDER BY a.fecha DESC";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($resultado->num_rows > 0){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos [] = $filaTmp;
					}
					return $datos;
				}
				else{
					return "No existen datos con el empleado seleccionado";
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

	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>