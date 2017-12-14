<?php 
class almacen
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT a.idAlmacen, a.nombre, a.tipo FROM tblAlmacen a ORDER BY nombre";
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
			$consulta="SELECT `idAlmacen`, `nombre`, `tipo` FROM `tblAlmacen` WHERE `idAlmacen`=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($almacen,$tipo){
		$banco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($almacen))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$errores = 0;
		$errorResultado = "";
		
		if (empty($almacen)) {
			$errores ++;
			$errorResultado .= "El campo almacén no puede estar vacío. <br>";
		}if (empty($tipo)) {
			$errores ++;
			$errorResultado .= "El campo tipo no puede estar vacío. <br>";
		}
		
		
		if($errores === 0){
			$consulta = "INSERT INTO tblAlmacen (nombre,tipo) SELECT * FROM (SELECT '$banco' AS banco,'$tipo' AS tipo) AS tmp WHERE NOT EXISTS (SELECT nombre FROM tblAlmacen WHERE nombre = '$almacen') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El almacén ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($id,$almacen,$tipo){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
		$almacen = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($almacen))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$errores = 0;
		$errorResultado = "";
		if (empty($id)) {
			$errores ++;
			$errorResultado .= "El campo id no puede estar vacío. <br>";
		}if (empty($almacen)) {
			$errores ++;
			$errorResultado .= "El campo almacén no puede estar vacío. <br>";
		}if (empty($tipo)) {
			$errores ++;
			$errorResultado .= "El campo tipo no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "UPDATE tblAlmacen a_b SET a_b.nombre = '$almacen',a_b.tipo = '$tipo' WHERE a_b.idAlmacen = '$id' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblAlmacen) AS a_b_2 WHERE a_b_2.nombre = '$almacen' AND a_b_2.idAlmacen != '$id') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El almacén ya existe o no se actualizó ningún dato. <br>";	
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
		$consulta="DELETE FROM `tblAlmacen` WHERE `idAlmacen`=$id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}
		
	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>