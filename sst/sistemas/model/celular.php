<?php 
class CelularModel
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT p.imei,m.modelo,p.idCelular,mr.marca,alm.nombre,alm.ubicacion,p.estado,sa.estado as estatus FROM tblCelurares p LEFT JOIN (SELECT s1.idAlmacen, s1.idCelular,s1.estado FROM tblCelularesAlmacen s1 WHERE s1.idCelularAlmacen = (SELECT MAX(idCelularAlmacen) FROM tblCelularesAlmacen WHERE idCelular = s1.idCelular)) sa ON p.idCelular = sa.idCelular inner join tblModelos m on p.idModelo=m.idModelo INNER JOIN tblMarcas mr on mr.idMarca=m.idMarca LEFT JOIN tblAlmacen alm ON alm.idAlmacen=sa.idAlmacen";
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
			$consulta="SELECT c.idCelular,c.idModelo,c.imei,ma.marca,ma.idMarca,c.estado,sa.idAlmacen as idAlm FROM tblCelurares c LEFT JOIN (SELECT s1.idAlmacen, s1.idCelular FROM tblCelularesAlmacen s1 WHERE s1.idCelularAlmacen = (SELECT MAX(idCelularAlmacen) FROM tblCelularesAlmacen WHERE idCelular = s1.idCelular)) sa ON c.idCelular = sa.idCelular inner join tblModelos m ON m.idModelo=c.idModelo INNER JOIN tblMarcas ma on ma.idMarca=m.idMarca WHERE c.idCelular = $id";
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
		$consulta="SELECT a.nombre, ca.fechaRegistro, a.ubicacion,ca.usuario,s.empleados_nombres,ca.estado FROM tblCelularesAlmacen ca left join tblAlmacen a ON ca.idAlmacen=a.idAlmacen left JOIN spar_empleados s ON s.empleados_numero_empleado=ca.usuario WHERE ca.idCelular = $id ORDER BY ca.fechaRegistro DESC";
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

	public function seleccionarIdUltimoCelular($id){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="SELECT Max(a.idAsignaciones) FROM tblAsignaciones a WHERE a.idCel=(SELECT Max(idCel) FROM tblAsignaciones WHERE idCel=$id)";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function guardar($modelo,$imei,$tipo,$usuario){
		$modelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($modelo))));
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$hoy = date("Y-m-d H:i:s");
		$estado= 'stock';
		$errores = 0;
		$errorResultado = "";
		
		if (empty($modelo)) {
			$errores ++;
			$errorResultado .= "El campo modelo no puede estar vacío. <br>";
		}if (empty($imei)) {
			$errores ++;
			$errorResultado .= "El campo imei no puede estar vacío. <br>";
		}if (empty($tipo)) {
			$errores ++;
			$errorResultado .= "El campo tipo no puede estar vacío. <br>";
		}

	if($errores === 0){
		$consulta = "INSERT INTO tblCelurares(idModelo,imei,estado) SELECT * FROM (SELECT '$modelo' AS modelo, '$imei' AS imei,'$estado' AS estado) AS tmp WHERE NOT EXISTS (SELECT imei FROM tblCelurares WHERE imei = '$imei') LIMIT 1;";
		$resultado = $this->conexion -> query($consulta);
			if($resultado){
				if($this->conexion->affected_rows === 1){
					$modificaciones = 1;
				}
			}
			
		if($resultado){
			if($this->conexion->affected_rows === 1){
		  		$idCel = $this->conexion->insert_id;
		  		$consulta2 = "INSERT INTO tblCelularesAlmacen(idAlmacen, idCelular, fechaRegistro,usuario,estado) VALUES ('$tipo', '$idCel', '$hoy','$usuario','$estado')";
				$resultado2 = $this->conexion -> query($consulta2);
				if($resultado){
		  			if($this->conexion->affected_rows === 1){
		  					return "OK";
		  				}
		  				else{
		  					return "Error al guardar en almacén.";
		  				}
					}
		  		}
				else 
					return "El IMEI ya existe en la base de datos.";
			
			}else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}

	}

	public function actualizar($id,$model,$imei,$tipo,$usuario,$estado,$idAlmacenHistorial,$idEstado,$utlimoIdAsignaciones){
		$utlimoIdAsignaciones = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($utlimoIdAsignaciones))));
		$idcelular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$model = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($model))));
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
		$idAlmacenHistorial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idAlmacenHistorial))));
		$idEstado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEstado))));
		$hoy = date("Y-m-d H:i:s");
		$errores = 0;
		$errorResultado = "";
		
		if (empty($model)) {
			$errores ++;
			$errorResultado .= "El campo Modelo no puede estar vacío. <br>";
		}if (empty($imei)) {
			$errores ++;
			$errorResultado .= "El campo IMEI no puede estar vacío. <br>";
		}if (empty($tipo)) {
			$errores ++;
			$errorResultado .= "El campo tipo no puede estar vacío. <br>";
		}if (empty($estado)) {
			$errores ++;
			$errorResultado .= "El campo estado no puede estar vacío. <br>";
		}

		$modificaciones = 0;
		if($errores === 0){
			if($idAlmacenHistorial != $tipo || $estado!=$idEstado) {
				$consulta2 = "INSERT INTO tblCelularesAlmacen(idAlmacen, idCelular, fechaRegistro,usuario,estado) VALUES ('$tipo', '$idcelular', '$hoy','$usuario','$estado')";
			$resultado2 = $this->conexion -> query($consulta2);
				$modificaciones = $modificaciones+1; 
			}		
			$consulta = "UPDATE tblCelurares a_b SET a_b.idModelo = '$model',a_b.imei = '$imei',a_b.estado = '$estado' WHERE a_b.idCelular = $idcelular AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblCelurares) AS a_b_2 WHERE a_b_2.imei = '$imei' AND a_b_2.idCelular != $idcelular) AS count); ";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1){
			  		$modificaciones = $modificaciones+1;
			  	}
			}	
			if($resultado || $resultado2){
			  	if($modificaciones == 1 || $modificaciones >= 1){
					return "OK";
			  	}
				else {
					return "El IMEI ya existe o no se actualizó ningún dato. <br>";	
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

	public function eliminar($id_celular){
		$id_celular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id_celular))));
		$consulta="DELETE FROM tbCelPhones WHERE idCelular = $id_celular";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function listarMarcas(){
		$datos = array();
		$consulta ="SELECT m.marca,m.idMarca FROM `tblProductos` p LEFT JOIN tblMarcasProductos mc ON p.idProducto = mc.idProducto LEFT JOIN tblMarcas m on mc.idMarca = m.idMarca WHERE p.producto LIKE '%celular%' ORDER BY m.marca";
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
 
	public function listarModelos($idMarca){
		$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
		$datos = array();
		$consulta ="SELECT m.idModelo, m.modelo FROM tblModelos m LEFT JOIN tblMarcas mc ON m.idMarca = mc.idMarca WHERE m.idMarca='$idMarca'";
		echo $consulta;
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

	public function listarImeis(){
		$datos = array();
		$consulta="SELECT c.idCelular,c.imei from tblCelurares c where not exists (select a.idCel from tblAsignaciones a where a.idCel = c.idCelular)";
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