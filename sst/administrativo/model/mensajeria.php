<?php 

class mensajeria
{
	protected $conexion;

	public function __construct() 
	{
	 	$this->conexion = accesoDB::conDB();
	}	

	public function listar(){
		$datos = array();
		$consulta="SELECT idmensajeria, nombre , urlrastreo FROM tblMensajerias ORDER BY nombre";
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

	public function actualizar($datos){
		
		$idMensajeria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['id']))));
		$nomMensajeria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['nombre']))));
		$url = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['url']))));

		if (!preg_match( '/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $url)) 
	    {
	    	$url="http://".$url;
	    }

		$consulta = "UPDATE tblMensajerias SET nombre='$nomMensajeria',urlrastreo='$url' WHERE idmensajeria=$idMensajeria" ;
				
				if($this->conexion->query($consulta)){
					return "OK";
				}
	   			elseif (!$this->conexion->query($consulta)) {
	   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   			}

	}

	public function guardar($datos){
		
		$nomMensajeria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['nombre']))));
		$url = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['url']))));

		if (!preg_match( '/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $url)) 
	    {
	    	$url="http://".$url;
	    }

		$consulta = "INSERT INTO tblMensajerias(nombre,urlrastreo) SELECT * FROM (SELECT '$nomMensajeria' AS mensajeria , '$url' AS url)AS tmp WHERE NOT EXISTS (SELECT nombre FROM tblMensajerias WHERE nombre = '$nomMensajeria') LIMIT 1";
			
			$resultado=$this->conexion->query($consulta);


			if($resultado){
		  		if($this->conexion->affected_rows === 1)
					return "OK";
				else 
					return "La mensajeria ya existe.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
	}

	public function eliminar($idMensajeria){
		$idMensajeria = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idMensajeria))));

		$consulta="DELETE FROM tblMensajerias WHERE idmensajeria = $idMensajeria";
		$resultado = $this->conexion->query($consulta);
		if($resultado){
			return "OK";
		}
		else{
			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

}	


?>
