<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/almacenes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varAlmacen = new almacen();

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
					$almacenes = $this->varAlmacen->listar();
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Almacen guardado correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					include_once("alta.php");
					break;
				case "modificar":
					$almacen = $this->varAlmacen->informacion($_GET["id"]);
					if(empty($almacen))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "guardar":
						$almacen = $_POST["almacen"];
						$tipo = $_POST["tipo"];
						$resultado = $this->varAlmacen->guardar($almacen,$tipo);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");

					break;

				case "actualizar":
						$id = $_GET["id"];
						$almacen = $_POST["almacen"];
						$tipo = $_POST["tipo"];
						$resultado = $this->varAlmacen->actualizar($id,$almacen,$tipo);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");
					break;
				
				case "eliminar":
						$id = $_POST["id"];
						$resultado = $this->varAlmacen->eliminar($id);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente el almacén.";
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