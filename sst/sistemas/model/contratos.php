<?php 
class contratos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function lineasCliente($idCliente){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
		$datos = array();
		$errores = 0;
		$errorResultado = "";
		
		if (!ctype_digit($idCliente) || $idCliente <= 0) {
			$errores ++;
			$errorResultado .= "El Cliente es incorrecto. <br>";
		}

		if($errores === 0){
			$consulta="SELECT l.idLinea, l.linea FROM tblLineas l LEFT JOIN tblContratos c ON l.idContrato = c.idContrato WHERE c.idCliente = $idCliente";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($resultado->num_rows > 0){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos [] = $filaTmp;
					}
					return $datos;
				}
				else{
					return 0;
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

	public function contratoLineas($idContrato){
		$idContrato = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idContrato))));
		$datos = array();
		$errores = 0;
		$errorResultado = "";
		
		if (!ctype_digit($idContrato) || $idContrato < 0) {
			$errores ++;
			$errorResultado .= "El Contrato es incorrecto. <br>";
		}

		if($errores === 0){
			$consulta="SELECT l.idLinea, l.linea, c.contrato FROM tblLineas l LEFT JOIN tblContratos c ON l.idContrato = c.idContrato WHERE l.idContrato = $idContrato AND CONVERT(l.linea, SIGNED INTEGER) ";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($resultado->num_rows > 0){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos [] = $filaTmp;
					}
					return $datos;
				}
				else{
					return "No existen datos de líneas buscadas.";
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

	public function verificarLineas($archivo){

		$datosResultado = array();
		$errores = 0;
		$errorResultado = "";
		if(pathinfo($archivo['name'], PATHINFO_EXTENSION) != "csv"){
			$errores ++;
			$errorResultado .= "La extensión del archivo es incorrecta. <br>";
		}

		if($errores === 0){
			if (($gestor = fopen($archivo['tmp_name'], "r")) !== FALSE) {
				$fila = 0;
	            while (($datos = fgetcsv($gestor, ",")) !== FALSE) {
	                $fila++;
	                $numero = count($datos);
	                if($numero != 1){
	                  	echo "Error: Únicamente debe existir una columna en el archivo";
	                  	break;
	                }
	                else{
						$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos[0]))));
	                	$consulta="SELECT l.idLinea, l.linea,IFNULL('Sin contrato',c.contrato) AS contrato, 'Existe en BD' AS estado FROM tblLineas l LEFT JOIN tblContratos c ON l.idContrato = c.idContrato WHERE l.linea = '$linea'";
						$resultado = $this->conexion->query($consulta);
						if($resultado){
							if($resultado->num_rows > 0){
								$datosResultado[] =  $resultado->fetch_assoc();
							}
							else{
								$datosResultado[] = array("idLinea" => "N/A", "linea" => $linea, "contrato" => "N/A", "estado" => "No existe en BD");
							}
						}
						else{
							echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
						}
	                }
	            }
				return $datosResultado;
	        }
		}
		else{
			echo $errorResultado;
		}
	}

	public function lineasDisponibles($lineasDisponibles, $lineasArchivo){
		$lineasFinales = array();
		$lineasArchivo = array_column($lineasArchivo, "linea");
		foreach ($lineasDisponibles as $tmp) {
			if(!in_array($tmp["linea"], $lineasArchivo)){
				$lineasFinales[] = $tmp;
			}
		}
		return $lineasFinales;
	}

	public function guardar($datosContrato, $idCliente, $de, $hasta){
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

	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>