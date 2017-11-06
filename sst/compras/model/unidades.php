<?php 
class unidades
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT idUnidad, nombre FROM spartodo_compras.tblUnidades ORDER BY nombre";
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

	public function informacion($idUnidad){
		$idUnidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUnidad))));
		$consulta="SELECT idUnidad, nombre FROM spartodo_compras.tblUnidades WHERE idUnidad = '$idUnidad'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function guardar($unidad){
		$unidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($unidad))));
		$errores = 0;
		$errorResultado = "";
		$arrClienteS = array();
		
		if (empty($unidad)) {
			$errores ++;
			$errorResultado .= "El campo Nombre no puede estar vacío. <br>";
		}
		
		if($errores === 0){
			$consulta = "INSERT INTO spartodo_compras.tblUnidades(nombre) SELECT * FROM (SELECT '$unidad' AS unidad) AS tmp WHERE NOT EXISTS (SELECT nombre FROM spartodo_compras.tblUnidades WHERE nombre = '$unidad') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){ 
		  			return "OK";
		  		}
				else 
					return "La unidad ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizar($idUnidad,$unidad){
		$idUnidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUnidad))));
		$unidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($unidad))));
		$arrClienteS = array();
		$errores = 0;
		$errorResultado = "";
		if(!is_numeric($idUnidad) || $idUnidad <= 0){
			$errores ++;
			$errorResultado .= "El campo Unidad es incorrecto. <br>";
		}
		if (empty($unidad)) {
			$errores ++;
			$errorResultado .= "El campo Nombre no puede estar vacío. <br>";
		}

		if($errores === 0){
			$consulta = "UPDATE spartodo_compras.tblUnidades a_b SET a_b.nombre = '$unidad' WHERE a_b.idUnidad = '$idUnidad' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_compras.tblUnidades) AS a_b_2 WHERE a_b_2.nombre = '$unidad' AND a_b_2.idUnidad != '$idUnidad') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	$filasModificadasUnidad = $this->conexion->affected_rows;
			  	if($filasModificadasUnidad === 1){
		  			return "OK";
		  		}
				else 
					return "La unidad ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminar($idUnidad){
		$idBanco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idBanco))));
		$consulta="DELETE FROM spartodo_compras.tblUnidades WHERE idUnidad = $idUnidad";
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