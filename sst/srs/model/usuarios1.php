<?php 

	require_once('../db/conectadb.php');

	class usuarios{

		protected $acceso;
 		protected $conexion;

		public function __construct() {
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		} 

		public function datosUsuario($usuario){

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$consulta = "SELECT idusuarios FROM tblusuarios WHERE user_name = '".$usuario."'";
  			$resultado = $this->conexion->query($consulta);
			$idUsuario = $resultado->fetch_assoc();
  			
			if($resultado){
				return $idUsuario;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function nombreUsuario($usuario){

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$consulta = "SELECT full_name FROM tblusuarios WHERE user_name = '".$usuario."'";
  			$resultado = $this->conexion->query($consulta);
			$datos = $resultado->fetch_assoc();
  			
			if($resultado){
				return $datos["full_name"];
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function listarUsuarios(){

			$consulta = "SELECT idusuarios,full_name as nombre,user_name as usuario,password as contrasena FROM tblusuarios";
  			$resultado = $this->conexion->query($consulta);
  			while($filaTmp = $resultado ->fetch_assoc()){
				$datos[] = $filaTmp;
  			}
  			
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function listarClientesUsuario($idUsuario){

			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$consulta = "SELECT uc.idcliente FROM tblusuariosclientes uc LEFT JOIN tblclientes c ON c.idclientes =  uc.idcliente WHERE idusuario = '".$idUsuario."'";
  			$resultado = $this->conexion->query($consulta);
  			while($filaTmp = $resultado ->fetch_assoc()){
				$datos[] = $filaTmp["idcliente"];
  			}
  			
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function datos($idUsuario){

			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$consulta = "SELECT full_name as nombre FROM tblusuarios WHERE idusuarios = '".$idUsuario."'";
  			$resultado = $this->conexion->query($consulta);
			$datos = $resultado->fetch_assoc();
  			
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function guardarClientesUsuario($idClientes,$estados,$idUsuario){

			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$i = 0; $ok = 0; $consulta =  "";
			foreach ($idClientes as $idCliente) {
				switch ($estados[$i]) {
					case '0':
						if($this->existeClienteUsuario($idUsuario,$idCliente))
							$consulta .= "DELETE FROM tblusuariosclientes WHERE idcliente = '".$idCliente."' AND idusuario = '".$idUsuario."'; ";

						break;
					
					case '1':
						if(!$this->existeClienteUsuario($idUsuario,$idCliente))
							$consulta .= "INSERT INTO tblusuariosclientes(idusuario,idcliente) VALUES ('".$idUsuario."','".$idCliente."'); ";

						break;
					
					default:
						# code...
						break;
				}
				$i++;
			}
			echo $consulta;
			if ($this->conexion->multi_query($consulta))
			{
				$ok = 1;
			  	do
			    {
			    // Store first result set
			    	if ($resultado = $this->conexion->store_result()) 
			    	{ 
			      		while ($fila = $this->conexion->fetch_row())
			      			$resultado->free();
			     	}
			    }
			  	while ($this->conexion->next_result());
			}


			if($$ok = 1){
				return true;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function existeClienteUsuario($idUsuario,$idCliente){

			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
			$consulta = "SELECT count(*) as total FROM tblusuariosclientes WHERE idusuario = '".$idUsuario."' AND idcliente = '".$idCliente."'";
  			$resultado = $this->conexion->query($consulta);
			$datos = $resultado->fetch_assoc();
  			
			if($datos["total"] != 0){
				return true;
			}
   			else{
   				return false;
   			}
		}

		public function __destruct() {
				mysqli_close($this->conexion);
  		}
	}
?>