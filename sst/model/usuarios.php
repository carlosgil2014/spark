<?php 
class usuarios{

	protected $conexion;

	public function __construct() {
		$this->conexion = accesoDB::conDB();
	}
	
	public function datosUsuario($usuario){
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
		$consulta = "SELECT u.usuarios_id AS idUsuario, u.usuarios_empleados_id AS idEmpleado, u.usuarios_usuario AS usuario, usuarios_foto AS foto, e.empleados_numero_empleado AS numEmpleado, e.empleados_correo AS correo, p.nombre AS puesto, CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS nombre, e.empleados_rfc AS rfc, usuarios_mrs AS mrs, usuarios_mcg AS mcg, usuarios_ma AS ma, usuarios_mcc AS mcc, usuarios_mrh AS mrh, usuarios_ms AS ms FROM spartodo_spar_bd.spar_empleados e LEFT JOIN spartodo_rh.tblPuestos p ON e.empleados_puesto = p.idPuesto LEFT JOIN tblUsuarios u ON e.empleados_id = u.usuarios_empleados_id WHERE u.usuarios_usuario = '".$usuario."' ";
		$resultado = $this->conexion->query($consulta);
		$datos = array();

		if($resultado){
			return $resultado->fetch_assoc();
		}
		else{
   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	}

	public function actualizarPerfil($idUsuario, $usuarioNuevo, $usuarioActual, $foto){
		$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
		$usuarioNuevo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuarioNuevo))));
		$usuarioActual = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuarioActual))));
		$actualizarFoto = "";
		$errores = 0;
		$errorResultado = "";

		if (empty($usuarioNuevo)) {
			$errores ++;
			$errorResultado .= "El campo usuario no puede estar vacío. <br>";
		}
		if(!empty($foto)){
			list($ancho, $alto) = getimagesize($foto);
			$foto = $this->conexion -> real_escape_string(trim(file_get_contents($foto)));
			// if($ancho != 120 || $alto != 140) { //$ancho != $alto
				// $errores ++;
				// $errorResultado .= "Las dimensiones deben de ser 120 x 140. <br>";
			// }
			$actualizarFoto = ", a_b.usuarios_foto = '$foto'";
		}

		if($errores == 0){
			$consulta = "UPDATE tblUsuarios a_b SET a_b.usuarios_usuario = '$usuarioNuevo'$actualizarFoto WHERE a_b.usuarios_id = '$idUsuario' AND usuarios_usuario = '$usuarioActual' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblUsuarios) AS a_b_2 WHERE a_b_2.usuarios_usuario = '$usuarioNuevo' AND a_b_2.usuarios_id != '$idUsuario') AS count); ";
			$resultado = $this->conexion -> query($consulta);
			if($resultado){
			  	if($this->conexion->affected_rows === 1){
			  		$_SESSION["spar_usuario"] = $usuarioNuevo;
					return "OK";
			  	}
				else 
					return "El Usuario ya existe o no se actualizó ningún dato. <br>";	
			}
			else{
				echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function actualizarContraseña($idUsuario, $usuario, $contraseñaActual, $contraseñaNueva, $contraseñaNueva1){

		$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));	
		$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));	
		$contraseñaActual = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($contraseñaActual))));
		$contraseñaNueva = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($contraseñaNueva))));
		$contraseñaNueva1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($contraseñaNueva1))));
		$errores = 0;
		$errorResultado = "";
		$consulta = "";

		if (empty($contraseñaActual)) {
			$errores ++;
			$errorResultado .= "El campo contraseña actual no puede estar vacío. <br>";
		}
		if (empty($contraseñaNueva)) {
			$errores ++;
			$errorResultado .= "El campo contraseña nueva no puede estar vacío. <br>";
		}
		if (empty($contraseñaNueva1)) {
			$errores ++;
			$errorResultado .= "El campo confirme contraseña no puede estar vacío. <br>";
		}

		if ($contraseñaNueva != $contraseñaNueva1) {
			$errores ++;
			$errorResultado .= "Las contraseñas nuevas no coinciden. <br>";
		}

		

		$consulta = "SELECT usuarios_contrasena FROM tblUsuarios WHERE usuarios_id = '$idUsuario' AND usuarios_usuario = '$usuario'; ";
		$resultado = $this->conexion -> query($consulta);
        if($resultado){
        	$filaTmp = $resultado->fetch_assoc();
        	$filas = $resultado->num_rows;
			if($filas === 1){
	        	if($filaTmp["usuarios_contrasena"] != sha1($contraseñaActual)){
	        		$errores ++;
					$errorResultado .= "La contraseña actual no es correcta. <br>";
	        	}
	        	if ($filaTmp["usuarios_contrasena"] == sha1($contraseñaNueva)){
					$errores ++;
					$errorResultado .= "Las contraseña nueva no puede ser igual a la anterior. <br>";
				}
			}		
		}
		else{
			return $this->conexion->error;
		}

		if($idUsuario !== "0" && $idUsuario > 0 && !empty($usuario)){
			$consulta = "UPDATE tblUsuarios SET usuarios_contrasena = sha1('$contraseñaNueva') WHERE usuarios_id = '$idUsuario' AND usuarios_usuario = '$usuario' AND usuarios_contrasena = sha1('$contraseñaActual'); ";
		}
		else{
			$errores ++;
			$errorResultado .= "Los datos son incorrectos.";
		}

		if($errores == 0){
			if(!empty($consulta)){	
				$resultado = $this->conexion -> query($consulta);
	            if($resultado){
	            	if($this->conexion->affected_rows === 1)
						return "OK";
					else{
						return "No se actualizó ningún dato.";
					}
				}
				else{
					return $this->conexion->error;
				}
			}
			else{
				return "OK";
			}
		}
		else{
			return $errorResultado;
		}
	}

	public function buscarEmpleados($buscar)
    {
        $datosEmpleados = array();
        $buscar = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($buscar))));
        $errores = 0;
        $errorResultado = "";
        if(empty($buscar)) {
           $errores ++;
           $errorResultado .= "El campo no puede estar vacío. <br>";
        }
        else{
           if(strlen($buscar) < 3){
              $errores ++;
              $errorResultado .= "El campo debe contener mínimo 3 caracteres. <br>";
           }
        }
        if($errores === 0){
           $consulta = "SELECT empleados_id AS id, CONCAT( empleados_apellido_paterno, ' ',empleados_apellido_materno, ' ',empleados_nombres) AS nombre, empleados_rfc AS rfc FROM spartodo_spar_bd.spar_empleados e LEFT JOIN tblUsuarios u ON e.empleados_id = u.usuarios_empleados_id WHERE (CONCAT( empleados_apellido_paterno, ' ',empleados_apellido_materno, ' ',empleados_nombres) LIKE '%$buscar%' OR empleados_apellido_paterno LIKE '%$buscar%' OR empleados_apellido_materno LIKE '%$buscar%' OR empleados_nombres LIKE '%$buscar%' OR empleados_rfc LIKE '%$buscar%') GROUP BY id";
           $resultado = $this->conexion->query($consulta);
           if($resultado){
              while ($filaTmp = $resultado->fetch_assoc()) {
                 $datosEmpleados[] = $filaTmp;
              }
           }
           else
              echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

           return $datosEmpleados;
        }
        else
           return $errorResultado;
    }

      public function informEmpleado($idEmpleado){
			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
   			$consulta="SELECT e.empleados_id,CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS nombre, e.empleados_correo,p.nombre FROM spar_empleados e LEFT join spartodo_rh.tblPuestos p on e.empleados_puesto=p.idPuesto WHERE e.empleados_id = $idEmpleado";
   			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}


	public function __destruct() {
		mysqli_close($this->conexion);
	}
}
?>