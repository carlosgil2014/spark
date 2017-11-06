<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/proveedores.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varProveedor = new proveedores();

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
					$proveedores = $this->varProveedor->listar();
					include_once("principal.php");
					unset($_SESSION["spar_error"]);
					break;

				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Registro guardado correctamente.";
						header("Location: index.php?accion=index");
					}
					else{
						$clase = "danger";
					
						require_once("../../model/bancos.php");
						$varBanco = new bancos();
						$bancos = $varBanco->listar();

						require_once("../../model/paises.php");
						$varPais = new paises();
						$paises = $varPais->listar();

						require_once("../../model/estados.php");
						$varEstado = new estados();
						$estados = $varEstado->listar("México");

						require_once("../../model/metodosPago.php");
						$varMetodoPago = new metodosPago();
						$metodosPago = $varMetodoPago->listar();

						require_once("../../model/diasCredito.php");
						$vardiasCredito = new diasCredito();
						$diasCredito = $vardiasCredito->listar();

						include_once("alta.php");
						unset($_SESSION["spar_error"]);
					}
					break;

				case "modificar":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Registro actualizado correctamente.";
						header("Location: index.php?accion=index");
					}
					else
						$clase = "danger";
					require_once("../../model/bancos.php");
					$varBanco = new bancos();
					$bancos = $varBanco->listar();

					require_once("../../model/paises.php");
					$varPais = new paises();
					$paises = $varPais->listar();

					require_once("../../model/estados.php");
					$varEstado = new estados();
					$estados = $varEstado->listar("México");

					require_once("../../model/metodosPago.php");
					$varMetodoPago = new metodosPago();
					$metodosPago = $varMetodoPago->listar();

					require_once("../../model/diasCredito.php");
					$vardiasCredito = new diasCredito();
					$diasCredito = $vardiasCredito->listar();

					$proveedor = $this->varProveedor->informacion($_GET["idProveedor"]);
					$metodosPagoProveedor =  $this->varProveedor->informacionMetodosPago($_GET["idProveedor"]);

					if(is_array($proveedor)){
						include_once("modificar.php");
						// unset($_SESSION["spar_error"]);
					}
					else{
						header("Location: index.php?accion=index");
					}

					break;

				case "guardar":
					if(!empty($_SESSION['spar_usuario']))
					{
						$resultado = $this->varProveedor -> guardar($_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=alta");
					}
					else{
						header("Location: index.php?accion=index");
					}
					break;

				case "actualizar":
					if(!empty($_SESSION['spar_usuario']))
					{
						$idProveedor = $_GET["idProveedor"];
						$resultado = $this->varProveedor -> actualizar($idProveedor,$_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						// echo $_SESSION["spar_error"];
						header("Location: index.php?accion=modificar&idProveedor=$idProveedor");
					}
					else
						header("Location: index.php?accion=index");
					break;

				case "eliminar":
					if(!empty($_SESSION['spar_usuario']))
					{
						$idProveedor = $_POST["idProveedor"];
						$resultado = $this->varProveedor -> eliminar($idProveedor);
						echo $resultado;
						$_SESSION["spar_error"] = "Registro eliminado correctamente.";
					}
					else
						echo "Error";
					break;

				default:
					header("location:../view/index.php");
					break;
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>