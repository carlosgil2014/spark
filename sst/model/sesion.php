<?php 
	class sesion{

		public function ultimaActividad(){
			session_start();
			// if (isset($_SESSION['kiosco_actividad']) && (time() - $_SESSION['kiosco_actividad'] > 300)) {
   //  			// 30 minutos
			// 	unset($_SESSION["kiosco_usu"]);
			// 	unset($_SESSION["kiosco_error"]);
			// 	unset($_SESSION["kiosco_actividad"]);
			// 	echo "<script type='text/javascript'>
			// 		alert('Expiró tu sesión, inicia nuevamente.');
			// 		location.reload();
			// 	</script>";
			// }
			// $_SESSION['kiosco_actividad'] = time();
		}	

	}
?>