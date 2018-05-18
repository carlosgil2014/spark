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
				$errorResultado .= "El usuario es incorrecto. <br>";
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

		public function cambiarPermiso($idUsuario, $idModuloPermiso, $valor){
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idUsuario)))));
			$idModuloPermiso = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idModuloPermiso)))));
			$valor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($valor)))));
			$hoy = date("Y-m-d H:i:s");
			$errores = 0;
			$errorResultado = "";

			if(!ctype_digit($idUsuario)){
				$errores ++;
				$errorResultado .= "El usuario es incorrecto. <br>";
			}

			if(!ctype_digit($idModuloPermiso)){
				$errores ++;
				$errorResultado .= "El módulo es incorrecto. <br>";
			}

			if($valor != 0 && $valor != 1){
				$errores ++;
				$errorResultado .= "El valor del permiso es incorrecto. <br>";
			}

			if($errores === 0){

				$consulta = "SELECT COUNT(pu.idModuloPermiso) AS count FROM spartodo_srs.tblPermisosUsuarios pu WHERE pu.idUsuario = '$idUsuario' AND pu.idModuloPermiso = '$idModuloPermiso'";
				$resultado = $this->conexion -> query($consulta);
				if($resultado){
					$filaTmp = $resultado->fetch_assoc();
				  	if($filaTmp["count"] === '0'){
						$consulta = "INSERT INTO spartodo_srs.tblPermisosUsuarios (idModuloPermiso, idUsuario, valor) VALUES('$idModuloPermiso', '$idUsuario', '$valor')";
						$resultado = $this->conexion -> query($consulta);
						if($resultado){
					  		if($this->conexion->affected_rows === 1){
					  			return "OK";
					  		}
							else 
								return "Error al guardar el permiso.";
						}
						else{
							return $this->conexion->errno . " : " . $this->conexion->error . "\n";
						}
					}
					else{
						$consulta = "UPDATE spartodo_srs.tblPermisosUsuarios SET valor = '$valor' WHERE idModuloPermiso = '$idModuloPermiso' AND idUsuario = '$idUsuario'";
						$resultado = $this->conexion -> query($consulta);
						if($resultado){
					  		if($this->conexion->affected_rows === 1){
					  			return "OK";
					  		}
							else 
								return "Error al actualizar el permiso.";
						}
						else{
							return $this->conexion->errno . " : " . $this->conexion->error . "\n";
						}
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