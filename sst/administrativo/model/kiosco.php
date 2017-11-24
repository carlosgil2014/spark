<?php 
require_once('../../db/conectadb.php');
require_once('../phpMailer/PHPMailerAutoload.php');
	
class kiosco{

	protected $acceso;
		protected $conexion;

	public function __construct(){
		$this->acceso = new accesoDB(); 
		 	$this->conexion = $this->acceso->conDB();
		}	

		function listar(){
			$datos = array();
			$consulta="SELECT empleados_rfc FROM spartodo_spar_bd.spar_empleados";
		// echo $consulta;
		$resultado = $this->conexion->query($consulta);
		
		while ($filaTmp = $resultado->fetch_assoc()) {
			$datos [] = $filaTmp["empleados_rfc"];
		}
		
		if($resultado){
			return $datos;
		}
			elseif (!$this->conexion->query($consulta)) {
   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}

		function buscar($rfc){
			//$datos=array();

			$rfc=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($rfc))));
			
			if($rfc!=""){
			   
			   $consulta = "SELECT *,CONCAT(empleados_nombres,' ',empleados_apellido_paterno,' ',empleados_apellido_materno)nombres FROM spartodo_spar_bd.spar_empleados WHERE empleados_rfc='$rfc'";
					
				$resultado = $this->conexion->query($consulta);
					
					if($resultado){
					
						$datos = $resultado->fetch_assoc();

						if($datos["empleados_empresa"]=="admon"){
							$datos["empleados_empresa"]="administrativa";
						}
					
						return $datos;
					}	

			}else{
				$_SESSION["spar_error"] = "Por favor intruduzca RFC";
			}

			
			
		}


		function actualizar($num_empleado,$rfc,$correo){
		
			$num_empleado=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($num_empleado))));
			$rfc=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim(strtoupper($rfc)))));
			$correo=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($correo))));
			$pass = sha1($rfc);
			
			//$datos = array();
			
			$consulta="UPDATE spartodo_spar_bd.spar_empleados SET empleados_contrasena ='$pass' WHERE empleados_numero_empleado = $num_empleado";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				//ENVIAR EL CORREO
		            		
		            		$mail = new PHPMailer;

							$mail->IsSMTP();                                      // Set mailer to use SMTP
							$mail->Host = 'spar-todopromo.mx';                 // Specify main and backup server
							$mail->Port = 26;                                    // Set the SMTP port
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = 'kiosco@spar-todopromo.mx';                // SMTP username
							$mail->Password = 'ST0SP4R15';                  // SMTP password
							$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
							$mail->CharSet = 'UTF-8';

							$mail->From = 'kiosco@spar-todopromo.mx';
							$mail->FromName = 'Kiosco Spar';
							$mail->AddAddress($correo);               // Name is optional

							$mail->IsHTML(true);                                  // Set email format to HTML

							$mail->Subject = 'Recuperación de contraseña';
							$mail->AddEmbeddedImage("../img/st.png", "logo", "Logo");
							$estilo = "<style type='text/css'>
											.form-style-9{
											max-width: 450px;
											background: #FAFAFA;
											padding: 30px;
											margin: 50px auto;
											box-shadow: 1px 1px 25px rgba(0, 0, 0, 0.35);
											border-radius: 10px;
											border: 6px solid #305A72;
											}
											.label{
												font-family: Arial, Helvetica, sans-serif;
											}
										</style> ";
							$cuerpo = "<div class='form-style-9'>
										<img src='cid:logo'><br/>
										<label class='label'>Su nueva contraseña es:  <strong>".$rfc."</strong></label><br/>
									</div> ";
							$mail->Body = $estilo.$cuerpo;

							

							if($mail->Send()) {
							   return "OK";
							}else{
							   echo 'El correo no se pudo enviar.';
							   echo 'Error: ' . $mail->ErrorInfo;
							   exit;
							}
							

			}
			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}


		}


}



?>