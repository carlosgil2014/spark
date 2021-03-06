<?php 
class clientes
	{
 		protected $conexion;

		public function __construct() 
		{ 
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT idclientes, nombreComercial FROM tblClientes c ORDER BY nombreComercial";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos [] = $filaTmp;
			}
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function usuariosClientes($id){
			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
   			$datos = array();
   			$consulta="SELECT c.idclientes, c.nombreComercial FROM tblClientes c LEFT JOIN tblUsuariosClientes uc ON c.idclientes = uc.idCliente WHERE uc.idUsuario = '$id' ORDER BY nombreComercial";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		

   		public function informacion($id){
			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
   			$consulta="SELECT tipo, nombreComercial, calle, noInterior, noExterior, colonia, delegacion, pais, estado, cp, nombreContacto, telefonoContactoPrincipal, telefonoContactoSecundario, telefonoContactoOtro  FROM tblClientes c WHERE c.idclientes= '$id' LIMIT 1";
   			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}


   		public function guardar($datos){

			$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tipo"]))));
			$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["rfc"]))));
			
			if(isset($datos["apellidoPaterno"]))
				$apellidoPaterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoPaterno"]))));
			else
				$apellidoPaterno = NULL;
			if(isset($datos["apellidoMaterno"]))
				$apellidoMaterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoMaterno"]))));
			else
				$apellidoMaterno = NULL;
			if(isset($datos["nombres"]))
				$nombres = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombres"]))));
			else
				$nombres = NULL;
			$razonSocial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["razonSocial"]))));
			if(isset($datos["nombreComercial"]))
				$nombreComercial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreComercial"]))));
			else
				$nombreComercial = NULL;
			$calle = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["calle"]))));
			$noInterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noInterior"]))));
			if(isset($datos["noExterior"]))
				$noExterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noExterior"]))));
			else
				$noExterior = NULL;
			$colonia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["colonia"]))));
			$delegacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["delegacion"]))));
			if(isset($datos["pais"]))
				$pais = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["pais"]))));
			else 
				$pais = NULL;
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idEstado"]))));
			$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cp"]))));
			$nombreContacto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreContacto"]))));
			$telefonoContactoPrincipal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoContactoPrincipal"]))));
			if(isset($datos["telefonoContactoSecundario"]))
				$telefonoContactoSecundario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoContactoSecundario"]))));
			else
				$telefonoContactoSecundario = NULL;
			if(isset($datos["telefonoContactoOtro"]))
				$telefonoContactoOtro = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoContactoOtro"]))));
			else
				$telefonoContactoOtro = NULL;

			$errores = 0;
			$errorResultado = "";
			
			if(empty($tipo) || ($tipo != 1 && $tipo != 2 && $tipo != 3)) {
				$errores ++;
				$errorResultado .= "El campo tipo es incorrecto. <br>";
			}
			else{
				switch ($tipo) {
					case '1':
						if(empty($apellidoPaterno)) {
							$errores ++;
							$errorResultado .= "El campo Apellido Paterno no puede estar vacío. <br>";
						}

						if(empty($apellidoMaterno)) {
							$errores ++;
							$errorResultado .= "El campo Apellido Materno no puede estar vacío. <br>";
						}

						if(empty($nombres)) {
							$errores ++;
							$errorResultado .= "El campo Nombres no puede estar vacío. <br>";
						}
						break;
					
					default:
						if(empty($razonSocial)) {
							$errores ++;
							$errorResultado .= "El campo Razón Social no puede estar vacío. <br>";
						}
						break;
				}
			}

			if(empty($rfc) || (strlen($rfc) != 12 & strlen($rfc) != 13)) {
				$errores ++;
				$errorResultado .= "El campo R.F.C. es incorrecto. <br>";
			}

			

			if(empty($calle)) {
				$errores ++;
				$errorResultado .= "El campo Calle no puede estar vacío. <br>";
			}

			if(empty($noInterior)) {
				$errores ++;
				$errorResultado .= "El campo No. Interior no puede estar vacío. <br>";
			}

			if(empty($colonia)) {
				$errores ++;
				$errorResultado .= "El campo Colonia no puede estar vacío. <br>";
			}

			if(empty($delegacion)) {
				$errores ++;
				$errorResultado .= "El campo Delegación/Municipio no puede estar vacío. <br>";
			}

			if(isset($pais)){
				if(empty($pais)) {
					$errores ++;
					$errorResultado .= "El campo País es incorrecto. <br>";
				}
			}

			if(empty($estado)) {
				$errores ++;
				$errorResultado .= "El campo Estado no puede estar vacío. <br>";
			}

			if(empty($cp)) {
				$errores ++;
				$errorResultado .= "El campo C.P. no puede estar vacío. <br>";
			}

			if(empty($nombreContacto)) {
				$errores ++;
				$errorResultado .= "El campo Nombre (Contacto) no puede estar vacío. <br>";
			}

			if(empty($telefonoContactoPrincipal)) {
				$errores ++;
				$errorResultado .= "El campo Teléfono Principal (Contacto) no puede estar vacío. <br>";
			}

			if($errores === 0){
				$consulta = "INSERT INTO tblClientes( tipo, rfc, razonSocial,apellidoPaterno,apellidoMaterno,nombres, nombreComercial, calle, noInterior, noExterior, colonia, delegacion, pais, estado, cp, nombreContacto, telefonoContactoPrincipal, telefonoContactoSecundario, telefonoContactoOtro) SELECT * FROM (SELECT '$tipo' AS tipo, '$rfc' AS rfc, '$razonSocial' AS razonSocial,'$apellidoPaterno' AS apellidoPaterno,'$apellidoMaterno' AS apellidoMaterno,'$nombres' AS nombres,'$nombreComercial' AS nombreComercial, '$calle' AS calle, '$noInterior' AS noInterior, '$noExterior' AS noExterior, '$colonia' AS colonia, '$delegacion' AS delegacion, '$pais' AS pais, '$estado' AS estado, '$cp' AS cp, '$nombreContacto' AS nombreContacto, '$telefonoContactoPrincipal' AS telefonoContactoPrincipal, '$telefonoContactoSecundario' AS telefonoContactoSecundario, '$telefonoContactoOtro' AS telefonoContactoOtro) AS tmp WHERE NOT EXISTS (SELECT '$rfc' FROM tblClientes WHERE rfc = '$rfc') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1){
			  			return "OK";
			  		}
					else 
						return "El Cliente ya existe. <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

		public function actualizar($idCliente,$datos){
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
			$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tipo"]))));
			$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["rfc"]))));
			$razonSocial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["razonSocial"]))));
			
			
			if(isset($datos["nombres"]) && isset($datos["apellidoPaterno"]) && isset($datos["apellidoMaterno"])){
			$nombres= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombres"]))));
			$apellidoPaterno= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoPaterno"]))));
			$apellidoMaterno= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoMaterno"]))));
			}else{
				$nombres=NULL;
				$apellidoPaterno=NULL;
				$apellidoMaterno=NULL;
			}	

			if(isset($datos["nombreComercial"]))
				$nombreComercial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreComercial"]))));
			else
				$nombreComercial = NULL;
			$calle = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["calle"]))));
			$noInterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noInterior"]))));
			
			if(isset($datos["noExterior"]))
				$noExterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noExterior"]))));
			else
				$noExterior = NULL;
			$colonia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["colonia"]))));
			$delegacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["delegacion"]))));
			if(isset($datos["pais"]))
				$pais = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["pais"]))));
			else 
				$pais = NULL;
			$idEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idEstado"]))));
			$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cp"]))));
			$nombreContacto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreContacto"]))));
			$telefonoContactoPrincipal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoContactoPrincipal"]))));
			if(isset($datos["telefonoContactoSecundario"]))
				$telefonoContactoSecundario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoContactoSecundario"]))));
			else
				$telefonoContactoSecundario = NULL;
			if(isset($datos["telefonoContactoOtro"]))
				$telefonoContactoOtro = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoContactoOtro"]))));
			else
				$telefonoContactoOtro = NULL;
			
			$errores = 0;
			$errorResultado = "";
			
			if(!is_numeric($idCliente) || $idCliente <= 0){
				$errores ++;
				$errorResultado .= "El id del cliente es incorrecto. <br>";
			}

			if(empty($tipo) || ($tipo != 1 && $tipo != 2 && $tipo != 3)) {
				$errores ++;
				$errorResultado .= "El campo tipo es incorrecto. <br>";
			}else{
				switch ($tipo) {
					case '1':
						if(empty($apellidoPaterno)) {
							$errores ++;
							$errorResultado .= "El campo Apellido Paterno no puede estar vacío. <br>";
						}

						if(empty($apellidoMaterno)) {
							$errores ++;
							$errorResultado .= "El campo Apellido Materno no puede estar vacío. <br>";
						}

						if(empty($nombres)) {
							$errores ++;
							$errorResultado .= "El campo Nombres no puede estar vacío. <br>";
						}
						break;
					
					default:
						/*if(empty($razonSocial)) {
							$errores ++;
							$errorResultado .= "El campo Razón Social no puede estar vacío. <br>";
						}*/
						echo "se comento esta linea";
						break;
				}
			}

			if(empty($rfc) || (strlen($rfc) != 12 & strlen($rfc) != 13)) {
				$errores ++;
				$errorResultado .= "El campo R.F.C. es incorrecto. <br>";
			}

			
			if(empty($calle)) {
				$errores ++;
				$errorResultado .= "El campo Calle no puede estar vacío. <br>";
			}

			if(empty($noInterior)) {
				$errores ++;
				$errorResultado .= "El campo No. Interior no puede estar vacío. <br>";
			}

			if(empty($colonia)) {
				$errores ++;
				$errorResultado .= "El campo Colonia no puede estar vacío. <br>";
			}

			if(empty($delegacion)) {
				$errores ++;
				$errorResultado .= "El campo Delegación/Municipio no puede estar vacío. <br>";
			}

			if(isset($pais)){
				if(empty($pais)) {
					$errores ++;
					$errorResultado .= "El campo País es incorrecto. <br>";
				}
			}

			if(empty($idEstado)) {
				$errores ++;
				$errorResultado .= "El campo Estado no puede estar vacío. <br>";
			}

			if(empty($cp)) {
				$errores ++;
				$errorResultado .= "El campo C.P. no puede estar vacío. <br>";
			}

			if(empty($nombreContacto)) {
				$errores ++;
				$errorResultado .= "El campo Nombre (Contacto) no puede estar vacío. <br>";
			}

			if(empty($telefonoContactoPrincipal)) {
				$errores ++;
				$errorResultado .= "El campo Teléfono Principal (Contacto) no puede estar vacío. <br>";
			}


			if($errores === 0){
				$consulta = "UPDATE tblClientes p_1 SET p_1.tipo = '$tipo', p_1.rfc = '$rfc', p_1.razonSocial = '$razonSocial', p_1.apellidoPaterno = '$apellidoPaterno', p_1.apellidoMaterno = '$apellidoMaterno',p_1.nombres = '$nombres', p_1.nombreComercial = '$nombreComercial', p_1.calle = '$calle', p_1.noInterior = '$noInterior', p_1.noExterior = '$noExterior', p_1.colonia = '$colonia', p_1.delegacion = '$delegacion', p_1.pais = '$pais', p_1.estado = '$idEstado', p_1.cp = '$cp', p_1.nombreContacto = '$nombreContacto', p_1.telefonoContactoPrincipal = '$telefonoContactoPrincipal', p_1.telefonoContactoSecundario = '$telefonoContactoSecundario', p_1.telefonoContactoOtro = '$telefonoContactoOtro' WHERE p_1.idclientes = '$idCliente'";
				//var_dump($consulta);
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
					$filasModificadasClientes = $this->conexion->affected_rows;
				  	if($filasModificadasClientes === 1){
			  			return "OK";
			  		}
					else 
						return "El cliente ya existe o no se actualizó ningún dato. <br>";	
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

	public function rfc($rfc){
		$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
			$consulta="SELECT c.rfc from tblClientes c where c.rfc='$rfc'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function eliminar($idCliente){
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
			$consulta="DELETE FROM tblClientes WHERE idclientes = $idCliente";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   }
?>