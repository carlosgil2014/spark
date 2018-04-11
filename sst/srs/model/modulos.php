<?php 
	class modulos{
		
 		protected $conexion;

		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 
		
		public function listar(){
			$datos = array();
			$consulta="SELECT m.idModulo, IFNULL(GROUP_CONCAT(p.nombre),'Sin permisos relacionados') AS permisos, m.nombre FROM spartodo_srs.tblModulos m LEFT JOIN spartodo_srs.tblModulosPermisos mp ON m.idModulo = mp.idModulo LEFT JOIN spartodo_srs.tblPermisos p ON mp.idPermiso = p.idPermiso GROUP BY m.idModulo";
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