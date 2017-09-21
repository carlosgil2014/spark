
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
		$consulta="SELECT m.modelo,mc.marca,p.idCelular,p.imei,p.sim FROM tbCelPhones p inner join tblMarcas mc on p.marca=mc.idmarca inner join tblModelos m on p.model=m.idModelo";
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
		$id_celular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id_celular))));
			$consulta="SELECT * FROM tbCelPhones WHERE idCelular = '$id_celular'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

		public function guardar($marca,$modelo,$imei,$sim){
		$marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($marca))));
		$modelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($modelo))));
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$sim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($sim))));
		$errores = 0;
		$errorResultado = "";
		
		if (empty($marca)) {
			$errores ++;
			$errorResultado .= "El campo marca no puede estar vacío. <br>";
		}

		if (empty($modelo)) {
			$errores ++;
			$errorResultado .= "El campo modelo no puede estar vacío. <br>";
		}

		if (empty($imei)) {
			$errores ++;
			$errorResultado .= "El campo imei no puede estar vacío. <br>";
		}

		if (empty($sim)) {
			$errores ++;
			$errorResultado .= "El campo sim no puede estar vacío. <br>";
		}
		


		if($errores === 0){

			$consulta = "INSERT INTO tbCelPhones(marca,model,imei,sim) SELECT * FROM (SELECT '$marca' AS marca, '$modelo' AS modelo, $imei AS imei,'$sim' AS sim) AS tmp WHERE NOT EXISTS (SELECT imei FROM tbCelPhones WHERE imei = '$imei') LIMIT 1; ";
			
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

	public function actualizar($id_celular,$marca,$model,$imei,$sim){
		$idcelular = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id_celular))));
		$marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($marca))));
		$model = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($model))));
		$imei = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($imei))));
		$sim = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($sim))));

		$errores = 0;
		$errorResultado = "";
		if (empty($marca)) {
			$errores ++;
			$errorResultado .= "El campo Marca no puede estar vacío. <br>";
		}
		if (empty($model)) {
			$errores ++;
			$errorResultado .= "El campo Modelo no puede estar vacío. <br>";
		}
		if (empty($imei)) {
			$errores ++;
			$errorResultado .= "El campo IMEI no puede estar vacío. <br>";
		}
		if (empty($sim)) {
			$errores ++;
			$errorResultado .= "El campo SIM no puede estar vacío. <br>";
		}
	

		if($errores === 0){
			$consulta = "UPDATE tbCelPhones a_b SET a_b.marca = '$marca', a_b.model = '$model',a_b.imei = '$imei',a_b.sim = '$sim' WHERE a_b.idCelular = $idcelular AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tbCelPhones) AS a_b_2 WHERE a_b_2.imei = '$imei' AND a_b_2.idCelular != $idcelular) AS count); ";
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
		$consulta ="SELECT m.marca,m.idMarca FROM `tblProductos` p LEFT JOIN tblMarcasProductos mc ON p.idProducto = mc.idProducto LEFT JOIN tblMarcas m on mc.idMarca = m.idMarca WHERE p.producto LIKE '%Celular%' ORDER BY m.marca";
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
	//sst/sistemas/controller/crudModelos.php 
 
	public function listarModelos($idMarca){
		$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
		$datos = array();
		$consulta ="SELECT m.idModelo, m.modelo FROM tblModelos m LEFT JOIN tblMarcas mc ON m.idMarca = mc.idMarca WHERE m.idMarca='$idMarca'";
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