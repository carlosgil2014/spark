<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/clientes.php"); //Funciones de usuarios del módulo compras
include_once("../../model/unidades.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varClienteCompras = new clientesCompras();
        $this->varUnidad = new unidades();

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
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Banco guardado correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
					$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
					include_once("alta.php");
					break;

				case "rubrosCliente":
					$rubros = $this->varClienteCompras->rubrosCliente($_GET["idCliente"]);
					$unidades = $this->varUnidad->listar();
					include_once("rubrosCliente.php");
					break;

				case "modificar":
					$banco = $this->varBanco->informacion($_GET["idBanco"]);
					if(empty($banco))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "guardar":
						$banco = $_POST["banco"];
						$resultado = $this->varBanco->guardar($banco);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");

					break;

				case "actualizar":
						$idBanco = $_GET["idBanco"];
						$banco = $_POST["banco"];
						$resultado = $this->varBanco->actualizar($idBanco,$banco);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");
					break;
				case "eliminar":
						$idBanco = $_POST["idBanco"];
						$resultado = $this->varBanco->eliminar($idBanco);
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