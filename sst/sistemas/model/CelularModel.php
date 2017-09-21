<?php
//requeri solo una vez el archivo 
require_once('../../db/conexion.php');
class CelularModel extends Model
{
	//private $id_status;
	//private $status;


	public function __construct()
	{
		$this->db_name = 'spartodo_spar_bd';
	}
	
	public function create($equipo,$model,$imei,$sim){
		$this->query = "insert into tbCelPhones (equipo,model,imei,sim) values ('$equipo','$model',$imei,'$sim')";
		$this->set_query();

	}

	public function read($id_celular = ''){
		$this->query = ($id_celular != '')
		? (" SELECT * FROM `tbCelPhones` WHERE idCelular=$id_celular") 
		: (" SELECT * FROM `tbCelPhones` ");
		$this->get_query();
		$data = array();

		foreach ($this->rows as $key => $value) {
			$data[$key] = $value;
		}
		//var_dump($data);
		return $data;
	}

	public function update($celular_data = ''){
		foreach ($status_data as $key => $value) {
			// variable de variable
			//http://php.net/manual/es/language.variables.variable.php
			$$key = $value;
		}
		$this->query = ("CALL modificar($id_status , '$status') ");
		$this->set_query();
	}



}
 ?>