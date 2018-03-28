<?php 
class usuariosMA
	{
 		protected $conexion;

		public function __construct() 
		{
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT u.usuarios_id AS id,u.usuarios_usuario AS usuario, CONCAT(e.empleados_apellido_paterno,' ',e.empleados_apellido_materno,' ',e.empleados_nombres) AS nombre, e.empleados_correo AS correo, u.usuarios_mrs AS mrs,u.usuarios_mcg AS mcg,u.usuarios_mcc AS mcc,u.usuarios_ma AS ma,u.usuarios_mrh AS mrh, u.usuarios_ms AS ms  FROM spartodo_spar_bd.tblUsuarios u LEFT JOIN spartodo_spar_bd.spar_empleados e ON u.usuarios_empleados_id = e.empleados_id";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			else {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function informacion($idUsuario){
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
   			$consulta="SELECT u.usuarios_usuario AS usuario, CONCAT(e.empleados_apellido_paterno,' ',e.empleados_apellido_materno,' ',e.empleados_nombres) AS nombre, e.empleados_correo AS correo, p.nombre AS puesto  FROM spartodo_spar_bd.spar_empleados e LEFT JOIN spartodo_spar_bd.tblUsuarios u ON e.empleados_id = u.usuarios_empleados_id LEFT JOIN spartodo_rh.tblPuestos p ON e.empleados_puesto = p.idPuesto WHERE u.usuarios_id = '$idUsuario'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function informacionEmpleado($idEmpleado){
			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
   			$consulta="SELECT CONCAT(e.empleados_apellido_paterno,' ',e.empleados_apellido_materno,' ',e.empleados_nombres) AS nombre, e.empleados_correo AS correo, e.empleados_rfc AS rfc  FROM spartodo_spar_bd.spar_empleados e WHERE e.empleados_id = '$idEmpleado'";
   			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function guardar($datos, $idEmpleado){

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["usuario"]))));
			$contrasena = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["contrasena"]))));
			$contrasena1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["contrasena1"]))));
			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));

			$errores = 0;
			$errorResultado = "";
			
			if (empty($usuario)) {
				$errores ++;
				$errorResultado .= "El campo usuario no puede estar vacío. <br>";
			}

			if (empty($idEmpleado)) {
				$errores ++;
				$errorResultado .= "El empleado es incorrecto. <br>";
			}

			if (empty($contrasena)) {
				$errores ++;
				$errorResultado .= "El campo contraseña actual no puede estar vacío. <br>";
			}
			if (empty($contrasena1)) {
				$errores ++;
				$errorResultado .= "El campo contraseña nueva no puede estar vacío. <br>";
			}

			if ($contrasena != $contrasena1) {
				$errores ++;
				$errorResultado .= "Las contraseñas no coinciden. <br>";
			}

			$clientes = array();
			if(isset($datos["clientes"])){
				foreach ($datos["clientes"] as $cliente) {
					$clientes[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cliente))));
					if(!is_numeric($cliente) || $cliente <= 0){
						$errores ++;
						$errorResultado .= "El campo Cliente es incorrecto. <br>";
						break;
					}
				}
			}

			if($errores === 0){
				$consulta = "INSERT INTO tblUsuarios(usuarios_empleados_id, usuarios_usuario, usuarios_contrasena) SELECT * FROM (SELECT '$idEmpleado' AS usuarios_empleados_id, '$usuario' AS usuarios_usuario, SHA1('$contrasena') AS usuarios_contrasena) AS tmp WHERE NOT EXISTS (SELECT usuarios_usuario FROM tblUsuarios WHERE usuarios_usuario = '$usuario') LIMIT 1; ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		if($this->conexion->affected_rows === 1){
			  			$idUsuario = $this->conexion->insert_id;
			  			return $this->guardarUsuarioClientes($idUsuario, $clientes);
			  		}
					else 
						return "El Usuario ya existe. <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}

		public function actualizar($datos,$idUsuario){
			
			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["usuario"]))));
			$contrasena = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["contrasena"]))));
			$contrasena1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["contrasena1"]))));
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));

			$errores = 0;
			$errorResultado = "";
			
			if (empty($usuario)) {
				$errores ++;
				$errorResultado .= "El campo usuario no puede estar vacío. <br>";
			}

			if (empty($idUsuario)) {
				$errores ++;
				$errorResultado .= "El usuario es incorrecto. <br>";
			}

			if ($contrasena != $contrasena1) {
				$errores ++;
				$errorResultado .= "Las contraseñas no coinciden. <br>";
			}

			$clientes = array();
			if(isset($datos["clientes"])){
				foreach ($datos["clientes"] as $cliente) {
					$clientes[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cliente))));
					if(!is_numeric($cliente) || $cliente <= 0){
						$errores ++;
						$errorResultado .= "El campo Clientes es incorrecto. <br>";
						break;
					}
				}
			}

			if($errores === 0){
				$consulta = "UPDATE tblUsuarios u SET u.usuarios_usuario = '$usuario' , u.usuarios_contrasena = SHA1('$contrasena') WHERE u.usuarios_id = '$idUsuario' AND '$contrasena' <> '' AND 0 = (SELECT COUNT(*) FROM (SELECT * FROM (SELECT * FROM tblUsuarios) AS u2 WHERE u2.usuarios_usuario = '$usuario' AND u2.usuarios_id != '$idUsuario') AS count); ";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
			  		$filasModificadasUsuario = $this->conexion->affected_rows;
				  	$clientesActualesUsuario = $this->informacionUsuariosClientes($idUsuario);
				  	if($filasModificadasUsuario === 1 || (count(array_intersect($clientes, $clientesActualesUsuario)) != count($clientesActualesUsuario)) || (count(array_intersect($clientesActualesUsuario, $clientes)) != count($clientes))){
						foreach ($clientesActualesUsuario as $clienteActualUsuario) {
							if(!in_array($clienteActualUsuario, $clientes)){
								$this->eliminarUsuariosClientes($clienteActualUsuario,$idUsuario);
							}
						}
			  			return $this->guardarUsuarioClientes($idUsuario, $clientes);
			  		}
					else 
						return "El Usuario ya existe o no se modificó ningún dato <br>";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
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
	           $consulta = "SELECT empleados_id AS id, CONCAT( empleados_apellido_paterno, ' ',empleados_apellido_materno, ' ',empleados_nombres) AS nombre, empleados_rfc AS rfc FROM spartodo_spar_bd.spar_empleados e LEFT JOIN tblUsuarios u ON e.empleados_id = u.usuarios_empleados_id WHERE (CONCAT( empleados_apellido_paterno, ' ',empleados_apellido_materno, ' ',empleados_nombres) LIKE '%$buscar%' OR empleados_apellido_paterno LIKE '%$buscar%' OR empleados_apellido_materno LIKE '%$buscar%' OR empleados_nombres LIKE '%$buscar%' OR empleados_rfc LIKE '%$buscar%') AND u.usuarios_empleados_id IS NULL GROUP BY id";
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


		public function guardarUsuarioClientes($idUsuario, $clientes){
			$ok = 0;
			$consulta = "";
			foreach ($clientes as $cliente) {
				$consulta .= "INSERT INTO tblUsuariosClientes(idUsuario, idCliente) SELECT * FROM (SELECT '$idUsuario' AS idUsuario, '$cliente' AS idCliente) AS tmp WHERE NOT EXISTS (SELECT idUsuario FROM tblUsuariosClientes WHERE idUsuario = '$idUsuario' AND idCliente = '$cliente') LIMIT 1; ";
			}
			if(!empty($consulta))
				if ($this->conexion->multi_query($consulta))
				{
					$ok = 1;
				  do
				    {
				    if ($resultado = $this->conexion->store_result()) {
				      $resultado->free();
				      }
				    }
				  while (@$this->conexion->next_result());
				}

			if ($ok==1 || count($clientes) == 0) {
				return "OK";
			}
			else{
   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   		}
			
		}

		public function informacionUsuariosClientes($idUsuario){
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$array = array();
   			$consulta="SELECT idCliente FROM tblUsuariosClientes WHERE idUsuario = '$idUsuario'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while($filaTmp = $resultado->fetch_assoc()){
					$array [] = $filaTmp["idCliente"];
				}
				return $array;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

		public function eliminarUsuariosClientes($idCliente,$idUsuario){
			$consulta="DELETE FROM tblUsuariosClientes WHERE idUsuario = '$idUsuario' AND idCliente = '$idCliente'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function eliminar($idCliente){
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
			$consulta="DELETE FROM tblclientes WHERE idclientes = $idCliente";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

   		public function actualizarModulo($idUsuario, $columna, $valor){
			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario))));
			$columna = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($columna))));
			$valor = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($valor))));
			$consulta="UPDATE spartodo_spar_bd.tblUsuarios SET usuarios_$columna = '$valor' WHERE usuarios_id = '$idUsuario';";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}

		public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	
   }
?>