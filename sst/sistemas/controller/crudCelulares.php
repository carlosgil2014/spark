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
					require_once('../../../model/almacenes.php');
					$varAlmacen = new almacen();
					$almacene = $varAlmacen->listar();
					$id_celular = $_POST["id"];					
					$resultado = $this->celular->informacion($id_celular);
					$marcas = $this->celular->listarMarcas();
					$modelos = $this->celular->listarModelos($resultado["marca"]);
					include_once("modificar.php");
					break;
				case "guardar":
						$marca = $_POST['marca'];
						$model = $_POST['modelo'];
						$imei = $_POST['imei'];
						$tipo = $_POST['tipo'];
						$resultado = $this->celular->guardar($marca,$model,$imei,$tipo);
						$_SESSION["spar_error"] = $resultado;
					break;

				case "actualizar":
						$id_celular = $_GET['id']; 
						$marca = $_POST['marca'];
						$model = $_POST['modelo'];
						$imei = $_POST['imei'];
						$tipo = $_POST['tipo'];
						$resultado = $this->celular->actualizar($id_celular,$marca,$model,$imei,$tipo);
						echo $resultado;
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");
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