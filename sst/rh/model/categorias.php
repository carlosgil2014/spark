<?php 
	require_once('../db/conectadb.php');

	class categorias
	{
 		protected $acceso;
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT idcategoria,categoria FROM tblCategorias ORDER BY categoria";
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
   		public function informacion($idCategoria){
			$idCategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCategoria))));
   			$consulta="SELECT idcategoria, categoria FROM tblCategorias WHERE idcategoria = '$idCategoria'";
   			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($Categoria){
			$Categoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Categoria))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($Categoria)) {
				$errores ++;
				$errorResultado .= "El campo Categoria no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblCategorias(categoria) SELECT * FROM (SELECT '$Categoria' AS Categoria) AS tmp WHERE NOT EXISTS (SELECT categoria FROM tblCategorias WHERE categoria = '$Categoria') LIMIT 1; ";
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
		public function actualizar($idCategoria,$Categoria){
			$idCategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCategoria))));
			$Categoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Categoria))));
			$errores = 0;
			$errorResultado = "";
			if (empty($Categoria)) {
				$errores ++;
				$errorResultado .= "El campo Categoria no puede estar vacío. <br>";
			}
			if($errores === 0){
				//$consulta = "UPDATE tblcomputadoras a_b SET a_b.Marca = '$computo' WHERE a_b.IdComputadoras = '$idComputadoras' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblcomputadoras) AS a_b_2 WHERE a_b_2.Marca = '$computo' AND a_b_2.IdComputadoras != '$idComputadoras') AS count); ";
				$consulta = "UPDATE tblCategorias SET categoria='$Categoria' where idcategoria = '$idCategoria'";
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
		public function eliminar($idCategoria){
			$idCategoria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCategoria))));
			$consulta="DELETE FROM tblCategorias WHERE idcategoria = '$idCategoria'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
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