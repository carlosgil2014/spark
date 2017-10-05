<?php 
class servicios
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT idServicio, nombre FROM spartodo_compras.tblServicios ORDER BY nombre";
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

	public function informacion($idServicio){
		$idServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idServicio))));
		$consulta="SELECT idServicio, nombre FROM spartodo_compras.tblServicios WHERE idServicio = '$idServicio'";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function informacionServiciosClientes($idServicio){
			$idServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idServicio))));
   			$datos = array();
   			$consulta="SELECT idCliente FROM spartodo_compras.tblServiciosClientes WHERE idServicio = '$idServicio'";
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

	public function guardar($servicio,$clientes){
		$servicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($servicio))));
		$errores = 0;
		$errorResultado = "";
		$arrClienteS = array();
		
		if (empty($servicio)) {
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
			$consulta = "INSERT INTO spartodo_compras.tblServicios(nombre) SELECT * FROM (SELECT '$servicio' AS servicio) AS tmp WHERE NOT EXISTS (SELECT nombre FROM spartodo_compras.tblServicios WHERE nombre = '$servicio') LIMIT 1; ";
				$resultado = $this->conexion -> query($consulta);
			if($resultado){
		  		if($this->conexion->affected_rows === 1){ 
			  		$idServicio = $this->conexion->insert_id;
			  		return $this->guardarServicioClientes($idServicio, $arrClienteS);
		  		}
				else 
					return "El servicio ya existe. <br>";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function guardarServicioClientes($idServicio, $clientes){
			$ok = 0;
			$consulta = "";
			foreach ($clientes as $cliente) {
				$consulta .= "INSERT INTO spartodo_compras.tblServiciosClientes(idServicio, idCliente) SELECT * FROM (SELECT '$idServicio' AS idServicio, '$cliente' AS idCliente) AS tmp WHERE NOT EXISTS (SELECT idServicio FROM spartodo_compras.tblServiciosClientes WHERE idServicio = '$idServicio' AND idCliente = '$cliente') LIMIT 1; ";
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

	public function actualizar($idServicio,$servicio,$clientes){
		$idServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idServicio))));
		$servicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($servicio))));
		$arrClienteS = array();
		$errores = 0;
		$errorResultado = "";
		if(!is_numeric($idServicio) || $idServicio <= 0){
			$errores ++;
			$errorResultado .= "El campo Servicio es incorrecto. <br>";
		}
		if (empty($servicio)) {
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
			$consulta = "UPDATE spartodo_compras.tblServicios a_b SET a_b.nombre = '$servicio' WHERE a_b.idServicio = '$idServicio' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM spartodo_compras.tblServicios) AS a_b_2 WHERE a_b_2.nombre = '$servicio' AND a_b_2.idServicio != '$idServicio') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	$filasModificadasServicio = $this->conexion->affected_rows;
			  	$clientesActualesServicio = $this->informacionServiciosClientes($idServicio);
			  	if($filasModificadasServicio === 1 || (count(array_intersect($arrClienteS, $clientesActualesServicio)) != count($clientesActualesServicio)) || (count(array_intersect($clientesActualesServicio, $arrClienteS)) != count($arrClienteS))){
					foreach ($clientesActualesServicio as $clienteActualServicio) {
						if(!in_array($clienteActualServicio, $arrClienteS)){
							$this->eliminarServicioCliente($clienteActualServicio,$idServicio);
						}
					}
		  			return $this->guardarServicioClientes($idServicio, $arrClienteS);
		  		}
				else 
					return "El servicio ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function eliminarServicioCliente($idCliente,$idServicio){
			$consulta="DELETE FROM spartodo_compras.tblServiciosClientes WHERE idServicio = '$idServicio' AND idCliente = '$idCliente'";
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
		$consulta="DELETE FROM spartodo_compras.tblServicios WHERE idServicio = $idServicio";
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