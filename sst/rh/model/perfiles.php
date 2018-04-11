<?php 
class perfiles
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT p.idPerfil,p.fechaSolicitud, p.nombrePerfil, p.edad, p.sexo, p.escolaridad, p.estadoCivil, p.experiencia, p.imagen, p.talla, p.entrevistaCliente, p.conocimientosEspecificos, p.habilidades, p.evaluaciones,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,cl.nombreComercial FROM spartodo_rh.tblPerfiles p left join spartodo_spar_bd.spar_empleados s on p.idSolicitante=s.empleados_id left join spartodo_spar_bd.tblClientes cl on cl.idclientes=p.idCliente";
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
			$consulta="SELECT p.edad,p.edadMaxima,p.idPerfil,p.fechaSolicitud,p.nombrePerfil,p.sexo,p.escolaridad as perfilEscolaridad,p.estadoCivil,p.experiencia,p.talla,p.entrevistaCliente,p.conocimientosEspecificos,p.habilidades,p.evaluaciones,s.empleados_nombres,e.escolaridad,p.imagen,p.idCliente,p.idPuesto,p.salario,p.opcional,p.diasTrabajados,p.horarioEntrada,p.horarioSalida,p.prestacionesLey,p.ayudaAuto,p.paquetes,p.uniforme FROM spartodo_rh.tblPerfiles p left join spar_empleados s on p.idSolicitante=s.empleados_id left join spartodo_spar_bd.tblEscolaridad e on e.idEscolaridad=p.escolaridad WHERE p.idPerfil=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function guardar($datos,$conocimientos,$imagen,$habilidades,$evaluaciones,$idEmpleado,$paquetesLenguajes,$diasTrabajados,$horariosEntrada,$horariosSalida){
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$nombrePerfil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombrePerfil"]))));
		$puesto= $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
		$salario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["salario"]))));
		$fechaSolicitud = date("Y-m-d H:i:s");
		$edad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edad"]))));
		$sexo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sexo"]))));
		$escolaridad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["escolaridad"]))));
		$estadoCivil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estadoCivil"]))));
		$experiencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["experiencia"]))));
		$talla = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["talla"]))));
		$entrevista = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["entrevista"]))));
		$prestaciones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["prestaciones"]))));
		$ayudaAuto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ayudaAuto"]))));
		$cliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cliente"]))));
		$edadMaxima = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edadMaxima"]))));
		$uniforme = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["uniforme"]))));
		if(isset($datos["opcional"])){
			$opcional = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["opcional"]))));
		}else{
			$opcional = NULL;
		}
		

		if(isset($diasTrabajados)){
			$diasTrabajados1 = implode(",", $diasTrabajados);
			$diasTrabajados1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($diasTrabajados1))));
		}else{
			$diasTrabajados1 = NULL;
		}
		if($paquetesLenguajes == ''){
			$paqueteLenguaje = NULL;
		}else{
			$paqueteLenguaje = implode(",", $paquetesLenguajes);
			$paqueteLenguaje = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($paqueteLenguaje))));
		}
		if($conocimientos == ''){
			$conocimientos = NULL;
		}else{
			$conocimientos = array_slice($conocimientos, 1); 
			$conocimiento = implode(",", $conocimientos);
			$conocimientos = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimiento))));
		}if(isset($horariosEntrada)){
			$entrada = implode(",", $horariosEntrada);
			$horarioEntrada = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($entrada))));
		}else{
			$horarioEntrada = NULL;
		}if(isset($horariosSalida)){
			$salida = implode(",", $horariosSalida);
			$HorarioSalida = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($salida))));
		}else{
			$HorarioSalida = NULL;
		}if(isset($imagen)){
			$imagenDescripcion = implode(",", $imagen);
			$imagen = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imagenDescripcion))));
		}else{
			$imagen = NULL;
		}if($habilidades == ''){
			$habilidad = NULL;
		}else{
			$habilidades = array_slice($habilidades, 1); 
			$habilidad = implode(",", $habilidades);
			$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad))));
		}if(isset($evaluaciones)){
			$evaluacion1 = implode(",", $evaluaciones);
			$evaluacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($evaluacion1))));
		}else{
			$evaluacion = NULL;
		}
		$errores = 0;
		$errorResultado = "";

		if (empty($idEmpleado)) {
			$errores ++;
			$errorResultado .= "El campo solicitante no puede estar vacío. <br>";
		}if (empty($fechaSolicitud)) {
			$errores ++;
			$errorResultado .= "El campo fecha de solicitud no puede estar vacío. <br>";
		}if (empty($edad)) {
			$errores ++;
			$errorResultado .= "El campo edad minima no puede estar vacío. <br>";
		}if (empty($edadMaxima)) {
			$errores ++;
			$errorResultado .= "El campo edad maxima no puede estar vacío. <br>";
		}if (empty($sexo)) {
			$errores ++;
			$errorResultado .= "El campo sexo no puede estar vacío. <br>";
		}if (empty($escolaridad)) {
			$errores ++;
			$errorResultado .= "El campo escolaridad no puede estar vacío. <br>";
		}if (empty($estadoCivil)) {
			$errores ++;
			$errorResultado .= "El campo estado civil no puede estar vacío. <br>";
		}if (empty($experiencia)) {
			$errores ++;
			$errorResultado .= "El campo experiencia no puede estar vacío. <br>";
		}if (empty($imagen)) {
			$errores ++;
			$errorResultado .= "El campo imagen no puede estar vacío. <br>";
		}if (empty($talla)) {
			$errores ++;
			$errorResultado .= "El campo talla no puede estar vacío. <br>";
		}if (empty($entrevista)) {
			$errores ++;
			$errorResultado .= "El campo entrevista no puede estar vacío. <br>";
		}if (empty($salario)) {
			$errores ++;
			$errorResultado .= "El campo salario no puede estar vacío. <br>";
		}if (empty($edadMaxima)) {
			$errores ++;
			$errorResultado .= "El campo edad maxima no puede estar vacío. <br>";
		}if (empty($uniforme)) {
			$errores ++;
			$errorResultado .= "El campo uniforme maxima no puede estar vacío. <br>";
		}if (empty($ayudaAuto)) {
			$errores ++;
			$errorResultado .= "El campo ayuda de auto no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO spartodo_rh.tblPerfiles (`idSolicitante`,`idPuesto`, `fechaSolicitud`, `nombrePerfil`, `salario`,`edad`, `edadMaxima`, `sexo`,`opcional`,`escolaridad`, `estadoCivil`,`diasTrabajados`,`horarioEntrada`,`horarioSalida`,`experiencia`, `imagen`, `talla`, `entrevistaCliente`, `conocimientosEspecificos`, `habilidades`,`evaluaciones`,`paquetes`,`ayudaAuto`,`prestacionesLey`,`idCliente`,`uniforme`) VALUES ($idEmpleado,$puesto,'$fechaSolicitud', '$nombrePerfil',$salario,$edad,'$edadMaxima','$sexo','$opcional','$escolaridad','$estadoCivil','$diasTrabajados1','$horarioEntrada','$HorarioSalida','$experiencia','$imagen','$talla','$entrevista','$conocimientos','$habilidad','$evaluacion','$paqueteLenguaje','$ayudaAuto','$prestaciones','$cliente','$uniforme')";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El perfil ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($datos,$conocimientos,$imagen,$habilidades,$evaluaciones,$idEmpleado,$paquetesLenguajes,$diasTrabajados,$horariosEntrada,$horariosSalida){
		$idPerfil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idPerfil"]))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$nombrePerfil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["nombrePerfil"]))));
		$puesto= $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
		$salario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["salario"]))));
		$fechaSolicitud = date("Y-m-d H:i:s");
		$edad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edad"]))));
		$sexo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sexo"]))));
		$escolaridad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["escolaridad"]))));
		$estadoCivil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estadoCivil"]))));
		$experiencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["experiencia"]))));
		$talla = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["talla"]))));
		$entrevista = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["entrevista"]))));
		$prestaciones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["prestaciones"]))));
		$ayudaAuto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ayudaAuto"]))));
		$cliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cliente"]))));
		$edadMaxima = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edadMaxima"]))));
		$uniforme = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["uniforme"]))));
		if(isset($datos["opcional"])){
			$opcional = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["opcional"]))));
		}else{
			$opcional = NULL;
		}
		if(isset($diasTrabajados)){
			$diasTrabajados1 = implode(",", $diasTrabajados);
			$diasTrabajados1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($diasTrabajados1))));
		}else{
			$diasTrabajados1 = NULL;
		}
		if($paquetesLenguajes == ''){
			$paqueteLenguaje = NULL;
		}else{
			$paqueteLenguaje = implode(",", $paquetesLenguajes);
			$paqueteLenguaje = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($paqueteLenguaje))));
		}
		if($conocimientos == ''){
			$conocimientos = NULL;
		}else{
			//$conocimientos = array_slice($conocimientos, 1); 
			$conocimiento = implode(",", $conocimientos);
			$conocimientos = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($conocimiento))));
		}if(isset($horariosEntrada)){
			$entrada = implode(",", $horariosEntrada);
			$horarioEntrada = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($entrada))));
		}else{
			$horarioEntrada = NULL;
		}if(isset($horariosSalida)){
			$salida = implode(",", $horariosSalida);
			$HorarioSalida = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($salida))));
		}else{
			$HorarioSalida = NULL;
		}if(isset($imagen)){
			$imagenDescripcion = implode(",", $imagen);
			$imagen = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imagenDescripcion))));
		}else{
			$imagen = NULL;
		}if($habilidades == NULL){
			$habilidad = NULL;
		}else{ 
			$habilidad = implode(",", $habilidades);
			$habilidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($habilidad))));
		}if(isset($evaluaciones)){
			$evaluacion1 = implode(",", $evaluaciones);
			$evaluacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($evaluacion1))));
		}else{
			$evaluacion = NULL;
		}
		$errores = 0;
		$errorResultado = "";

		if (empty($idEmpleado)) {
			$errores ++;
			$errorResultado .= "El campo solicitante no puede estar vacío. <br>";
		}if (empty($fechaSolicitud)) {
			$errores ++;
			$errorResultado .= "El campo fecha de solicitud no puede estar vacío. <br>";
		}if (empty($edad)) {
			$errores ++;
			$errorResultado .= "El campo edad minima no puede estar vacío. <br>";
		}if (empty($edadMaxima)) {
			$errores ++;
			$errorResultado .= "El campo edad maxima no puede estar vacío. <br>";
		}if (empty($sexo)) {
			$errores ++;
			$errorResultado .= "El campo sexo no puede estar vacío. <br>";
		}if (empty($escolaridad)) {
			$errores ++;
			$errorResultado .= "El campo escolaridad no puede estar vacío. <br>";
		}if (empty($estadoCivil)) {
			$errores ++;
			$errorResultado .= "El campo estado civil no puede estar vacío. <br>";
		}if (empty($experiencia)) {
			$errores ++;
			$errorResultado .= "El campo experiencia no puede estar vacío. <br>";
		}if (empty($imagen)) {
			$errores ++;
			$errorResultado .= "El campo imagen no puede estar vacío. <br>";
		}if (empty($talla)) {
			$errores ++;
			$errorResultado .= "El campo talla no puede estar vacío. <br>";
		}if (empty($entrevista)) {
			$errores ++;
			$errorResultado .= "El campo entrevista no puede estar vacío. <br>";
		}if (empty($salario)) {
			$errores ++;
			$errorResultado .= "El campo salario no puede estar vacío. <br>";
		}if (empty($edadMaxima)) {
			$errores ++;
			$errorResultado .= "El campo edad maxima no puede estar vacío. <br>";
		}if (empty($uniforme)) {
			$errores ++;
			$errorResultado .= "El campo uniforme maxima no puede estar vacío. <br>";
		}if (empty($ayudaAuto)) {
			$errores ++;
			$errorResultado .= "El campo ayuda de auto no puede estar vacío. <br>";
		}

		if($errores === 0){ 
			$consulta = "UPDATE spartodo_rh.tblPerfiles a_b SET a_b.idPuesto='$puesto',a_b.idSolicitante=$idEmpleado,a_b.fechaSolicitud='$fechaSolicitud',a_b.nombrePerfil='$nombrePerfil',a_b.salario=$salario,a_b.edad=$edad,a_b.edadMaxima=$edadMaxima,a_b.sexo='$sexo',a_b.opcional='$opcional',a_b.escolaridad=$escolaridad,a_b.estadoCivil='$estadoCivil',a_b.diasTrabajados='$diasTrabajados1',a_b.horarioEntrada='$horarioEntrada',a_b.horarioSalida='$HorarioSalida',a_b.experiencia='$experiencia',a_b.imagen='$imagen',a_b.talla='$talla',a_b.entrevistaCliente='$entrevista',a_b.conocimientosEspecificos='$conocimientos',a_b.habilidades='$habilidad',a_b.evaluaciones='$evaluacion',a_b.paquetes='$paqueteLenguaje',a_b.ayudaAuto='$ayudaAuto',a_b.prestacionesLey='$prestaciones',a_b.idCliente=$cliente,a_b.uniforme='$uniforme' WHERE a_b.idperfil=$idPerfil";
			//echo $consulta;
			$resultado = $this->conexion->query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
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
		$consultarPerfiles="SELECT * FROM spartodo_rh.tblVacantes v inner join spartodo_rh.tblPerfiles p on v.idPerfil = p.idPerfil where p.idPerfil = $id";
		$resultado = $this->conexion->query($consultarPerfiles);		
		if($resultado){
			if($this->conexion->affected_rows >= 1){
				return "No se puede eliminar este perfil esta asigando a una vacante.";
			}else{
				$consulta="DELETE FROM spartodo_rh.tblPerfiles WHERE idPerfil = $id";
				$resultado2 = $this->conexion->query($consulta);
				return "OK";
			}
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarEscolaridad(){
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
		
	public function cargarPerfiles($idCliente){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$datos = array();
		$consulta="SELECT p.idPerfil, p.nombrePerfil, p.salario FROM spartodo_rh.tblPerfiles p WHERE p.idCliente = '$idCliente' ORDER BY p.nombrePerfil";
		$resultado = $this->conexion->query($consulta);
		// echo $consulta;
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

	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>