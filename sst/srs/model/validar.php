<?php 
	require_once('../db/conectadb.php');

	class validar{
 		protected $acceso;
 		protected $conexion;

		public function __construct() {
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		} 

		public function validaUsuario($usuario,$contrasena){

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$contrasena = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($contrasena))));
			$consulta = "SELECT * FROM tblusuarios WHERE user_name = '".$usuario."' and password = '".$contrasena."'"; //Consulta si existe el usuario                   
            $queryConsulta = $this->conexion -> query($consulta) or die($this->conexion->error);
            $resultado = $queryConsulta->fetch_assoc();
			$correcto = $queryConsulta->num_rows;
				if($correcto == 1){
					$_SESSION['srs_usuario'] = $usuario;
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