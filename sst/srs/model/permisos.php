<?php 
	class permisos{
		
 		protected $conexion;

		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 
		
		public function verificarPermiso($idUsuario,$idPermiso){
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$consulta = "SELECT IFNULL(SUM(crear),0) as crear,IFNULL(SUM(autorizar),0) as autorizar,IFNULL(SUM(polizas),0) as poliza,IFNULL(SUM(cfdi),0) as cfdi,IFNULL(SUM(pagos),0) as pagos FROM spartodo_srs.tblpermisosusuarios WHERE idusuario = '$idUsuario' AND idpermiso = '$idPermiso'"; //PERMISOS PARA CADA USUARIo
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $permisos = $resultado ->fetch_assoc();
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function __destruct() {
				mysqli_close($this->conexion);
  		}
	}
?>