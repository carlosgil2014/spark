<?php 
class usuarios
	{
 		protected $acceso;
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		}	

   		public function datosUsuario($usuario){

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$consulta = "SELECT e.empleados_numero_empleado,CONCAT(e.empleados_apellido_paterno,' ',e.empleados_apellido_materno,' ',e.empleados_nombres) AS nombre, usuarios_ms AS ms FROM spartodo_spar_bd.spar_empleados e LEFT JOIN tblUsuarios u ON e.empleados_id = u.usuarios_empleados_id WHERE u.usuarios_usuario = '".$usuario."' ";
			$resultado = $this->conexion->query($consulta);
			$datos = array();

			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$resultado) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	
   }
?>