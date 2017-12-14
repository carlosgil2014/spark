<?php 
	class sesion{

		public function ultimaActividad(){
			session_start();
			/* Establecemos que las paginas no pueden ser cacheadas */
			header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
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