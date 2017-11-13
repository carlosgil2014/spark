<?php
include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/mensajeria.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varMensajeria = new mensajeria();

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
					$mensajerias = $this->varMensajeria->listar();
					
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Operación realizada correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					

					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case 'alta':
						
					include_once("alta.php");
					break;	

				case 'guardar':

					//echo $_POST['mensajeria'];
					
					$datos=$this->varMensajeria->guardar($_POST['mensajeria']);	

				
					echo $datos;
					$_SESSION['spar_error']=$datos;

					header("Location: index.php?accion=index");
				
					break;

				case 'modificar':

					include_once("modificar.php");
					
					break;

				case 'actualizar':


					$datos=$this->varMensajeria->actualizar($_POST['mensajeria']);	

					$_SESSION['spar_error']=$datos;

					header("Location: index.php?accion=index");	

					break;											
				
				case 'eliminar':
					
					$resultado=$this->varMensajeria->eliminar($_POST['idMensajeria']);
					echo $resultado;
						$_SESSION["spar_error"] = "Registro eliminado correctamente.";

					break;		

				default:
					header("Location: index.php?accion=index");
					break;
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>