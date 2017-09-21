<?php 
	class Marcas
	{
 		protected $acceso;
 		protected $conexion;

		public function __construct() 
		{
		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT idmarca,marca FROM tblMarcas ORDER BY marca";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos [] = $filaTmp;
			}
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
//funcion para consultar la informacion
   		public function informacion($idMarca){
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
   			$consulta="SELECT idmarca, marca FROM tblMarcas WHERE idmarca = '$idMarca'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function informacionProductos($idMarca){
   			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
   			$array = array();
   			$consulta="SELECT p.idProducto FROM tblProductos p LEFT JOIN tblMarcasProductos mp ON p.idProducto = mp.idProducto WHERE mp.idMarca = $idMarca";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while($filaTmp = $resultado->fetch_assoc()){
					$array [] = $filaTmp["idProducto"];
				}
				return $array;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($Marca,$idProductos){
			$Marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Marca))));
			$productos = array();
			
			$errores = 0;
			$errorResultado = "";
			if(isset($idProductos)){
				foreach ($idProductos as $idProducto) {
					$productos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
					if(!is_numeric($idProducto) || $idProducto <= 0){
						$errores ++;
						$errorResultado .= "El campo Productos es incorrecto. <br>";
						break;
					}
				}
			}
			
			if (empty($Marca)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblMarcas(marca) SELECT * FROM (SELECT '$Marca' AS Marca) AS tmp WHERE NOT EXISTS (SELECT marca FROM tblMarcas WHERE marca = '$Marca') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1){
						$idMarca = $this->conexion->insert_id;
			  			return $this->insertMarcasProductos($idMarca, $productos);
					}else{ 
						return "La Marca ya existe. <br>";
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

		public function insertMarcasProductos($idMarca, $productos){
			$ok = 0;
			$consulta = "";
			foreach ($productos as $producto) {
				$consulta .= "INSERT INTO tblMarcasProductos(idMarca, idProducto) SELECT * FROM (SELECT '$idMarca' AS idMarca, '$producto' AS iproductodProducto) AS tmp WHERE NOT EXISTS (SELECT idMarca FROM tblMarcasProductos WHERE idMarca = '$idMarca' AND idProducto = '$producto') LIMIT 1; ";
			}
			if(!empty($consulta)){
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
		   	else
		   		return "OK";
		}

//funcion para actualizar los registros
		public function actualizar($idMarca,$Marca,$idProductos){
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
			$Marca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Marca))));
			$errores = 0;
			$errorResultado = "";
			if(isset($idProductos)){
				foreach ($idProductos as $idProducto) {
					$productos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
					if(!is_numeric($idProducto) || $idProducto <= 0){
						$errores ++;
						$errorResultado .= "El campo Productos es incorrecto. <br>";
						break;
					}
				}
			}
			if (empty($Marca)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			if($errores === 0){				
				$consulta = "UPDATE tblMarcas SET marca='$Marca' where idmarca = '$idMarca'";

  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
					$filasModificadasMarcas = $this->conexion->affected_rows;
				  	$marcasProductosActuales = $this->informacionProductos($idMarca);
				  	var_dump($marcasProductosActuales);
				  	if($filasModificadasMarcas === 1 || (count(array_intersect($productos, $marcasProductosActuales)) != count($marcasProductosActuales)) || (count(array_intersect($marcasProductosActuales, $productos)) != count($productos))){
						foreach ($marcasProductosActuales as $marcasProductoActual) {
							if(!in_array($marcasProductoActual, $productos)){
								echo $idProducto;
								$this->eliminarmMarcasProducto($marcasProductoActual,$idMarca);
							}
						}
			  			return $this->insertMarcasProductos($idMarca, $productos);
			  		}else{ 
						return "La Marca ya existe o no se actualizó ningún dato. <br>";	
					}

				}else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}

			}else{
				return $errorResultado;
			}
		}

		public function eliminarmMarcasProducto($idProducto,$idMarca){
			if ($idProducto == 0) {
				$consulta="DELETE FROM tblMarcasProductos WHERE idMarca = $idMarca";
			}else{
			$consulta="DELETE FROM tblMarcasProductos WHERE idMarca = $idMarca AND idProducto = $idProducto";
			}
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}
		
//funcion eliminar los registros
		public function eliminar($idMarca){
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
			$idProducto = "0";
			$this->eliminarmMarcasProducto($idProducto,$idMarca);
			$consulta="DELETE FROM tblMarcas WHERE idmarca = $idMarca";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}


   		public function listarMarcasProductos($idMarca){
   			$datos = array();
   			$consulta="SELECT p.idProducto FROM tblProductos p left join tblMarcasProductos mp ON mp.idProducto=p.idProducto LEFT JOIN tblMarcas m ON m.idMarca=mp.idMarca where m.idMarca=$idMarca";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos [] = $filaTmp["idProducto"];
			}
			if($resultado){
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