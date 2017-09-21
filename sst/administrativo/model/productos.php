<?php 
	class productos
	{
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT * FROM tblProductos p inner join tblSubcategorias s on p.idSubcategoria=s.idSubcategoria inner join tblCategorias c on c.idCategoria=s.idCategoria";
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
   		public function informacion($idProducto){
			$idProducto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
   			$consulta="SELECT p.idProducto, p.producto, s.subcategoria,s.idSubcategoria FROM tblProductos p inner join tblSubcategorias s on p.idSubcategoria=s.idSubcategoria WHERE p.idProducto=$idProducto";
   			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($producto,$idSubcategoria){
   			$producto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($producto))));
			$idSubcategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idSubcategoria))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($producto)) {
				$errores ++;
				$errorResultado .= "El campo Producto no puede estar vacío. <br>";
			}
			if (empty($idSubcategoria)) {
				$errores ++;
				$errorResultado .= "El campo Subcategoria no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblProductos(producto, idSubcategoria) SELECT * FROM (SELECT '$producto' AS producto, '$idSubcategoria' AS idSubcategoria) AS tmp WHERE NOT EXISTS (SELECT producto FROM tblProductos WHERE producto = '$producto') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "La Categoria ya existe. <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}
//funcion para actualizar los registros
		public function actualizar($idProducto,$producto,$idSubcategoria){
			$idProducto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
			$producto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($producto))));
			$idSubcategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idSubcategoria))));
			$errores = 0;
			$errorResultado = "";
			if (empty($idProducto)) {
				$errores ++;
				$errorResultado .= "El campo idProducto no puede estar vacío. <br>";
			}
			if (empty($producto)) {
				$errores ++;
				$errorResultado .= "El campo producto no puede estar vacío. <br>";
			}
			if (empty($idSubcategoria)) {
				$errores ++;
				$errorResultado .= "El campo Subcategoria no puede estar vacío. <br>";
			}
			if($errores === 0){
				//$consulta = "UPDATE tblcomputadoras a_b SET a_b.Marca = '$computo' WHERE a_b.IdComputadoras = '$idComputadoras' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblcomputadoras) AS a_b_2 WHERE a_b_2.Marca = '$computo' AND a_b_2.IdComputadoras != '$idComputadoras') AS count); ";
				$consulta = "UPDATE tblProductos SET producto='$producto',idSubcategoria=$idSubcategoria  where idProducto='$idProducto'";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
				  	if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "La Producto ya existe o no se actualizó ningún dato. <br>";	
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			}
			else{
				return $errorResultado;
			}
		}
		
//funcion eliminar los registros
		public function eliminar($idProducto){
			$idProducto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idProducto))));
			$consulta="DELETE FROM tblProductos WHERE idProducto=$idProducto";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

		public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	


   }

   
?>