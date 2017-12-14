<?php 
	class logout{
		public function salir(){
			session_start();
			unset($_SESSION['srs_usuario']);
			session_destroy();
			return true;
		}	
	}
?>