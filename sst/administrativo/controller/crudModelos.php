<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/modelos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varModelos = new modelos();

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
					$modelos=$this->varModelos->listar();
					include_once("principal.php");
					unset($_SESSION["spar_error"]);
					break;
				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
					// $clase = "success";
					$_SESSION["spar_error"] = "Registro guardado correctamente.";
					//header("Location: index.php?accion=index");
					}
					else
					$clase = "danger";
					require_once("../../model/marcas.php");
					$varMarcas = new Marcas();
					$marcas = $varMarcas->listar();
					include_once("alta.php");
					// unset($_SESSION["spar_error"]);
					break;
				case "modificar":
					require_once("../../model/marcas.php");
					$varMarcas = new Marcas();
					$marcas = $varMarcas->listar();
					$Modelo = $this->varModelos->informacion($_GET["idModelo"]);
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						 $clase = "success";
						$_SESSION["spar_error"] = "Registro actualizado correctamente.";
						header("Location: ../categorias/index.php?accion=index&activo=5");
					}
					else
						$clase = "danger";
					include_once("modificar.php");
					//unset($_SESSION["spar_error"]);
					break;

		//caso para guardar nueva informacion
				case "guardar":
						$Modelo = $_POST["Modelo"];
						$idMarca = $_POST["idMarca"];
						$resultado = $this->varModelos->guardar($Modelo,$idMarca);
						$_SESSION["spar_error"] = $resultado;
						// echo $_SESSION["spar_error"];
						header("Location: ../categorias/index.php?accion=index&activo=5");
		           break;

		//caso para actualizar la informacion
				case "actualizar":
					// {
						$idModelo = $_POST["idModelo"];
						$Modelo = $_POST["modelo"];
						$idMarca = $_POST["idMarca"];
						$resultado = $this->varModelos->actualizar($idModelo,$Modelo,$idMarca);

						$_SESSION["spar_error"] = $resultado;
						 //echo $_SESSION["spar_error"];
						header("Location: ../categorias/index.php?accion=index&activo=5");
					break;

		//caso para eliminar la informacion
				case "eliminar":
						$idModelo = $_POST["idModelo"];
						$resultado = $this->varModelos->eliminar($idModelo);
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