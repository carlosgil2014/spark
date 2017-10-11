<?php

//$basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
//include_once($basedir.'/../db/conectadb.php');

// error_reporting(0);

if(!isset($_GET["accion"])){
	// header("location: ../view/contrasenias/index.php?accion=index");
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
						$empleadosBaja = $this->varEmpleados->listarEmpleados("0");

						// $datosEmpleado = $this->varEmpleados->datosEmpleado($_GET["idEmpleado"]);
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$_SESSION["spar_error"] = "Operación realizada correctamente!.";
							$clase = "success";
						}else{
							$clase = "error";
						}


						include_once("principal.php");
		
						if(isset($_SESSION["spar_error"])){
							unset($_SESSION["spar_error"]);
						}


						break;

					case 'consultar':

						$empleados=$this->varEmpleados->listarEmpleadosVigentes();
						
						
						include_once("agregar.php");
						
						break;


					case 'editar':

						include_once("editar.php");
						
											
						break;

					case 'agregar':

						$datos=$this->varEmpleados->agregarEmpleado($_POST['datos']);
						$_SESSION['spar_error']=$datos;

						header("Location: index.php?accion=index");		
						
						break;	
					
					case 'actualizar':

						
						$datos=$this->varEmpleados->actualizarEmpleado($_POST['datos']);

						$_SESSION['spar_error']=$datos;
						
						header("Location: index.php?accion=index");
						
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