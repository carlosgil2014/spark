<?php 
class permisos
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar($modulo, $idUsuario){
		$datos = array();
		$modulo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($modulo))));
		$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
		$consulta="SELECT p.nombre, pu.valor FROM spartodo_rh.tblModulos m LEFT JOIN spartodo_rh.tblModulosPermisos mp ON m.idModulo = mp.idModulo LEFT JOIN spartodo_rh.tblPermisos p ON mp.idPermiso = p.idPermiso LEFT JOIN spartodo_rh.tblPermisosUsuarios pu ON mp.idModuloPermiso = pu.idModuloPermiso WHERE m.nombre = '$modulo' AND pu.idUsuario = '$idUsuario'";
		$resultado = $this->conexion->query($consulta);
		// echo $consulta;
		if($resultado){
			while ($filaTmp = $resultado->fetch_assoc()) {
				// var_dump($filaTmp);
				$datos[$filaTmp["nombre"]] = $filaTmp["valor"];
			}
			return $datos;
		}
		else{
			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function __destruct() 
	{
		mysqli_close($this->conexion);
	}	
}
?>