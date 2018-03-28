<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once('../../model/celular.php');


class Controller {

	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->celular = new CelularModel();
        

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
					$celular = $this->celular->listar();
					$marcas = $this->celular->listarMarcas();
					require_once('../../../model/almacenes.php');
					$varAlmacen = new almacen();
					$almacenes = $varAlmacen->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Registro guardado correctamente.";
						header("Location: index.php?accion=index");
					}
					break;
				case "modificar":
					$id_celular = $_POST["id"];
					require_once('../../../model/almacenes.php');
					$varAlmacen = new almacen();
					$almacenes = $varAlmacen->listar();
					$IdCelularAsignaciones = $this->celular->informacion($id_celular);					
					$resultado = $this->celular->informacion($id_celular);
					$marcas = $this->celular->listarMarcas();
					$modelos = $this->celular->listarModelos($resultado["idMarca"]);
					include_once("modificar.php");
					break;
				case "guardar":
						$model = $_POST['modelo'];
						$imei = $_POST['imei'];
						$tipo = $_POST['tipo'];
						$usuario = $_POST['usuario'];
						$resultado = $this->celular->guardar($model,$imei,$tipo,$usuario);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se agregó el celular correctamente.";
						}else
						$clase = "danger";
						echo $resultado;
						header("Location: index.php?accion=index&clase=".$clase);
						break;
				case "actualizar":
						$id_celular = $_GET['id'];
						$idAlmacenHistorial = $_POST['idAlmacenHistorial'];
						$idEstado = $_POST['idEstado'];
						$model = $_POST['modelo'];
						$imei = $_POST['imei'];
						$tipo = $_POST['tipo'];
						$usuario = $_POST['usuario'];
						$estado = $_POST['estado'];
						// crear metodo que obtiene el ultimo id de celular aignaciones para insertar en la tabal de asignaciones
						$utlimoIdAsignaciones= $this->celular->seleccionarIdUltimoCelular($id_celular);
						$resultado = $this->celular->actualizar($id_celular,$model,$imei,$tipo,$usuario,$estado,$idAlmacenHistorial,$idEstado,$utlimoIdAsignaciones);
						echo $resultado;
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se modificó los datos correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;
				case "historial":
					echo $_POST["id"];
					$movimientos = $this->celular->historial($_POST["id"]);
					if(empty($movimientos)){
						include_once("historial.php");
						echo "No existen movimientos con ese SIM";
					}
					else{
						include_once("historial.php");
					}
					break;
				case "eliminar":
						$id_celular = $_POST["id"];
						$resultado = $this->celular->eliminar($id_celular);
						echo $resultado;
					$_SESSION["spar_error"] = "Registro eliminado correctamente.";
					break;
				case "listarmodelos":
						$idMarca = $GET["marca"];
						$listarModelo = $this->celular->listarModelos($idMarca);
				break;
				case "buscarLinea":
					$listarModelo = $this->celular->buscarLinea($_GET['sim']);
					if( !empty($listarModelo) ){
						echo json_encode($listarModelo);
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