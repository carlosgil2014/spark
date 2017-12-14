
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
		$consulta="SELECT p.imei,m.modelo,mc.marca,p.idCelular FROM tbCelPhones p inner join tblMarcas mc on p.marca=mc.idmarca inner join tblModelos m on p.model=m.idModelo";
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

	public function informacion($id_celular){
		$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id_celular))));
			$consulta="SELECT c.idCelular,c.marca,c.model,c.imei,c.almacen FROM tbCelPhones c  WHERE idCelular = $id";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($marca,$modelo,$imei,$tipo){
		$marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($marca))));
		$modelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($modelo))));
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$errores = 0;
		$errorResultado = "";
		
		if (empty($marca)) {
			$errores ++;
			$errorResultado .= "El campo marca no puede estar vacío. <br>";
		}if (empty($modelo)) {
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

			$consulta = "INSERT INTO tbCelPhones(marca,model,imei,almacen) SELECT * FROM (SELECT '$marca' AS marca, '$modelo' AS modelo, $imei AS imei, $tipo AS tipo) AS tmp WHERE NOT EXISTS (SELECT imei FROM tbCelPhones WHERE imei = '$imei') LIMIT 1; ";
			
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El registro  ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}

	}

	public function actualizar($id_celular,$marca,$model,$imei,$tipo){
		$idcelular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id_celular))));
		$marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($marca))));
		$model = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($model))));
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipo))));
		$errores = 0;
		$errorResultado = "";
		if (empty($marca)) {
			$errores ++;
			$errorResultado .= "El campo Marca no puede estar vacío. <br>";
		}if (empty($model)) {
			$errores ++;
			$errorResultado .= "El campo Modelo no puede estar vacío. <br>";
		}if (empty($imei)) {
			$errores ++;
			$errorResultado .= "El campo IMEI no puede estar vacío. <br>";
		}if (empty($tipo)) {
			$errores ++;
			$errorResultado .= "El campo tipo no puede estar vacío. <br>";
		}
		if($errores === 0){
			$consulta = "UPDATE tbCelPhones a_b SET a_b.marca = '$marca', a_b.model = '$model',a_b.imei = '$imei',a_b.almacen = '$tipo' WHERE a_b.idCelular = $idcelular AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tbCelPhones) AS a_b_2 WHERE a_b_2.imei = '$imei' AND a_b_2.idCelular != $idcelular) AS count); ";
			echo $consulta;
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "El celular ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
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
		$consulta="SELECT c.idCelular,c.imei from tbCelPhones c where not exists (select a.idCel from tblAsignaciones a where a.idCel = c.idCelular)";
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