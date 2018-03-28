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
		$consulta = "SELECT cu.cliente,a.idLinea,a.idAsignaciones,l.linea,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,c.imei,m.modelo,ma.marca,a.estatus,Es.nombre FROM (SELECT a1.idAsignaciones, a1.estatus, a1.idLinea, a1.idEmpleado, a1.idCel,a1.idEstado,a1.idCuenta FROM tblAsignaciones a1 WHERE a1.idAsignaciones = (SELECT MAX(idAsignaciones) FROM tblAsignaciones WHERE idLinea = a1.idLinea)) a LEFT JOIN tblLineas l ON l.idLinea = a.idLinea LEFT JOIN spar_empleados s on s.empleados_id = a.idEmpleado LEFT JOIN tblCelurares c on c.idCelular = a.idCel LEFT JOIN tblModelos m on m.idModelo=c.idModelo LEFT JOIN tblMarcas ma on ma.idMarca = m.idMarca LEFT JOIN tblEstados Es ON Es.idestado=a.idEstado left join tblCuentas cu on cu.idCuenta=a.idCuenta";
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
			$consulta="SELECT a.idEstado,a.idAsignaciones,a.idLinea,a.idEmpleado,a.idCel,a.estatus,a.idCuenta,l.linea,s.idSim,s.icc,c.imei,m.modelo,ma.marca,se.empleados_nombres,se.empleados_apellido_paterno,se.empleados_apellido_materno FROM tblAsignaciones a left JOIN tblLineas l on l.idLinea=a.idLinea left join tblSim s on s.idSim=l.idSim left join tblCelurares c on c.idCelular=a.idCel left JOIN tblModelos m on m.idModelo=c.idModelo left JOIN tblMarcas ma on ma.idMarca=m.idMarca left join spar_empleados se on se.empleados_id=a.idEmpleado WHERE a.idAsignaciones=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function historial($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$consulta="SELECT l.linea,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,c.imei,a.estatus,a.fecha,cu.cliente FROM tblAsignaciones a LEFT JOIN tblLineas l on l.idLinea=a.idLinea left join spar_empleados s on s.empleados_id=a.idEmpleado left join tblCelurares c on c.idCelular=a.idCel left join tblCuentas cu on cu.idCuenta=a.idCuenta WHERE a.idLinea=$id ORDER BY a.fecha DESC";
		$resultado = $this->conexion->query($consulta);
		$datos = array();
		if($resultado){
			while($filaTmp = $resultado->fetch_assoc()) {
				$datos[] =  $filaTmp;
			}
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function guardar($lineas,$responsable,$imei,$cuenta,$idEstado){
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($lineas))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($responsable))));
		$idCel = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$cuenta = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cuenta))));
		$idEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEstado))));
		$hoy = date("Y-m-d H:i:s");
		$estatus="Activo";
		$errores = 0;
		$errorResultado = "";

		if (empty($idCel)) {
			$errores ++;
			$errorResultado .= "El campo imei no puede estar vacío. <br>";
		}if (empty($idEmpleado)) {
			$errores ++;
			$errorResultado .= "El campo idEmpleado no puede estar vacío. <br>";
		}	

		if($errores === 0){
			$consulta = "INSERT INTO tblAsignaciones(idLinea,idEmpleado,idCel,estatus,idCuenta,fecha,idEstado) SELECT * FROM (SELECT '$linea' AS linea,'$idEmpleado' AS idEmpleado,'$idCel' AS idCel,'$estatus' AS estatus,'$cuenta' AS cuenta,'$hoy' AS '$hoy','$idEstado' AS '$idEstado') AS tmp WHERE NOT EXISTS (SELECT idCel FROM tblAsignaciones WHERE idCel = '$idCel') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La asignacion ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($compararLinea,$compararImei,$compararResponsable,$compararCuenta,$compararEstado,$id,$linea,$responsable,$imei,$cuenta,$estado,$idEstado,$compararIdEstado,$usuario,$compararIdICC){
		$compararIdICC = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararIdICC))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$compararIdEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararIdEstado))));
		$idEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEstado))));
		$compararLinea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararLinea))));
		$compararImei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararImei))));
		$compararResponsable = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararResponsable))));
		$compararCuenta = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararCuenta))));
		$compararEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($compararEstado))));
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$linea = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($linea))));
		$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($responsable))));
		$idCel = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$cuenta = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cuenta))));
		$estatus = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		if (empty($id)) {
			$errores ++;
			$errorResultado .= "El campo id no puede estar vacío. <br>";
		}if (empty($linea)) {
			$errores ++;
			$errorResultado .= "El campo linea no puede estar vacío. <br>";
		}
		if($errores === 0){
			if($compararLinea!=$linea || $compararImei!=$idCel || $compararResponsable!=$idEmpleado || $compararCuenta!=$cuenta || $compararEstado!=$estatus || $compararIdEstado!=$idEstado) {
				$consulta = "INSERT INTO tblAsignaciones(idLinea,idEmpleado,idCel,estatus,idCuenta,fecha,idEstado) VALUES ('$linea', '$idEmpleado', '$idCel','$estatus','$cuenta','$hoy',$idEstado)";
				$resultado = $this->conexion -> query($consulta);
				$idInsertAsignaciones = $this->conexion->insert_id;	
				if($estatus == "Robada"){
					$consulta0 = "UPDATE tblAsignaciones a left join tblCelurares c on c.idCelular=a.idCel set c.estado='Robado' where a.idAsignaciones=$idInsertAsignaciones";
					$resultado0 = $this->conexion -> query($consulta0);
					$consulta1 = "UPDATE tblAsignaciones a SET a.idCel=0 where a.idAsignaciones=$idInsertAsignaciones";
					$resultado1 = $this->conexion -> query($consulta1);
					$consulta2 = "UPDATE tblAsignaciones a left join tblLineas l on l.idLinea=a.idLinea left join tblSim s on s.idSim=l.idSim SET s.estado='Robada' where a.idAsignaciones=$idInsertAsignaciones";
					$resultado2 = $this->conexion -> query($consulta2);
					$consulta3 = "UPDATE tblAsignaciones a left join tblLineas l on l.idLinea=a.idLinea SET l.idSim='' where a.idAsignaciones=$idInsertAsignaciones";
					$resultado3 = $this->conexion -> query($consulta3);
					$hoy = date("Y-m-d H:i:s");
					$consulta4 = "INSERT INTO tblLineasSim(idLinea, idSim, fechaRegistro) VALUES ('$linea', '', '$hoy')";
					$resultado4 = $this->conexion -> query($consulta4);
					$consulta5 = "INSERT INTO tblCelularesAlmacen(idAlmacen, idCelular, fechaRegistro,usuario,estado) VALUES (24, '$compararImei', '$hoy','$usuario','Robado')";
					$resultado5 = $this->conexion -> query($consulta5);
					$consulta6 = "INSERT INTO tblSimsAlmacen(idAlmacen, idSim, idUsuario, estado, fechaRegistro) VALUES (24, '$compararIdICC', '$usuario', 'Robada', '$hoy')";
					$resultado6 = $this->conexion -> query($consulta6);
				}
			}else{
				$resultado = 2;
			}
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La asignacion ya existe o no se actualizó ningún dato. <br>";	
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
		$consulta="SELECT c.idCelular,mo.modelo as model,c.imei,ma.marca FROM tblCelurares c INNER JOIN tblModelos mo ON mo.idModelo=c.idModelo inner join tblMarcas ma on ma.idMarca=mo.idMarca  WHERE c.idCelular=$imei";
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