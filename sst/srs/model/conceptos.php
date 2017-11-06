<?php 

	require_once('../db/conectadb.php');

	class conceptos{

		protected $acceso;
 		protected $conexion;

		public function __construct() {
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		} 

   		public function datosConcepto($idConcepto)
		{
			$idConcepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idConcepto))));
			$consulta = "SELECT c.nombreRubro, c.id,c.precio,c.categoria FROM tblconceptos c WHERE id = '".$idConcepto."'";
			$resultado=$this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos = $filaTmp;
			}
			return $datos;
		}

		public function conceptoCliente($cliente,$idConcepto)
		{
			$cliente = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($cliente))));
			$idConcepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idConcepto))));
			$consulta = "SELECT count(*) as Total FROM tblrelacionconceptos WHERE idcliente = ".$cliente. " AND idconcepto = ".$idConcepto." AND estado = 'Activo'";
			$resultado=$this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos = $filaTmp;
			}
			return $datos["Total"];
		}


   		public function listarConceptos($usuario)
		{
			$usuario=$this->conexion->real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$datos = array();
			$consulta = "SELECT c.nombreRubro, c.id,c.categoria,c.precio FROM tblconceptos c WHERE id IN (SELECT idconcepto FROM tblrelacionconceptos WHERE idcliente IN (SELECT uc.idcliente FROM tblusuariosclientes uc LEFT OUTER JOIN tblusuarios u ON u.idusuarios = uc.idusuario WHERE u.user_name ='".$usuario."')) and c.nombreRubro not like 'Gastos Administrativos'";
			$resultado=$this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;
			}
			return $datos;
		}

		public function cargarConceptos($idCliente,$tipoServicio){
			//$datos[0];
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));	
			$tipoServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tipoServicio))));	
  			$consulta = "SELECT id AS idconcepto FROM tblconceptos c LEFT JOIN tblrelacionconceptos rc ON c.id = rc.idconcepto WHERE rc.idcliente ='".$idCliente."' AND c.estado = 'Activo' AND (c.categoria='".$tipoServicio."' OR c.categoria = '')";
			$resultado = $this->conexion->query($consulta);
			while($filaTmp = $resultado->fetch_assoc())                        
			{              
			    $consulta = "SELECT id,nombreRubro FROM tblconceptos WHERE id='".$filaTmp["idconcepto"]."'";
			    $resultadoConcepto = $this->conexion->query($consulta); 
			    while($filaConcepto = $resultadoConcepto->fetch_assoc())
					$datos[] = $filaConcepto;   
			}
			if(isset($datos) && is_array($datos)){
				return $datos;
			}
   			else{
	   			return $datos=false;
   			}
		}

		public function existeConcepto($concepto,$usuario)
		{
			$concepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($concepto))));
			$usuario = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$consulta = "SELECT c.nombreRubro from tblconceptos c where c.nombreRubro='".$concepto."' AND id IN (SELECT idconcepto FROM tblrelacionconceptos WHERE idcliente IN (SELECT uc.idcliente FROM tblusuariosclientes uc LEFT OUTER JOIN tblusuarios u ON u.idusuarios = uc.idusuario WHERE u.user_name ='".$usuario."')) and c.nombreRubro not like 'Gastos Administrativos'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				$num = $resultado->num_rows;
				if($num > 0)
					return true;
				else 
					return false;
			}
			else 
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}


		public function almacenarConcepto($concepto,$categoria,$precio,$clientes)
		{
			$concepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($concepto))));
			$categoria = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($categoria))));
			$precio = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($precio))));
			if(empty($precio))
					$precio = 0.00;

			$consulta = "INSERT INTO tblconceptos(nombreRubro,categoria,precio) VALUES ('".$concepto."','".$categoria."','".$precio."')";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				$idConcepto = $this->conexion->insert_id;
				$consulta = "INSERT INTO tblrelacionconceptos (idcliente,idconcepto, nombreconcepto,tiposervicio,estado) VALUES ";
				for ($i=0; $i < count($clientes); $i++) { 
					$cliente = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($clientes[$i]))));
					$valores[] = "('".$cliente."','".$idConcepto."','".$concepto."','".$categoria."','Activo')";
				}
				$consulta .= implode(",", $valores);
				$resultado = $this->conexion->query($consulta);
				if($resultado){
					return true;
				}
				else{
					echo  $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}			
			else
				echo $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";
		}

		public function existeRelacionConcepto($cliente,$concepto)
		{
			$cliente = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($cliente))));
			$concepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($concepto))));
			$consulta = "SELECT count(*) as total FROM tblrelacionconceptos WHERE idconcepto = '".$concepto."' AND idcliente = '".$cliente."'";
			$resultado =$this->conexion->query($consulta);
			$num = $resultado->fetch_assoc();
			if($num["total"] > 0)
				return true;
			else
				return false;
		}

		public function actualizaRelacionConcepto($cliente,$concepto,$estado)
		{
			$cliente = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($cliente))));
			$concepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($concepto))));
			$estado = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($estado))));
			$consulta = "UPDATE tblrelacionconceptos SET estado = '".$estado."' WHERE idcliente = '".$cliente."' and idconcepto ='".$concepto."'";
			$resultado =$this->conexion->query($consulta);
			if(!$resultado)
				echo $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";
			
		}

		public function almacenarRelacionConcepto($clientes,$idConcepto,$nomConcepto,$categoria,$precio,$estado)
		{

			$clientes = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($clientes))));
			$idConcepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idConcepto))));
			$nomConcepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($nomConcepto))));
			$categoria = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($categoria))));
			$precio = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($precio))));
			$estado = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($estado))));
			if(empty($precio))
				$precio = 0.00;

			$consulta = "INSERT INTO tblrelacionconceptos (idcliente,idconcepto, nombreconcepto,tiposervicio,estado) VALUES('".$clientes."','".$idConcepto."','".$nomConcepto."','".$categoria."','".$estado."')";
			$resultado=$this->conexion->query($consulta);
			if(!$resultado)
				echo $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";
		}

		public function actualizarNombre($concepto,$id)
		{
			$concepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($concepto))));
			$id = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($id))));

			$consulta = "UPDATE tblconceptos SET nombreRubro = '".$concepto."' WHERE id = '".$id."'; ";	
			$consulta .= "UPDATE  tblrelacionconceptos set nombreconcepto='".$concepto."' WHERE idconcepto = '".$id."'; ";
			$resultado = $this->conexion->multi_query($consulta);
			if ($resultado)
				return true;
			else
				echo $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";
		}
	
		public function actualizarPrecio($precio,$id)
		{
			$precio = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($precio))));
			$id = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta = "UPDATE tblconceptos set precio = '".$precio."' WHERE id = '".$id."'";
			$resultado=$this->conexion->query($consulta);
			if ($resultado)
				return true;
			else
				echo $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";
					
		}

		public function preciosFijos($idConcepto)
		{
			$idConcepto=$this->conexion->real_escape_string(strip_tags(stripslashes(trim($idConcepto))));
			$query="SELECT precio from tblconceptos where id=".$idConcepto;
			$resultado=$this->conexion->query($query);
			$pFijo=$resultado->fetch_assoc();
			return $pFijo;
		}

		public function __destruct() {
				mysqli_close($this->conexion);
  		}
	}
?>