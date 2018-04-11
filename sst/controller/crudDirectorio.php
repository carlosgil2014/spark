<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
include_once('../../db/conectadb.php');
include_once("../../model/sesion.php");
include_once("../../model/usuarios.php");
include_once("../../model/directorio.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varDirectorio = new directorio();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				//caso para el inicio
				case "index":
					require_once('../../model/proveedores.php');
					require_once('../../model/clientes.php');
					$directorios = $this->varDirectorio->listar();
					//$Representantes = $this->varDirectorio->listarRepresentante();
					$varProveedor = new proveedores();
					$proveedores = $varProveedor->listar();
					$varClientes = new clientes();
					$clientes = $varClientes->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
					unset($_SESSION["spar_error"]);
					break;

				// buscar empleado para agregarlo		
				case "buscarEmpleado":
						$datosEmpleado = $this->varDirectorio->buscarEmpleados();
						if (!is_array($datosEmpleado)) {
							$_SESSION["spar_error"] = $datosEmpleado;
							$_SESSION["spar_error"] = "No hay empleados por agregar";
							header("Location: index.php?accion=index&clase=success");
						}else{
							include_once("buscarEmpleado.php");
						}
					break;

					// buscar empleado para agregarlo		
				case "verProveedor":
					$datosProveedor = $this->varDirectorio->verProveedor($_GET['id']);
					if (empty($datosProveedor)) {
							header("Location: index.php?accion=index");
					}else{
							include_once('verProveedor.php');
					}
					break;
				case "bajasDirectorio":
					$bajas = $this->varDirectorio->bajaDirectorio();
					if (empty($bajas)) {
							include_once('bajasDirectorio.php');
					}else{
							include_once('bajasDirectorio.php');
					}
					break;
					// buscar empleado para agregarlo		
				case "verCliente":
						//require_once('../../model/clientes.php');
						//$varClientes = new clientes();
						$datosClientes = $this->varDirectorio->verCliente($_GET['id']);
						if (empty($datosClientes)) {
							header("Location: index.php?accion=index");
						}else{
							include_once('verCliente.php');
						}
					break;

				case "verDatos";
					$verDatos = $this->varDirectorio->informacion($_GET['id']);
					if (empty($verDatos)) {
						header("Location: index.php?accion=index");
					}else{
						include_once('verDatos.php');
					}
					break;

				//caso para dar de alta una nueva marca de computadora
				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						// $clase = "success";
						$_SESSION["spar_error"] = "Registro guardado correctamente.";
						header("Location: index.php?accion=index");
					}
					else
						$usuarios = $this->varUsuario->informEmpleado($_GET['id']);
						$clase = "danger";
					include_once("alta.php");
					// unset($_SESSION["spar_error"]);
					break;

				//caso para actualizacion de la informacion 			
				case "modificar":
					$idDirectorio = $this->varDirectorio->informacion($_GET["id"]);
					if(empty($idDirectorio))
						header("Location: index.php?accion=index");
					else{
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$_SESSION["spar_error"] = "Registro actualizado correctamente.";
							header("Location: index.php?accion=index");
						}
						else
							$clase = "danger";
						include_once("modificar.php");
					}
					break;
				//caso para guardar nueva informacion
				case "guardar":
						$region = $_GET['region'];
						$resultado = $this->varDirectorio->guardar($_POST['id'],$_POST['telefono'],$_POST['extension'],$_POST['celular'],$_POST['telefonoCasa'],$_POST['telefonoAlterno'],$region);
						$_SESSION["spar_error"] = $resultado;
						if ($resultado == "OK") {
							$clase = "success";
							$_SESSION["spar_error"] = "Se agrego el empleado al directorio telefónico";
							header("Location: index.php?accion=index&clase=success");	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
						}
		           break;

				//caso para actualizar la informacion
				case "actualizar":
						$resultados = $this->varDirectorio->actualizar($_POST["idDirectorio"],$_POST["telefono"],$_POST["extension"],$_POST["celular"],$_POST["telefonoCasa"],$_POST['telefonoAlterno']);
						//$_SESSION["spar_error"] = $resultados;
						// echo $_SESSION["spar_error"];
						if ($resultados == "OK") {
							$_SESSION["spar_error"] = "Se actualizaron los datos del empleado";
							header("Location: index.php?accion=index");	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultados;
							header("Location: index.php?accion=index&clase=danger");	
						}
					break;

				//caso para eliminar la informacion
				case "eliminar": 
						$resultado = $this->varDirectorio->eliminar($_POST["id"]);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Empleado eliminado del directorio telefónico";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
						}
					break;

				default:
					header("Location: index.php?accion=index&activo=1");
					break;

			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>