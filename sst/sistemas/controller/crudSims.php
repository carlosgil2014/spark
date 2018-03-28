<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/almacenes.php");
include_once("../../model/sims.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varSims = new sims();
        $this->varAlmacen = new almacen();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					$sims = $this->varSims->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					$almacenes = $this->varAlmacen->listar();
					include_once("alta.php");
					break;

				case "agregar":
					$almacenes = $this->varAlmacen->listar();
					include_once("agregar.php");
					break;

				case "modificar":
					$clase = "success";
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "SIM actualizada correctamente.";
					}
					else{
						$clase = "danger";
					}
					$sim = $this->varSims->informacion($_GET["idSim"]);
					$almacenes = $this->varAlmacen->listar();
					$movimientos = $this->varSims->historial($_GET["idSim"]);
					if(empty($sim)){
						echo "No existen datos con ese SIM";
					}
					else{
						include_once("modificar.php");
					}
					unset($_SESSION["spar_error"]);
					break;
				case "guardar":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varSims->guardar($_POST["icc"],$_POST["almacen"],$_POST["tipo"],$datosUsuario["idUsuario"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "actualizar":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varSims->actualizar($_POST["idSim"], $_POST["icc"], $_POST["almacen"], $_POST["tipo"], $_POST["estado"], $datosUsuario["idUsuario"]);
						$_SESSION["spar_error"] = $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;
				
				case "eliminar":
						$id = $_POST["id"];
						$resultado = $this->varSims->eliminar($id);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente el salario.";
					break;

				case "buscarICC":
						$idLinea = $_GET["idLinea"];
						$datosLinea = $this->varSims->buscarICC($idLinea);
						// var_dump($datosLinea);
						if( !empty($datosLinea) ){
							echo json_encode($datosLinea);
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