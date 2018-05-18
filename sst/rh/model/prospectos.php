<?php 
class prospectos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT p.idPerfil,p.fechaSolicitud, p.nombrePerfil, p.edad, p.sexo, p.escolaridad, p.estadoCivil, p.experiencia, p.imagen, p.talla, p.entrevistaCliente, p.conocimientosEspecificos, p.habilidades, p.evaluaciones,CONCAT(e.empleados_nombres,' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS solicitante,cl.nombreComercial FROM spartodo_rh.tblPerfiles p left join spartodo_spar_bd.spar_empleados s on p.idSolicitante=s.empleados_id left join spartodo_spar_bd.tblClientes cl on cl.idclientes=p.idCliente";
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

	public function prospectos($vacante){
		$datos = array();
		$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($vacante["idPuesto"]))));
		$sexo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($vacante["sexo"]))));
		$diasTrabajados = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($vacante["diasTrabajados"]))));
		$edad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($vacante["edad"]))));
		$edadMaxima = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($vacante["edadMaxima"]))));
		$experiencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($vacante["experiencia"]))));
		$consulta="SELECT se.idSolicitudEmpleo,se.nombresDatosPersonales,se.apellidoPaternoDatosPersonales,se.apellidoMaternoDatosPersonales,se.puesto,se.sueldo,se.diasTrabajados,se.idPromocion,se.edad,se.sexo,ae.ultimoGradoEstudios,se.experienciaPuesto,ae.habilidades,ae.paquetesLenguajes,ae.conocimientosEspecificos,es.escolaridad,es.idEscolaridad FROM spartodo_rh.tblSolicitudEmpleo se left join spartodo_rh.tblAcademiaExperiencia ae ON ae.idSolicitudEmpleo=se.idSolicitudEmpleo LEFT JOIN spartodo_rh.tblEscolaridad es on es.idEscolaridad=ae.ultimoGradoEstudios WHERE se.sexo = '$sexo' AND se.diasTrabajados='$diasTrabajados'  and $edad<=se.edad and '$edadMaxima'>=se.edad and se.estado='Activa' AND '$experiencia'<=se.experienciaPuesto AND se.puesto = $puesto and se.rfc not in (SELECT empleados_rfc from spartodo_spar_bd.spar_empleados) limit 10";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			while ($filaTmp = $resultado->fetch_assoc()) {
				$tmpPuntaje = $this->match($vacante,$filaTmp);
				if($tmpPuntaje >= 5){
					$filaTmp["puntaje"] = $tmpPuntaje;
					$datos [] = $filaTmp;
				}
			}
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function verMatch($vacante,$solicitudEmpleo){
		$datos = array();
		$solicitudEmpleo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($solicitudEmpleo))));
		$consulta="SELECT se.idSolicitudEmpleo,se.nombresDatosPersonales,se.apellidoPaternoDatosPersonales,se.apellidoMaternoDatosPersonales,se.puesto,se.sueldo,se.diasTrabajados,se.idPromocion,se.edad,se.sexo,ae.ultimoGradoEstudios,se.experienciaPuesto,ae.habilidades,ae.paquetesLenguajes,ae.conocimientosEspecificos FROM spartodo_rh.tblSolicitudEmpleo se left join spartodo_rh.tblAcademiaExperiencia ae ON ae.idSolicitudEmpleo=se.idSolicitudEmpleo WHERE se.idSolicitudEmpleo='$solicitudEmpleo'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			$filaTmp = $resultado->fetch_assoc(); 
			$tmpPuntaje = $this->match($vacante,$filaTmp);
			if($tmpPuntaje >= 5){
				$filaTmp["puntaje"] = $tmpPuntaje;
				$datos = $filaTmp;
			}			
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function match($datosVacante, $datosSolicitud){
		$puntaje = array();
		$cadenaDiasPromocion = explode(",", $datosSolicitud['idPromocion']);
		$cadenaDiasPerfil = explode(",",$datosVacante['diasTrabajados']);
		$cadenaDiasTrabajados = explode(",", $datosSolicitud['diasTrabajados']);
		$cadenaHabilidadesPerfil = explode(",",$datosVacante['habilidades']);
		$cadenaHabilidades = explode(",", $datosSolicitud['habilidades']);
		$cadenaPaquetes = explode(",", $datosSolicitud['paquetesLenguajes']);
		$cadenaPaquetesPerfil = explode(",", $datosVacante['paquetes']);
		$cadenaConocimientos = explode(",", $datosSolicitud['conocimientosEspecificos']);
		$cadenaConocimientosPerfil = explode(",", $datosVacante['conocimientosEspecificos']);

		$coincidenciasDias = array_intersect($cadenaDiasTrabajados,$cadenaDiasPerfil);
		$coincidenciasHabilidades = array_intersect($cadenaHabilidades,$cadenaHabilidadesPerfil);
		$coincidenciasConocimientos = array_intersect($cadenaConocimientos,$cadenaConocimientosPerfil);
		$coincidenciasPaquetes = array_intersect($cadenaPaquetes,$cadenaPaquetesPerfil);

		$porcentajeConocimientos = count($coincidenciasConocimientos) * 10;
		$porcentajeConocimientos = $porcentajeConocimientos/count($cadenaConocimientosPerfil);		
		$porcentajeHabilidades = count($coincidenciasHabilidades) * 10;
		$porcentajeHabilidades = $porcentajeHabilidades/count($cadenaHabilidadesPerfil);
		$porcentajePaquetes = count($coincidenciasPaquetes) * 10;
		$porcentajePaquetes = $porcentajePaquetes/count($cadenaPaquetesPerfil);

	    if($porcentajeConocimientos>=1){
	    	$puntaje["conocimientos"] = $porcentajeConocimientos;
	    }else{
			$puntaje["conocimientos"] = 0;
		}
	    if($porcentajePaquetes>=1){
	    	$puntaje["paquetes"] = $porcentajePaquetes;
	    }else{
			$puntaje["paquetes"] = 0;
		}
	    if($porcentajeHabilidades>=1){
	    	$puntaje["habilidades"] = $porcentajeHabilidades;
	    }else{
			$puntaje["habilidades"] = 0;
		}
	    if( count($coincidenciasDias)==count($cadenaDiasPerfil) ){
	    	$puntaje["dias"] = 10;
	    }else{
			$puntaje["dias"] = 0;
		}
	    if( count($cadenaDiasPromocion>=1) ){
	    	$puntaje["promocion"] = 'reingreso';
	    }else{
			$puntaje["promocion"] = 0;
		}
	    if($datosSolicitud["edad"] >= $datosVacante["edad"] && $datosSolicitud["edad"] <= $datosVacante["edadMaxima"]){
			$puntaje["edad"] = 10;
		}else{
			$puntaje["edad"] = 0;
		}
		if($datosSolicitud["sueldo"]<=$datosVacante["salario"]){
			$puntaje["sueldo"] = 10;
		}else{
			$puntaje["sueldo"] = 0;
		} 
		if( $datosSolicitud["sexo"] == $datosVacante["sexo"] || $datosVacante["sexo"] == 'Indistinto' ){
			$puntaje["sexo"] = 10;
		}else{
			$puntaje["sexo"] = 0;
		}
		if( $datosSolicitud["ultimoGradoEstudios"] == $datosVacante["escolaridad"] || $datosSolicitud["ultimoGradoEstudios"] <= $datosVacante["escolaridad"]){
			$puntaje["escolaridad"] = 10;
		}else{
			$puntaje["escolaridad"] = 0;
		} 
		if( $datosSolicitud["experienciaPuesto"] == $datosVacante["experiencia"] || $datosSolicitud["experienciaPuesto"] >= $datosVacante["experiencia"] ){
			$puntaje["experiencia"] = 10;
		}else{
			$puntaje["experiencia"] = 0;
		}
		// echo "Puntaje: ".$puntaje."<br><br>";
		return $puntaje;
	}


	public function listarSolicitudPostuladas($estado){
		$datos = array();
		$consulta="SELECT s.idSolicitudEmpleo,s.idSolicitudEmpleo,CONCAT(s.nombresDatosPersonales,' ',s.apellidoPaternoDatosPersonales,' ',s.apellidoMaternoDatosPersonales) as solicitante,p.nombre,s.rfc,s.telefonoCelular,s.puesto,s.sexo,s.edad,s.experienciaPuesto,s.diasTrabajados,s.sueldo,s.idPromocion,ae.ultimoGradoEstudios,s.experienciaPuesto,ae.habilidades,ae.paquetesLenguajes,ae.conocimientosEspecificos,es.escolaridad,es.idEscolaridad from spartodo_rh.tblSolicitudEmpleo s left join spartodo_rh.tblAcademiaExperiencia ae ON ae.idSolicitudEmpleo=s.idSolicitudEmpleo LEFT JOIN spartodo_rh.tblEscolaridad es on es.idEscolaridad=ae.ultimoGradoEstudios left join spartodo_rh.tblPuestos p on p.idPuesto=s.puesto where s.estado = '$estado'  and not EXISTS (SELECT idSolicitudEmpleo from spartodo_rh.tblVacantesPostuladas p where p.idSolicitudEmpleo=s.idSolicitudEmpleo)";
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

	public function validarSolictudVacante($datosSolicitud){
		$datosSolicitud = json_decode($datosSolicitud,true);
		$datos = array();
		$estado = 'Solicitada';
		$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($estado)))));
		$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['puesto']))));
		$sexo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['sexo']))));
		$edad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['edad']))));
		$experienciaPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['experienciaPuesto']))));
		$diasTrabajados = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['diasTrabajados']))));
		$idPromocion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['idPromocion']))));
		$habilidades = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['habilidades']))));
		$paquetesLenguajes = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['paquetesLenguajes']))));
		$conocimientosEspecificos = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['conocimientosEspecificos']))));
		$sueldo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['sueldo']))));
		$ultimoGradoEstudios = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosSolicitud['ultimoGradoEstudios']))));
		$consulta="SELECT p.idPerfil,p.edad,p.edadMaxima,p.salario,p.sexo,p.escolaridad,p.diasTrabajados,p.experiencia,p.conocimientosEspecificos,p.habilidades,p.paquetes,v.idVacante,p.idPerfil,v.folio,pto.nombre as puesto,p.nombrePerfil,v.estado,c.nombreComercial,v.mes,v.semana,v.anio FROM spartodo_rh.tblVacantes v LEFT JOIN spartodo_rh.tblPerfiles p on p.idPerfil=v.idPerfil left join spartodo_rh.tblPuestos pto on pto.idPuesto=v.idPuesto LEFT JOIN spartodo_spar_bd.tblClientes c on c.idclientes=v.idCliente WHERE p.idPuesto=$puesto and p.edad<=$edad and p.edadMaxima>=$edad and p.diasTrabajados='$diasTrabajados' and p.sexo='$sexo' and p.experiencia<='$experienciaPuesto' and v.estado='Solicitada'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			while ($filaTmp = $resultado->fetch_assoc()) {
				$tmpPuntaje = $this->match($filaTmp,$datosSolicitud);
				if($tmpPuntaje >= 5){
					$filaTmp["puntaje"] = $tmpPuntaje;
					$datos [] = $filaTmp;
				}
			}
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function verMatch2($solicitudEmpleo,$idPefil){
		$solicitudEmpleo = json_decode($solicitudEmpleo,true);
		$datos = array();
		$consulta="SELECT p.edad, p.edadMaxima, p.idPuesto,p.salario,p.sexo,p.escolaridad,p.diasTrabajados,p.experiencia,p.conocimientosEspecificos,p.habilidades,p.paquetes FROM spartodo_rh.tblPerfiles p where p.idPerfil='$idPefil'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			$filaTmp = $resultado->fetch_assoc(); 
			$tmpPuntaje = $this->match($filaTmp,$solicitudEmpleo);
			if($tmpPuntaje >= 1){
				$filaTmp["puntaje"] = $tmpPuntaje;
				$datos = $filaTmp;
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