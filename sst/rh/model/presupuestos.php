<?php 
class presupuestos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar($clientes){
		$datos = array();
		// var_dump($clientes);
		$tmpClientes = implode("','", array_map(function ($cliente){return $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($cliente['idclientes'])))));}, $clientes));
		$consulta="SELECT p.idPresupuesto, p.nombre, p.tipo, c.nombreComercial, pr.nombre AS proyecto, CONCAT(e.empleados_nombres, ' ', e.empleados_apellido_paterno, ' ', e.empleados_apellido_materno) AS elaborado, p.fechaRegistro FROM spartodo_rh.tblPresupuestos p LEFT JOIN tblClientes c ON p.idCliente = c.idclientes LEFT JOIN tblProyectos pr ON p.idProyecto = pr.idProyecto LEFT JOIN spar_empleados e ON p.idSolicitante = e.empleados_id WHERE p.idCliente IN ('$tmpClientes')";
		// echo $consulta;
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

	public function informacion($idPresupuesto){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$consulta="SELECT p.idPresupuesto, p.nombre, p.tipo, p.idProyecto, p.idCliente, COUNT(v.idVacante) AS vacantes  FROM spartodo_rh.tblPresupuestos p LEFT JOIN spartodo_rh.tblVacantes v ON v.idPresupuesto = p.idPresupuesto WHERE p.idPresupuesto = '$idPresupuesto'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function informacionPuestosPresupuesto($idPresupuesto){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(base64_decode(trim($idPresupuesto)))));
		$datos = array();
		$consulta="SELECT p.idPresupuestoPuesto, p.idPresupuesto, p.idPuesto, p.cantidad, p.costoUnitario, p.dias, COUNT(v.idVacante) AS vacantes FROM spartodo_rh.tblPresupuestosPuestos p LEFT JOIN spartodo_rh.tblVacantes v ON v.idPresupuestoPuesto = p.idPresupuestoPuesto WHERE p.idPresupuesto = '$idPresupuesto' GROUP BY p.idPresupuestoPuesto";
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

	public function informacionPuestoPresupuesto($idPresupuestoPuestos){
		$datos = array();
		$arrTmp = array();
		foreach ($idPresupuestoPuestos as $idPresupuestoPuesto) {
			$arrTmp[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuestoPuesto)))));
		}
		$cadenaIdPresupuestoPuestos = implode("','", $arrTmp);
		$consulta="SELECT p.idPresupuesto, p.idPresupuestoPuesto, p.idPuesto, (p.cantidad - COUNT(v.idPresupuestoPuesto)) AS disponible, p.costoUnitario, pu.nombre FROM spartodo_rh.tblPresupuestosPuestos p LEFT JOIN spartodo_rh.tblVacantes v ON v.idPresupuestoPuesto = p.idPresupuestoPuesto LEFT JOIN spartodo_rh.tblPuestos pu ON p.idPuesto = pu.idPuesto WHERE  p.idPresupuestoPuesto IN ('$cadenaIdPresupuestoPuestos') GROUP BY p.idPresupuestoPuesto, p.idPuesto HAVING disponible > 0 ";
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

	public function guardar($nombre, $tipo, $idCliente, $idProyecto, $idEmpleado){
		$nombre = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($nombre))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$idProyecto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idProyecto)))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$arrTipo = array("Fijo", "Temporal"); 
		$errores = 0;
		$errorResultado = "";
		
		if(empty($nombre)) {
			$errores ++;
			$errorResultado .= "El nombre del presupuesto es incorrecto. <br>";
		}
		
		if(!in_array($tipo, $arrTipo)){
			$errores ++;
			$errorResultado .= "El tipo es incorrecto. <br>";
		}

		if(!ctype_digit($idCliente)) {
			$errores ++;
			$errorResultado .= "El cliente es incorrecto. <br>";
		}

		if(!ctype_digit($idProyecto)) {
			$idProyecto = 0;
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO spartodo_rh.tblPresupuestos(nombre, tipo, idCliente, idProyecto, idSolicitante, fechaRegistro, fechaModificacion) VALUES('$nombre', '$tipo', '$idCliente', '$idProyecto', '$idEmpleado', '$hoy', '$hoy')";
			$resultado = $this->conexion -> query($consulta);
			// echo $consulta;
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			return base64_encode($this->conexion->insert_id);
		  		}
				else 
					return "Error al guardar el presupuesto.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function guardarPuestosPresupuesto($idPresupuesto, $idPuesto, $cantidad, $costoUnitario, $dias, $idEmpleado){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPuesto)))));
		$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cantidad))));
		$costoUnitario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($costoUnitario))));
		$dias = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dias))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}
		
		if(!ctype_digit($idPuesto)){
			$errores ++;
			$errorResultado .= "El puesto es incorrecto. <br>";
		}

		if(!ctype_digit($cantidad)) {
			$errores ++;
			$errorResultado .= "La $cantidad es incorrecta. <br>";
		}

		if(!$costoUnitario = number_format($costoUnitario,2)) {
			$errores ++;
			$errorResultado .= "El $costoUnitario es incorrecto. <br>";
		}

		if(!ctype_digit($dias)) {
			$errores ++;
			$errorResultado .= "Los $dias son incorrectos. <br>";
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}

		if($errores === 0){
			$consulta = "INSERT INTO spartodo_rh.tblPresupuestosPuestos(idPresupuesto, idPuesto, cantidad, costoUnitario, dias, idSolicitante, fechaRegistro, fechaModificacion) VALUES('$idPresupuesto', '$idPuesto', '$cantidad', '$costoUnitario', '$dias', '$idEmpleado', '$hoy', '$hoy')";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			return "OK";
		  		}
				else 
					return "Error al guardar el presupuesto.";
	 		}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminarFilaPresupuesto($idPresupuesto, $idPresupuestoPuesto, $idEmpleado){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idPresupuestoPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuestoPuesto)))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";

		if(!ctype_digit($idPresupuesto)){
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}

		if(!ctype_digit($idPresupuestoPuesto)){
			$errores ++;
			$errorResultado .= "La fila del presupuesto es incorrecta. <br>";
		}

		if(!ctype_digit($idEmpleado)){
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}

		if($errores === 0){

			$consulta = "SELECT COUNT(v.idVacante) AS vacantes FROM spartodo_rh.tblPresupuestosPuestos p LEFT JOIN spartodo_rh.tblVacantes v ON v.idPresupuestoPuesto = p.idPresupuestoPuesto WHERE p.idPresupuestoPuesto = '$idPresupuestoPuesto' AND p.idPresupuesto = '$idPresupuesto'";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
				$filaTmp = $resultado->fetch_assoc();
			  	if($filaTmp["vacantes"] === '0'){
					$consulta = "UPDATE spartodo_rh.tblPresupuestos SET fechaModificacion = '$hoy', idSolicitante = '$idEmpleado' WHERE idPresupuesto = '$idPresupuesto'";
					$resultado = $this->conexion -> query($consulta);
					if($resultado){
				  		if($this->conexion->affected_rows === 1){
				  			$consulta = "DELETE FROM spartodo_rh.tblPresupuestosPuestos WHERE idPresupuestoPuesto = '$idPresupuestoPuesto' AND idPresupuesto = '$idPresupuesto'";
							$resultado = $this->conexion -> query($consulta);
							if($resultado){
				  				if($this->conexion->affected_rows === 1){
				  					return "OK";
				  				}
				  				else
				  					return "No existe registro a borrar.";
				  			}
				  		}
						else 
							return "Error al guardar el presupuesto.";
					}
					else{
						return $this->conexion->errno . " : " . $this->conexion->error . "\n";
					}
				}
				else{
					return "Vacantes existentes.";
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

	public function actualizar($idPresupuesto, $nombre, $tipo, $idCliente, $idProyecto, $idEmpleado){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$nombre = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($nombre))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$idProyecto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idProyecto)))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$arrTipo = array("Fijo", "Temporal"); 
		$errores = 0;
		$errorResultado = "";
		
		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}

		if(empty($nombre)) {
			$errores ++;
			$errorResultado .= "El nombre del presupuesto es incorrecto. <br>";
		}
		
		if(!in_array($tipo, $arrTipo)){
			$errores ++;
			$errorResultado .= "El tipo es incorrecto. <br>";
		}

		if(!ctype_digit($idCliente)) {
			$errores ++;
			$errorResultado .= "El cliente es incorrecto. <br>";
		}

		if(!ctype_digit($idProyecto)) {
			$idProyecto = 0;
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}

		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblPresupuestos SET nombre = '$nombre', tipo = '$tipo', idCliente = '$idCliente', idProyecto = '$idProyecto', idSolicitante = '$idEmpleado', fechaModificacion = '$hoy' WHERE idPresupuesto = '$idPresupuesto'";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		return "OK";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizarPuestosPresupuesto($idPresupuestoPuesto, $idPresupuesto, $idPuesto, $cantidad, $costoUnitario, $dias, $idEmpleado){
		$idPresupuestoPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuestoPuesto)))));
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$idPuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPuesto)))));
		$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cantidad))));
		$costoUnitario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($costoUnitario))));
		$dias = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dias))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if(!ctype_digit($idPresupuestoPuesto)) {
			$errores ++;
			$errorResultado .= "La fila del presupuesto es incorrecta. <br>";
		}

		if(!ctype_digit($idPresupuesto)) {
			$errores ++;
			$errorResultado .= "El presupuesto es incorrecto. <br>";
		}
		
		if(!ctype_digit($idPuesto)){
			$errores ++;
			$errorResultado .= "El $idPuesto es incorrecto. <br>";
		}

		if(!ctype_digit($cantidad)) {
			$errores ++;
			$errorResultado .= "La $cantidad es incorrecta. <br>";
		}

		if(!$costoUnitario = number_format($costoUnitario,2)) {
			$errores ++;
			$errorResultado .= "El $costoUnitario es incorrecto. <br>";
		}

		if(!ctype_digit($dias)) {
			$errores ++;
			$errorResultado .= "Los $dias son incorrectos. <br>";
		}

		if(!ctype_digit($idEmpleado)) {
			$errores ++;
			$errorResultado .= "La sesión expiró, inicie nuevamente. <br>";
		}

		if($errores === 0){
			$consulta = "UPDATE spartodo_rh.tblPresupuestosPuestos SET idPuesto = '$idPuesto', cantidad = '$cantidad', costoUnitario = '$costoUnitario', dias = '$dias', idSolicitante = '$idEmpleado' WHERE idPresupuestoPuesto = '$idPresupuestoPuesto' AND idPresupuesto = '$idPresupuesto'";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){
		  			$consulta = "UPDATE spartodo_rh.tblPresupuestosPuestos SET fechaModificacion = '$hoy' WHERE idPresupuestoPuesto = '$idPresupuestoPuesto' AND idPresupuesto = '$idPresupuesto'";
					$resultado = $this->conexion -> query($consulta);
					if($resultado){
		  				return "Actualizado";
		  			}
		  			else{
						return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		  			}
		  		}
				else 
					return "OK";
	 		}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function cargarPresupuestos($idCliente){
		$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idCliente)))));
		$datos = array();
		$consulta="SELECT p.idPresupuesto, p.nombre FROM spartodo_rh.tblPresupuestos p WHERE p.idCliente = '$idCliente' ORDER BY p.nombre";
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

	public function cargarPuestosPresupuestos($idPresupuesto){
		$idPresupuesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(base64_decode($idPresupuesto)))));
		$datos = array();
		$consulta="SELECT p.idPresupuesto, p.idPresupuestoPuesto, p.idPuesto, (p.cantidad - COUNT(v.idPresupuestoPuesto)) AS disponible, p.costoUnitario, pu.nombre FROM spartodo_rh.tblPresupuestosPuestos p LEFT JOIN spartodo_rh.tblVacantes v ON v.idPresupuestoPuesto = p.idPresupuestoPuesto LEFT JOIN spartodo_rh.tblPuestos pu ON p.idPuesto = pu.idPuesto WHERE p.idPresupuesto = '$idPresupuesto' GROUP BY p.idPresupuestoPuesto, p.idPuesto HAVING disponible > 0";
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

	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>