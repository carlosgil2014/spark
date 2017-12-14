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
		$consulta="SELECT v.IdPerfil, v.solicitante, v.fechaSolicitud, v.nombrePuesto, v.plan, v.edad, v.sexo, v.escolaridad, v.estadoCivil, v.experiencia, v.conocimientosEspecificos, v.imagen, v.talla, v.entrevistadoCliente, v.otro, v.jornadaInicio, v.descanso, v.horario, v.horarioTermino, v.sueldo, v.ayuda, v.prestacionesLey, v.uniforme, v.material, v.observaciones, v.funcionesGenerales, v.conocimientos, v.habilidades, v.cleaver, v.personalidad, v.excel, v.ppt, v.word, v.otra,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno FROM tblPerfiles v inner join spar_empleados s ON v.solicitante=s.empleados_id";
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
			$consulta="SELECT s.idSalarios,s.cliente,s.salario,s.estado,s.puesto,Es.nombre,c.razonSocial,p.idPuesto FROM tblSalariosPuestos s inner join tblEstados Es ON Es.idestado=s.estado inner join tblClientes c ON c.idclientes=s.cliente inner join tblPuestos p ON p.idPuesto=s.puesto where s.idSalarios=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($datos,$conocimientos,$horariosEntrada,$horariosSalida,$imagen,$habilidades,$personalidad){

			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idSolicitante"]))));
			$fechaSolicitud = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["fechaSolicitud"]))));
			$puesto = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
			$plan = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["plan"]))));
			$edad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edad"]))));
			$sexo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sexo"]))));
			$escolaridad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["escolaridad"]))));
			$estadoCivil = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estadoCivil"]))));
			$experiencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["experiencia"]))));
			$talla = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["talla"]))));
			$entrevista = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["entrevista"]))));
			$sueldo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["sueldo"]))));
			$ayuda = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["ayuda"]))));
			$prestaciones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["prestaciones"]))));
			$uniforme = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["uniforme"]))));
			
			if(isset($datos["observaciones"]))
			$observaciones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["observaciones"]))));
			else
			$calle = NULL;
			if(isset($datos["otros"]))
			$otros = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["otros"]))));
			else
			$calle = NULL;

			$conocimiento = implode(",", $conocimientos);
			$entrada = implode(",", $horariosEntrada);
			$salida = implode(",", $horariosSalida);
			$imagenDescripcion = implode(",", $imagen);
			$habilidad = implode(",", $habilidades);
			$personalidad1 = implode(",", $personalidad);
			echo $conocimiento,$entrada,$salida,$imagenDescripcion,$habilidad,$personalidad1;


		$errores = 0;
		$errorResultado = "";

		if (empty($id)) {
			$errores ++;
			$errorResultado .= "El campo solicitante no puede estar vacío. <br>";
		}if (empty($fechaSolicitud)) {
			$errores ++;
			$errorResultado .= "El campo fecha de solicitud no puede estar vacío. <br>";
		}if (empty($puesto)) {
			$errores ++;
			$errorResultado .= "El campo puesto no puede estar vacío. <br>";
		}if (empty($plan)) {
			$errores ++;
			$errorResultado .= "El campo plan no puede estar vacío. <br>";
		}if (empty($edad)) {
			$errores ++;
			$errorResultado .= "El campo edad no puede estar vacío. <br>";
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
		}if (empty($talla)) {
			$errores ++;
			$errorResultado .= "El campo talla no puede estar vacío. <br>";
		}if (empty($entrevista)) {
			$errores ++;
			$errorResultado .= "El campo entrevista no puede estar vacío. <br>";
		}if (empty($otros)) {
			$errores ++;
			$errorResultado .= "El campo otros no puede estar vacío. <br>";
		}if (empty($sueldo)) {
			$errores ++;
			$errorResultado .= "El campo sueldo no puede estar vacío. <br>";
		}if (empty($ayuda)) {
			$errores ++;
			$errorResultado .= "El campo ayuda no puede estar vacío. <br>";
		}if (empty($prestaciones)) {
			$errores ++;
			$errorResultado .= "El campo prestaciones no puede estar vacío. <br>";
		}if (empty($uniforme)) {
			$errores ++;
			$errorResultado .= "El campo uniforme no puede estar vacío. <br>";
		}if (empty($observaciones)) {
			$errores ++;
			$errorResultado .= "El campo observaciones no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO `tblVacantes` (`IdVacante`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `fechaSolicitud`, `nombreVacante`, `plan`, `edad`, `sexo`, `escolaridad`, `estadoCivil`, `experiencia`, `conocimientosEspecificos`, `imagen`, `talla`, `entrevistadoCliente`, `otro`, `jornadaInicio`, `descanso`, `horario`, `horarioTermino`, `sueldo`, `ayuda`, `prestacionesLey`, `uniforme`, `material`, `observaciones`, `funcionesGenerales`, `conocimientos`, `habilidades`, `cleaver`, `personalidad`, `excel`, `ppt`, `word`, `otra`) VALUES (NULL, 'Jim', 'Morrison', 'Angus', '2017-11-27', 'Hey amigo', '1', '25', '1', 'universidad', '1', 'mucha', 'muchos', 'PRESENTABLE, ASEADO', '30.5', 'no', 'xxxxxx', '1,2,3,4,5', '6,7', '9:00', '6:00', '200.30', 'si', 'si', 'si', 'xxxxxx', 'pppppppp', 'aaaaaa', 'php,mysql', 'muchas', 'si', 'si', 'si', 'si', 'si', 'si'); LIMIT 1";
			//echo $consulta;
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El salario ya existe para el puesto y la ciudad. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$datos){
			$cliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cliente"]))));
			$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estado"]))));
			$salario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["salario"]))));

		$errores = 0;
		$errorResultado = "";

		if (empty($cliente)) {
			$errores ++;
			$errorResultado .= "El cliente no puede estar vacío. <br>";
		}if (empty($puesto)) {
			$errores ++;
			$errorResultado .= "El puesto no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El estado  no puede estar vacío. <br>";
		}if (empty($salario)) {
			$errores ++;
			$errorResultado .= "El campo salario  no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "UPDATE tblSalariosPuestos a_b SET a_b.cliente = '$cliente',a_b.puesto = '$puesto',a_b.estado = '$estado',a_b.salario = '$salario' WHERE a_b.idSalarios = $id";
			$resultado = $this->conexion -> query($consulta);
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

	public function listarEstadoCivil(){
		$datos = array();
		$consulta="SELECT e.idEstadoCivil, e.estadoCivil FROM tblEstadoCivil e ORDER BY e.estadoCivil";
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
		
	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>