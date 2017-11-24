<?php 
	class subcategorias
	{
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT s.idSubcategoria as id,s.subcategoria,ct.categoria FROM tblSubcategorias s inner join tblCategorias ct on s.idCategoria=ct.idCategoria";
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
   		public function informacion($idSubcategoria){
			$idSubcategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idSubcategoria))));
   			$consulta="SELECT s.idSubcategoria, s.subcategoria, c.categoria,c.idCategoria FROM tblSubcategorias s inner join tblCategorias c on s.idCategoria=c.idCategoria WHERE idSubcategoria=$idSubcategoria";
   			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($idCategoria,$subCategoria){
   			$idCategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCategoria))));
			$subCategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($subCategoria))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($subCategoria)) {
				$errores ++;
				$errorResultado .= "El campo subCategoria no puede estar vacío. <br>";
			}
			if (empty($idCategoria)) {
				$errores ++;
				$errorResultado .= "El campo categoria no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblSubcategorias(subcategoria, idCategoria) SELECT * FROM (SELECT '$subCategoria' AS subcategoria, '$idCategoria' AS idCategoria) AS tmp WHERE NOT EXISTS (SELECT subcategoria FROM tblSubcategorias WHERE subcategoria = '$subCategoria') LIMIT 1; ";
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
		public function actualizar($idSubcategoria,$subcategoria,$idCategoria){
			$idSubcategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idSubcategoria))));
			$subcategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($subcategoria))));
			$idCategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCategoria))));
			$errores = 0;
			$errorResultado = "";
			if (empty($idSubcategoria)) {
				$errores ++;
				$errorResultado .= "El campo idSubcategoria no puede estar vacío. <br>";
			}
			if (empty($subcategoria)) {
				$errores ++;
				$errorResultado .= "El campo subcategoria no puede estar vacío. <br>";
			}
			if (empty($idCategoria)) {
				$errores ++;
				$errorResultado .= "El campo idCategoria no puede estar vacío. <br>";
			}
			if($errores === 0){
				//$consulta = "UPDATE tblcomputadoras a_b SET a_b.Marca = '$computo' WHERE a_b.IdComputadoras = '$idComputadoras' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblcomputadoras) AS a_b_2 WHERE a_b_2.Marca = '$computo' AND a_b_2.IdComputadoras != '$idComputadoras') AS count); ";
				$consulta = "UPDATE tblSubcategorias SET subcategoria='$subcategoria',idCategoria=$idCategoria  where idSubcategoria = '$idSubcategoria'";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
				  	if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "La Categoria ya existe o no se actualizó ningún dato. <br>";	
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
		public function eliminar($idSubcategoria){
			$idSubcategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idSubcategoria))));
			$consulta = "SELECT * FROM tblSubcategorias s inner join tblProductos p on s.idSubcategoria = p.idSubcategoria where p.idSubcategoria=$idSubcategoria";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				if($this->conexion->affected_rows >= 1){
						return "SubCategoria tiene un Producto.";
					}else{
						$consulta1="DELETE FROM tblSubcategorias WHERE idSubcategoria = '$idSubcategoria'";
						$resultado2 = $this->conexion->query($consulta1);
						return "OK";
						}
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
  		//public function listarSubcategoria(){
   		//	$datos = array();
   		//	$consulta="SELECT idsubcategoria,idcategoria,subcategoria FROM tblSubcategorias ORDER BY subcategoria";
   			//$consulta="SELECT * FROM tblsubcategorias INNER JOIN tblcategorias ON tblsubcategorias.idcategoria=tblcategorias.idcategoria";
   		//	$resultado = $this->conexion->query($consulta);
		//	while ($filaTmp = $resultado->fetch_assoc()) {
		//		$datos [] = $filaTmp;
		//		}
		//	if($resultado){
		//		return $datos;
		//	}
   		//	elseif (!$this->conexion->query($consulta)) {
	 	//		echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   		//	}
   		//}
   		
		public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	


   }

   
?>