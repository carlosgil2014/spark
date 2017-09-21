<?php

//$basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
//include_once($basedir.'/../db/conectadb.php');

error_reporting(0);

if(!isset($_GET["accion"])){
	header("location: ../view/contrasenias/index.php?accion=index");
}


include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/usuariosContrasenias.php");

class controller{

	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varEmpleados = new empleados();
        
    } 

	public function principal(){

		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"])){

				switch ($_GET["accion"]) {
				
					case 'index':
						
						
						$empleados = $this->varEmpleados->listarEmpleados("1");
						//$datosEmpleado = $this->varEmpleados->datosEmpleado($_GET["idEmpleado"]);
						include_once("principal.php");

						break;

					case 'editar':

						include_once("editar.php");

						break;
					
					default:
						header("location: index.php?accion=index");
						break;
				}

			
		}else{

			header("location: index.php?accion=index");
		}
	}

}


?>