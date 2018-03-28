<?php 
class representantes
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT e.empleados_id,e.empleados_nombres,e.empleados_apellido_paterno,e.empleados_apellido_materno,e.empleados_rfc,e.empleados_curp,e.empleados_correo,Es.nombre,r.region,e.codigoPostal FROM spar_empleados e LEFT JOIN tblEstados Es ON e.empleados_estado=Es.idestado INNER JOIN tblRegiones r ON Es.region=r.idRegion INNER JOIN spartodo_rh.tblPuestos p ON e.empleados_puesto=p.idPuesto WHERE p.idPuesto=164 and e.empleados_vigente=1";
		$resultado = $this->conexion->query($consulta);
		while ($filaTmp = $resultado->fetch_assoc()) {
			$datos [] = $filaTmp;
		}
		if($resultado){
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function informacion($idRepresentante){
		$idRepresentante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idRepresentante))));
			$consulta="SELECT s.empleados_id,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,s.empleados_rfc,s.empleados_fecha_nacimiento,s.empleados_correo,s.codigoPostal as cp,s.calle,s.numeroInterior,s.numeroExterior,d.telefonoSecundario,d.telefonoAlterno,d.telefonoCasa,s.empleados_colonia,s.empleados_puesto,s.empleados_estado,p.nombre as puesto FROM spar_empleados s left join tblDirectorio d ON d.idUsuario=s.empleados_id inner join spartodo_rh.tblPuestos p ON p.idPuesto=s.empleados_puesto inner JOIN tblEstados Es On Es.idestado=s.empleados_estado INNER JOIN tblRegiones reg ON reg.idRegion=Es.region where s.empleados_id=$idRepresentante";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($datos){

			$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["rfc"]))));
			$nombres = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombres"]))));
			$apellidoPaterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoPaterno"]))));
			$apellidoMaterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoMaterno"]))));
			$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cp"]))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estado"]))));
			$delegacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["delegacion"]))));
			$colonia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["colonia"]))));
			$region = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["region"]))));
			$fechaNacimiento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaNacimiento"]))));
			$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
			$correo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["correo"]))));
			$idEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idEstado"]))));
			$rfc = strtoupper($rfc);

			if(isset($datos["calle"]))
				$calle = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["calle"]))));
			else
				$calle = NULL;
			if(isset($datos["noInterior"]))
				$noInterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noInterior"]))));
			else
				$noInterior = NULL;
			if(isset($datos["noExterior"]))
				$noExterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noExterior"]))));
			else
				$noExterior = NULL;
			if(isset($datos["celular"]))
				$celular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["celular"]))));
			else
				$celular = NULL;
			if(isset($datos["telefonoCasa"]))
				$telefonoCasa = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoCasa"]))));
			else
				$telefonoCasa = NULL;
			if(isset($datos["telefonoAlterno"]))
				$telefonoAlterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoAlterno"]))));
			else
				$telefonoAlterno = NULL;

		$errores = 0;
		$errorResultado = "";
		$vigente=1;
		$empresa = "campo";
		$fechaBaja="";
		$puestoId=164;

		if (empty($rfc)) {
			$errores ++;
			$errorResultado .= "El campo rfc no puede estar vacío. <br>";
		}if (empty($nombres)) {
			$errores ++;
			$errorResultado .= "El campo nombres no puede estar vacío. <br>";
		}if (empty($apellidoPaterno)) {
			$errores ++;
			$errorResultado .= "El campo apellido paterno no puede estar vacío. <br>";
		}if (empty($apellidoMaterno)) {
			$errores ++;
			$errorResultado .= "El campo apellido materno no puede estar vacío. <br>";
		}if (empty($cp)) {
			$errores ++;
			$errorResultado .= "El campo codigo postal no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El campo estado no puede estar vacío. <br>";
		}if (empty($delegacion)) {
			$errores ++;
			$errorResultado .= "El campo delegacion no puede estar vacío. <br>";
		}if (empty($colonia)) {
			$errores ++;
			$errorResultado .= "El campo colonia no puede estar vacío. <br>";
		}if (empty($region)) {
			$errores ++;
			$errorResultado .= "El campo region no puede estar vacío. <br>";
		}if (empty($colonia)) {
			$errores ++;
			$errorResultado .= "El campo colonia no puede estar vacío. <br>";
		}if (empty($delegacion)) {
			$errores ++;
			$errorResultado .= "El campo delegacion no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El campo estado no puede estar vacío. <br>";
		}if (empty($fechaNacimiento)) {
			$errores ++;
			$errorResultado .= "El campo fecha de nacimiento no puede estar vacío. <br>";
		}if (empty($puestoId)) {
			$errores ++;
			$errorResultado .= "El campo puesto no puede estar vacío. <br>";
		}if (empty($correo)) {
			$errores ++;
			$errorResultado .= "El campo correo no puede estar vacío. <br>";
		}if (empty($idEstado)) {
			$errores ++;
			$errorResultado .= "El campo  no puede estar vacío. <br>";
		}				

		if($errores === 0){
			$consulta = "INSERT INTO `spar_empleados`
(`empleados_contrasena`, `empleados_numero_empleado`, `empleados_nombres`, `empleados_apellido_paterno`, `empleados_apellido_materno`, `empleados_rfc`, `empleados_curp`, `empleados_vigente`, `empleados_fecha_nacimiento`, `empleados_fecha_baja`, `empleados_puesto`, `empleados_correo`, `empleados_ultimo_ingreso`, `empleados_empresa`, `empleados_confirmacion_datos`, `empleados_gastos`, `empleados_encontrado_supernomina`, `empleados_estado`,`codigoPostal`,`calle`,`numeroInterior`,`numeroExterior`,`empleados_colonia`) SELECT * FROM (SELECT '' AS contraseña,'' AS numeroEmpleado,'$nombres' AS nombres,'$apellidoPaterno' AS apellidoPaterno,'$apellidoMaterno' AS apellidoMaterno,'$rfc' AS rfc,'' AS curp,'$vigente' AS vigente,'$fechaNacimiento' AS fechaNacimiento,'0000-00-00' AS fechaBaja,'$puestoId' AS puesto,'$correo' AS correo,'0000-00-00 00:00:00' AS ultimoIngreso,'$empresa' AS empresa,'0' AS confirmacionDatos,'0' AS gastosEmpleados,'0' AS superNomina,'$idEstado' AS idEstado,'$cp' AS cp,'$calle' AS calle,'$noInterior' AS noInterior,'$noExterior' AS noExterior, $colonia AS colonia) AS tmp WHERE NOT EXISTS (SELECT '$rfc' FROM spar_empleados WHERE empleados_rfc = '$rfc') LIMIT 1";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$consulta2="INSERT INTO tblDirectorio(idUsuario, telefono, telefonoSecundario, telefonoExtencion, telefonoAlterno, telefonoCasa, region, activo) ( SELECT MAX(empleados_id) as idUsuario,'' as telefono,'$celular' as celular,'' as telefonoExtencion,'$telefonoAlterno' as telefonoAlterno,'$telefonoCasa' as telefonoCasa,'$idEstado' as idEstado,1 as activo FROM spar_empleados)";
					$resultado2 = $this->conexion -> query($consulta2);
					return "OK";
		  		}else{ 
					return "El representante ya existe. <br>";
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

	public function actualizar($idRepresentante,$datos){
			$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["rfc"]))));
			$nombres = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombres"]))));
			$apellidoPaterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoPaterno"]))));
			$apellidoMaterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoMaterno"]))));
			$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cp"]))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estado"]))));
			$delegacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["delegacion"]))));
			$colonia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["colonia"]))));
			$region = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["region"]))));
			$fechaNacimiento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaNacimiento"]))));
			$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
			$correo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["correo"]))));
			$idEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idEstado"]))));

			if(isset($datos["calle"]))
				$calle = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["calle"]))));
			else
				$calle = NULL;
			if(isset($datos["noInterior"]))
				$noInterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noInterior"]))));
			else
				$noInterior = NULL;
			if(isset($datos["noExterior"]))
				$noExterior = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["noExterior"]))));
			else
				$noExterior = NULL;
			if(isset($datos["celular"]))
				$celular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["celular"]))));
			else
				$celular = NULL;
			if(isset($datos["telefonoCasa"]))
				$telefonoCasa = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoCasa"]))));
			else
				$telefonoCasa = NULL;
			if(isset($datos["telefonoAlterno"]))
				$telefonoAlterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoAlterno"]))));
			else
				$telefonoAlterno = NULL;

		$errores = 0;
		$errorResultado = "";
		$empresa = "campo";

		if (empty($rfc)) {
			$errores ++;
			$errorResultado .= "El campo rfc no puede estar vacío. <br>";
		}if (empty($nombres)) {
			$errores ++;
			$errorResultado .= "El campo nombres no puede estar vacío. <br>";
		}if (empty($apellidoPaterno)) {
			$errores ++;
			$errorResultado .= "El campo apellido paterno no puede estar vacío. <br>";
		}if (empty($apellidoMaterno)) {
			$errores ++;
			$errorResultado .= "El campo apellido materno no puede estar vacío. <br>";
		}if (empty($cp)) {
			$errores ++;
			$errorResultado .= "El campo codigo postal no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El campo estado no puede estar vacío. <br>";
		}if (empty($delegacion)) {
			$errores ++;
			$errorResultado .= "El campo delegacion no puede estar vacío. <br>";
		}if (empty($colonia)) {
			$errores ++;
			$errorResultado .= "El campo colonia no puede estar vacío. <br>";
		}if (empty($region)) {
			$errores ++;
			$errorResultado .= "El campo region no puede estar vacío. <br>";
		}if (empty($colonia)) {
			$errores ++;
			$errorResultado .= "El campo colonia no puede estar vacío. <br>";
		}if (empty($delegacion)) {
			$errores ++;
			$errorResultado .= "El campo delegacion no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El campo estado no puede estar vacío. <br>";
		}if (empty($fechaNacimiento)) {
			$errores ++;
			$errorResultado .= "El campo fecha de nacimiento no puede estar vacío. <br>";
		}if (empty($puesto)) {
			$errores ++;
			$errorResultado .= "El campo puesto no puede estar vacío. <br>";
		}if (empty($correo)) {
			$errores ++;
			$errorResultado .= "El campo correo no puede estar vacío. <br>";
		}if (empty($idEstado)) {
			$errores ++;
			$errorResultado .= "El campo  estado no puede estar vacío. <br>";
		}		


		$modificaciones = 0;
		if($errores === 0){
			if (!empty($celular) || !empty($telefonoAlterno) || !empty($telefonoCasa)) {
				$consulta2 = "UPDATE tblDirectorio d SET d.telefonoSecundario='$celular',d.telefonoAlterno='$telefonoAlterno',d.telefonoCasa='$telefonoCasa' WHERE d.idUsuario=$idRepresentante";
			  			$resultado2 = $this->conexion -> query($consulta2);
			  			if($resultado2){
			  				if($this->conexion->affected_rows === 1){
			  					$modificaciones = 1;
			  				}
			  			}
			  			
			}
			$consulta = "UPDATE spar_empleados a_b SET a_b.empleados_nombres = '$nombres',a_b.empleados_apellido_paterno='$apellidoPaterno',a_b.empleados_apellido_materno='$apellidoMaterno',a_b.empleados_rfc='$rfc',a_b.empleados_fecha_nacimiento='$fechaNacimiento',a_b.empleados_correo='$correo',a_b.empleados_estado='$idEstado',a_b.codigoPostal='$cp',a_b.calle='$calle',a_b.numeroInterior='$noInterior',a_b.numeroExterior='$noExterior',a_b.empleados_colonia='$colonia' WHERE a_b.empleados_id='$idRepresentante' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spar_empleados) AS a_b_2 WHERE a_b_2.empleados_rfc = '$rfc' AND a_b_2.empleados_id != '$idRepresentante') AS count);";
				$resultado = $this->conexion -> query($consulta);
				
				if($resultado){
			  		if($this->conexion->affected_rows === 1){
			  			$modificaciones = 1;
			  		}
			  	}
			if($resultado || $resultado2){

			  		if($modificaciones ===1){
			  			return "OK";
			  		}
					else{
						return "No se hicieron modificaciones.";
					}

				}else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}



	public function eliminar($idRepresentante){
		$idRepresentante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idRepresentante))));
		$fecha_actual=date("Y/m/d");
		$consulta="UPDATE spar_empleados s SET s.empleados_vigente=0,s.empleados_fecha_baja='$fecha_actual' WHERE s.empleados_id=$idRepresentante";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function buscar($cp){
		$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cp))));
			$consulta="SELECT cp.estado as idEstado,cp.delegacion,Es.nombre as estado,r.region,cp.cp  FROM tblCP cp INNER JOIN tblEstados Es ON Es.idestado=cp.estado INNER JOIN tblRegiones r ON r.idRegion=Es.region WHERE cp.cp=$cp limit 1";
		$resultado = $this->conexion->query($consulta);
		if($resultado){

			if($this->conexion->affected_rows === 1){
			$datos = $resultado->fetch_assoc();
			$datos['colonias']= $this->listarColonias($cp);
			 return $datos;
			}else{
				return "error";	
			}
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarColonias($cp){
		$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cp))));
		$datos = array();
		$consulta="SELECT cp.idcp,cp.asentamiento FROM tblCP cp WHERE cp.cp=$cp ORDER BY cp.asentamiento";
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

	public function listarPuestos(){
		$datos = array();
		$consulta="SELECT p.idPuesto, p.nombre as puesto FROM spartodo_rh.tblPuestos p ORDER BY `p`.`nombre` ASC";
		$resultado = $this->conexion->query($consulta);
		while ($filaTmp = $resultado->fetch_assoc()) {
			$datos [] = $filaTmp;
		}
		if($resultado){
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}


	public function rfcEmpleado($rfc){
		$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
			$consulta="SELECT s.empleados_rfc from spar_empleados s  where s.empleados_rfc='$rfc' and s.empleados_vigente=1";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			if($this->conexion->affected_rows === 1){
			$datos = $resultado->fetch_assoc();
			 return $datos;
			}else{
				return "error";	
			}

			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}

	}

	public function rfc($rfc){
		$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
			$consulta="SELECT s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,s.codigoPostal,s.empleados_rfc,s.empleados_estado,s.calle,s.numeroInterior,s.numeroExterior,cp.asentamiento,cp.delegacion,cp.estado,Es.nombre from spar_empleados s INNER JOIN tblCP cp ON s.empleados_colonia=cp.idcp inner join tblEstados Es on Es.idestado=cp.estado where s.empleados_rfc='$rfc'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			if($this->conexion->affected_rows === 1){
			$datos = $resultado->fetch_assoc();
			$datos['colonias']= $this->listarAsentamientos($rfc);
			 return $datos;
			}else{
				return "error";	
			}

			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}

	}

	public function listarAsentamientos($rfc){
		$cp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
		$datos = array();
		$consulta="SELECT cp.idcp,cp.asentamiento FROM spar_empleados s INNER JOIN tblCP cp ON cp.cp=s.codigoPostal where s.empleados_rfc='$rfc'";
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
		
	public function rfcNoVigente($rfc){
		$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
			$consulta="SELECT s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,s.codigoPostal,s.empleados_rfc,s.empleados_estado,s.calle,s.numeroInterior,s.numeroExterior,cp.asentamiento,cp.delegacion,cp.estado,Es.nombre from spar_empleados s INNER JOIN tblCP cp ON s.empleados_colonia=cp.idcp inner join tblEstados Es on Es.idestado=cp.estado where s.empleados_rfc='$rfc' and s.empleados_vigente=0";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			if($this->conexion->affected_rows === 1){
			$datos = $resultado->fetch_assoc();
			$datos['colonias']= $this->listarAsentamientos($rfc);
			 return $datos;
			}else{
				return "error";	
			}

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