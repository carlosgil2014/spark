<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
		case "index":
		
			require_once("../model/marcas.php");
			$varMarcas = new marcas();
			$marcas = $varMarcas->listarMarcasCategorias('celular');
			
			include_once("../view/celulares/index.php");
		
			break;
		
		case "buscarEstados":
		
			require_once("../model/ladas.php");
			$varLadas = new ladas();
			$datosLadas = $varLadas->listarEstados($_POST['lada1'],$_POST['lada2']);
			
						
			foreach ($datosLadas as $lada){
			
			echo "<option value='".$lada['nombre']."'>".$lada['nombre']."</option>"; 


			}

     		break;
		
		case "buscarMunicipio":
			
			require_once("../model/municipiosLocalidades.php");
			$varEstados = new municipiosLocalidades();
			$datosEstados = $varEstados->listarMunicipios($_POST['estado']); 


			foreach ($datosEstados as $estado){
			
			echo "<option value='".$estado['municipio']."'>".$estado['municipio']."</option>"; 


			}

			break;
		
		case "buscarLocalidad":
			
			require_once("../model/municipiosLocalidades.php");
			$varMunicipios = new municipiosLocalidades();
			$datosMunicipios = $varMunicipios->listarLocalidades($_POST['municipio']); 


			foreach ($datosMunicipios as $municipio){
			
			echo "<option value='".$municipio['localidad']."'>".$municipio['localidad']."</option>"; 


			}


			break;

		case "actualizar":
			
			break;
		case "eliminar":
			
			break;


		default:
		//	header("location:../view/index.php");
			break;
	}
}
else
	header("location:../view/index.php");
?>