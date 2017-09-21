<?php 
	class logout{

		public function salir(){
			unset($_SESSION["spar_usuario"]);
			unset($_SESSION["spar_error"]);
			return true;
		}	

	}
?>