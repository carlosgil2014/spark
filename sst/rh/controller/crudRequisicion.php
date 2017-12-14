<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/requisicion.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varRequisicion = new requisicion();

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
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
						include_once("../../model/salarios.php");
						$varSalarios = new salarios();
						$clientes = $varSalarios->listarClientes();
						include_once("alta.php");
					break;

				case "modificar":
					include_once("../../../administrativo/model/representantes.php");
					$varRepresentantes = new representantes();
					$puestos = $varRepresentantes->listarPuestos();
					$salario = $this->varRequisicion->informacion($_GET["id"]);
					var_dump($salario);
					if(empty($salario))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;

				case "guardar":
						$resultado = $this->varSalarios -> guardar($_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se agregó el salario correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "actualizar":
						$id = $_GET["id"];
						$resultado = $this->varSalarios->actualizar($id,$_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se modificó los datos correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "eliminar":
						$idRepresentante = $_POST["idRepresentante"];
						$resultado = $this->varRepresentantes -> eliminar($idRepresentante);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente el salario.";
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