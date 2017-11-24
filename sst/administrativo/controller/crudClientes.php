<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();

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
					$clientes = $this->varCliente->listar();

					include_once("principal.php");
					unset($_SESSION["spar_error"]);
					break;

				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Registro guardado correctamente.";
						header("Location: index.php?accion=index");
					}
					else{
						$clase = "danger";
					
						require_once("../../model/paises.php");
						$varPais = new paises();
						$paises = $varPais->listar();

						require_once("../../model/estados.php");
						$varEstado = new estados();
						$estados = $varEstado->listar("México");

						include_once("alta.php");
						unset($_SESSION["spar_error"]);
					}
					break;

				case "modificar":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Registro actualizado correctamente.";
						header("Location: index.php?accion=index");
					}
					else{
						$clase = "danger";
					
						require_once("../../model/paises.php");
						$varPais = new paises();
						$paises = $varPais->listar();

						require_once("../../model/representantes.php");
						$varRepresentantes = new representantes();
						$codigoPostal = $varRepresentantes->buscar($_GET["cp"]);
						$cliente = $this->varCliente->informacion($_GET["idCliente"]);

						if(is_array($cliente)){
							include_once("modificar.php");
							unset($_SESSION["spar_error"]);
						}
						else{
							// header("Location: index.php?accion=index");
						}
					}

					break;

				case "guardar":
						$resultado = $this->varCliente -> guardar($_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=alta");
					break;

				case "actualizar":
						$idCliente = $_GET["idCliente"];
						var_dump($_POST["Datos"]);
						$resultado = $this->varCliente -> actualizar($idCliente,$_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=modificar&idCliente=$idCliente");
					break;

				case "eliminar":
						$idCliente = $_POST["idCliente"];
						$resultado = $this->varCliente -> eliminar($idCliente);
						echo $resultado;
						$_SESSION["spar_error"] = "Registro eliminado correctamente.";

					break;
				case "buscarRfc":
						$validarRfc = $this->varCliente -> rfc($_GET["rfc"]);
						if( !empty($validarRfc) ){
							echo json_encode($validarRfc);
						}else{
							echo 'error';
						}
							
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