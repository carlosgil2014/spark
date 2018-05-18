<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/modulos.php");
include_once("../../model/permisos.php");
include_once("../../model/usuarios.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varModulos = new modulos();
        $this->varPermisos = new permisos();
        $this->varUsuarios = new usuariosSRS();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
		if(isset($datosUsuario["idUsuario"])){
			$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$permisos = $this->varPermisos->listar("Permisos", $datosUsuario["idUsuario"]);
		}
		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					$usuarios = $this->varUsuarios->listar();
					$modulos = $this->varModulos->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "permisos":
					if(isset($_POST["usuario"])){
						$permisosUsuario = $this->varPermisos->permisos($_POST["usuario"]);
						include_once("permisos.php");
					}
					else{
						header("Location: index.php?accion=index");
					}
					break;

				case "cambiarPermiso":
					if(isset($_POST["usuario"])){
						$resultado = $this->varPermisos->cambiarPermiso($_POST["usuario"], $_POST["permiso"], $_POST["valor"]);
						echo $resultado;
					}
					else{
						header("Location: index.php?accion=index");
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