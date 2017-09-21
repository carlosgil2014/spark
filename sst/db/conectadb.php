<?php 
	class accesoDB
	{
		
	//Conecta la base principal de la base de datos llamada bdSpar
	    function conDB()
		{
			$servidor = "localhost";
			$usuario = "root";
			$contrasena = "ST0SP4R15";
			$bd = "spartodo_spar_bd";
			$conexion = new mysqli($servidor,$usuario,$contrasena,$bd)or die("Problemas con el servidor de BD. ");
    		$conexion -> set_charset("utf8");
			return $conexion;
		}
	}
?>