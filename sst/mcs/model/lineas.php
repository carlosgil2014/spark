<?php 
	require_once('../db/conectadb.php');

	class bancos
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
   			$consulta="SELECT idbanco, nombre FROM tblbancos ORDER BY nombre";
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

   		public function informacion($idBanco){
			$idBanco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idBanco))));
   			$consulta="SELECT idbanco, nombre FROM tblbancos WHERE idbanco = '$idBanco'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function guardar($banco){
			$banco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($banco))));
			$errores = 0;
			$errorResultado = "";
			
			if (empty($banco)) {
				$errores ++;
				$errorResultado .= "El campo Nombre no puede estar vacío. <br>";
			}
			
			
			if($errores === 0){
				$consulta = "INSERT INTO tblbancos(nombre) SELECT * FROM (SELECT '$banco' AS banco) AS tmp WHERE NOT EXISTS (SELECT nombre FROM tblbancos WHERE nombre = '$banco') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "El banco ya existe. <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

		public function actualizar($idBanco,$banco){
			$idBanco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idBanco))));
			$banco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($banco))));
			$errores = 0;
			$errorResultado = "";
			if (empty($banco)) {
				$errores ++;
				$errorResultado .= "El campo Nombre no puede estar vacío. <br>";
			}
			if($errores === 0){
				$consulta = "UPDATE tblbancos a_b SET a_b.nombre = '$banco' WHERE a_b.idbanco = '$idBanco' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblbancos) AS a_b_2 WHERE a_b_2.nombre = '$banco' AND a_b_2.idbanco != '$idBanco') AS count); ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
				  	if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "El banco ya existe o no se actualizó ningún dato. <br>";	
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

		public function eliminar($idBanco){
			$idBanco = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idBanco))));
			$consulta="DELETE FROM tblbancos WHERE idbanco = $idBanco";
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