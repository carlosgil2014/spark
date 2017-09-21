<?php 
	class validar{
 		protected $conexion;

		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 

		public function validaEmpleado($usuario,$contrasena){

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$contrasena = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($contrasena))));
			if(!empty(trim($usuario))){
				if(!empty(trim($contrasena))){
					$consulta = "SELECT * FROM tblUsuarios WHERE usuarios_usuario = '$usuario'"; //Consulta si existe el usuario                   
		            $queryConsulta = $this->conexion -> query($consulta) or die($this->conexion->error);
		            $resultado = $queryConsulta->fetch_assoc();
					$filas = $queryConsulta->num_rows;
						if($filas === 1){
							$consulta = "SELECT * FROM tblUsuarios WHERE usuarios_usuario = '$usuario' "; // AND empleados_vigente = 1 Consulta si el usuario está activo                 
				            $queryConsulta = $this->conexion -> query($consulta) or die($this->conexion->error);
				            $resultado = $queryConsulta->fetch_assoc();
							$filas = $queryConsulta->num_rows;
							if($filas === 1){			
								$consulta = "SELECT * FROM tblUsuarios WHERE usuarios_usuario = '$usuario' and usuarios_contrasena = SHA1('$contrasena')"; //Consulta si existe el usuario con el usuarios_contrasena correcto                   
					            $queryConsulta = $this->conexion -> query($consulta) or die($this->conexion->error);
					            $resultado = $queryConsulta->fetch_assoc();
								$filas = $queryConsulta->num_rows;
								if($filas === 1){
									$_SESSION["spar_usuario"] = $usuario;
									// $ultimo_ingreso = date('Y-m-d H:i:s');
									// $empleados_id = $resultado['empleados_id'];
									// $consulta = "UPDATE tblUsuarios SET empleados_ultimo_ingreso = '$ultimo_ingreso' WHERE empleados_id = '$empleados_id'";              
						            $resultado = $this->conexion -> query($consulta);
						            if($resultado){
						            	// $ip = $_SERVER["REMOTE_ADDR"];
						            	// $consulta = "INSERT INTO kiosco_spar_log (log_usuario,log_descripcion,log_ip,log_fecha) VALUES('$usuario','Inicio de sesión','$ip','$ultimo_ingreso') ;"; //Actualizar el ultimo ingreso de la persona                 
						            	$resultado = $this->conexion -> query($consulta);
						            	if($resultado){	
						            		// $_SESSION["kiosco_actividad"] = time();
											return "OK";
										}
										else{
											return $this->conexion->error;
										}
									}
									else{
										return $this->conexion->error;
									}
								}
								else{
									return "La contraseña es incorrecta, verifique.";
								}
							}
							else{
								return "Este usuario está dado de baja.";
							}
						}
						else{
							return "El usuario que está ingresando no existe, verifique por favor.";
						}
				}
				else{
					return "El campo contraseña es un campo obligatorio.";
				}
			}
			else{
				return "El campo usuario es un campo obligatorio.";
			}
		}
	}
?>