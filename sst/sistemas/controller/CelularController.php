<?php 

require_once '../model/CelularModel.php';
$celular = new CelularModel();


if( isset($_POST['insertar']) ){
$equipo = $_POST['equipo'];
$model = $_POST['modelo'];
$imei = $_POST['imei'];
$sim = $_POST['sim'];
$celular->create($equipo,$model,$imei,$sim);
$celular_data = $celular->read();
}




$statuspruebanumero = 1;
//echo $statuspruebanumero;
//$status->read();

$statusEditar = 'statusEditar';
$id_status = 10;
$update_status = array(
'id_status'=> $id_status,
'status' => $statusEditar
);
//$status->update($update_status);
	//$status_data =$status->read();
	//var_dump($status_data);

	//$num_status = count($status_data);





 ?>