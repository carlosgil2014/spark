<?php 
	class usuariosSRS{

 		protected $conexion;

		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 

		public function listar(){
			$datos = array();
			$consulta = "SELECT u.usuarios_id AS id,u.usuarios_usuario AS usuario,CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS nombre FROM spartodo_spar_bd.tblUsuarios u LEFT JOIN spartodo_spar_bd.spar_empleados e ON u.usuarios_empleados_id = e.empleados_id WHERE u.usuarios_mrs = '1'";
  			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					// var_dump($filaTmp);
					$datos[] = $filaTmp;
				}
				return $datos;
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function __destruct() {
				mysqli_close($this->conexion);
  		}
	}
?>