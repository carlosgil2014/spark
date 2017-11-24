<?php
//Conecta la base principal de la base de datos llamada bdSpar

$server="localhost";
$usuario="spartodo_sparus";
$contrasena="ST0SP4R15"; 
$bd="spartodo_bdspar";

@$conexion=mysql_connect($server,$usuario,$contrasena) or die ("Problemas con el servidor de BD. ");
@mysql_select_db($bd,$conexion) or die ("Problema al conectar con la BD.");


class conceptos
{
//Conecta la base principal de la base de datos llamada bdSpar

    function conDB()
	{
		$conexion=mysql_connect("localhost","spartodo_sparus","ST0SP4R15")or die("Problemas con el servidor de BD. ");
			mysql_select_db("spartodo_bdspar",$conexion)or die("Problema al conectar con la BD.");
    		mysql_query("set names 'utf8'",$conexion);
		return $conexion;
	}
}
?>