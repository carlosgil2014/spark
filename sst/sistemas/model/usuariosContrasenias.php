<?php 

	
	class empleados{
		
		protected $acceso;
 		protected $conexion;

		public function __construct() {
			//$this->acceso = new accesoDB(); 
 		 	$this->conexion =accesoDB::conDB();
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

			$idEmpleado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idempleado']))));
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
			{ //Comprobar si es valido el correo
				$correoCorrecto = 1;
			}

			if(!empty($idEmpleado) && !empty($nombres) && !empty($apellidop) && !empty($contraseniacomp) && !empty($contraseniacorreo) && $correoCorrecto == 1)
			{
				$consulta = "UPDATE tblempleados e LEFT JOIN sistemas_tblempleados se ON e.id = se.idempleado SET e.nombre = '".$nombres."', e.apellidop = '".$apellidop."', e.apellidom = '".$apellidom."', e.iddepartamento = '".$departamento."', e.idpuesto = '".$puesto."', e.correo = '".$correo."', e.telefono = '".$telefono."', e.extension = '".$extension."', se.contraseniacomp = '".$contraseniacomp."',se. contraseniacorreo = '".$contraseniacorreo."', se.expiracion = '".$expiracion."', se.fechacambio = '".$fechacambio."' WHERE e.id = '".$idEmpleado."'";
				if($this->conexion->query($consulta)){
					return 1;
				}
	   			elseif (!$this->conexion->query($consulta)) {
	   				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
	   			}
   			}
   			else{
   				return 2;   			
   			}
		}

		public function listarEmpleados($estado){

			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
			$consulta = "SELECT empleados_id,CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno) AS nombre ,empleados_correo,correoagencia,contraseniacomp,contraseniacorreo,expiracion, datediff(expiracion,curdate()) AS expira FROM spar_empleados RIGHT JOIN sistemas_tblempleados ON idempleado=empleados_id WHERE estado=1 AND empleados_id IS NOT NULL";
				
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;

			}

			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";


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

		public function datosCuenta(){

			$consulta = "SELECT idcuenta,nombre FROM tblcuentas WHERE estado = 1";
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;
			}

			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function datosDepartamento(){

			$consulta = "SELECT iddepartamento,nombre FROM tbldepartamentos ORDER BY nombre";
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;
			}

			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function datosPuesto(){

			$consulta = "SELECT idpuesto,nombre FROM tblpuestos ORDER BY nombre";
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;
			}

			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
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