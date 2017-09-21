<?php 
class metodosPago
{
	protected $conexion;

	public function __construct() 
	{
		 $this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta = "SELECT idmetodopago, nombre FROM tblMetodosPago";
		// echo $consulta;
		$resultado = $this->conexion->query($consulta);
		while ($filaTmp = $resultado->fetch_assoc()) {
			$datos [] = $filaTmp;
		}
		if($resultado){
			return $datos;
		}
		else{
   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}
}
?>