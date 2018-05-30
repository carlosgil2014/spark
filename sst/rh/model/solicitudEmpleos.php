<?php 
class solicitudEmpleos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}

	public function listar(){
		$datos = array();
		$consulta="SELECT s.idSolicitudEmpleo,s.edad,s.nombresDatosPersonales,s.apellidoPaternoDatosPersonales,s.apellidoMaternoDatosPersonales,s.telefonoCelular,p.nombre,s.fechaSolicitud,s.rfc,s.cpDatosPersonales,s.estado,s.puesto FROM spartodo_rh.tblSolicitudEmpleo s LEFT JOIN spartodo_rh.tblAcademiaExperiencia ae ON ae.idSolicitudEmpleo=s.idSolicitudEmpleo LEFT JOIN spartodo_rh.tblDatosFamiliaresReferencias dfr ON dfr.idSolicitudEmpleo=s.idSolicitudEmpleo LEFT JOIN spartodo_rh.tblPuestos p ON p.idPuesto=s.puesto"; 
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

	public function informacion($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$consulta="SELECT s.sexo,af.conocimientosEspecificos,s.edad,s.idPromocion,s.idSolicitudEmpleo,s.fechaSolicitud,p.nombre,s.sueldo,s.horarioEntrada ,s.horarioSalida,s.diasTrabajados,s.nombresDatosPersonales,s.apellidoPaternoDatosPersonales,s.apellidoMaternoDatosPersonales,s.cpDatosPersonales,s.calleDatosPersonales,s.noInteriorDatosPersonales,s.noExteriorDatosPersonales, s.coloniaASentamiento, s.telefonoParticular,s.immsLicencia,s.numeroLicenciaOImss,s.estadoCivil,s.estatura,s.talla,s.telefonoRecados,s.rfc,s.curp,s.telefonoCelular,s.correo,s.automovilPropio,s.medioPublicidad,s.otroMedioPublicidad,s.reingreso,s.periodo,s.motivoSalida,s.familiarTrabajando,s.familiarTrabajando,s.nombreFamiliarTrabajando,cp.asentamiento,s.puesto,cp.delegacion,et.nombre as nombreEstado,df.nombrePadre,df.direccionPadre,df.telefonoPadre,df.ocupacionPadre,df.nombreMadre,df.direccionMadre,df.telefonoMadre,df.ocupacionMadre,df.nombreEsposoA,df.ocupacionEsposoA,df.escuelaEmpresaEsposoA,df.edadEsposoA,df.telefonoEsposoA,df.nombreReferenciaUno,df.telefonoReferenciaUno,df.ocupacionReferenciaUno,df.tiempoConocerloReferenciaUno,df.nombreReferenciaDos,df.telefonoReferenciaDos,df.ocupacionReferenciaDos,df.tiempoConocerloReferenciaDos,df.nombreReferenciaTres,df.telefonoReferenciaTres,df.ocupacionReferenciaTres,df.tiempoConocerloReferenciaTres,af.ultimoGradoEstudios,af.nombreEscuela,af.fecha,af.anosCursados,af.tituloRecibido,af.carrera,af.estudiosActualmente,af.escuela,af.horario,af.cursoCarrera,af.ingles,af.paquetesLenguajes,af.otrosOficios,af.nombreEmpresa1,af.fecha1,af.puesto1,af.motivo1,af.jefe1,af.puestoJefe1,af.telefono1,af.sueldo1,af.nombreEmpresa2,af.fecha2,af.puesto2,af.motivo2,af.jefe2,af.jefePuesto2,af.telefono2,af.sueldo2,af.nombreEmpresa3,af.fecha3,af.puesto3,af.motivo3,af.jefe3,af.jefePuesto3,af.telefono3,af.sueldo3,af.nombreEmpresa4,af.fecha4,af.puesto4,af.motivo4,af.jefe4,af.jefePuesto4,af.telefono4,af.sueldo4,af.habilidades,s.experienciaPuesto,s.estado FROM spartodo_rh.tblSolicitudEmpleo s LEFT JOIN spartodo_rh.tblPuestos p on p.idPuesto=s.puesto LEFT JOIN spartodo_spar_bd.tblCP cp on cp.idcp=s.coloniaAsentamiento LEFT JOIN spartodo_spar_bd.tblEstados et on et.idestado=cp.estado left join spartodo_rh.tblDatosFamiliaresReferencias df on df.idSolicitudEmpleo=s.idSolicitudEmpleo left join spartodo_rh.tblAcademiaExperiencia af on af.idSolicitudEmpleo=s.idSolicitudEmpleo where s.idSolicitudEmpleo=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function guardar($datos,$diasTrabajados,$paquestesLenguajes,$promocion,$conocimientosEspecificos,$habilidades){
		$fechaSolicitud = date("Y-m-d H:i:s");
		$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
		$sueldo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["sueldo"]))));
		$horarioEntrada = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["horarioEntrada"]))));
		$horarioSalida = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["horarioSalida"]))));
		if(isset($diasTrabajados)){
		$diasTrabajados1 = implode(",", $diasTrabajados);
		$diasTrabajados1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($diasTrabajados1))));
		}else{
			$diasTrabajados1 = NULL;
		}
		$experienciaPuesto = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["experienciaPuesto"]))));
		$nombresDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombresDatosPersonales"]))));
		$edad = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["edadDatosPersonales"]))));
		$apellidoPaternoDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoPaternoDatosPersonales"]))));
		if (isset($datos["apellidoMaternoDatosPersonales"])){
			$apellidoMaternoDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoMaternoDatosPersonales"]))));				
		}else{
			$apellidoMaternoDatosPersonales = NULL;
		}
		$cpDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["cpDatosPersonales"]))));
		$coloniaDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["coloniaDatosPersonales"]))));
		$calleDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["calleDatosPersonales"]))));
		$noInteriorDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["noInteriorDatosPersonales"]))));
		if (isset($datos["noExteriorDatosPersonales"])){
			$noExteriorDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["noExteriorDatosPersonales"]))));				
		}else{
			$noExteriorDatosPersonales = NULL;
		}
		if (isset($datos["telefonoParticularDatosPersonales"])){
			$telefonoParticularDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoParticularDatosPersonales"]))));				
		}else{
			$telefonoParticularDatosPersonales = NULL;
		}
		$LicenciaImssDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["LicenciaImssDatosPersonales"]))));
		if (isset($datos["numeroLicenciaImssDatosPersonales"])){
			$numeroLicenciaImssDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["numeroLicenciaImssDatosPersonales"]))));				
		}else{
			$numeroLicenciaImssDatosPersonales = NULL;
		}
		$estadoCivilDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estadoCivilDatosPersonales"]))));
		$estaturaDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estaturaDatosPersonales"]))));
		$tallaDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tallaDatosPersonales"]))));
		if (isset($datos["telefonoRecadosDatosPersonales"])){
			$telefonoRecadosDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoRecadosDatosPersonales"]))));				
		}else{
			$telefonoRecadosDatosPersonales = NULL;
		}
		if($habilidades == ''){
		$habilidad = NULL;
		}else{
			$habilidades = array_slice($habilidades, 1); 
			$habilidad = implode(",", $habilidades);
			$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad))));
		}
		$rfcDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["rfcDatosPersonales"]))));
		$curpDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["curpDatosPersonales"]))));
		$telefonoCelularDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoCelularDatosPersonales"]))));
		$correoDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["correoDatosPersonales"]))));
		$sexo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["sexo"]))));

		if (isset($datos["padreDatosFamiliares"])){
			$padreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["padreDatosFamiliares"]))));
		}else{
			$padreDatosFamiliares = NULL;
		}if (isset($datos["direccionTelefonoPadreDatosFamiliares"])){
			$direccionTelefonoPadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["direccionTelefonoPadreDatosFamiliares"]))));
		}else{
			$direccionTelefonoPadreDatosFamiliares = NULL;
		}if (isset($datos["telefonoPadreDatosFamiliares"])){
			$telefonoPadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoPadreDatosFamiliares"]))));
		}else{
			$telefonoPadreDatosFamiliares = NULL;
		}if (isset($datos["ocupacionPadreDatosFamiliares"])){
			$ocupacionPadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionPadreDatosFamiliares"]))));
		}else{
			$ocupacionPadreDatosFamiliares = NULL;
		}
		if (isset($datos["madreDatosFamiliares"])){
			$madreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["madreDatosFamiliares"]))));
		}else{
			$madreDatosFamiliares = NULL;
		}if (isset($datos["direccionTelefonoMadreDatosFamiliares"])){
			$direccionTelefonoMadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["direccionTelefonoMadreDatosFamiliares"]))));
		}else{
			$direccionTelefonoMadreDatosFamiliares = NULL;
		}if (isset($datos["telefonoMadreDatosFamiliares"])){
			$telefonoMadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoMadreDatosFamiliares"]))));
		}else{
			$telefonoMadreDatosFamiliares = NULL;
		}if (isset($datos["ocupacionMadreDatosFamiliares"])){
			$ocupacionMadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionMadreDatosFamiliares"]))));
		}else{
			$ocupacionMadreDatosFamiliares = NULL;
		}
		if (isset($datos["nombreEsposoA"])){
			$nombreEsposoA = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreEsposoA"]))));			
		}else{
			$nombreEsposoA = NULL;
		}
		if (isset($datos["ocupacion"])){
			$ocupacion = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacion"]))));	
		}else{
			$ocupacion = NULL;
		}
		if (isset($datos["escuelaEmpresa"])){
			$escuelaEmpresa = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["escuelaEmpresa"]))));	
		}else{
			$escuelaEmpresa = NULL;
		}
		if (isset($datos["edadDatosFamiliares"])){
			$edadDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["edadDatosFamiliares"]))));	
		}else{
			$edadDatosFamiliares = NULL;
		}
		if (isset($datos["telefonoFamiliar"])){
			$telefonoFamiliar = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoFamiliar"]))));	
		}else{
			$telefonoFamiliar = NULL;
		}
		$nombreReferencia = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreReferencia"]))));
		$telefonoReferencia = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoReferencia"]))));
		$ocupacionReferencia = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionReferencia"]))));
		$tiempoConocerlo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tiempoConocerlo"]))));
		$nombreReferencia2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreReferencia2"]))));
		$telefonoReferencia2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoReferencia2"]))));
		$ocupacionReferencia2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionReferencia2"]))));
		$tiempoConocerlo2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tiempoConocerlo2"]))));
		if (isset($datos["nombreReferencia3"])){
			$nombreReferencia3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreReferencia3"]))));	
		}else{
			$nombreReferencia3 = NULL;
		}
		if (isset($datos["telefonoReferencia3"])){
			$telefonoReferencia3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoReferencia3"]))));	
		}else{
			$telefonoReferencia3 = NULL;
		}
		if (isset($datos["ocupacionReferencia3"])){
			$ocupacionReferencia3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionReferencia3"]))));	
		}else{
			$ocupacionReferencia3 = NULL;
		}
		if (isset($datos["tiempoConocerlo3"])){
			$tiempoConocerlo3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tiempoConocerlo3"]))));
		}else{
			$tiempoConocerlo3 = NULL;
		}
		$escolaridad = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["escolaridad"]))));
		$nombreEscuelaPreparacionaAcademica = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreEscuelaPreparacionaAcademica"]))));
		$fechaInicioFin = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["fechaInicioFin"]))));
		$anosPreparacionAcademica = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["anosPreparacionAcademica"]))));
		$tituloRecibido = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tituloRecibido"]))));
		$carrera = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["carrera"]))));
		if (isset($datos["estudiosActuales"])){
			$estudiosActuales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estudiosActuales"]))));
		}else{
			$estudiosActuales = NULL;
		}
		if (isset($datos["escuela"])){
			$escuela = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["escuela"]))));
		}else{
			$escuela = NULL;
		}if (isset($datos["horario"])){
			$horario = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["horario"]))));
		}else{
			$horario = NULL;
		}if (isset($datos["cursoCarrera"])){
			$cursoCarrera = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["cursoCarrera"]))));
		}else{
			$cursoCarrera = NULL;
		}
		$automovilPropio = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["automovilPropio"]))));
		$publicidadEmpleo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["publicidadEmpleo"]))));
		if (isset($datos["otrosPublicidadEmpleo"])){
			$otrosPublicidadEmpleo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["otrosPublicidadEmpleo"]))));
		}else{
			$otrosPublicidadEmpleo = NULL;
		}
		$idioma = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["idioma"]))));
		if($paquestesLenguajes == ''){
		$paquestesLenguaje = NULL;
		}else{
			$paquestesLenguajes = array_slice($paquestesLenguajes, 1); 
			$paquestesLenguaje = implode(",", $paquestesLenguajes);
			$paquestesLenguaje = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($paquestesLenguaje))));
		} 
		if(isset($datos["oficios"])){
			$oficios = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["oficios"]))));
		}else{
			$oficios = NULL;
		}
		$ultimoActual1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual1"]))));
		$ultimoActual1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual1"]))));
		$ultimoActual2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual2"]))));
		$ultimoActual3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual3"]))));
		$ultimoActual4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual4"]))));
		$fechaExperienciaLaboral1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral1"]))));
		$fechaExperienciaLaboral2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral2"]))));
		$fechaExperienciaLaboral3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral3"]))));
		$fechaExperienciaLaboral4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral4"]))));
		if($datos["puestoExperienciaLaboral1"]){
			$puestoExperienciaLaboral1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral1"]))));
		}else{
			$puestoExperienciaLaboral1 = NULL;
		}
		if($datos["puestoExperienciaLaboral2"]){
			$puestoExperienciaLaboral2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral2"]))));
		}else{
			$puestoExperienciaLaboral2 = NULL;
		}
		if($datos["puestoExperienciaLaboral3"]){
			$puestoExperienciaLaboral3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral3"]))));
		}else{
			$puestoExperienciaLaboral3 = NULL;
		}
		if($datos["puestoExperienciaLaboral4"]){
			$puestoExperienciaLaboral4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral4"]))));
		}else{
			$puestoExperienciaLaboral4 = NULL;
		}
		if($datos["nombreJefeInmediato1"]){
			$nombreJefeInmediato1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato1"]))));
		}else{
			$nombreJefeInmediato1 = NULL;
		}
		if($datos["nombreJefeInmediato2"]){
			$nombreJefeInmediato2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato2"]))));
		}else{
			$nombreJefeInmediato2 = NULL;
		}
		if($datos["nombreJefeInmediato3"]){
			$nombreJefeInmediato3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato3"]))));
		}else{
			$nombreJefeInmediato3 = NULL;
		}
		if($datos["nombreJefeInmediato4"]){
			$nombreJefeInmediato4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato4"]))));
		}else{
			$nombreJefeInmediato4 = NULL;
		}
		if($datos["puestoUltimoActual1"]){
			$puestoUltimoActual1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual1"]))));
		}else{
			$puestoUltimoActual1 = NULL;
		}
		if($datos["puestoUltimoActual2"]){
			$puestoUltimoActual2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual2"]))));
		}else{
			$puestoUltimoActual2 = NULL;
		}
		if($datos["puestoUltimoActual3"]){
			$puestoUltimoActual3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual3"]))));
		}else{
			$puestoUltimoActual3 = NULL;
		}
		if($datos["puestoUltimoActual4"]){
			$puestoUltimoActual4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual4"]))));
		}else{
			$puestoUltimoActual4 = NULL;
		}
		if($datos["telefonoExtension1"]){
			$telefonoExtension1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension1"]))));
		}else{
			$telefonoExtension1 = NULL;
		}
		if($datos["telefonoExtension2"]){
			$telefonoExtension2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension2"]))));
		}else{
			$telefonoExtension2 = NULL;
		}
		if($datos["telefonoExtension3"]){
			$telefonoExtension3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension3"]))));
		}else{
			$telefonoExtension3 = NULL;
		}
		if($datos["telefonoExtension4"]){
			$telefonoExtension4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension4"]))));
		}else{
			$telefonoExtension4 = NULL;
		}
		if($datos["sueldoDirario1"]){
			$sueldoDirario1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario1"]))));
		}else{
			$sueldoDirario1 = NULL;
		}
		if($datos["sueldoDirario2"]){
			$sueldoDirario2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario2"]))));
		}else{
			$sueldoDirario2 = NULL;
		}
		if($datos["sueldoDirario3"]){
			$sueldoDirario3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario3"]))));
		}else{
			$sueldoDirario3 = NULL;
		}
		if($datos["sueldoDirario4"]){
			$sueldoDirario4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario4"]))));
		}else{
			$sueldoDirario4 = NULL;
		}
		if($datos["motivoSeparacion1"]){
			$motivoSeparacion1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion1"]))));
		}else{
			$motivoSeparacion1 = NULL;
		}if($datos["motivoSeparacion2"]){
			$motivoSeparacion2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion2"]))));
		}else{
			$motivoSeparacion2 = NULL;
		}if($datos["motivoSeparacion3"]){
			$motivoSeparacion3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion3"]))));
		}else{
			$motivoSeparacion3 = NULL;
		}if($datos["motivoSeparacion4"]){
			$motivoSeparacion4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion4"]))));
		}else{
			$motivoSeparacion4 = NULL;
		}
		if($promocion == ''){
			$promociones = NULL;
		}else{
			$promocion = array_slice($promocion, 1); 
			$promociones = implode(",", $promocion);
			$promociones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($promociones))));
		}
		if($conocimientosEspecificos == ''){
			$conocimientoEspecifico = NULL;
		}else{
			$conocimientosEspecificos = array_slice($conocimientosEspecificos, 1); 
			$conocimientoEspecifico = implode(",", $conocimientosEspecificos);
			$conocimientoEspecifico = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimientoEspecifico))));
		}
		$reingreso = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["reingreso"]))));
		if (isset($datos["periodoReingreso"])){
			$periodoReingreso = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["periodoReingreso"]))));
		}else{
			$periodoReingreso = NULL;
		}
		if (isset($datos["motivoSalida"])){
			$motivoSalida = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSalida"]))));
		}else{
			$motivoSalida = NULL;
		}
		$familiaresReingreso = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["familiaresReingreso"]))));
		if (isset($datos["familiaresReingresoInformacion"])){
			$familiaresReingresoInformacion = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["familiaresReingresoInformacion"]))));
		}else{
			$familiaresReingresoInformacion = NULL;
		}
		$estadoActividad = 'Activa';

		$errores = 0;
		$errorResultado = "";

		if (empty($fechaSolicitud)) {
			$errores ++;
			$errorResultado .= "El campo fecha de solicitud no puede estar vacío. <br>";
		}if (empty($puesto)) {
			$errores ++;
			$errorResultado .= "El campo puesto no puede estar vacío. <br>";
		}if (empty($sueldo)) {
			$errores ++;
			$errorResultado .= "El campo sueldo no puede estar vacío. <br>";
		}if (empty($horarioEntrada)) {
			$errores ++;
			$errorResultado .= "El campo horario de entrada no puede estar vacío. <br>";
		}if (empty($horarioSalida)) {
			$errores ++;
			$errorResultado .= "El campo horario de salida no puede estar vacío. <br>";
		}if (empty($diasTrabajados1)) {
			$errores ++;
			$errorResultado .= "El campo dias trabajados no puede estar vacío. <br>";
		}if (empty($nombresDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo nombres en datos personales no puede estar vacío. <br>";
		}if (empty($apellidoPaternoDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo apellido paterno en datos personales no puede estar vacío. <br>";
		}if (empty($cpDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo codigo postal en datos personales no puede estar vacío. <br>";
		}if (empty($coloniaDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo colonia en datos personale no puede estar vacío. <br>";
		}if (empty($calleDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo calle en datos personales no puede estar vacío. <br>";
		}if (empty($noInteriorDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo numero interior en datos personales no puede estar vacío. <br>";
		}if (empty($LicenciaImssDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo licencia de manejo o numero de IMMS de solicitud no puede estar vacío. <br>";
		}if (empty($estadoCivilDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo estado civil en datos personales de solicitud no puede estar vacío. <br>";
		}if (empty($rfcDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo RFC en datos personales no puede estar vacío. <br>";
		}if (empty($curpDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo CURP en datos personales no puede estar vacío. <br>";
		}if (empty($telefonoCelularDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo telefono celular en datos personales no puede estar vacío. <br>";
		}if (empty($correoDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo correo en datos personales no puede estar vacío. <br>";
		}if (empty($escolaridad)) {
			$errores ++;
			$errorResultado .= "El campo ultimo grado de estudios en preparacion academica no puede estar vacío. <br>";
		}if (empty($nombreEscuelaPreparacionaAcademica)) {
			$errores ++;
			$errorResultado .= "El campo nombre de escuela en preparacion academica no puede estar vacío. <br>";
		}if (empty($fechaInicioFin)) {
			$errores ++;
			$errorResultado .= "El campo fecha inicio  y fin en preparacion academica no puede estar vacío. <br>";
		}if (empty($anosPreparacionAcademica)) {
			$errores ++;
			$errorResultado .= "El campo años cursados en preparacion academica no puede estar vacío. <br>";
		}if (empty($tituloRecibido)) {
			$errores ++;
			$errorResultado .= "El campo titulo recibido en preparacion academica no puede estar vacío. <br>";
		}if (empty($automovilPropio)) {
			$errores ++;
			$errorResultado .= "El campo automovil propio en datos generales no puede estar vacío. <br>";
		}if (empty($publicidadEmpleo)) {
			$errores ++;
			$errorResultado .= "El campo ¿como se entero del empleo? en datos generales no puede estar vacío. <br>";
		}if (empty($idioma)) {
			$errores ++;
			$errorResultado .= "El campo ¿domina el ingles? en conocimientos generales no puede estar vacío. <br>";
		}if (empty($reingreso)) {
			$errores ++;
			$errorResultado .= "El campo ¿Has trabajado anteriormete con nosotros? no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO spartodo_rh.tblSolicitudEmpleo(fechaSolicitud,puesto,sueldo,horarioEntrada,horarioSalida,diasTrabajados,nombresDatosPersonales,apellidoPaternoDatosPersonales,apellidoMaternoDatosPersonales,cpDatosPersonales,calleDatosPersonales,noInteriorDatosPersonales,noExteriorDatosPersonales,coloniaAsentamiento,telefonoParticular,immsLicencia,numeroLicenciaOImss,estadoCivil,estatura,talla,telefonoRecados,rfc,curp,telefonoCelular,correo,automovilPropio,medioPublicidad,otroMedioPublicidad,reingreso,idPromocion,periodo,motivoSalida,familiarTrabajando,nombreFamiliarTrabajando,edad,sexo,experienciaPuesto,Activa) SELECT * FROM (SELECT '$fechaSolicitud' AS fechaSolicitud,'$puesto' AS puesto,'$sueldo' AS sueldo,'$horarioEntrada' AS entrada,'$horarioSalida' AS salida,'$diasTrabajados1' AS diasTrabajados1,'$nombresDatosPersonales' AS nombresDatosPersonales,'$apellidoPaternoDatosPersonales' AS apellidoPaternoDatosPersonales,'$apellidoMaternoDatosPersonales' AS apellidoMaternoDatosPersonales,'$cpDatosPersonales' AS cpDatosPersonales,'$calleDatosPersonales' AS calleDatosPersonales,'$noInteriorDatosPersonales' AS noInteriorDatosPersonales,'$noExteriorDatosPersonales' AS noExteriorDatosPersonales,'$coloniaDatosPersonales' AS coloniaDatosPersonales,'$telefonoParticularDatosPersonales' AS telefonoParticularDatosPersonales,'$LicenciaImssDatosPersonales' AS LicenciaImssDatosPersonales,'$numeroLicenciaImssDatosPersonales' AS numeroLicenciaImssDatosPersonales,'$estadoCivilDatosPersonales' AS estadoCivilDatosPersonales,'$estaturaDatosPersonales' AS estaturaDatosPersonales,'$tallaDatosPersonales' AS tallaDatosPersonales,'$telefonoRecadosDatosPersonales' AS telefonoRecadosDatosPersonales,'$rfcDatosPersonales' AS rfcDatosPersonales,'$curpDatosPersonales' AS curpDatosPersonales,'$telefonoCelularDatosPersonales' AS telefonoCelularDatosPersonales,'$correoDatosPersonales' AS correoDatosPersonales,'$automovilPropio' AS automovilPropio,'$publicidadEmpleo' AS publicidadEmpleo,'$otrosPublicidadEmpleo' AS otrosPublicidadEmpleo,'$reingreso' AS reingreso,'$promociones' AS promociones,'$periodoReingreso' AS periodoReingreso,'$motivoSalida' AS motivoSalida,'$familiaresReingreso' AS familiaresReingreso,'$familiaresReingresoInformacion' as familiaresReingresoInformacion,'$edad' as edad,'$sexo' as sexo,'$experienciaPuesto' as experienciaPuesto,'$estadoActividad' as estadoActividad) AS tmp WHERE NOT EXISTS (SELECT rfc FROM spartodo_rh.tblSolicitudEmpleo WHERE rfc = '$rfcDatosPersonales') LIMIT 1";
			$resultado = $this->conexion -> query($consulta);
			//echo $consulta;
			$idSolicitante = $this->conexion->insert_id;
			$consulta2 = "INSERT INTO spartodo_rh.tblDatosFamiliaresReferencias(nombrePadre,direccionPadre,telefonoPadre,ocupacionPadre,nombreMadre,direccionMadre,telefonoMadre,ocupacionMadre,nombreEsposoA,ocupacionEsposoA,escuelaEmpresaEsposoA,edadEsposoA,telefonoEsposoA,nombreReferenciaUno,telefonoReferenciaUno,ocupacionReferenciaUno,tiempoConocerloReferenciaUno,nombreReferenciaDos,telefonoReferenciaDos,ocupacionReferenciaDos,tiempoConocerloReferenciaDos,nombreReferenciaTres,telefonoReferenciaTres,ocupacionReferenciaTres,tiempoConocerloReferenciaTres,idSolicitudEmpleo) SELECT * FROM (SELECT '$padreDatosFamiliares' AS padreDatosFamiliares,'$direccionTelefonoPadreDatosFamiliares' AS direccionTelefonoPadreDatosFamiliares,'$telefonoPadreDatosFamiliares' AS telefonoPadreDatosFamiliares,'$ocupacionPadreDatosFamiliares' AS ocupacionPadreDatosFamiliares,'$madreDatosFamiliares' AS madreDatosFamiliares,'$direccionTelefonoMadreDatosFamiliares' AS direccionTelefonoMadreDatosFamiliares,'$telefonoMadreDatosFamiliares' AS telefonoMadreDatosFamiliares,'$ocupacionMadreDatosFamiliares' AS ocupacionMadreDatosFamiliares,'$nombreEsposoA' AS nombreEsposoA,'$ocupacion' AS ocupacion,'$escuelaEmpresa' AS escuelaEmpresa,'$edadDatosFamiliares' AS edadDatosFamiliares,'$telefonoFamiliar' AS telefonoFamiliar,'$nombreReferencia' AS nombreReferencia,'$telefonoReferencia' AS telefonoReferencia,'$ocupacionReferencia' AS ocupacionReferencia,'$tiempoConocerlo' AS tiempoConocerlo,'$nombreReferencia2' AS nombreReferencia2,'$telefonoReferencia2' AS telefonoReferencia2,'$ocupacionReferencia2' AS ocupacionReferencia2,'$tiempoConocerlo2' AS tiempoConocerlo2,'$nombreReferencia3' AS nombreReferencia3,'$telefonoReferencia3' AS telefonoReferencia3,'$ocupacionReferencia3' AS ocupacionReferencia3,'$tiempoConocerlo3' AS tiempoConocerlo3,'$idSolicitante' AS idSolicitante) AS tmp  LIMIT 1";
			$resultado2 = $this->conexion -> query($consulta2);
			$consulta3 = "INSERT INTO spartodo_rh.tblAcademiaExperiencia(ultimoGradoEstudios,nombreEscuela,fecha,anosCursados,tituloRecibido,carrera,estudiosActualmente,escuela,horario,cursoCarrera,ingles,paquetesLenguajes,otrosOficios,nombreEmpresa1,fecha1,puesto1,motivo1,jefe1,puestoJefe1,telefono1,sueldo1,nombreEmpresa2,fecha2,puesto2,motivo2,jefe2,jefePuesto2,telefono2,sueldo2,nombreEmpresa3,fecha3,puesto3,motivo3,jefe3,jefePuesto3,telefono3,
			sueldo3,nombreEmpresa4,fecha4,puesto4,motivo4,jefe4,jefePuesto4,telefono4,sueldo4,conocimientosEspecificos,habilidades,idSolicitudEmpleo) SELECT * FROM (SELECT '$escolaridad' AS escolaridad,'$nombreEscuelaPreparacionaAcademica' AS nombreEscuelaPreparacionaAcademica,'$fechaInicioFin' AS fechaInicioFin,'$anosPreparacionAcademica' AS anosPreparacionAcademica,'$tituloRecibido' AS tituloRecibido,'$carrera' AS carrera,'$estudiosActuales' AS estudiosActuales,'$escuela' AS escuela,'$horario' AS horario,'$cursoCarrera' AS cursoCarrera,'$idioma' AS idioma,'$paquestesLenguaje' AS paquestesLenguaje,'$oficios' AS oficios,'$ultimoActual1' AS ultimoActual1,'$fechaExperienciaLaboral1' AS fechaExperienciaLaboral1,'$puestoExperienciaLaboral1' AS puestoExperienciaLaboral1,'$motivoSeparacion1' AS motivoSeparacion1,'$nombreJefeInmediato1' AS nombreJefeInmediato1,'$puestoUltimoActual1' AS puestoUltimoActual1,'$telefonoExtension1' AS telefonoExtension1,'$sueldoDirario1' AS sueldoDirario1,'$ultimoActual2' AS ultimoActual2,'$fechaExperienciaLaboral2' AS fechaExperienciaLaboral2,'$puestoExperienciaLaboral2' AS puestoExperienciaLaboral2,'$motivoSeparacion2' AS motivoSeparacion2,'$nombreJefeInmediato2' AS nombreJefeInmediato2,'$puestoUltimoActual2' AS puestoUltimoActual2,'$telefonoExtension2' AS telefonoExtension2,'$sueldoDirario2' AS sueldoDirario2,'$ultimoActual3' AS ultimoActual3,'$fechaExperienciaLaboral3' AS fechaExperienciaLaboral3,'$puestoExperienciaLaboral3' AS puestoExperienciaLaboral3,'$motivoSeparacion3' AS motivoSeparacion3,'$nombreJefeInmediato3' AS nombreJefeInmediato3,'$puestoUltimoActual3' AS puestoUltimoActual3,'$telefonoExtension3' AS telefonoExtension3,'$sueldoDirario3' AS sueldoDirario3,'$ultimoActual4' AS ultimoActual4,'$fechaExperienciaLaboral4' AS fechaExperienciaLaboral4,'$puestoExperienciaLaboral4' AS puestoExperienciaLaboral4,'$motivoSeparacion4' AS motivoSeparacion4,'$nombreJefeInmediato4' AS nombreJefeInmediato4,'$puestoUltimoActual4' AS puestoUltimoActual4,'$telefonoExtension4' AS telefonoExtension4,'$sueldoDirario4' AS sueldoDirario4,'$conocimientoEspecifico' AS conocimientoEspecifico,'$habilidad' AS habilidad,'$idSolicitante' AS idSolicitante) AS tmp  LIMIT 1";
				$resultado3 = $this->conexion -> query($consulta3);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La solictud de empleo ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($datos,$diasTrabajados,$paquestesLenguajes,$promocion,$conocimientosEspecificos,$habilidades){
		$var = "";
		$idSolicitudEmpleoID = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idSolicitudEmpleoID"]))));
		$fechaSolicitud = date("Y-m-d H:i:s");
		$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
		$sueldo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["sueldo"]))));
		$horarioEntrada = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["horarioEntrada"]))));
		$horarioSalida = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["horarioSalida"]))));
		if(isset($diasTrabajados)){
		$diasTrabajados1 = implode(",", $diasTrabajados);
		$diasTrabajados1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($diasTrabajados1))));
		}else{
			$diasTrabajados1 = NULL;
		}
		$experienciaPuesto = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["experienciaPuesto"]))));
		$nombresDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombresDatosPersonales"]))));
		$edad = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["edadDatosPersonales"]))));
		$apellidoPaternoDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoPaternoDatosPersonales"]))));
		if (isset($datos["apellidoMaternoDatosPersonales"])){
			$apellidoMaternoDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["apellidoMaternoDatosPersonales"]))));				
		}else{
			$apellidoMaternoDatosPersonales = NULL;
		}
		$cpDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["cpDatosPersonales"]))));
		$coloniaDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["coloniaDatosPersonales"]))));
		$calleDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["calleDatosPersonales"]))));
		$noInteriorDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["noInteriorDatosPersonales"]))));
		if (isset($datos["noExteriorDatosPersonales"])){
			$noExteriorDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["noExteriorDatosPersonales"]))));				
		}else{
			$noExteriorDatosPersonales = NULL;
		}
		if (isset($datos["telefonoParticularDatosPersonales"])){
			$telefonoParticularDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoParticularDatosPersonales"]))));				
		}else{
			$telefonoParticularDatosPersonales = NULL;
		}
		$LicenciaImssDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["LicenciaImssDatosPersonales"]))));
		if (isset($datos["numeroLicenciaImssDatosPersonales"])){
			$numeroLicenciaImssDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["numeroLicenciaImssDatosPersonales"]))));				
		}else{
			$numeroLicenciaImssDatosPersonales = NULL;
		}
		$estadoCivilDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estadoCivilDatosPersonales"]))));
		$estaturaDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estaturaDatosPersonales"]))));
		$tallaDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tallaDatosPersonales"]))));
		if (isset($datos["telefonoRecadosDatosPersonales"])){
			$telefonoRecadosDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoRecadosDatosPersonales"]))));				
		}else{
			$telefonoRecadosDatosPersonales = NULL;
		}
		$rfcDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["rfcDatosPersonales"]))));
		$curpDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["curpDatosPersonales"]))));
		$telefonoCelularDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoCelularDatosPersonales"]))));
		$correoDatosPersonales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["correoDatosPersonales"]))));
		$sexo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["sexo"]))));

		if (isset($datos["padreDatosFamiliares"])){
			$padreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["padreDatosFamiliares"]))));
		}else{
			$padreDatosFamiliares = NULL;
		}if (isset($datos["direccionTelefonoPadreDatosFamiliares"])){
			$direccionTelefonoPadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["direccionTelefonoPadreDatosFamiliares"]))));
		}else{
			$direccionTelefonoPadreDatosFamiliares = NULL;
		}if (isset($datos["telefonoPadreDatosFamiliares"])){
			$telefonoPadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoPadreDatosFamiliares"]))));
		}else{
			$telefonoPadreDatosFamiliares = NULL;
		}if (isset($datos["ocupacionPadreDatosFamiliares"])){
			$ocupacionPadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionPadreDatosFamiliares"]))));
		}else{
			$ocupacionPadreDatosFamiliares = NULL;
		}

		if (isset($datos["madreDatosFamiliares"])){
			$madreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["madreDatosFamiliares"]))));
		}else{
			$madreDatosFamiliares = NULL;
		}if (isset($datos["direccionTelefonoMadreDatosFamiliares"])){
			$direccionTelefonoMadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["direccionTelefonoMadreDatosFamiliares"]))));
		}else{
			$direccionTelefonoMadreDatosFamiliares = NULL;
		}if (isset($datos["telefonoMadreDatosFamiliares"])){
			$telefonoMadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoMadreDatosFamiliares"]))));
		}else{
			$telefonoMadreDatosFamiliares = NULL;
		}if (isset($datos["ocupacionMadreDatosFamiliares"])){
			$ocupacionMadreDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionMadreDatosFamiliares"]))));
		}else{
			$ocupacionMadreDatosFamiliares = NULL;
		}

		if (isset($datos["nombreEsposoA"])){
			$nombreEsposoA = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreEsposoA"]))));			
		}else{
			$nombreEsposoA = NULL;
		}
		if (isset($datos["ocupacion"])){
			$ocupacion = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacion"]))));	
		}else{
			$ocupacion = NULL;
		}
		if (isset($datos["escuelaEmpresa"])){
			$escuelaEmpresa = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["escuelaEmpresa"]))));	
		}else{
			$escuelaEmpresa = NULL;
		}
		if (isset($datos["edadDatosFamiliares"])){
			$edadDatosFamiliares = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["edadDatosFamiliares"]))));	
		}else{
			$edadDatosFamiliares = NULL;
		}
		if (isset($datos["telefonoFamiliar"])){
			$telefonoFamiliar = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoFamiliar"]))));	
		}else{
			$telefonoFamiliar = NULL;
		}
		$nombreReferencia = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreReferencia"]))));
		$telefonoReferencia = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoReferencia"]))));
		$ocupacionReferencia = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionReferencia"]))));
		$tiempoConocerlo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tiempoConocerlo"]))));
		$nombreReferencia2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreReferencia2"]))));
		$telefonoReferencia2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoReferencia2"]))));
		$ocupacionReferencia2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionReferencia2"]))));
		$tiempoConocerlo2 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tiempoConocerlo2"]))));
		if (isset($datos["nombreReferencia3"])){
			$nombreReferencia3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreReferencia3"]))));	
		}else{
			$nombreReferencia3 = NULL;
		}
		if (isset($datos["telefonoReferencia3"])){
			$telefonoReferencia3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoReferencia3"]))));	
		}else{
			$telefonoReferencia3 = NULL;
		}
		if (isset($datos["ocupacionReferencia3"])){
			$ocupacionReferencia3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["ocupacionReferencia3"]))));	
		}else{
			$ocupacionReferencia3 = NULL;
		}
		if (isset($datos["tiempoConocerlo3"])){
			$tiempoConocerlo3 = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tiempoConocerlo3"]))));
		}else{
			$tiempoConocerlo3 = NULL;
		}
		$escolaridad = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["escolaridad"]))));
		$nombreEscuelaPreparacionaAcademica = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["nombreEscuelaPreparacionaAcademica"]))));
		$fechaInicioFin = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["fechaInicioFin"]))));
		$anosPreparacionAcademica = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["anosPreparacionAcademica"]))));
		$tituloRecibido = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["tituloRecibido"]))));
		$carrera = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["carrera"]))));
		if (isset($datos["estudiosActuales"])){
			$estudiosActuales = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estudiosActuales"]))));
		}else{
			$estudiosActuales = NULL;
		}
		if (isset($datos["escuela"])){
			$escuela = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["escuela"]))));
		}else{
			$escuela = NULL;
		}if (isset($datos["horario"])){
			$horario = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["horario"]))));
		}else{
			$horario = NULL;
		}if (isset($datos["cursoCarrera"])){
			$cursoCarrera = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["cursoCarrera"]))));
		}else{
			$cursoCarrera = NULL;
		}
		$automovilPropio = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["automovilPropio"]))));
		$publicidadEmpleo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["publicidadEmpleo"]))));
		if (isset($datos["otrosPublicidadEmpleo"])){
			$otrosPublicidadEmpleo = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["otrosPublicidadEmpleo"]))));
		}else{
			$otrosPublicidadEmpleo = NULL;
		}
		$idioma = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["idioma"]))));
		if(isset($datos["oficios"])){
			$oficios = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["oficios"]))));
		}else{
			$oficios = NULL;
		}
		$ultimoActual1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual1"]))));
		$ultimoActual1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual1"]))));
		$ultimoActual2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual2"]))));
		$ultimoActual3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual3"]))));
		$ultimoActual4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ultimoActual4"]))));
		$fechaExperienciaLaboral1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral1"]))));
		$fechaExperienciaLaboral2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral2"]))));
		$fechaExperienciaLaboral3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral3"]))));
		$fechaExperienciaLaboral4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaExperienciaLaboral4"]))));
		if($datos["puestoExperienciaLaboral1"]){
			$puestoExperienciaLaboral1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral1"]))));
		}else{
			$puestoExperienciaLaboral1 = NULL;
		}
		if($datos["puestoExperienciaLaboral2"]){
			$puestoExperienciaLaboral2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral2"]))));
		}else{
			$puestoExperienciaLaboral2 = NULL;
		}
		if($datos["puestoExperienciaLaboral3"]){
			$puestoExperienciaLaboral3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral3"]))));
		}else{
			$puestoExperienciaLaboral3 = NULL;
		}
		if($datos["puestoExperienciaLaboral4"]){
			$puestoExperienciaLaboral4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoExperienciaLaboral4"]))));
		}else{
			$puestoExperienciaLaboral4 = NULL;
		}
		if($datos["nombreJefeInmediato1"]){
			$nombreJefeInmediato1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato1"]))));
		}else{
			$nombreJefeInmediato1 = NULL;
		}
		if($datos["nombreJefeInmediato2"]){
			$nombreJefeInmediato2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato2"]))));
		}else{
			$nombreJefeInmediato2 = NULL;
		}
		if($datos["nombreJefeInmediato3"]){
			$nombreJefeInmediato3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato3"]))));
		}else{
			$nombreJefeInmediato3 = NULL;
		}
		if($datos["nombreJefeInmediato4"]){
			$nombreJefeInmediato4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombreJefeInmediato4"]))));
		}else{
			$nombreJefeInmediato4 = NULL;
		}
		if($datos["puestoUltimoActual1"]){
			$puestoUltimoActual1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual1"]))));
		}else{
			$puestoUltimoActual1 = NULL;
		}
		if($datos["puestoUltimoActual2"]){
			$puestoUltimoActual2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual2"]))));
		}else{
			$puestoUltimoActual2 = NULL;
		}
		if($datos["puestoUltimoActual3"]){
			$puestoUltimoActual3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual3"]))));
		}else{
			$puestoUltimoActual3 = NULL;
		}
		if($datos["puestoUltimoActual4"]){
			$puestoUltimoActual4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puestoUltimoActual4"]))));
		}else{
			$puestoUltimoActual4 = NULL;
		}
		if($datos["telefonoExtension1"]){
			$telefonoExtension1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension1"]))));
		}else{
			$telefonoExtension1 = NULL;
		}
		if($datos["telefonoExtension2"]){
			$telefonoExtension2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension2"]))));
		}else{
			$telefonoExtension2 = NULL;
		}
		if($datos["telefonoExtension3"]){
			$telefonoExtension3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension3"]))));
		}else{
			$telefonoExtension3 = NULL;
		}
		if($datos["telefonoExtension4"]){
			$telefonoExtension4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["telefonoExtension4"]))));
		}else{
			$telefonoExtension4 = NULL;
		}
		if($datos["sueldoDirario1"]){
			$sueldoDirario1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario1"]))));
		}else{
			$sueldoDirario1 = NULL;
		}
		if($datos["sueldoDirario2"]){
			$sueldoDirario2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario2"]))));
		}else{
			$sueldoDirario2 = NULL;
		}
		if($datos["sueldoDirario3"]){
			$sueldoDirario3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario3"]))));
		}else{
			$sueldoDirario3 = NULL;
		}
		if($datos["sueldoDirario4"]){
			$sueldoDirario4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldoDirario4"]))));
		}else{
			$sueldoDirario4 = NULL;
		}
		if($datos["motivoSeparacion1"]){
			$motivoSeparacion1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion1"]))));
		}else{
			$motivoSeparacion1 = NULL;
		}if($datos["motivoSeparacion2"]){
			$motivoSeparacion2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion2"]))));
		}else{
			$motivoSeparacion2 = NULL;
		}if($datos["motivoSeparacion3"]){
			$motivoSeparacion3 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion3"]))));
		}else{
			$motivoSeparacion3 = NULL;
		}if($datos["motivoSeparacion4"]){
			$motivoSeparacion4 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSeparacion4"]))));
		}else{
			$motivoSeparacion4 = NULL;
		}
		$reingreso = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["reingreso"]))));
		if (isset($datos["periodoReingreso"])){
			$periodoReingreso = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["periodoReingreso"]))));
		}else{
			$periodoReingreso = NULL;
		}
		if (isset($datos["motivoSalida"])){
			$motivoSalida = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["motivoSalida"]))));
		}else{
			$motivoSalida = NULL;
		}
		$familiaresReingreso = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["familiaresReingreso"]))));
		if (isset($datos["familiaresReingresoInformacion"])){
			$familiaresReingresoInformacion = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["familiaresReingresoInformacion"]))));
		}else{
			$familiaresReingresoInformacion = NULL;
		}

		if ( isset($conocimientosEspecificos) ){
			if( in_array('NULL', $conocimientosEspecificos) ){
				$array1 = array('NULL');
				$x = array_diff($conocimientosEspecificos, $array1);
				$conocimientoEspecifico = implode(",", $x);
				$conocimientoEspecifico = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimientoEspecifico))));
			}else{
				$conocimientoEspecifico = implode(",", $conocimientosEspecificos);
				$conocimientoEspecifico = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimientoEspecifico ))));	
			}
		}else{
			$conocimientoEspecifico = NULL;
		}

		if ( isset($paquestesLenguajes) ){
			if( in_array('NULL', $paquestesLenguajes) ){
				$array2 = array('NULL');
				$z = array_diff($paquestesLenguajes, $array2);
				$paquestesLenguaje = implode(",", $z);
				$paquestesLenguaje = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($paquestesLenguaje))));
			}else{
				$paquestesLenguaje = implode(",", $paquestesLenguajes);
				$paquestesLenguaje = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($paquestesLenguaje ))));	
			}
		}else{
			$paquestesLenguaje = NULL;
		}
		if ( isset($habilidades) ){
			if( in_array('NULL', $habilidades) ){
				$array3 = array('NULL');
				$y = array_diff($habilidades, $array3);
				$habilidad = implode(",", $y);
				$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad))));
			}else{
				$habilidad = implode(",", $habilidades);
				$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad ))));	
			}
		}else{
			$habilidad = NULL;
		}
		if ( isset($promocion) ){
			if( in_array('NULL', $promocion) ){
				$array4 = array('NULL');
				$w = array_diff($promocion, $array4);
				$promociones = implode(",", $w);
				$promociones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($promociones))));
			}else{
				$promociones = implode(",", $promocion);
				$promociones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($promociones ))));	
			}
		}else{
			$promociones = NULL;
		}

		$estadoActividad = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["estadoActividad"]))));

		$errores = 0;
		$errorResultado = "";

		if (empty($fechaSolicitud)) {
			$errores ++;
			$errorResultado .= "El campo fecha de solicitud no puede estar vacío. <br>";
		}if (empty($puesto)) {
			$errores ++;
			$errorResultado .= "El campo puesto no puede estar vacío. <br>";
		}if (empty($sueldo)) {
			$errores ++;
			$errorResultado .= "El campo sueldo no puede estar vacío. <br>";
		}if (empty($horarioEntrada)) {
			$errores ++;
			$errorResultado .= "El campo horario de entrada no puede estar vacío. <br>";
		}if (empty($horarioSalida)) {
			$errores ++;
			$errorResultado .= "El campo horario de salida no puede estar vacío. <br>";
		}if (empty($diasTrabajados1)) {
			$errores ++;
			$errorResultado .= "El campo dias trabajados no puede estar vacío. <br>";
		}if (empty($nombresDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo nombres en datos personales no puede estar vacío. <br>";
		}if (empty($apellidoPaternoDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo apellido paterno en datos personales no puede estar vacío. <br>";
		}if (empty($cpDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo codigo postal en datos personales no puede estar vacío. <br>";
		}if (empty($coloniaDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo colonia en datos personale no puede estar vacío. <br>";
		}if (empty($calleDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo calle en datos personales no puede estar vacío. <br>";
		}if (empty($noInteriorDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo numero interior en datos personales no puede estar vacío. <br>";
		}if (empty($LicenciaImssDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo licencia de manejo o numero de IMMS de solicitud no puede estar vacío. <br>";
		}if (empty($estadoCivilDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo estado civil en datos personales de solicitud no puede estar vacío. <br>";
		}if (empty($rfcDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo RFC en datos personales no puede estar vacío. <br>";
		}if (empty($curpDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo CURP en datos personales no puede estar vacío. <br>";
		}if (empty($telefonoCelularDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo telefono celular en datos personales no puede estar vacío. <br>";
		}if (empty($correoDatosPersonales)) {
			$errores ++;
			$errorResultado .= "El campo correo en datos personales no puede estar vacío. <br>";
		}if (empty($escolaridad)) {
			$errores ++;
			$errorResultado .= "El campo ultimo grado de estudios en preparacion academica no puede estar vacío. <br>";
		}if (empty($nombreEscuelaPreparacionaAcademica)) {
			$errores ++;
			$errorResultado .= "El campo nombre de escuela en preparacion academica no puede estar vacío. <br>";
		}if (empty($fechaInicioFin)) {
			$errores ++;
			$errorResultado .= "El campo fecha inicio  y fin en preparacion academica no puede estar vacío. <br>";
		}if (empty($anosPreparacionAcademica)) {
			$errores ++;
			$errorResultado .= "El campo años cursados en preparacion academica no puede estar vacío. <br>";
		}if (empty($tituloRecibido)) {
			$errores ++;
			$errorResultado .= "El campo titulo recibido en preparacion academica no puede estar vacío. <br>";
		}if (empty($automovilPropio)) {
			$errores ++;
			$errorResultado .= "El campo automovil propio en datos generales no puede estar vacío. <br>";
		}if (empty($publicidadEmpleo)) {
			$errores ++;
			$errorResultado .= "El campo ¿como se entero del empleo? en datos generales no puede estar vacío. <br>";
		}if (empty($idioma)) {
			$errores ++;
			$errorResultado .= "El campo ¿domina el ingles? en conocimientos generales no puede estar vacío. <br>";
		}if (empty($reingreso)) {
			$errores ++;
			$errorResultado .= "El campo ¿Has trabajado anteriormete con nosotros? no puede estar vacío. <br>";
		}
		
		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblSolicitudEmpleo a_b SET a_b.fechaSolicitud='$fechaSolicitud',a_b.puesto='$puesto',a_b.sueldo='$sueldo',a_b.horarioEntrada='$horarioEntrada',a_b.horarioSalida='$horarioSalida',a_b.diasTrabajados='$diasTrabajados1',a_b.nombresDatosPersonales='$nombresDatosPersonales',a_b.apellidoPaternoDatosPersonales='$apellidoPaternoDatosPersonales',a_b.apellidoMaternoDatosPersonales='$apellidoMaternoDatosPersonales',a_b.cpDatosPersonales='$cpDatosPersonales',a_b.calleDatosPersonales='$calleDatosPersonales',a_b.noInteriorDatosPersonales='$noInteriorDatosPersonales',a_b.noExteriorDatosPersonales='$noExteriorDatosPersonales',a_b.coloniaAsentamiento='$coloniaDatosPersonales',a_b.telefonoParticular='$telefonoParticularDatosPersonales',a_b.immsLicencia='$LicenciaImssDatosPersonales',a_b.numeroLicenciaOImss='$numeroLicenciaImssDatosPersonales',a_b.estadoCivil='$estadoCivilDatosPersonales',a_b.estatura='$estaturaDatosPersonales',a_b.talla='$tallaDatosPersonales',a_b.telefonoRecados='$telefonoRecadosDatosPersonales',a_b.rfc='$rfcDatosPersonales',a_b.curp='$curpDatosPersonales',a_b.telefonoCelular='$telefonoCelularDatosPersonales',a_b.correo='$correoDatosPersonales',a_b.automovilPropio='$automovilPropio',a_b.medioPublicidad='$publicidadEmpleo',a_b.otroMedioPublicidad='$otrosPublicidadEmpleo',a_b.reingreso='$reingreso',a_b.idPromocion='$promociones',a_b.periodo='$periodoReingreso',a_b.motivoSalida='$motivoSalida',a_b.familiarTrabajando='$familiaresReingreso',a_b.nombreFamiliarTrabajando='$familiaresReingresoInformacion',a_b.edad='$edad',a_b.sexo='$sexo',a_b.experienciaPuesto='$experienciaPuesto',a_b.estado='$estadoActividad' WHERE a_b.idSolicitudEmpleo=$idSolicitudEmpleoID AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_rh.tblSolicitudEmpleo) AS a_b_2 WHERE a_b_2.rfc = '$rfcDatosPersonales' AND a_b_2.idSolicitudEmpleo != '$idSolicitudEmpleoID') AS count); ";
			$resultado = $this->conexion->query($consulta); 
			if($this->conexion->affected_rows === 1)
					$var = "OK";
			$consulta2 = "UPDATE spartodo_rh.tblDatosFamiliaresReferencias a_b SET a_b.nombrePadre='$padreDatosFamiliares',a_b.direccionPadre='$direccionTelefonoPadreDatosFamiliares',a_b.telefonoPadre='$telefonoPadreDatosFamiliares',a_b.ocupacionPadre='$ocupacionPadreDatosFamiliares',a_b.nombreMadre='$madreDatosFamiliares',a_b.direccionMadre='$direccionTelefonoMadreDatosFamiliares',a_b.telefonoMadre='$telefonoMadreDatosFamiliares',a_b.ocupacionMadre='$ocupacionMadreDatosFamiliares',a_b.nombreEsposoA='$nombreEsposoA',a_b.ocupacionEsposoA='$ocupacion',a_b.escuelaEmpresaEsposoA='$escuelaEmpresa',a_b.edadEsposoA='$edadDatosFamiliares',a_b.telefonoEsposoA='$telefonoFamiliar',a_b.nombreReferenciaUno='$nombreReferencia',a_b.telefonoReferenciaUno='$telefonoReferencia',a_b.ocupacionReferenciaUno='$ocupacionReferencia',a_b.tiempoConocerloReferenciaUno='$tiempoConocerlo',a_b.nombreReferenciaDos='$nombreReferencia2',a_b.telefonoReferenciaDos='$telefonoReferencia2',a_b.ocupacionReferenciaDos='$ocupacionReferencia2',a_b.tiempoConocerloReferenciaDos='$tiempoConocerlo2',a_b.nombreReferenciaTres='$nombreReferencia3',a_b.telefonoReferenciaTres='$telefonoReferencia3',a_b.ocupacionReferenciaTres='$ocupacionReferencia3',a_b.tiempoConocerloReferenciaTres='$tiempoConocerlo3' WHERE a_b.idSolicitudEmpleo=$idSolicitudEmpleoID";
			$resultado2 = $this->conexion->query($consulta2);
			if($this->conexion->affected_rows === 1)
					$var = "OK";
			$consulta3 = "UPDATE spartodo_rh.tblAcademiaExperiencia a_b SET a_b.ultimoGradoEstudios='$escolaridad',a_b.nombreEscuela='$nombreEscuelaPreparacionaAcademica',a_b.fecha='$fechaInicioFin',a_b.anosCursados='$anosPreparacionAcademica',a_b.tituloRecibido='$tituloRecibido',a_b.carrera='$carrera',a_b.estudiosActualmente='$estudiosActuales',a_b.escuela='$escuela',a_b.horario='$horario',a_b.cursoCarrera='$cursoCarrera',a_b.ingles='$idioma',a_b.paquetesLenguajes='$paquestesLenguaje',a_b.otrosOficios='$oficios',a_b.nombreEmpresa1='$ultimoActual1',a_b.fecha1='$fechaExperienciaLaboral1',a_b.puesto1='$puestoExperienciaLaboral1',a_b.motivo1='$motivoSeparacion1',a_b.jefe1='$nombreJefeInmediato1',a_b.puestoJefe1='$puestoUltimoActual1',a_b.telefono1='$telefonoExtension1',a_b.sueldo1='$sueldoDirario1',a_b.nombreEmpresa2='$ultimoActual2',a_b.fecha2='$fechaExperienciaLaboral2',a_b.puesto2='$puestoExperienciaLaboral2',a_b.motivo2='$motivoSeparacion2',a_b.jefe2='$nombreJefeInmediato2',a_b.jefePuesto2='$puestoUltimoActual2',a_b.telefono2='$telefonoExtension2',a_b.sueldo2='$sueldoDirario2',a_b.nombreEmpresa3='$ultimoActual3',a_b.fecha3='$fechaExperienciaLaboral3',a_b.puesto3='$puestoExperienciaLaboral3',a_b.motivo3='$motivoSeparacion3',a_b.jefe3='$nombreJefeInmediato3',a_b.jefePuesto3='$puestoUltimoActual3',a_b.telefono3='$telefonoExtension3',a_b.sueldo3='$sueldoDirario3',a_b.nombreEmpresa4='$ultimoActual4',a_b.fecha4='$fechaExperienciaLaboral4',a_b.puesto4='$puestoExperienciaLaboral4',a_b.motivo4='$motivoSeparacion4',a_b.jefe4='$nombreJefeInmediato4',a_b.jefePuesto4='$puestoUltimoActual4',a_b.telefono4='$telefonoExtension4',a_b.sueldo4='$sueldoDirario4',a_b.conocimientosEspecificos='$conocimientoEspecifico',a_b.habilidades='$habilidad' WHERE a_b.idSolicitudEmpleo=$idSolicitudEmpleoID";
			$resultado3 = $this->conexion->query($consulta3);
			if($this->conexion->affected_rows === 1)
					$var = "OK";
			if($resultado==1 || $resultado2==1 || $resultado3==1){
			  	if($var === "OK")
					return "OK";
				else 
					return "No se realizaron cambios. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminar($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$fecha_actual=date("Y/m/d");
		$consulta="DELETE FROM tblSalariosPuestos WHERE idSalarios=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarClientes(){
		$datos = array();
		$consulta="SELECT e.idEscolaridad, e.escolaridad FROM tblEscolaridad e order by e.idEscolaridad";
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

	public function buscarSalarios($cliente,$puesto){
		$datos = array();
		$consulta="SELECT s.idSalarios,s.cliente,s.estado,s.puesto,s.salario,Es.nombre from tblSalariosPuestos s inner join tblEstados Es ON Es.idestado=s.estado where s.cliente=$cliente and s.puesto=$puesto";
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

	public function listarEstados(){
		$datos = array();
		$consulta="SELECT Es.idestado,Es.idpais,Es.nombre,Es.region FROM tblEstados Es ORDER By Es.nombre ASC";
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

	public function rfc($rfc){
		$rfc = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
			$consulta="SELECT s.rfc,s.idSolicitudEmpleo,s.cpDatosPersonales FROM spartodo_rh.tblSolicitudEmpleo s WHERE s.rfc='$rfc'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			if($this->conexion->affected_rows === 1){
				return $resultado->fetch_assoc();
			}else{
				return "error";	
			}

			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function actualizarEstado($id,$estado){
		$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="UPDATE spartodo_rh.tblSolicitudEmpleo SET `estado`='$estado' WHERE `idSolicitudEmpleo`= '$id'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			if($this->conexion->affected_rows === 1){
				return "OK";
			}else{
				return "error";	
			}

			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function busquedaSolicitudVacante($busqueda){
		echo $busqueda;
		$busqueda = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($busqueda))));
		$datos = array();
		$consulta="SELECT s.idSolicitudEmpleo, CONCAT(s.nombresDatosPersonales,' ', s.apellidoPaternoDatosPersonales, ' ', s.apellidoMaternoDatosPersonales) AS nombre, p.nombre AS puesto FROM spartodo_rh.tblSolicitudEmpleo s LEFT JOIN spartodo_rh.tblPuestos p ON s.puesto = p.idPuesto left join spartodo_rh.tblAcademiaExperiencia ae ON ae.idSolicitudEmpleo=s.idSolicitudEmpleo LEFT JOIN spartodo_rh.tblEscolaridad es on es.idEscolaridad=ae.ultimoGradoEstudios WHERE MATCH(s.nombresDatosPersonales, s.apellidoPaternoDatosPersonales, s.apellidoMaternoDatosPersonales, s.curp, s.rfc) AGAINST('$busqueda' IN NATURAL LANGUAGE MODE) AND s.estado='Activa' and not EXISTS (SELECT idSolicitudEmpleo from spartodo_rh.tblVacantesPostuladas p where p.idSolicitudEmpleo=s.idSolicitudEmpleo) LIMIT 10";
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