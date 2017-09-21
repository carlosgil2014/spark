<?php 
class proveedores
	{
 		protected $conexion;

		public function __construct() 
		{
		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT idproveedor, if(razonSocial='',CONCAT(nombres,' ',apellidoPaterno,' ',apellidoMaterno),razonSocial) AS razonSocial, nombreComercial, telefonoContactoPrincipal, b.nombre as bancoProveedor, noCuentaProveedor, clabeProveedor FROM tblProveedores p LEFT JOIN tblBancos b ON p.bancoProveedor = b.idbanco ";
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

   		public function informacion($idProveedor){
			$idProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProveedor))));
   			$consulta="SELECT tipo, rfc, razonSocial,nombres,apellidoPaterno,apellidoMaterno, nombreComercial, calle, noInterior, noExterior, colonia, delegacion, pais, estado, cp, nombreContacto, telefonoContactoPrincipal, telefonoContactoSecundario, telefonoContactoOtro, tipoProveedor, diasCredito, bancoProveedor, noCuentaProveedor, clabeProveedor FROM tblProveedores WHERE idproveedor = '$idProveedor'";
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
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estado"]))));
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
			$tipoProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tipoProveedor"]))));
			$diasCredito = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["diasCredito"]))));
			$bancoProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["bancoProveedor"]))));
			$noCuentaProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noCuentaProveedor"]))));
			$clabeProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["clabeProveedor"]))));


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

			if(empty($tipoProveedor)) {
				$errores ++;
				$errorResultado .= "El campo Tipo de Proveedor es incorrecto. <br>";
			}

			if(!is_numeric($diasCredito) || $diasCredito < 0){
				$errores ++;
				$errorResultado .= "El campo Dias de Crédito es incorrecto. <br>";
			}

			if(!isset($datos["metodosPago"]) || count($datos["metodosPago"]) <= 0){
				$errores ++;
				$errorResultado .= "El campo Métodos de pago es incorrecto. <br>";
			}
			else{
				foreach ($datos["metodosPago"] as $metodoPago) {
					$metodosPago[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($metodoPago))));
					if(!is_numeric($metodoPago) || $metodoPago <= 0){
						$errores ++;
						$errorResultado .= "El campo Métodos de pago es incorrecto. <br>";
						break;
					}
				}
			}

			if($errores === 0){
				$consulta = "INSERT INTO tblProveedores( tipo, rfc, razonSocial,apellidoPaterno,apellidoMaterno,nombres, nombreComercial, calle, noInterior, noExterior, colonia, delegacion, pais, estado, cp, nombreContacto, telefonoContactoPrincipal, telefonoContactoSecundario, telefonoContactoOtro, tipoProveedor, diasCredito, bancoProveedor, noCuentaProveedor, clabeProveedor) SELECT * FROM (SELECT '$tipo' AS tipo, '$rfc' AS rfc, '$razonSocial' AS razonSocial,'$apellidoPaterno' AS apellidoPaterno,'$apellidoMaterno' AS apellidoMaterno,'$nombres' AS nombres,'$nombreComercial' AS nombreComercial, '$calle' AS calle, '$noInterior' AS noInterior, '$noExterior' AS noExterior, '$colonia' AS colonia, '$delegacion' AS delegacion, '$pais' AS pais, '$estado' AS estado, '$cp' AS cp, '$nombreContacto' AS nombreContacto, '$telefonoContactoPrincipal' AS telefonoContactoPrincipal, '$telefonoContactoSecundario' AS telefonoContactoSecundario, '$telefonoContactoOtro' AS telefonoContactoOtro, '$tipoProveedor' AS tipoProveedor, '$diasCredito' AS diasCredito, '$bancoProveedor' AS bancoProveedor, '$noCuentaProveedor' AS noCuentaProveedor, '$clabeProveedor' AS clabeProveedor) AS tmp WHERE NOT EXISTS (SELECT rfc FROM tblProveedores WHERE rfc = '$rfc') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1){
			  			$idProveedor = $this->conexion->insert_id;
			  			return $this->guardarMetodosPago($idProveedor, $metodosPago);
			  		}
					else 
						return "El Proveedor ya existe. <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

		public function guardarMetodosPago($idProveedor, $metodosPago){
			$ok = 0;
			$consulta = "";
			foreach ($metodosPago as $metodoPago) {
				$consulta .= "INSERT INTO tblMetodosProveedores(idproveedor, idmetodopago) SELECT * FROM (SELECT '$idProveedor' AS idproveedor, '$metodoPago' AS idmetodopago) AS tmp WHERE NOT EXISTS (SELECT idproveedor FROM tblMetodosProveedores WHERE idproveedor = '$idProveedor' AND idmetodopago = '$metodoPago') LIMIT 1; ";
			}
			
			if ($this->conexion->multi_query($consulta))
			{
				$ok = 1;
			  do
			    {
			    if ($resultado = $this->conexion->store_result()) {
			      $resultado->free();
			      }
			    }
			  while (@$this->conexion->next_result());
			}

			if ($ok==1) {
				return "OK";
			}
			else{
   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   		}
			
		}

		public function informacionMetodosPago($idProveedor){
			$idProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProveedor))));
			$array = array();
   			$consulta="SELECT idmetodopago FROM tblMetodosProveedores WHERE idproveedor = '$idProveedor'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while($filaTmp = $resultado->fetch_assoc()){
					$array [] = $filaTmp["idmetodopago"];
				}
				return $array;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

		public function actualizar($idProveedor,$datos){
			$idProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProveedor))));
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
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estado"]))));
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
			
			$tipoProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tipoProveedor"]))));
			$diasCredito = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["diasCredito"]))));
			$bancoProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["bancoProveedor"]))));
			$noCuentaProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noCuentaProveedor"]))));
			$clabeProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["clabeProveedor"]))));

			

			$errores = 0;
			$errorResultado = "";
			
			if(!is_numeric($idProveedor) || $idProveedor <= 0){
				$errores ++;
				$errorResultado .= "El identificador del proveedor es incorrecto. <br>";
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

			if(empty($tipoProveedor)) {
				$errores ++;
				$errorResultado .= "El campo Tipo de Proveedor es incorrecto. <br>";
			}

			if(!is_numeric($diasCredito) || $diasCredito < 0){
				$errores ++;
				$errorResultado .= "El campo Dias de Crédito es incorrecto. <br>";
			}

			if(!isset($datos["metodosPago"]) || count($datos["metodosPago"]) <= 0){
				$errores ++;
				$errorResultado .= "El campo Métodos de pago es incorrecto. <br>";
			}
			else{
				foreach ($datos["metodosPago"] as $metodoPago) {
					$metodosPago[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($metodoPago))));
					if(!is_numeric($metodoPago) || $metodoPago <= 0){
						$errores ++;
						$errorResultado .= "El campo Métodos de pago es incorrecto. <br>";
						break;
					}
				}
			}

			if($errores === 0){
				$consulta = "UPDATE tblProveedores p_1 SET p_1.tipo = '$tipo', p_1.rfc = '$rfc', p_1.razonSocial = '$razonSocial', p_1.apellidoPaterno = '$apellidoPaterno', p_1.apellidoMaterno = '$apellidoMaterno',p_1.nombres = '$nombres', p_1.nombreComercial = '$nombreComercial', p_1.calle = '$calle', p_1.noInterior = '$noInterior', p_1.noExterior = '$noExterior', p_1.colonia = '$colonia', p_1.delegacion = '$delegacion', p_1.pais = '$pais', p_1.estado = '$estado', p_1.cp = '$cp', p_1.nombreContacto = '$nombreContacto', p_1.telefonoContactoPrincipal = '$telefonoContactoPrincipal', p_1.telefonoContactoSecundario = '$telefonoContactoSecundario', p_1.telefonoContactoOtro = '$telefonoContactoOtro', p_1.tipoProveedor = '$tipoProveedor', p_1.diasCredito = '$diasCredito', p_1.bancoProveedor = '$bancoProveedor', p_1.noCuentaProveedor = '$noCuentaProveedor', p_1.clabeProveedor = '$clabeProveedor' WHERE p_1.idproveedor = '$idProveedor' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblProveedores) AS p_2 WHERE p_2.rfc = '$rfc' AND p_2.idproveedor != '$idProveedor') AS count); ";
				
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
					$filasModificadasProveedores = $this->conexion->affected_rows;
				  	$metodosActualesPago = $this->informacionMetodosPago($idProveedor);
				  	if($filasModificadasProveedores === 1 || (count(array_intersect($metodosPago, $metodosActualesPago)) != count($metodosActualesPago)) || (count(array_intersect($metodosActualesPago, $metodosPago)) != count($metodosPago))){
						foreach ($metodosActualesPago as $metodoActualPago) {
							if(!in_array($metodoActualPago, $metodosPago)){
								$this->eliminarMetodosPago($metodoActualPago,$idProveedor);
							}
						}
			  			return $this->guardarMetodosPago($idProveedor, $metodosPago);
			  		}
					else 
						return "El proveedor ya existe o no se actualizó ningún dato. <br>";	
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

		public function eliminarMetodosPago($idMetodoPago,$idProveedor){
			$consulta="DELETE FROM tblMetodosProveedores WHERE idmetodopago = '$idMetodoPago' AND idproveedor = '$idProveedor'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}


		public function eliminar($idProveedor){
			$idProveedor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProveedor))));
			$consulta="DELETE FROM tblProveedores WHERE idproveedor = $idProveedor";
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