<?php 
	class permisos{
		
 		protected $conexion;

		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 
		
		public function listar($modulo, $idUsuario){
			$datos = array();
			$modulo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($modulo))));
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$consulta="SELECT p.nombre, pu.valor FROM spartodo_srs.tblModulos m LEFT JOIN spartodo_srs.tblModulosPermisos mp ON m.idModulo = mp.idModulo LEFT JOIN spartodo_srs.tblPermisos p ON mp.idPermiso = p.idPermiso LEFT JOIN spartodo_srs.tblPermisosUsuarios pu ON mp.idModuloPermiso = pu.idModuloPermiso WHERE m.nombre = '$modulo' AND pu.idUsuario = '$idUsuario'";
			$resultado = $this->conexion->query($consulta);
			// echo $consulta;
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					// var_dump($filaTmp);
					$datos[$filaTmp["nombre"]] = $filaTmp["valor"];
				}
				return $datos;
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}

		public function permisos($idUsuario){
			$datos = array();
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idUsuario)))));
			$errores = 0;
			$errorResultado = "";

			if(!ctype_digit($idUsuario)) {
				$errores ++;
				$errorResultado .= "El Usuario es incorrecto. <br>";
			}

			if($errores === 0){
				$consulta="SELECT mp.idModuloPermiso, m.nombre AS modulo, p.nombre AS permiso, IFNULL(pu.valor,0) AS valor FROM spartodo_srs.tblModulos m LEFT JOIN spartodo_srs.tblModulosPermisos mp ON m.idModulo = mp.idModulo LEFT JOIN spartodo_srs.tblPermisos p ON mp.idPermiso = p.idPermiso LEFT JOIN spartodo_srs.tblPermisosUsuarios pu ON mp.idModuloPermiso = pu.idModuloPermiso AND pu.idUsuario = $idUsuario GROUP BY mp.idModuloPermiso ORDER BY modulo, permiso";
				$resultado = $this->conexion->query($consulta);
				// echo $consulta;
				if($resultado){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos[] = $filaTmp;
					}
					return $datos;
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else
				return $errorResultado;
		}

		public function eliminarFilaPresupuesto($idPresupuesto, $idPresupuestoPuesto, $idEmpleado){
			$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
			$idPresupuestoPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuestoPuesto)))));
			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
			$hoy = date("Y-m-d H:i:s");
			$errores = 0;
			$errorResultado = "";

			if(!ctype_digit($idPresupuesto)){
				$errores ++;
				$errorResultado .= "El presupuesto es incorrecto. <br>";
			}

			if(!ctype_digit($idPresupuestoPuesto)){
				$errores ++;
				$errorResultado .= "La fila del presupuesto es incorrecta. <br>";
			}

			if(!ctype_digit($idEmpleado)){
				$errores ++;
				$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
			}

			if($errores === 0){

				$consulta = "SELECT COUNT(v.idVacante) AS vacantes FROM spartodo_rh.tblPresupuestosPuestos p LEFT JOIN spartodo_rh.tblVacantes v ON v.idPresupuestoPuesto = p.idPresupuestoPuesto WHERE p.idPresupuestoPuesto = '$idPresupuestoPuesto' AND p.idPresupuesto = '$idPresupuesto'";
				$resultado = $this->conexion -> query($consulta);
				if($resultado){
					$filaTmp = $resultado->fetch_assoc();
				  	if($filaTmp["vacantes"] === '0'){
						$consulta = "UPDATE spartodo_rh.tblPresupuestos SET fechaModificacion = '$hoy', idSolicitante = '$idEmpleado' WHERE idPresupuesto = '$idPresupuesto'";
						$resultado = $this->conexion -> query($consulta);
						if($resultado){
					  		if($this->conexion->affected_rows === 1){
					  			$consulta = "DELETE FROM spartodo_rh.tblPresupuestosPuestos WHERE idPresupuestoPuesto = '$idPresupuestoPuesto' AND idPresupuesto = '$idPresupuesto'";
								$resultado = $this->conexion -> query($consulta);
								if($resultado){
					  				if($this->conexion->affected_rows === 1){
					  					return "OK";
					  				}
					  				else
					  					return "No existe registro a borrar.";
					  			}
					  		}
							else 
								return "Error al guardar el presupuesto.";
						}
						else{
							return $this->conexion->errno . " : " . $this->conexion->error . "\n";
						}
					}
					else{
						return "Vacantes existentes.";
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

		public function __destruct() {
			mysqli_close($this->conexion);
		}
	}
?>