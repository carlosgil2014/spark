<?php 
require_once '../model/CelularModel.php';
$celular = new CelularModel();
	$celular_data =$celular->read();
	//var_dump($status_data);

	//$num_status = count($status_data);

	echo '<tr class="odd gradeX">';
	for ($i=0; $i <count($celular_data); $i++) { 
		$btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="editarProducto('.$celular_data[$i]['idCelular'].')">Editar</a>';
		$btnEliminar='<a class="btn btn-danger" href="javascript:eliminarProducto('.$celular_data[$i]['idCelular'].');">Eliminar</a>';
		echo '<td>'.$celular_data[$i]['idCelular'].'</td>
		<td>'.$celular_data[$i]['equipo'].'</td>
		<td>'.$celular_data[$i]['model'].'</td>
		<td>'.$celular_data[$i]['imei'].'</td>
		td>'.$celular_data[$i]['sim'].'</td>
		<td>
		'.$btnEdit.'
		'.$btnEliminar.'
		</td>
		</tr>';
	}


 ?>