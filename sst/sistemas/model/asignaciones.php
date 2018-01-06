<?php 
class asignaciones
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT * FROM tblAsignaciones a";
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

	public function informacion($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="SELECT sp.empleados_nombres,sp.empleados_apellido_paterno,sp.empleados_apellido_materno,sp.empleados_id,a.idLinea,a.idEmpleado,a.idCel,a.idSim,cp.imei,m.idMarca,m.marca,s.icc,l.linea,mo.modelo,sp.empleados_rfc FROM tblAsignaciones a inner join tbCelPhones c ON c.idCelular=a.idCel inner join tblMarcas m on m.idMarca=c.marca left join spar_empleados sp on sp.empleados_id=a.idEmpleado inner join tbCelPhones cp on cp.idCelular=a.idCel inner join tblSim s ON s.idSim=a.idSim inner join tblLineas l ON l.idLinea=a.idLinea inner join tblModelos mo ON mo.idModelo=cp.model WHERE a.idAsginaciones=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function guardar($datos){
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['lineas']))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idEmpleado']))));
		$idCel = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['imei']))));
		$idSim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idSimCCC']))));
		$estatus="Activo";
		$errores = 0;
		$errorResultado = "";

		if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El campo linea no puede estar vacío. <br>";
		}if (empty($idCel)) {
			$errores ++;
			$errorResultado .= "El campo imei no puede estar vacío. <br>";
		}if (empty($idSim)) {
			$errores ++;
			$errorResultado .= "El campo idSim no puede estar vacío. <br>";
		}if (empty($idEmpleado)) {
			$errores ++;
			$errorResultado .= "El campo idEmpleado no puede estar vacío. <br>";
		}	
		
		if($errores === 0){
			$consulta = "INSERT INTO tblAsignaciones(idLinea,idEmpleado,idCel,idSim,estatus) SELECT * FROM (SELECT '$linea' AS linea,'$idEmpleado' AS idEmpleado,'$idCel' AS idCel,'$idSim' AS idSim,'$estatus' AS estatus) AS tmp WHERE NOT EXISTS (SELECT idCel FROM tblAsignaciones WHERE idCel = '$idCel') LIMIT 1; ";
			echo $consulta;
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El imei ya existe. <br>";
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
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['lineas']))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idEmpleado']))));
		$idCel = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['imei']))));
		$idSim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idSimCCC']))));

		$errores = 0;
		$errorResultado = "";

		if (empty($id)) {
			$errores ++;
			$errorResultado .= "El campo id no puede estar vacío. <br>";
		}if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El campo linea no puede estar vacío. <br>";
		}if (empty($idCel)) {
			$errores ++;
			$errorResultado .= "El campo imei no puede estar vacío. <br>";
		}if (empty($idSim)) {
			$errores ++;
			$errorResultado .= "El campo idSim no puede estar vacío. <br>";
		}if (empty($idEmpleado)) {
			$errores ++;
			$errorResultado .= "El campo idEmpleado no puede estar vacío. <br>";
		}	

		if($errores === 0){
			$consulta = "UPDATE tblAsignaciones  a_b SET a_b.idLinea = '$linea',a_b.idEmpleado = '$idEmpleado',a_b.idCel = '$idCel',a_b.idSim = '$idSim' WHERE a_b.idAsginaciones = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblAsignaciones) AS a_b_2 WHERE a_b_2.idCel = '$idCel' AND a_b_2.idAsginaciones != '$id') AS count)";
			echo $consulta;
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El imei ya existe o no se actualizó ningún dato. <br>";	
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
		$consultarRegiones="SELECT * FROM tblRegiones r inner join tblEstados Es on r.id=Es.region  where Es.region=$id";
		$resultado = $this->conexion->query($consultarRegiones);
			if($resultado){
				if($this->conexion->affected_rows >= 1){
						return "No se puede eliminar esta región porque ya está asignada a un empleado.";
					}else{
						$consulta="DELETE FROM tblRegiones WHERE id = $id";
						$resultado2 = $this->conexion->query($consulta);
						return "OK";
						}
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}



		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	
	public function buscarImei($imei){
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$consulta="SELECT c.idCelular,m.marca,mo.modelo as model,c.imei FROM tbCelPhones c inner join tblMarcas m ON m.idMarca=c.marca INNER JOIN tblModelos mo ON mo.idModelo=c.model  WHERE c.idCelular=$imei";
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

	public function buscarLinea($linea){
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($linea))));
		$consulta="SELECT a.idAsginaciones, a.linea,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,s.empleados_rfc FROM tblAsignaciones a inner join spar_empleados s ON s.empleados_id=a.idEmpleado where a.linea='$linea'";
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

	public function listarCuentas(){
		$datos = array();
		$consulta="SELECT idCuenta, numeroCuenta, cliente FROM tblCuentas";
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


	public function listarAdmon(){
		$datos = array();
		$consulta="SELECT s.empleados_id,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno FROM spar_empleados s where s.empleados_vigente=1 and s.empleados_empresa='admon' order by s.empleados_nombres";
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