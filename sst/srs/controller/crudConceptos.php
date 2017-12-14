<?php
// $basedir = realpath(__DIR__);
include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/conceptos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
		$this->varConcepto = new conceptos();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"])){
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
			$permisos = array("cotizaciones" => 1, "ordenes" => 2, "prefacturas" => 3, "reportes" => 4, "estadodecuenta" => 5, "conceptos" => 6);
			$datosClientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$idClientes = array();
			foreach($datosClientes as $cliente){$idClientes[] = $cliente["idclientes"];}
			if(isset($_GET["accion"]))
			{
				switch($_GET["accion"])
				{
					case 'listarConceptos':
					    require_once('../model/conceptos.php');
				    	require_once("../model/clientes.php");
						session_start();
					    $conceptos = new conceptos();
						$clientes = new clientes();	
						$usuario = $_SESSION["srs_usuario"];
						$datos = $clientes -> listarClientes($usuario);	
						$datosConcepto = $conceptos -> listarConceptos($usuario);	
						if(is_array($datos) && is_array($datosConcepto)){
							include_once('../view/conceptos/index.php');
						}
						else
							header('location:../view/index.php');
				        break;

					case 'cargarConceptos':
						if(isset($_POST["idCliente"]) && isset($_POST["tipoServicio"])){
						    $datos = $this->varConcepto -> cargarConceptos($_POST["idCliente"],$_POST["tipoServicio"]);
							if(is_array($datos)){
								include_once('cargarconcepto.php');
							}
						}	
				        break;

				    case 'guardarConcepto':
					    require_once('../model/conceptos.php');
						session_start();
					    $conceptos = new conceptos();	
						$usuario = $_SESSION["srs_usuario"];
					    $continuar = $conceptos->existeConcepto($_POST["nombre"],$usuario);
						if($continuar){	
							header('Location:crudConceptos.php?accion=listarConceptos&error=1');
						}
						else{
							$continuar = $conceptos->almacenarConcepto($_POST["nombre"],$_POST["categoria"],$_POST["precioConcepto"],$_POST["Datos"]["idCliente"]);
							if($continuar)
								header('Location:crudConceptos.php?accion=listarConceptos&error=0');
							else
								echo $continuar;
						}	
				        break;
				        
				    case 'preciosFijos':
						$precioFijo = $this->varConcepto->preciosFijos($_POST["concepto"]);
						echo $precioFijo["precio"];
						break;

					case 'modalClientes':
					    require_once("../model/conceptos.php");
					    require_once("../model/clientes.php");
					    session_start();
						$conceptos = new conceptos();
						$clientes = new clientes();
						$datosConcepto = $conceptos->datosConcepto($_POST["idConcepto"]);
						$usuario = $_SESSION["srs_usuario"];
						$datosCliente = $clientes -> listarClientes($usuario);	
						
						if(is_array($datosConcepto) && is_array($datosCliente))
						{
							foreach ($datosCliente as $cliente) {
								$clienteRelacionado[] = $conceptos->conceptoCliente($cliente["idclientes"],$_POST["idConcepto"]);
							}
							include_once("../view/conceptos/modalclientes.php");
						}
						else 
							echo $datosConcepto;
						break;

					case 'guardarRelacion':
					    require_once("../model/conceptos.php");
					    $conceptos = new conceptos();
						$clientes = $_POST['clientes'];
						$estados = $_POST['estados'];
						$concepto = $_POST['id'];
						$nombre = $_POST['nombre'];
						$precio = $_POST['precio'];
						$categoria = $_POST['categoria'];
						$i = 0;
						foreach ($clientes as $cliente) {
							$existe = $conceptos->existeRelacionConcepto($cliente,$concepto);
							if($existe){
								$conceptos->actualizaRelacionConcepto($cliente,$concepto,$estados[$i]);
							}
							else{
								$conceptos->almacenarRelacionConcepto($cliente,$concepto,$nombre,$categoria,$precio,$estados[$i]);
							}
							$i++;
						}
						break;

					case 'actualizarNombre':
					    require_once("../model/conceptos.php");
					    session_start();
					    $conceptos = new conceptos();
						$idConcepto = $_POST['pk'];
						$nombre = $_POST['value'];
						$usuario = $_SESSION["srs_usuario"];
						$continuar = $conceptos->existeConcepto($_POST["value"],$usuario);
						if($continuar){	
								header('HTTP 400 Bad Request', true, 400);
			        			echo "¡Ya existe un concepto con el mismo nombre $nombre!";
						}
						else{
							if(!empty($nombre)){
								$continuar = $conceptos->actualizarNombre($nombre,$idConcepto);
							}
							else{
								header('HTTP 400 Bad Request', true, 400);
			        			echo "¡Este campo no puede estar vacío!";
							}
			        	}
				
						break;

					case 'actualizarPrecio':
					    require_once("../model/conceptos.php");
					    $conceptos = new conceptos();
						$idConcepto = $_POST['pk'];
						$precio = $_POST['value'];
						if(!empty($precio)){
							$continuar = $conceptos->actualizarPrecio($precio,$idConcepto);
						}
						else{
							header('HTTP 400 Bad Request', true, 400);
		        			echo "¡Este campo no puede estar vacío!";
						}
			        	break;

				    default:
							header('location:../view/index.php');
						break;			
				}
			}
			else{
				header("Location: index.php?accion=index");
			}
		}
		else
			header("Location: ../../index.php");
	}
}

?>