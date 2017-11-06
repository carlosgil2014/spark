<?php 

	
	class empleados{
		
		protected $acceso;
 		protected $conexion;

		public function __construct() {
			//$this->acceso = new accesoDB(); 
 		 	$this->conexion =accesoDB::conDB();
   		}

   		public function limpiarEmpleadosBaja(){
   			$consulta="DELETE FROM sistemas_tblempleados WHERE datediff(expiracion,curdate()) <= -15 AND idempleado IN ( SELECT empleados_id FROM spar_empleados WHERE empleados_vigente='0')";
   			$this->conexion->query($consulta);
   		}

		public function guardaEmpleado($datos){

			$nombres = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['nombres']))));
			$apellidop = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['apellidop']))));
			$apellidom = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['apellidom']))));
			$departamento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['departamento']))));
			$puesto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['puesto']))));
			$correo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['correo']))));
			$telefono = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['telefono']))));
			$extension = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['extension']))));
			$contraseniacomp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['contraseniacomp']))));
			$contraseniacorreo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['contraseniacorreo']))));
			$fechacambio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechacambio']))));
			$expiracion = date('Y-m-d', strtotime($fechacambio. ' + 90 days'));
			$correoCorrecto = 0;
		
			if(filter_var($correo, FILTER_VALIDATE_EMAIL))
			{ //Comprobar si es válido el correo
				$correoCorrecto = 1;
			}
			
			if(!empty($nombres) && !empty($apellidop) && !empty($contraseniacomp) && !empty($contraseniacorreo)  && $correoCorrecto == 1)
			{
			
				$consulta = "INSERT INTO tblempleados (nombre,apellidop,apellidom,iddepartamento,idpuesto,correo,telefono,extension) VALUES (UPPER('".$nombres."'),UPPER('".$apellidop."'),UPPER('".$apellidom."'),'".$departamento."','".$puesto."','".$correo."','".$telefono."','".$extension."')";
				if($this->conexion->query($consulta)){
					$id= $this->conexion->insert_id;
					$consulta = "INSERT INTO sistemas_tblempleados(idempleado,contraseniacomp,contraseniacorreo,expiracion,fechacambio) VALUES ('".$id."','".$contraseniacomp."','".$contraseniacorreo."','".$expiracion."','".$fechacambio."')";
					if($this->conexion->query($consulta)){
						return 1;
					}
				}
	   			elseif (!$this->conexion->query($consulta)) {
	   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   			}
   			}
   			else{
   				return 2;   			
   			}
		}

		public function actualizarEmpleado($datos){

			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['id']))));
			$idSistemasEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idsistemasempleado']))));
			$correoAgencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['correoAgencia']))));
			$contraComp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['contraComp']))));
			$contraCorreo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['contraCorreo']))));
			$fchExpira = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fchExpira']))));
			$fchCambio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fchCambio']))));
		

			$expiracion = date('Y-m-d', strtotime($fchCambio. ' + 90 days'));
			


			if(filter_var($correoAgencia, FILTER_VALIDATE_EMAIL))
			{ //Comprobar si es valido el correo
				$correoCorrecto = 1;
			}

			if(!empty($idEmpleado) && !empty($correoAgencia) && !empty($contraComp) && !empty($contraCorreo) && !empty($fchCambio) && $correoCorrecto == 1)
			{ 
				$consulta = "UPDATE sistemas_tblempleados SET contraseniacomp='$contraComp' , contraseniacorreo='$contraCorreo' , fechacambio='$fchCambio' , expiracion='$fchExpira' , correoagencia='$correoAgencia' WHERE idempleado=$idEmpleado AND idsistemasempleado=$idSistemasEmpleado" ;
				
				if($this->conexion->query($consulta)){
					return "OK";
				}
	   			elseif (!$this->conexion->query($consulta)) {
	   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   			}
   			
   			}else{
   			
   				return "Algunos Campos no se llenaron";   			
   			}


		}

		public function listarEmpleadosExpirados(){

   			//$consulta="DELETE FROM sistemas_tblempleados WHERE datediff(expiracion,curdate()) < -33";
   			$consulta="SELECT idsistemasempleado,empleados_id,empleados_vigente,CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno) AS nombre ,empleados_correo,correoagencia,contraseniacomp,contraseniacorreo,expiracion, datediff(expiracion,curdate()) AS expira,empleados_empresa FROM spar_empleados RIGHT JOIN sistemas_tblempleados ON idempleado=empleados_id WHERE empleados_vigente=1 AND datediff(expiracion,curdate()) <= 0";
			
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			

			if($resultado){

				while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;

				}
				
				return $datos;

			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

	   			//echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}			

   		}

		public function listarEmpleadosActivos(){

			
			$consulta = "SELECT idsistemasempleado,empleados_id,empleados_vigente,CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno) AS nombre ,empleados_correo,correoagencia,contraseniacomp,contraseniacorreo,expiracion, datediff(expiracion,curdate()) AS expira,empleados_empresa FROM spar_empleados RIGHT JOIN sistemas_tblempleados ON idempleado=empleados_id WHERE empleados_vigente='1' AND datediff(expiracion,curdate()) >= 1";
			
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			

			if($resultado){

				while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;

				}
				
				return $datos;

			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

	   			//echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}
		}


		public function listarEmpleadosBajas(){

			$consulta = "SELECT idsistemasempleado,empleados_id,empleados_vigente,CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno) AS nombre ,empleados_correo,correoagencia,contraseniacomp,contraseniacorreo,expiracion, datediff(expiracion,curdate()) AS expira,empleados_empresa FROM spar_empleados RIGHT JOIN sistemas_tblempleados ON idempleado=empleados_id WHERE empleados_vigente='0'";
			
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			

			if($resultado){

				while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;

				}
				
				return $datos;

			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

	   			//echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}
		}



		public function listarEmpleadosVigentes(){

			$consulta = "SELECT empleados_id AS id , CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno) AS nombre FROM spar_empleados LEFT JOIN sistemas_tblempleados ON empleados_id=idempleado WHERE empleados_vigente=1 ORDER BY nombre ASC";
				
			$resultado = $this->conexion->query($consulta);
			
			$datos = array();
			

			if($resultado){

				while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;

				}
				
				return $datos;

			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

	   			//echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}
		}


		public function agregarEmpleado($datos){

			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['id']))));
			$correoAgencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['correoAgencia']))));
			$contraComp = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['contraComp']))));
			$contraCorreo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['contraCorreo']))));
			$fchExpira = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fchExpira']))));
			$fchCambio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fchCambio']))));

			$consulta = "INSERT INTO sistemas_tblempleados (idempleado,contraseniacomp,contraseniacorreo,fechacambio,expiracion,correoagencia,estado) VALUES ('$idEmpleado','$contraComp','$contraCorreo','$fchCambio','$fchExpira','$correoAgencia','1')";

			$resultado = $this->conexion->query($consulta);

			if($resultado){

				return "OK";
			}else{

				//return "Fallo";
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}	


			
		}


		public function bajaEmpleado($idEmpleado){

			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));

			$consulta = "UPDATE sistemas_tblempleados SET estado=0 WHERE idempleado=$idEmpleado";

			$resultado = $this->conexion->query($consulta);

			
			if($resultado){

				return "OK";
			}

			

		}



		public function datosEmpleado($idEmpleado){

			if($idEmpleado > 0){

					$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
					
					$consulta = "SELECT *,CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno) AS nombre , datediff(expiracion,curdate()) AS expira FROM spar_empleados RIGHT JOIN sistemas_tblempleados ON idempleado=empleados_id WHERE estado=1 AND empleados_id='$idEmpleado'";

					$resultado = $this->conexion->query($consulta);
					$datos = array();

					if($resultado && $resultado->num_rows >0){
						$datos = $resultado->fetch_assoc();
						return $datos;
					}
		   			elseif (!$resultado) {
			   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		   			}
		   			elseif ($resultado && $resultado->num_rows <=0) {
		   				
		   				return 0;
		   				
		   			}

   			} else {

   				return 0;

   			}
		}

		
		public function bajaActivarEmpleado($datos){
			
			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idempleado']))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['estado']))));
			if(!empty($idEmpleado) && isset($estado)){
				$consulta = "UPDATE sistemas_tblempleados SET estado = '".$estado."' WHERE idempleado = '".$idEmpleado."';";
				$resultado = $this->conexion->multi_query($consulta);
				if($resultado){
					return 1;
				}
	   			elseif (!$resultado) {
		   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   			}
   			}
   			else{
   				return 2;
   			}
		}

		public function existeCorreo($correo,$idEmpleado){

			$acceso = new accesoDB(); 
			$this->conexion = $acceso->conDB();
			$correo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($correo))));
			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idEmpleado))));
			$subconsulta = 'AND id != ' .$idEmpleado; 
			if($idEmpleado == 0)
				$subconsulta = '';
			$consulta = "SELECT * FROM tblempleados WHERE correo = '".$correo."' ".$subconsulta;
			$resultado = $this->conexion->query($consulta);
			$datos = array();

			if($resultado && $resultado->num_rows >0){
				mysqli_close($this->conexion);
				return 0;
			}
   			elseif (!$resultado) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   			elseif ($resultado && $resultado->num_rows <=0) {
   				return 1;
   			}
		}

		
		public function __destruct() {
				mysqli_close($this->conexion);
  		}

	}
?>