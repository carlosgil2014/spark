<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/asignaciones.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varAsignaciones = new asignaciones();

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
					$asignaciones = $this->varAsignaciones->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					require_once("../../model/celular.php");
					$varCelular = new CelularModel();
					$imeis = $varCelular->listarImeis();
					require_once("../../../model/estados.php");
					$varEstsdos = new estados();
					$estados = $varEstsdos->listar();
					require_once("../../model/lineas.php");
					$varLineas = new lineas();
					$lineas = $varLineas->listarLineas();
					$administrativos = $this->varAsignaciones->listarAdmon();
					$cuentas = $this->varAsignaciones->listarCuentas();
					include_once("alta.php");
					break;
				case "altaPorClientes":
					require_once("../../../model/estados.php");
					$varEstsdos = new estados();
					$estados = $varEstsdos->listar();
					require_once("../../model/celular.php");
					$varCelular = new CelularModel();
					$imeis = $varCelular->listarImeis();
					require_once("../../../model/cuentas.php");
					$varCuentas = new cuentas();
					$cuentas = $varCuentas->listar();
					require_once("../../../model/estados.php");
					$varEstsdos = new estados();
					$estados = $varEstsdos->listar();
					require_once("../../model/lineas.php");
					$varLineas = new lineas();
					$lineas = $varLineas->listarLineas();
					$administrativos = $this->varAsignaciones->listarAdmon();
					$cuentas = $this->varAsignaciones->listarCuentas();
					include_once("altaPorCliente.php");
					break;
				case "modificar":
					require_once("../../../model/estados.php");
					$varEstsdos = new estados();
					$estados = $varEstsdos->listar();
					require_once("../../model/celular.php");
					$varCelular = new CelularModel();
					$imeis = $varCelular->listarImeis();
					require_once("../../model/lineas.php");
					$varLineas = new lineas();
					$lineas = $varLineas->listarLineas();
					require_once("../../../model/cuentas.php");
					$varCuentas = new cuentas();
					$cuentas = $varCuentas->listar();
					$asignaciones = $this->varAsignaciones->informacion($_GET["id"]);
					$administrativos = $this->varAsignaciones->listarAdmon();
					if(empty($asignaciones))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "historial":
					$movimientos = $this->varAsignaciones->historial($_POST["id"]);
					if(empty($movimientos)){
						include_once("historial.php");
						echo "No existen movimientos con ese asignaciones";
					}
					else{
						include_once("historial.php");
					}
					break;
				case "guardar":
						$idEstado = $_POST["idEstado"];
						$linea = $_POST["linea"];
						$responsable = $_POST['responsable'];
						$imei = $_POST['imei'];
						$cuenta = $_POST['cuenta'];
						$resultado = $this->varAsignaciones->guardar($linea,$responsable,$imei,$cuenta,$idEstado);
						echo $resultado;
					break;
				case "guardar2":
						$linea = $_POST["linea"];
						$responsable = $_POST['responsable'];
						$imei = $_POST['imei'];
						$cuenta = $_POST['cuenta'];
						$idEstado = $_POST['idEstado'];
						$resultado = $this->varAsignaciones->guardar($linea,$responsable,$imei,$cuenta,$idEstado);
						echo $resultado;
						 $_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se asigno correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;
				case "actualizar":
						$usuario = $_POST['usuario'];
						$icc = $_POST['icc'];
						$compararIdEstado = $_POST['compararIdEstado'];
						$idEstado = $_POST['idEstado'];
						$compararLinea = $_POST['compararLinea'];
						$compararImei = $_POST['compararImei'];
						$compararResponsable = $_POST['compararResponsable'];
						$compararCuenta = $_POST['compararCuenta'];
						$compararEstado = $_POST['compararEstado'];
						$id= $_GET['id'];
						$linea = $_POST["linea"];
						$responsable = $_POST['responsable'];
						$imei = $_POST['imei'];
						$cuenta = $_POST['cuenta'];
						$estado = $_POST['estado'];
						$resultado = $this->varAsignaciones->actualizar($compararLinea,$compararImei,$compararResponsable,$compararCuenta,$compararEstado,$id,$linea,$responsable,$imei,$cuenta,$estado,$idEstado,$compararIdEstado,$usuario,$compararIdICC);
						echo $resultado;
						 $_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se modifico correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;
				
				case "eliminar":
						$id = $_POST["id"];
						$resultado = $this->varAsignaciones->eliminar($id);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
							//echo $resultado;
						}
					break;
					case "buscarImei":
						$imei = $this->varAsignaciones -> buscarImei($_GET["imei"]);
						if( !empty($imei) ){
							echo json_encode($imei);
						}else{
							echo 'error';
						}						
					break;
					case "buscarLinea":
						$datosLinea = $this->varAsignaciones -> buscarLinea($_GET["linea"]);
						if( !empty($datosLinea) ){
							echo json_encode($datosLinea);
						}else{
							echo 'error';
						}						
					break;
					case "buscarRfc":
						$datosRfc = $this->varAsignaciones -> buscarRfc($_GET["rfc"]);
						if( !empty($datosRfc) ){
							echo json_encode($datosRfc);
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