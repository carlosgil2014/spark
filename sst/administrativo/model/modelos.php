<?php 
	class modelos
	{
 		protected $acceso;
 		protected $conexion;

		public function __construct() 
		{
		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT mr.idmarca,mr.marca , m.modelo, m.idModelo FROM tblMarcas mr inner join tblModelos m on mr.idMarca=m.idMarca order by marca";
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
   		public function informacion($idModelo){
			$idModelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idModelo))));
   			$consulta="SELECT idModelo, modelo, idMarca FROM tblModelos WHERE idmodelo = '$idModelo'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($Modelo,$idMarca){
			$Modelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Modelo))));
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($Modelo)) {
				$errores ++;
				$errorResultado .= "El campo Modelo no puede estar vacío. <br>";
			}
			if (empty($idMarca)) {
				$errores ++;
				$errorResultado .= "El campo Marca no puede estar vacío. <br>";
			}
			
			if($errores === 0){
				$consulta = "INSERT INTO tblModelos(modelo,idMarca) SELECT * FROM (SELECT '$Modelo' AS Modelo, $idMarca AS idMarca) AS tmp WHERE NOT EXISTS (SELECT modelo FROM tblModelos WHERE modelo = '$Modelo') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "La Modelo ya existe. <br>";
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
		public function actualizar($idModelo,$Modelo,$idMarca){
			$idModelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idModelo))));
			$Modelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($Modelo))));
			$idMarca = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMarca))));
			$errores = 0;
			$errorResultado = "";
			if (empty($Modelo)) {
				$errores ++;
				$errorResultado .= "El campo Modelo no puede estar vacío. <br>";
			}
			if (empty($idMarca)) {
				$errores ++;
				$errorResultado .= "El campo marca no puede estar vacío. <br>";
			}
			if($errores === 0){
				
				$consulta = "UPDATE tblModelos SET modelo='$Modelo', idMarca='$idMarca' where idModelo = '$idModelo'";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
				  	if($this->conexion->affected_rows === 1)
						echo "OK";
					else 
						echo "La Modelo ya existe o no se actualizó ningún dato. <br>";	
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
		public function eliminar($idModelo){
			$idModelo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idModelo))));
			$consulta="DELETE FROM tblModelos WHERE idModelo = $idModelo";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}


   		// Angie Favor de no borrar :(
   		public function listarMarcasCategorias($equipo){
			
   			$consulta="SELECT marca FROM tblMarcaCategoria t1 INNER JOIN
						tblCategorias t2 ON t1.idcategoria=t2.idcategoria INNER JOIN
						tblMarcas t3 ON t1.idmarca=t3.idmarca WHERE t2.categoria='$equipo'";

			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				
				while($tmp = $resultado->fetch_assoc()){

					$datos[] = $tmp;

				}
				
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