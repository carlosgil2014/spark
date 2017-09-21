<?php
include_once('../db/conectadb.php');
include_once('../model/sesion.php');
class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
    } 
	

	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_GET['accion'])){
			
			switch ($_GET['accion']) 
			{

			    case 'login':

			    	require_once('../model/validar.php');

					$valida = new validar();

					if(empty($_SESSION['spar_usuario'])){
						$resultado = $valida->validaEmpleado($_POST['usuario'],$_POST['contrasena']);
						if($resultado === "OK"){
							header('Location:index.php?accion=login');
						}
						else{
							$_SESSION["spar_error"] = $resultado;
							header('Location:../index.php');
						}
					}
					elseif(!empty($_SESSION['spar_usuario']))
					{
						require_once("../model/usuarios.php");
						$varUsuario = new usuarios();
						$datosUsuario = $varUsuario -> datosUsuario($_SESSION["spar_usuario"]);
						require_once("principal.php");
						unset($_SESSION["spar_error"]);
					}

			        break;

			    case 'logout':
			    	require_once('../model/logout.php');
					$log = new logout();
					$resultadoLog = $log->salir();
					if($resultadoLog == true)
						header('Location:../');
					else
						header('Location: '. $_SERVER['HTTP_REFERER']); //Regresa a la pagina anterior
			        break;

			    case 'perfil':
			    	require_once('../model/usuarios.php');
					$varUsuario = new usuarios();
					$datosUsuario = $varUsuario -> datosUsuario($_SESSION["spar_usuario"]);
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] == "OK"){
						$_SESSION["spar_error"] = "Se modificó correctamente el perfil";
						$clase = "success";
					}
					else{
						$clase = "danger";
					}
					include_once("usuarios/perfil.php");
					unset($_SESSION["spar_error"]);
					break;

				case 'actualizarPerfil':
			    	require_once('../model/usuarios.php');
					$varUsuario = new usuarios();
					$resultado = $varUsuario -> actualizarPerfil($_POST["idUsuario"], $_POST["usuario"],$_SESSION["spar_usuario"],$_FILES["foto"]["tmp_name"]);
					$_SESSION["spar_error"] = $resultado;
					header("Location: index.php?accion=perfil");

			        break;

			    case 'actualizarContrasena':
			    	require_once('../model/usuarios.php');
					$varUsuario = new usuarios();
					$resultado = $varUsuario -> actualizarContraseña($_POST["idUsuario"], $_SESSION["spar_usuario"],$_POST["contrasenaActual"], $_POST["contrasenaNueva"], $_POST["contrasenaNueva1"]);
					$_SESSION["spar_error"] = $resultado;
					header("Location: index.php?accion=perfil");

			        break;

			    default:
					require_once('index.php');		
					break;	
			}
		}
		else{	
			header('Location:../');
		}
	}
}

?>