<?php
include_once("../db/conectadb.php");
include_once("../model/sesion.php");
include_once("../model/usuarios.php");
include_once("../model/clientes.php");
include_once("model/permisos.php");
include_once("model/vacantes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varPermisos = new permisos();
        $this->varVacantes = new vacantes();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
		if(isset($datosUsuario["idUsuario"])){
			$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$permisosVacantes = $this->varPermisos->listar("Vacantes", $datosUsuario["idUsuario"]);
		}

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case 'index':
					if (isset($_POST["clientes"])) {
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => $cliente);}, $_POST["clientes"]);
					}
					else{
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => base64_encode($cliente["idclientes"]));}, $clientes);
					}
					$hoy = date("Y-m-d H:i:s");
					$fecha = new DateTime($hoy);
					$dia = $fecha->format("Y-m-d");
					$semana = $fecha->format("W");
					$mes = $fecha->format("m");
					$año = $fecha->format("Y");
					$tmp = "Semana $semana";
					$txtBoton =  "Semanal";
					$calculado = $fecha->format("d-m-Y H:i");
					$ejeX = array("1" => "Domingo", "2" => "Lunes", "3" => "Martes", "4" => "Miércoles", "5" => "Jueves", "6" => "Viernes", "7" => "Sábado");
					if(isset($_POST["g"])){
						switch ($_POST["g"]) {
							case 'Diario':
								$tmp = $fecha->format("d-m-Y");
								$txtBoton = "Diario"; 
								$ejeX = array("1" => $tmp);
								$vacantes = $this->varVacantes->listarMovimientosDia($tmpClientes, $dia); //
								break;

							case 'Semanal':
								$txtBoton = "Semanal";
								$vacantes = $this->varVacantes->listarMovimientosSemana($tmpClientes, $semana);
								break;

							case 'Mensual':
								$tmp = "Mes $mes";
								$txtBoton = "Mensual";
								$dias = cal_days_in_month(CAL_GREGORIAN,$mes,$año);
								$ejeX = array();
								for($i = 1; $i <= $dias; $i++) { 
									$ejeX[$i] = str_pad($i, 2, "0", STR_PAD_LEFT) ;
								}
								$vacantes = $this->varVacantes->listarMovimientosMes($tmpClientes, $mes);
								break;

							case 'Anual':
								$tmp = "Año $año";
								$txtBoton = "Anual";
								$ejeX = array("1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
								$vacantes = $this->varVacantes->listarMovimientosAño($tmpClientes, $año);
								break;

							default:
								$vacantes = $this->varVacantes->listarMovimientosSemana($tmpClientes, $semana);
								break;
						}
					}
					else{
						$vacantes = $this->varVacantes->listarMovimientosSemana($tmpClientes, $semana);
					}
			    	include_once("view/index.php");
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