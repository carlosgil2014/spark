<?php	
class cotizaciones{

 		protected $conexion;

		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 

		public function datosCount($idClientes,$estado,$fechaInicial,$fechaFinal){

			$datosCount = 0;

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));
			if(count($idClientes) > 0)
				foreach ($idClientes as $idCliente) {

					$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));

					$consulta = "SELECT count(*) AS total FROM spartodo_srs.tblcotizaciones c WHERE c.idcliente = '$idCliente' AND c.estado = '$estado' and ((c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal' and c.fechaFinal BETWEEN '$fechaInicial' AND '$fechaFinal')or(c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal') or ('$fechaInicial' BETWEEN c.fechaInicial AND c.fechaFinal))";

					$resultado = $this->conexion->query($consulta);

					$filaTmp = $resultado->fetch_assoc();

					$datosCount += $filaTmp["total"];

				}

			return $datosCount;

		}

		public function listarCotizaciones($datos){



			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idCliente']))));

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaInicial']))));	

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaFinal']))));		

  			$consulta="SELECT id FROM tblcotizaciones WHERE idcliente =".$idCliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."')or(fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (estado ='Autorizada')";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$consulta = "SELECT c.id,cl.clave_cliente as clave, c.anio,c.fechaInicial,c.fechaFinal, c.ncotizacion, c.servicio, cc.idcotconcepto, cc.concepto FROM tblcotizaciones c LEFT OUTER JOIN tblcotizacionconceptos cc ON c.id = cc.idcotizacion LEFT OUTER JOIN tblclientes cl ON  c.idcliente = cl.idclientes WHERE c.id = '".$filaTmp['id']."'";

				$resultadoConceptos = $this->conexion->query($consulta);

				while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {

					$consultaCantidad = "SELECT (cc.cant) - (SELECT COALESCE(SUM(os.cantidad),0) FROM tblordenesdeservicio o LEFT OUTER JOIN tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idcotconcepto = cc.idcotconcepto AND (o.estado != 'Cancelada')) - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idcotconcepto = cc.idcotconcepto AND (pf.estado != 'Cancelada')) AS cantidad FROM tblcotizacionconceptos cc WHERE cc.idcotizacion = '".$filaTmpConcepto['id']."' AND cc.idcotconcepto ='".$filaTmpConcepto['idcotconcepto']."'";

					$resultadoCantidad = $this->conexion->query($consultaCantidad);

					$cantidad = $resultadoCantidad->fetch_array();

						if($cantidad["cantidad"] > 0 )

							$datos[] = $filaTmpConcepto;

				}

			}

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function datosCotizacion($idClientes,$estado,$fechaInicial,$fechaFinal){

			$datos = array();

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));

			foreach ($idClientes as $idCliente) {

				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));

				$consulta = "SELECT c.id,cl.nombreComercial as clave_cliente, c.anio, c.ncotizacion,c.servicio, c.fechaInicial, c.fechaFinal, c.estado, (SELECT SUM(total) as total FROM spartodo_srs.tblcotizacionconceptos WHERE idcotizacion = c.id) as total FROM spartodo_srs.tblcotizaciones c LEFT JOIN tblClientes cl ON c.idcliente = cl.idclientes WHERE c.idcliente = '$idCliente' AND c.estado = '$estado' and ((c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal' and c.fechaFinal BETWEEN '$fechaInicial' AND '$fechaFinal')or(c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal') or ('$fechaInicial' BETWEEN c.fechaInicial AND c.fechaFinal))";

				$resultado = $this->conexion->query($consulta);

				if($resultado){

					while ($filaTmp = $resultado->fetch_assoc()) {
						$filaTmp["num"] = $this->validarPermisoAutorizarCotizacion($filaTmp["id"]);
						$datos[] =  $filaTmp;

					}
					

				}

				else{

					return $this->conexion->errno . " : " . $this->conexion->error . "\n";

				}

			}

			// print_r($datos);

			return $datos;

		}
		public function validarPermisoAutorizarCotizacion($idCotizacion)
		{
			$consulta = "SELECT (SELECT count(oc.idorden) FROM spartodo_srs.tblordenesconceptos oc LEFT JOIN spartodo_srs.tblordenesdeservicio os ON os.idorden = oc.idorden WHERE oc.idcotconcepto IN (select cc.idcotconcepto FROM spartodo_srs.tblcotizacionconceptos cc WHERE cc.idcotizacion = c.id) AND os.estado = 'Autorizada') as numOrd,(SELECT count(pc.idprefactura) FROM spartodo_srs.tblprefacturasconceptos pc LEFT JOIN spartodo_srs.tblprefacturas p ON p.idprefactura = pc.idprefactura WHERE pc.idcotconcepto IN (select cc.idcotconcepto FROM spartodo_srs.tblcotizacionconceptos cc WHERE cc.idcotizacion = c.id) AND pc.idcotizacion = c.id AND p.estado = 'Facturada') as numPf FROM spartodo_srs.tblcotizaciones c where c.id = '$idCotizacion'";
			$resultado = $this->conexion->query($consulta);
			$datos =  $resultado->fetch_assoc();
			if($resultado)
				return $datos;
   			elseif (!$this->conexion->query($consulta)) 
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}



		public function datosCotizaciones($idCotizacion){



			$idCotizacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));	

  			$consulta="SELECT cl.clave_cliente as clave, c.anio, c.ncotizacion FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE id = '".$idCotizacion."'";

			$resultado = $this->conexion->query($consulta);

			$datos =  $resultado->fetch_assoc();

			//print_r($datos);

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function detalleConceptoCotizacion($idCotConcepto){



			$idCotConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotConcepto))));	

  			$consulta="SELECT cc.cant,cc.tipoplan,cc.tiposervicio,cc.concepto,cc.precio,cc.comisionagencia,cc.total,cc.descrip FROM tblcotizacionconceptos cc WHERE cc.idcotconcepto = '".$idCotConcepto."'";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$datos[] = $filaTmp;

			}

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function detalleConceptoCotizacionOs($idCotConcepto){



			$idCotConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotConcepto))));	

  			$consulta="SELECT osc.cantidad,osc.concepto as conceptoOS,osc.precioUnitario,osc.comision,osc.total as totalOrden,cl.clave_cliente as claveOrden, os.anio as anioOs, os.norden,osc.descripcion FROM tblordenesconceptos osc LEFT JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idcotconcepto = '".$idCotConcepto."'";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$datos[] = $filaTmp;

			}

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function detalleConceptoCotizacionPf($idCotConcepto){



			$idCotConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotConcepto))));	

  			$consulta="SELECT pfc.cantidad,pfc.concepto as conceptoPf,pfc.precioUnitario,pfc.comision,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura FROM tblprefacturasconceptos pfc LEFT JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pfc.idcotconcepto = '".$idCotConcepto."' AND pf.estado != 'Cancelada'";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$datos[] = $filaTmp;

			}

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function actualizarEstado($idCotizacion,$estado,$motivo){



			$idCotizacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));	

			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));	

			$motivo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($motivo))));	

  			$consulta="UPDATE spartodo_srs.tblcotizaciones SET estado = '$estado', motivo = '$motivo' WHERE id = '$idCotizacion'";

			$resultado = $this->conexion->query($consulta);

			if($resultado){
           		return "OK";
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}



		public function datosConcepto($arrCot,$arrCotCon){



			$datos = array();

			for ($i=0; $i<count($arrCot); $i++) {

				$idCotizacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($arrCot[$i]))));	

				$idCotConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($arrCotCon[$i]))));

				$consulta = "SELECT (cc.cant) - (SELECT COALESCE(SUM(os.cantidad),0) FROM tblordenesdeservicio o LEFT OUTER JOIN tblordenesconceptos os ON o.idorden = os.idorden WHERE idcotconcepto = cc.idcotconcepto AND o.estado != 'Cancelada') - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idcotconcepto = cc.idcotconcepto AND (pf.estado != 'Cancelada')) AS maximo, cc.cant, cc.idcotconcepto as id_rubro,cc.idcotizacion as id, cc.precio, cc.comision,cc.comisionagencia, cc.total,cc.tipoplan,cc.tiposervicio,cc.concepto,cc.idconcepto,c.precio as precioConcepto,cc.descrip FROM tblcotizacionconceptos cc LEFT OUTER JOIN tblconceptos c ON cc.idconcepto = c.id  WHERE cc.idcotconcepto = '".$idCotConcepto."' AND cc.idcotizacion = '".$idCotizacion."'";

				$resultado = $this->conexion->query($consulta);

				if($resultado)

					$datos[] = $resultado->fetch_assoc();

				else

					break;



			}	

			if($resultado){

				$ordenado = false;

				while (false === $ordenado) {

			        $ordenado = true;

			        for ($i = 0; $i < count($datos)-1; ++$i) {

			            $actual = $datos[$i];

			            $sig = $datos[$i+1];

			            if ($datos[$i+1]["id"] < $datos[$i]["id"]) {

			                $datos[$i] = $sig;

			                $datos[$i+1] = $actual;

			                $ordenado = false;

			            }

			        }

    			}

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}

		public function numeroCotizacion($claveCliente)
		{
			$claveCliente = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($claveCliente))));
			$consulta = "SELECT COALESCE(max(c.ncotizacion),0) + 1 as cotizacion FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl. idclientes where cl.clave_cliente ='".$claveCliente."' AND c.anio = '".date("y")."'";
			$resultado=$this->conexion->query($consulta);
			if($resultado)
			{
				$numCot=$resultado->fetch_assoc();
				return $numCot;
			}
			else
				return $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";

		}	

		public function almacenarCotizacion($datosCotizacion,$cotizacionConceptos)
		{
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["idCliente"]))));
			$anio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["anio"]))));
			$servicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["servicio"]))));
			$fInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["fechaInicial"]))));
			$fFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["fechaFinal"]))));
			$ncotizacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["numCotizacion"]))));
			$total = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["total"]))));
			$realizo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["usuario"]))));
			$fechaElaboracion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["fechaElaboracion"]))));
			$permisoAutorizar = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCotizacion["permisoAutorizar"]))));
			
			if($permisoAutorizar == 1)
				$estado = "Autorizada";
			else
				$estado = "Por autorizar";

			$consulta = "INSERT into tblcotizaciones(idcliente,anio,servicio,fechaInicial,fechaFinal,ncotizacion,importe,estado,realizo,elaboracion)values('$idCliente','$anio','$servicio','$fInicial','$fFinal','$ncotizacion','$total','$estado','$realizo','$fechaElaboracion')";
			$resultado=$this->conexion->query($consulta);
			if($resultado)
			{	
				$consulta = "";
				$idCotizacion = $this->conexion->insert_id;
				foreach ($cotizacionConceptos as $datosConceptos) 
				{
					$idConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["idConcepto"]))));
					$cmbTipoPlan = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["cmbTipoPlan"]))));
					$cmbTipoServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["cmbTipoServicio"]))));
					$cmbTipoConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["cmbTipoConcepto"]))));
					$txtDescripcionConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["txtDescripcionConcepto"]))));
					$txtPUnitario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["txtPUnitario"]))));
					$txtCantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["txtCantidad"]))));
					$precioTotal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["precioTotal"]))));
					$txtComisionAgencia = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["txtComisionAgencia"]))));
					$subTotal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["subTotal"]))));
					$txtComisionAgenciaM = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosConceptos["txtComisionAgenciaM"]))));
					$consulta .= "INSERT INTO tblcotizacionconceptos(idcotizacion,idconcepto,tipoplan,tiposervicio,concepto,descrip,precio,cant,preciototal,comision,total,comisionagencia) VALUES ('$idCotizacion','$idConcepto','$cmbTipoPlan','$cmbTipoServicio','$cmbTipoConcepto','$txtDescripcionConcepto','$txtPUnitario','$txtCantidad','$precioTotal','$txtComisionAgencia','$subTotal','$txtComisionAgenciaM');"; 
				}
				$resultado = $this->conexion->multi_query($consulta);
				if($resultado)
				{
					$cotizacionGuardada = true;
				}
				else
					$cotizacionGuardada = $this->conexion->errno . " : " . $this->conexion->error . "\n";

			}
			else
				$cotizacionGuardada = $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";

			return $cotizacionGuardada;

		} 
		public function obtenerid()

		{

			$query="SELECT max(id) as id from tblcotizaciones";	

			$resultado=$this->conexion->query($query);

			if($resultado)

			{

				$idCotizacion=$resultado->fetch_assoc();

			}

			else

				$idCotizacion=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			return $idCotizacion;

		}



		public function almacenarCotConceptos($idcotizacion,$idconcepto,$tipoplan,$tiposervicio,$concepto,$descripcion,$precio,$cant,$preciototal,$comision,$subtotal,$ca)

		{

			$query="INSERT into tblcotizacionconceptos(idcotizacion,idconcepto,tipoplan,tiposervicio,concepto,descrip,precio,cant,preciototal,comision,total,comisionagencia)values('$idcotizacion','$idconcepto','$tipoplan','$tiposervicio','$concepto','$descripcion','$precio','$cant','$preciototal','$comision','$subtotal','$ca')";

			$resultado=$this->conexion->query($query);

			if($resultado)

					$insercion=true;

				else

					$insercion=false;

				return $query;

		}	



		public function clonarCotizacion($idCotizacion,$usuario)

		{

			

			$idCotizacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));

			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));

  			$consulta="SELECT cl.clave_cliente FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE c.id = '".$idCotizacion."'";

			$resultado = $this->conexion->query($consulta);

			if($resultado){

				$dato = $resultado->fetch_assoc();

				$maxCotizacion = $this->numeroCotizacion($dato["clave_cliente"]);

				$consulta = "INSERT INTO tblcotizaciones(idcliente,anio,servicio,fechaInicial,fechaFinal,ncotizacion,importe,estado,realizo,elaboracion) (SELECT idcliente,'".date('y')."',servicio,fechaInicial,fechaFinal,".$maxCotizacion["cotizacion"].",importe,'Por autorizar','".$usuario."','".date('Y-m-d')."' FROM tblcotizaciones WHERE id= '".$idCotizacion."'); ";

				$resultado = $this->conexion->query($consulta);

				if($resultado){

					$idCotizacionNuevo = $this->conexion->insert_id;

					$consulta = "INSERT INTO tblcotizacionconceptos(idcotizacion,idconcepto,tipoplan,tiposervicio,concepto,descrip,precio,cant,preciototal,comision,total,comisionagencia) (select ".$idCotizacionNuevo.",idconcepto,tipoplan,tiposervicio,concepto,descrip,precio,cant,preciototal,comision,total,comisionagencia from tblcotizacionconceptos WHERE idcotizacion= '".$idCotizacion."');";

					$resultado = $this->conexion->query($consulta);

					if($resultado){

						return "COT-".$dato["clave_cliente"]."-".date('y')."-".$maxCotizacion["cotizacion"];

					}

					else

						return $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";

				}

				else

					return $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";

			}

			else

				return $consulta.$this->conexion->errno . " : " . $this->conexion->error . "\n";

		}



		public function cotizacionEspecifica($idCotConcepto)
		{
			$idCotConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotConcepto))));
			$consulta = "SELECT idcotizacion FROM spartodo_srs.tblcotizacionconceptos WHERE idcotconcepto = '$idCotConcepto'";
			$resultado=$this->conexion->query($consulta);
			if($resultado)
			{
				$datos=$resultado->fetch_assoc();
			}
			else
				$datos=null;
			return $datos;
		}

		public function cotizacion($idcotizacion)

		{

			$idcotizacion=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idcotizacion))));

			$consulta="SELECT * FROM tblcotizaciones WHERE id =".$idcotizacion;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			return $datos;



		}



		public function folioCotizacion($idcotconcepto)

		{

			$idcotconcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idcotconcepto))));

			$consulta="SELECT c.nombreComercial AS clave_cliente, cot.anio, cot.ncotizacion FROM spartodo_srs.tblcotizacionconceptos cc JOIN spartodo_srs.tblcotizaciones cot ON cc.idcotizacion = cot.id JOIN tblClientes c ON cot.idcliente=c.idclientes WHERE cc.idcotconcepto = '$idcotconcepto'";

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			return $datos;

		}

		public function datosCotizacionEspecifica($idCotizacion)

		{

			$idCotizacion=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));

			$consulta="SELECT cot.idcliente, cot.motivo, cot.realizo, cot.fechaInicial, cot.fechaFinal, cot.anio, cot.ncotizacion, cot.estado, cot.servicio, cl.nombreComercial as clave_cliente FROM spartodo_srs.tblcotizaciones cot LEFT OUTER JOIN tblClientes cl ON cot.idcliente = cl.idclientes WHERE id = '$idCotizacion'";

			$resultado=$this->conexion->query($consulta);

			if($resultado)
				return $resultado->fetch_assoc();
			else
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}

		public function listarConceptosCot($idCotizacion)

		{

			//$datos="";

			$idCotizacion=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));

			$consulta="SELECT idcotconcepto,idconcepto,tipoplan,tiposervicio,concepto,descrip,cant,precio,preciototal,comision,total,comisionagencia FROM spartodo_srs.tblcotizacionconceptos WHERE idCotizacion = '$idCotizacion'";

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				while($datosConceptos=$resultado->fetch_assoc())

				{

					$datos[]=$datosConceptos;

				}

			}

			elseif (!$this->conexion->query($consulta)) {

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			}

			if(isset($datos))

			return $datos;

		}

		public function sumaConceptosCot($idCotizacion)

		{

			$idCotizacion=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));

			$consulta="SELECT SUM(preciototal) as totalPu, SUM(comision) as totalCa, SUM(total) as totalT from spartodo_srs.tblcotizacionconceptos where idcotizacion = '$idCotizacion'";

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos=$resultado->fetch_assoc();

			elseif (!$this->conexion->query($consulta)) {

				$datos=null;

			}

			return $datos;

		}

		public function estado($id,$estado)

		{

			$id=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));

			$estado=$this->conexion -> real_escape_string($estado);

			$consulta="UPDATE tblcotizaciones SET estado='".$estado."' WHERE id=".$id;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos=true;

			elseif (!$this->conexion->query($consulta)) {

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			}

			return $datos;

		}

		public function guardarCambiosCotizacion($idConcepto,$idcot,$tipoplan,$tiposervicio,$concepto,$descripcion,$precio,$cant,$total,$comisiona)

		{

			$idConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idConcepto))));

			$idcot=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idcot))));

			$tipoplan=$this->conexion -> real_escape_string($tipoplan);

			$tiposervicio=$this->conexion -> real_escape_string($tiposervicio);

			$concepto=$this->conexion -> real_escape_string($concepto);

			$descripcion=$this->conexion -> real_escape_string($descripcion);

			$precio=$this->conexion -> real_escape_string($precio);

			$cant=$this->conexion -> real_escape_string($cant);

			$total=$this->conexion -> real_escape_string($total);

			$comisiona=$this->conexion -> real_escape_string($comisiona);



			$precioTotal=$precio*$cant;

			$comision=$precioTotal*($comisiona/100);

			$subTotal=$precioTotal+$comision;

			$consulta="UPDATE tblcotizacionconceptos SET idconcepto= ".$idConcepto." ,tipoplan='".$tipoplan."' ,tiposervicio='".$tiposervicio."' ,concepto='".$concepto."' ,descrip='".$descripcion."' ,precio=".$precio.",cant=".$cant.",preciototal=".$precioTotal.", comision=".$comision.", total=".$subTotal." ,comisionagencia=".$comisiona." where idcotconcepto=".$idcot;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos=true;

			elseif (!$this->conexion->query($consulta)) {

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			}

			return $datos;

			

		}

		public function eliminarRubroCotizacion($idConcepto)

		{

			$idConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idConcepto))));

			$consulta="DELETE from tblcotizacionconceptos where idcotconcepto=".$idConcepto;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos=true;

			elseif (!$this->conexion->query($consulta)) {

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			}

			return $datos;

		}

		public function guardarModificacionCot($idCotizacion,$idCliente,$fechaIn,$fechaFin,$servicio,$numCotizacion)

		{

			$idCotizacion=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotizacion))));

			$idCliente=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));

			$numCotizacion=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($numCotizacion))));

			$fechaIn=$this->conexion -> real_escape_string($fechaIn);

			$fechaFin=$this->conexion -> real_escape_string($fechaFin);

			$servicio=$this->conexion -> real_escape_string($servicio);

			$consulta="UPDATE tblcotizaciones SET idcliente=".$idCliente.",anio='".date("y")."',fechaInicial='".$fechaIn."',fechaFinal='".$fechaFin."',servicio='".$servicio."',ncotizacion=".$numCotizacion." WHERE id=".$idCotizacion;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos=true;

			elseif (!$this->conexion->query($consulta)) {

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			}

			return $datos;



		}
		public function tipoProceso($idCotConcepto,$folioCotizacion)
		{	
			$proceso = "";$folios="";
			$idCotConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotConcepto))));
			$consulta = "SELECT oc.idcotconcepto AS os , pc.idcotconcepto AS pf FROM spartodo_srs.tblcotizacionconceptos cc LEFT JOIN spartodo_srs.tblordenesconceptos oc ON oc.idcotconcepto = cc.idcotconcepto LEFT JOIN spartodo_srs.tblprefacturasconceptos pc ON pc.idcotconcepto = cc.idcotconcepto WHERE cc.idcotconcepto = 'idCotConcepto'";
			$resultado = $this->conexion->query($consulta);
			$tipoProceso = $resultado->fetch_assoc();
			if($tipoProceso["os"] == $idCotConcepto)
				$proceso = "ABC";
			else if($tipoProceso["pf"] == $idCotConcepto)
				$proceso = "ACB";
			
			switch ($proceso) 
			{
				case 'ABC':
					$folios = "";
					$origen = "";
					$consulta = "SELECT oc.idordconcepto,CONCAT('OS-',c.clave_cliente,'-',os.anio,'-',os.norden) AS os FROM tblordenesconceptos oc LEFT JOIN tblordenesdeservicio os ON os.idorden = oc.idorden LEFT JOIN tblclientes c ON os.idcliente = c.idclientes WHERE oc.idcotconcepto = ".$idCotConcepto;
					$resultado = $this->conexion->query($consulta);
					while ($folioOs = $resultado->fetch_assoc()) 
					{
						$foliosOs[] = $folioOs;
					}
					if(isset($foliosOs))
					{
						foreach ($foliosOs as $valueOs) 
						{
							$folios = $folioCotizacion."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span>".$valueOs["os"];
							$consulta = "SELECT CONCAT('PF-',c.clave_cliente,'-',p.anio,'-',p.nprefactura) AS pf FROM tblprefacturasconceptos pc LEFT JOIN tblprefacturas p ON  p.idprefactura = pc.idprefactura LEFT JOIN tblclientes c ON c.idclientes = p.idcliente WHERE pc.idordconcepto = ".$valueOs["idordconcepto"];
							$resultado = $this->conexion->query($consulta);
							while ($folioPf = $resultado->fetch_assoc()) 
							{
								$foliosPf[] = $folioPf;
							}
							// print_r($foliosPf);
							if(isset($foliosPf) && !empty($foliosPf))
							{
								foreach ($foliosPf as $valuePf) 
								{
									// echo $valuePf["pf"];
									$origen .= $folios."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span>".$valuePf["pf"]."<br>";
								}
							}
							else
							{
								$origen .= $folios."<br>";
							}
							$foliosPf = array();

						}
					}

					break;
				case 'ACB':
					$folios = "";
					$origen = "";
					$consulta = "SELECT pc.idprefacturaconcepto AS idpfconcepto,CONCAT('PF-',c.clave_cliente,'-',p.anio,'-',p.nprefactura) AS pf FROM tblprefacturasconceptos pc LEFT JOIN tblprefacturas p ON  p.idprefactura = pc.idprefactura LEFT JOIN tblclientes c ON c.idclientes = p.idcliente WHERE pc.idcotconcepto = ".$idCotConcepto;
					$resultado = $this->conexion->query($consulta);
					while ($folioPf = $resultado->fetch_assoc()) 
					{
						$foliosPf[] = $folioPf;
					}
					if(isset($foliosPf))
					{
						foreach ($foliosPf as $valuePf) 
						{
							$folios = $folioCotizacion."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span>".$valuePf["pf"];
							$consulta = "SELECT CONCAT('OS-',c.clave_cliente,'-',os.anio,'-',os.norden) AS os FROM tblordenesconceptos oc LEFT JOIN tblordenesdeservicio os ON os.idorden = oc.idorden LEFT JOIN tblclientes c ON os.idcliente = c.idclientes WHERE oc.idpfconcepto = ".$valuePf["idpfconcepto"];
							$resultado = $this->conexion->query($consulta);
							while ($folioOs = $resultado->fetch_assoc()) 
							{
								$foliosOs[] = $folioOs;
							}
							if(isset($foliosOs) && !empty($foliosOs))
							{
								foreach ($foliosOs as $valueOs) 
								{
									$origen .= $folios."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span>".$valueOs["os"]."<br>";
								}
							}
							else
							{
								$origen .= $folios."<br>";
							}
							$foliosOs = array();
						}
					}
					
					break;
				
				default:
					# code...
					break;
			}
			if(isset($origen))
				return $origen;
			else
				return $folios;

		}

		public function folioOrdenServicio($idCotConcepto)

		{

			$idCotConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotConcepto))));
			$consulta="SELECT oc.idordconcepto,CONCAT('OS-',c.clave_cliente,'-',os.anio,'-',os.norden) AS os FROM tblordenesconceptos oc LEFT JOIN tblordenesdeservicio os ON oc.idorden = os.idorden LEFT JOIN tblclientes c ON os.idcliente = c.idclientes WHERE oc.idcotconcepto = ".$idcotconcepto;
			$resultado=$this->conexion->query($consulta);
			if($resultado)
			{
				$datos=$resultado->fetch_assoc();
			}
			else
				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			return $datos;

		}	

		public function folioPrefactura($idcotconcepto)

		{

			$idcotconcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idcotconcepto))));

			$consulta="SELECT c.clave_cliente, pf.anio AS anioPf, pf.nprefactura, pc.idprefacturaconcepto FROM tblprefacturasconceptos pc JOIN tblprefacturas pf ON pc.idprefactura=pf.idprefactura JOIN tblclientes c ON pf.idcliente=c.idclientes WHERE pc.idcotconcepto=".$idcotconcepto;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=false;

			return $datos;

		}
		public function folioOrdenServicioCot($idPfConcepto)

		{

			$idPfConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));

			$consulta="SELECT cl.clave_cliente, os.anio AS anioOs, os.norden FROM tblordenesconceptos oc 

			JOIN tblordenesdeservicio os ON oc.idorden = os.idorden

			JOIN tblclientes cl ON os.idcliente=cl.idclientes WHERE oc.idpfconcepto=".$idPfConcepto;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=false;

			return $datos;

		}



		public function folioPrefacturaCot($idOrdConcepto)

		{

			$idOrdConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idOrdConcepto))));

			$consulta="SELECT cl.clave_cliente, pf.anio  AS anioPf, pf.nprefactura FROM tblprefacturasconceptos pc 

			JOIN tblprefacturas pf ON pf.idprefactura = pc.idprefactura

			JOIN tblclientes cl ON pf.idcliente=cl.idclientes WHERE pc.idOrdConcepto=".$idOrdConcepto;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=false;

			return $datos;

		}



		

		public function __destruct() {

				mysqli_close($this->conexion);

  		}

	}

?>