<?php 
class productos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT idProducto, nombre FROM spartodo_compras.tblProductos ORDER BY nombre";
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

	public function informacion($idProducto){
		$idProducto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
		$consulta="SELECT idProducto, nombre FROM spartodo_compras.tblProductos WHERE idProducto = '$idProducto'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function informacionProductosClientes($idProducto){
			$idProducto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
   			$datos = array();
   			$consulta="SELECT idCliente FROM spartodo_compras.tblProductosClientes WHERE idProducto = '$idProducto'";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp["idCliente"];
				}
				return $datos;
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

	public function guardar($producto,$clientes){
		$producto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($producto))));
		$errores = 0;
		$errorResultado = "";
		$arrClienteS = array();
		
		if (empty($producto)) {
			$errores ++;
			$errorResultado .= "El campo Nombre no puede estar vacío. <br>";
		}

		if(!isset($clientes) || count($clientes) <= 0){
			$errores ++;
			$errorResultado .= "El campo Clientes es incorrecto. <br>";
		}
		else{
			foreach ($clientes as $cliente) {
				$arrClienteS[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cliente))));
				if(!is_numeric($cliente) || $cliente <= 0){
					$errores ++;
					$errorResultado .= "El campo Cliente es incorrecto. <br>";
					break;
				}
			}
		}
		
		
		if($errores === 0){
			$consulta = "INSERT INTO spartodo_compras.tblProductos(nombre) SELECT * FROM (SELECT '$producto' AS producto) AS tmp WHERE NOT EXISTS (SELECT nombre FROM spartodo_compras.tblProductos WHERE nombre = '$producto') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){ 
			  		$idProducto = $this->conexion->insert_id;
			  		return $this->guardarProductoClientes($idProducto, $arrClienteS);
		  		}
				else 
					return "El producto ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function guardarProductoClientes($idProducto, $clientes){
			$ok = 0;
			$consulta = "";
			foreach ($clientes as $cliente) {
				$consulta .= "INSERT INTO spartodo_compras.tblProductosClientes(idProducto, idCliente) SELECT * FROM (SELECT '$idProducto' AS idProducto, '$cliente' AS idCliente) AS tmp WHERE NOT EXISTS (SELECT idProducto FROM spartodo_compras.tblProductosClientes WHERE idProducto = '$idProducto' AND idCliente = '$cliente') LIMIT 1; ";
			}
			
			if ($this->conexion->multi_query($consulta))
			{
				$ok = 1;
			  do
			    {
			    if ($resultado = $this->conexion->store_result()) {
			      $resultado->free();
			      }
			    }
			  while (@$this->conexion->next_result());
			}

			if ($ok==1) {
				return "OK";
			}
			else{
   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   		}
			
		}

	public function actualizar($idProducto,$producto,$clientes){
		$idProducto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
		$producto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($producto))));
		$arrClienteS = array();
		$errores = 0;
		$errorResultado = "";
		if(!is_numeric($idProducto) || $idProducto <= 0){
			$errores ++;
			$errorResultado .= "El campo idProducto es incorrecto. <br>";
		}
		if (empty($producto)) {
			$errores ++;
			$errorResultado .= "El campo Nombre no puede estar vacío. <br>";
		}

		if(!isset($clientes) || count($clientes) <= 0){
			$errores ++;
			$errorResultado .= "El campo Clientes es incorrecto. <br>";
		}
		else{
			foreach ($clientes as $cliente) {
				$arrClienteS[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cliente))));
				if(!is_numeric($cliente) || $cliente <= 0){
					$errores ++;
					$errorResultado .= "El campo Cliente es incorrecto. <br>";
					break;
				}
			}
		}

		if($errores === 0){
			$consulta = "UPDATE spartodo_compras.tblProductos a_b SET a_b.nombre = '$producto' WHERE a_b.idProducto = '$idProducto' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_compras.tblProductos) AS a_b_2 WHERE a_b_2.nombre = '$producto' AND a_b_2.idProducto != '$idProducto') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	$filasModificadasProducto = $this->conexion->affected_rows;
			  	$clientesActualesProductos = $this->informacionProductosClientes($idProducto);
			  	if($filasModificadasProducto === 1 || (count(array_intersect($arrClienteS, $clientesActualesProductos)) != count($clientesActualesProductos)) || (count(array_intersect($clientesActualesProductos, $arrClienteS)) != count($arrClienteS))){
					foreach ($clientesActualesProductos as $clienteActualProducto) {
						if(!in_array($clienteActualProducto, $arrClienteS)){
							$this->eliminarProductoCliente($clienteActualProducto,$idProducto);
						}
					}
		  			return $this->guardarProductoClientes($idProducto, $arrClienteS);
		  		}
				else 
					return "El producto ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminarProductoCliente($idCliente,$idProducto){
			$consulta="DELETE FROM spartodo_compras.tblProductosClientes WHERE idProducto = '$idProducto' AND idCliente = '$idCliente'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

	public function eliminar($idBanco){
		$idBanco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idBanco))));
		$consulta="DELETE FROM spartodo_compras.tblProductos WHERE idProducto = $idProducto";
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