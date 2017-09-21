<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../model/sesion.php");
include_once("../../model/usuarios.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					include_once("principal.php");
					require_once('../../model/logout.php');
					$log = new logout();
					$resultadoLog = $log->salir();
					break;

				case 'reingresar':

			    	require_once('../../model/validar.php');

					$valida = new validar();

					if(empty($_SESSION['spar_usuario'])){
						echo "aqui";
						$resultado = $valida->validaEmpleado($_POST['usuario'],$_POST['contrasena']);
						if($resultado === "OK"){
							header('Location: '.$_POST["paginaAnterior"]);
						}
						else{
							$_SESSION["spar_error"] = $resultado;
							header('Location:../index.php');
						}
					}
					
			        break;	

				default:
					header("Location: ../index.php");
					break;
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>