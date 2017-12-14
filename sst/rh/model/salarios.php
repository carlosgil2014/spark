<?php 
class salarios
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT e.empleados_id,e.empleados_nombres,e.empleados_apellido_paterno,e.empleados_apellido_materno,e.empleados_rfc,e.empleados_curp,e.empleados_correo,Es.nombre,r.region,e.codigoPostal FROM spar_empleados e LEFT JOIN tblEstados Es ON e.empleados_estado=Es.idestado INNER JOIN tblRegiones r ON Es.region=r.idRegion INNER JOIN tblPuestos p ON e.empleados_puesto=p.idPuesto WHERE p.idPuesto=164 and e.empleados_vigente=1";
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

		public function guardar($datos){

			$cliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cliente"]))));
			$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["puesto"]))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["estado"]))));
			$salario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["salario"]))));
			

		$errores = 0;
		$errorResultado = "";

		if (empty($cliente)) {
			$errores ++;
			$errorResultado .= "El campo cliente no puede estar vacío. <br>";
		}if (empty($puesto)) {
			$errores ++;
			$errorResultado .= "El campo puesto no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El campo estado no puede estar vacío. <br>";
		}if (empty($salario)) {
			$errores ++;
			$errorResultado .= "El campo salario no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO tblSalariosPuestos (cliente,estado,puesto,salario) SELECT * FROM (SELECT '$cliente' AS cliente,'$estado' AS estado,'$puesto' AS puesto,'$salario' AS salario) AS tmp WHERE NOT EXISTS (SELECT cliente,estado,puesto FROM tblSalariosPuestos WHERE cliente = '$cliente' and estado = '$estado' and puesto = '$puesto') LIMIT 1";
			echo $consulta;
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

	public function listarClientes(){
		$datos = array();
		$consulta="SELECT c.idclientes,c.razonSocial FROM tblClientes c ORDER BY c.razonSocial ASC";
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