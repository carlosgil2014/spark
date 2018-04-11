<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/puestos.php");
include_once("../../../model/clientes.php");
include_once("../../model/conocimientos.php");
include_once("../../model/habilidades.php");
include_once("../../model/perfiles.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varPerfil = new perfiles();
		$this->varConocimientos = new conocimientos();
		$this->varPuestos = new puestos();
		$this->varClientes = new clientes();
		$this->varHabilidades = new habilidades();
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
					$perfiles = $this->varPerfil->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
					$conocimientos = $this->varConocimientos->listar();
					$puestos = $this->varPuestos->listar();
					$clientes = $this->varClientes->listar();
					$habilidades = $this->varHabilidades->listar();
					$perfiles = $this->varPerfil->listarEscolaridad();
					include_once("alta.php");
					break;
				case "modificar":
					$conocimientos = $this->varConocimientos->listar();
					$puestos = $this->varPuestos->listar();
					$clientes = $this->varClientes->listar();
					$habilidades = $this->varHabilidades->listar();
					$escolaridades = $this->varPerfil->listarEscolaridad();
					$perfil = $this->varPerfil->informacion($_GET["id"]);
					if(empty($perfil)){
						header("Location: index.php?accion=index");
					}
					else{
						include_once("modificar.php");
					}
					break;

				case "guardar":
					$resultado = $this->varPerfil -> guardar($_POST["Datos"],$_POST["conocimientos"],$_POST["imagen"],$_POST["habilidades"],$_POST["evaluaciones"],$datosUsuario["idEmpleado"],$_POST["paquetesLenguajes"],$_POST["diasTrabajados"],$_POST["horariosEntrada"],$_POST["horariosSalida"]);
					echo $resultado;
					$_SESSION["spar_error"] = "Se agregó el perfil correctamente.";
					break;

				case "actualizar":
					$resultado = $this->varPerfil->actualizar($_POST["Datos"],$_POST["conocimientos"],$_POST["imagen"],$_POST["habilidades"],$_POST["evaluaciones"],$datosUsuario["idEmpleado"],$_POST["paquetesLenguajes"],$_POST["diasTrabajados"],$_POST["horariosEntrada"],$_POST["horariosSalida"]);
					if($resultado == "OK") {
						$_SESSION["spar_error"] = "Se modificó el perfil correctamente.";	
					}else{
						$_SESSION["spar_error"] = $resultado;
					}
					echo $resultado;
					break;

				case "eliminar":
					$id = $_POST["id"];
					$resultado = $this->varPerfil -> eliminar($id);
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
						}
					echo $resultado;
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