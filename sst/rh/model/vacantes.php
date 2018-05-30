<?php 
class vacantes
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar($clientes){
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT COUNT(*) AS vacantes, COUNT(CASE WHEN v.estado = 'Solicitada' then 1 ELSE NULL END) AS solicitadas, COUNT(CASE WHEN v.estado = 'Cubierta' then 1 ELSE NULL END) AS cubiertas, COUNT(CASE WHEN v.estado = 'Cancelada' then 1 ELSE NULL END) AS canceladas, COUNT(CASE WHEN v.estado = 'Proceso' then 1 ELSE NULL END) AS proceso, COUNT(CASE WHEN v.estado = 'Búsqueda' then 1 ELSE NULL END) AS búsqueda, v.idCliente, v.idPresupuesto, v.idPerfil, v.idPuesto, v.fechaRegistro, v.fechaModificacion, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON pr.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idCliente IN ('$tmpClientes') GROUP BY v.idPresupuesto";
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

	public function informacionVacantesPresupuesto($idCliente, $idPresupuesto, $filasPorPagina){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$filasPorPagina = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($filasPorPagina))));
		$datos = array();
		$consulta="SELECT COUNT(*) AS vacantes, CEIL(COUNT(*)/$filasPorPagina) AS paginas, COUNT(CASE WHEN v.estado = 'Solicitada' then 1 ELSE NULL END) AS solicitadas, COUNT(CASE WHEN v.estado = 'Cubierta' then 1 ELSE NULL END) AS cubiertas, COUNT(CASE WHEN v.estado = 'Cancelada' then 1 ELSE NULL END) AS canceladas, COUNT(CASE WHEN v.estado = 'Proceso' then 1 ELSE NULL END) AS proceso, COUNT(CASE WHEN v.estado = 'Búsqueda' then 1 ELSE NULL END) AS búsqueda, v.idCliente, v.idPresupuesto, v.idPerfil, v.idPuesto, v.fechaRegistro, v.fechaModificacion, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON pr.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idCliente = '$idCliente' AND v.idPresupuesto = '$idPresupuesto' GROUP BY v.idPresupuesto";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos = $filaTmp;
			}
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarVacantes($clientes, $estado){
		$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($estado)))));
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT v.estado,v.idVacante, v.idCliente, v.idPresupuesto, v.idPerfil,	 pe.nombrePerfil AS perfil, v.idPuesto, v.fechaRegistro, v.folio, v.mes, v.anio, v.fechaModificacion, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON pr.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idCliente IN('$tmpClientes') AND v.estado = '$estado'";
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

	public function listarVacantesSolicitudBusquedas($clientes, $estado,$estado2){
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT v.estado,v.idVacante, v.idCliente, v.idPresupuesto, v.idPerfil,	 pe.nombrePerfil AS perfil, v.idPuesto, v.fechaRegistro, v.folio, v.mes, v.anio, v.fechaModificacion, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON pr.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE (v.idCliente IN('$tmpClientes') AND v.estado = '$estado') OR (v.idCliente IN('$tmpClientes') AND v.estado='$estado2') and not EXISTS (SELECT idVacante from spartodo_rh.tblVacantesPostuladas p where p.idVacante=v.idVacante)";
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

	public function informacionVacante($idPresupuesto, $idVacante){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idVacante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idVacante)))));
		$datos = "";
		$consulta="SELECT v.idVacante, v.fechaRegistro, v.estado, v.idPerfil, v.idPresupuesto, v.folio, v.mes, v.anio, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre AS puesto, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante, p.costoUnitario, pe.edad, pe.edadMaxima, v.idPuesto,pe.salario,pe.sexo,pe.escolaridad,pe.diasTrabajados,pe.experiencia,pe.conocimientosEspecificos,pe.habilidades,pe.paquetes FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestosPuestos p ON v.idPresupuestoPuesto = p.idPresupuestoPuesto LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON v.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idPresupuesto = '$idPresupuesto' AND v.idVacante = '$idVacante'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			$datos = $resultado->fetch_assoc();
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function informacionVacantes($idCliente, $idPresupuesto, $idPerfil, $idPuesto, $fechaModificacion){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idPerfil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPerfil)))));
		$idPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPuesto)))));
		$fechaModificacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(base64_decode(trim($fechaModificacion)))));
		$datos = array();
		$consulta="SELECT v.idVacante, v.fechaRegistro, v.fechaModificacion, v.estado, v.idPerfil, v.idPresupuesto, v.folio, v.mes, v.anio, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre AS puesto, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante, p.costoUnitario FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestosPuestos p ON v.idPresupuestoPuesto = p.idPresupuestoPuesto LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON v.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idPresupuesto = '$idPresupuesto' AND v.idCliente = '$idCliente' ORDER BY v.idVacante LIMIT 100";
		// echo $consulta;
		$resultado = $this->conexion->query($consulta);
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

	public function historial($idVacante){
		$idVacante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idVacante)))));
		$datos = array();
		$consulta="SELECT v.fechaRegistro, v.estado, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante FROM spartodo_rh.tblVacantesHistorial v LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idVacante = '$idVacante'";
		$resultado = $this->conexion->query($consulta);
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

	public function guardar($idCliente, $idPresupuesto, $idPresupuestoPuesto, $cantidad, $idPerfil, $idEmpleado){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idPresupuestoPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuestoPuesto)))));
		$idPerfil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPerfil)))));
		$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cantidad))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$mes = date("m");
		$año = date("y");
		$tmpSemana = new DateTime($hoy);
		$semana = $tmpSemana->format("W");
		$errores = 0;
		$errorResultado = "";

		if(!ctype_digit($idCliente)) {
			$errores ++;
			$errorResultado .= "El cliente es incorrecto. <br>";
		}

		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}

		if(!ctype_digit($idPresupuestoPuesto)) {
			$errores ++;
			$errorResultado .= "La fila del presupuesto es incorrecta. <br>";
		}

		if(!ctype_digit($idPerfil)) {
			$errores ++;
			$errorResultado .= "El perfil es incorrecto. <br>";
		}

		if(!ctype_digit($cantidad)) {
			$errores ++;
			$errorResultado .= "La $cantidad es incorrecta. <br>";
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}

		if($errores === 0){
			$consulta = "";
			for ($i = 0; $i < $cantidad; $i++) { 
				$consulta .="INSERT INTO spartodo_rh.tblVacantes(idCliente, idPresupuesto, idPresupuestoPuesto, idPerfil, idPuesto, idSolicitante, folio, semana, mes, anio, estado, fechaRegistro, fechaModificacion) (SELECT p.idCliente, pp.idPresupuesto, pp.idPresupuestoPuesto, '$idPerfil', pp.idPuesto, '$idEmpleado', COALESCE(MAX(v.folio),0) + 1, '$semana', '$mes', '$año', 'Solicitada', '$hoy', '$hoy' FROM spartodo_rh.tblPresupuestos p LEFT JOIN spartodo_rh.tblPresupuestosPuestos pp ON p.idPresupuesto = pp.idPresupuesto LEFT JOIN spartodo_rh.tblVacantes v ON p.idCliente = v.idCliente AND v.mes = '$mes' AND v.anio = '$año' WHERE  p.idCliente = '$idCliente' AND pp.idPresupuesto = '$idPresupuesto' AND pp.idPresupuestoPuesto = '$idPresupuestoPuesto'); INSERT INTO spartodo_rh.tblVacantesHistorial(idVacante, estado, idSolicitante, fechaRegistro) VALUES (LAST_INSERT_ID(), 'Solicitada', '$idEmpleado', '$hoy'); ";
			}

			if($this->conexion->multi_query($consulta) === TRUE) {
				do {					
				    if ($resultado = $this->conexion->store_result()) {
				        $resultado->free();
				    }
				} while ($this->conexion->more_results() && $this->conexion->next_result());
		  		return "OK";
			} else {
			    echo "Error: ".$this->conexion->error;
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function guardarPostulacion($solicitudes, $idVacantes){
		$solicitud = array();
		$vacante = array();
		foreach ($solicitudes as $solicitudA){
			$solicitud[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($solicitudA)))));
		}
		foreach ($idVacantes as $idVacanteA){
			$vacante[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idVacanteA)))));	
		}
		$cantidad = count($solicitud);
		$actual = date("Y-m-d H:i:s");
		$modificacion = date("Y-m-d H:i:s");

		$errores = 0;
		$errorResultado = "";
		
		if(empty($solicitud)) {
			$errores ++;
			$errorResultado .= "La solicitud no puede estar vacia.";
		}
		
		if(empty($vacante)) {
			$errores ++;
			$errorResultado .= "La vacante no puede estar vacia.";
		}

		if($errores === 0){
			$consulta = "";
			for ($i = 0; $i < $cantidad; $i++) { 
				$consulta .= "INSERT INTO spartodo_rh.tblVacantesPostuladas (idVacante,idSolicitudEmpleo,estado,fechaRegistro,fechaModificacion) SELECT * FROM (SELECT '$vacante[$i]' as idVacante, '$solicitud[$i]' as idSolicitudEmpleo,'Postulada' as estado,'$actual' as fechaRegistro,'$modificacion' as fechaModificacion) AS tmp WHERE NOT EXISTS (SELECT idSolicitudEmpleo FROM spartodo_rh.tblVacantesPostuladas WHERE idSolicitudEmpleo = '$solicitud[$i]') LIMIT 1; ";
			}

			if($this->conexion->multi_query($consulta) === TRUE) {
				do {					
				    if ($resultado = $this->conexion->store_result()) {
				        $resultado->free();
				    }
				} while ($this->conexion->more_results() && $this->conexion->next_result());
		  		return "OK";
			} else {
			    echo "Error: ".$this->conexion->error;
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function cancelar($idPresupuesto, $idVacante, $motivo, $idEmpleado){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idVacante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idVacante)))));
		$motivo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($motivo))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";

		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}

		if(!ctype_digit($idVacante)) {
			$errores ++;
			$errorResultado .= "La vacante es incorrecta. <br>";
		}

		if(empty($motivo)) {
			$errores ++;
			$errorResultado .= "El motivo de cancelación no puede estar vacío.<br>";
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}
		
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblVacantes SET estado = 'Cancelada', idSolicitante = '$idEmpleado', fechaModificacion = '$hoy' WHERE idVacante = '$idVacante' AND idPresupuesto = '$idPresupuesto'; INSERT INTO spartodo_rh.tblVacantesHistorial(idVacante, estado, idSolicitante, fechaRegistro) VALUES ('$idVacante', 'Cancelada', '$idEmpleado', '$hoy'); INSERT INTO spartodo_rh.tblVacantesCanceladas(idVacanteHistorial, motivo) VALUES (LAST_INSERT_ID(), '$motivo'); ";
			if($this->conexion->multi_query($consulta) === TRUE) {
				do {					
				    if ($resultado = $this->conexion->store_result()) {
				        $resultado->free();
				    }
				} while ($this->conexion->more_results() && $this->conexion->next_result());
		  		return "OK";
			} else {
			    echo "Error: ".$this->conexion->error;
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function cambiarEstado($idPresupuesto, $idVacante, $estado, $idEmpleado){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idVacante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idVacante)))));
		$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($estado)))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";

		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}

		if(!ctype_digit($idVacante)) {
			$errores ++;
			$errorResultado .= "La vacante es incorrecta. <br>";
		}

		if(empty($estado)) {
			$errores ++;
			$errorResultado .= "El estado de la vacante es incorrecto.<br>";
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}
		
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblVacantes SET estado = '$estado', idSolicitante = '$idEmpleado', fechaModificacion = '$hoy' WHERE idVacante = '$idVacante' AND idPresupuesto = '$idPresupuesto'; INSERT INTO spartodo_rh.tblVacantesHistorial(idVacante, estado, idSolicitante, fechaRegistro) VALUES ('$idVacante', '$estado', '$idEmpleado', '$hoy');";
			if($this->conexion->multi_query($consulta) === TRUE) {
				do {					
				    if ($resultado = $this->conexion->store_result()) {
				        $resultado->free();
				    }
				} while ($this->conexion->more_results() && $this->conexion->next_result());
		  		return "OK";
			} else {
			    echo "Error: ".$this->conexion->error;
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($idPresupuesto, $idVacante, $idPerfil, $idEmpleado){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idVacante = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idVacante)))));
		$idPerfil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPerfil)))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";

		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}

		if(!ctype_digit($idVacante)) {
			$errores ++;
			$errorResultado .= "La vacante es incorrecta. <br>";
		}

		if(!ctype_digit($idPerfil)) {
			$errores ++;
			$errorResultado .= "El perfil seleccionado es incorrecto.<br>";
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}
		
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblVacantes SET idPerfil = '$idPerfil', idSolicitante = '$idEmpleado' WHERE idVacante = '$idVacante' AND idPresupuesto = '$idPresupuesto'; ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$consulta = "UPDATE spartodo_rh.tblVacantes SET fechaModificacion = '$hoy' WHERE idVacante = '$idVacante' AND idPresupuesto = '$idPresupuesto'; ";
					$resultado = $this->conexion -> query($consulta);
					if($resultado){
		  				return "OK";
		  			}
		  			else{
						return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		  			}
		  		}
				else 
					return "No existe ningún cambio en la vacante.";
	 		}
			else {
			    echo "Error: ".$this->conexion->error;
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function listarMovimientosDia($clientes, $dia){
		$dia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dia))));
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT COUNT(*) AS vacantes, 1 AS ejeX,  COALESCE(COUNT(CASE WHEN v.estado = 'Solicitada' then 1 ELSE NULL END),0) AS solicitadas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cubierta' then 1 ELSE NULL END),0) AS cubiertas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cancelada' then 1 ELSE NULL END),0) AS canceladas,  COALESCE(COUNT(CASE WHEN v.estado = 'Proceso' then 1 ELSE NULL END),0) AS proceso,  COALESCE(COUNT(CASE WHEN v.estado = 'Búsqueda' then 1 ELSE NULL END),0) AS búsqueda FROM spartodo_rh.tblVacantesHistorial v LEFT JOIN spartodo_rh.tblVacantes vp ON v.idVacante = vp.idVacante WHERE DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d') = '$dia' AND vp.idCliente IN ('$tmpClientes') GROUP BY ejeX ORDER BY ejeX;";
		$resultado = $this->conexion->query($consulta);
		// echo $consulta;
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

	public function listarMovimientosSemana($clientes, $semana){
		$semana = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($semana))));
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT COUNT(*) AS vacantes, DAYOFWEEK(DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d')) AS ejeX,  COALESCE(COUNT(CASE WHEN v.estado = 'Solicitada' then 1 ELSE NULL END),0) AS solicitadas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cubierta' then 1 ELSE NULL END),0) AS cubiertas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cancelada' then 1 ELSE NULL END),0) AS canceladas,  COALESCE(COUNT(CASE WHEN v.estado = 'Proceso' then 1 ELSE NULL END),0) AS proceso,  COALESCE(COUNT(CASE WHEN v.estado = 'Búsqueda' then 1 ELSE NULL END),0) AS búsqueda FROM spartodo_rh.tblVacantesHistorial v LEFT JOIN spartodo_rh.tblVacantes vp ON v.idVacante = vp.idVacante WHERE WEEKOFYEAR(DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d')) = '$semana' AND vp.idCliente IN ('$tmpClientes') GROUP BY ejeX ORDER BY ejeX;";
		$resultado = $this->conexion->query($consulta);
		// echo $consulta;
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

	public function listarMovimientosMes($clientes, $mes){
		$mes = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($mes))));
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT COUNT(*) AS vacantes, DAYOFMONTH(DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d')) AS ejeX,  COALESCE(COUNT(CASE WHEN v.estado = 'Solicitada' then 1 ELSE NULL END),0) AS solicitadas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cubierta' then 1 ELSE NULL END),0) AS cubiertas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cancelada' then 1 ELSE NULL END),0) AS canceladas,  COALESCE(COUNT(CASE WHEN v.estado = 'Proceso' then 1 ELSE NULL END),0) AS proceso,  COALESCE(COUNT(CASE WHEN v.estado = 'Búsqueda' then 1 ELSE NULL END),0) AS búsqueda FROM spartodo_rh.tblVacantesHistorial v LEFT JOIN spartodo_rh.tblVacantes vp ON v.idVacante = vp.idVacante WHERE MONTH(DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d')) = '$mes' AND vp.idCliente IN ('$tmpClientes') GROUP BY ejeX ORDER BY ejeX;";
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
	
	public function listarMovimientosAño($clientes, $año){
		$año = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($año))));
		$datos = array();
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT COUNT(*) AS vacantes, MONTH(DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d')) AS ejeX,  COALESCE(COUNT(CASE WHEN v.estado = 'Solicitada' then 1 ELSE NULL END),0) AS solicitadas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cubierta' then 1 ELSE NULL END),0) AS cubiertas,  COALESCE(COUNT(CASE WHEN v.estado = 'Cancelada' then 1 ELSE NULL END),0) AS canceladas,  COALESCE(COUNT(CASE WHEN v.estado = 'Proceso' then 1 ELSE NULL END),0) AS proceso,  COALESCE(COUNT(CASE WHEN v.estado = 'Búsqueda' then 1 ELSE NULL END),0) AS búsqueda FROM spartodo_rh.tblVacantesHistorial v LEFT JOIN spartodo_rh.tblVacantes vp ON v.idVacante = vp.idVacante WHERE YEAR(DATE_FORMAT(v.fechaRegistro, '%Y-%m-%d')) = '$año' AND vp.idCliente IN ('$tmpClientes') GROUP BY ejeX ORDER BY ejeX;";
		$resultado = $this->conexion->query($consulta);
		// echo $consulta;
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

	public function paginacion($idCliente, $idPresupuesto,  $pagina){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$pagina = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($pagina)))));
		$datos = array();
		$tmpPagina = 1;
		if(!empty($pagina)) {
		    $tmpPagina = filter_var($pagina, FILTER_VALIDATE_INT);
		    if(false === $tmpPagina) {
		        $tmpPagina = 1;
		    }
		}

		$tmp = ($tmpPagina - 1) * 100;

		$consulta="SELECT v.idVacante, v.fechaRegistro, v.fechaModificacion, v.estado, v.idPerfil, v.idPresupuesto, v.folio, v.mes, v.anio, pr.nombre AS presupuesto, pe.nombrePerfil, c.nombreComercial, pu.nombre AS puesto, CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante, p.costoUnitario FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPresupuestosPuestos p ON v.idPresupuestoPuesto = p.idPresupuestoPuesto LEFT JOIN spartodo_rh.tblPresupuestos pr ON v.idPresupuesto = pr.idPresupuesto LEFT JOIN spartodo_rh.tblPerfiles pe ON v.idPerfil = pe.idPerfil LEFT JOIN tblClientes c ON v.idCliente = c.idclientes LEFT JOIN spartodo_rh.tblPuestos pu ON v.idPuesto = pu.idPuesto LEFT JOIN spar_empleados e ON v.idSolicitante = e.empleados_id WHERE v.idPresupuesto = '$idPresupuesto' AND v.idCliente = '$idCliente' ORDER BY v.idVacante LIMIT $tmp, 100";
		// echo $consulta;
		$resultado = $this->conexion->query($consulta);
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

	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	

}
?>