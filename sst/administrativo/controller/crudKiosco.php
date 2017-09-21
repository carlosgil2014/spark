<?php  

if(isset($_GET["accion"]))
{
	switch($_GET["accion"]){

		case "index":
		
			require_once("../model/kiosco.php");
			$varRFC = new kiosco();
			$rfc = $varRFC->listar();
			include_once("../view/kiosco/index.php");

			break;
		
		case "buscar":

			require_once("../model/kiosco.php");
			$varbuscar = new kiosco();
			$rfc = $varbuscar->listar();
			$datos = $varbuscar->buscar($_POST['rfc']); 
			include_once("../view/kiosco/index.php");
			//header("Location: crudKiosco.php?accion=index");

			break;
		
		case "restablecer":


			require_once("../model/kiosco.php");
			$varactualizar = new kiosco();	
			$datos = $varactualizar->actualizar($_POST['num_empleado'] , $_POST['rfc'] , $_POST['correo']);
			echo $datos;
						
			//header("Location: crudKiosco.php?accion=index");
			
			break;
		

	}
	

}

?>