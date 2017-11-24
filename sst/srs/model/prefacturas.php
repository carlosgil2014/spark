 <?php
class prefacturas{

 		protected $conexion;
		public function __construct() {
 		 	$this->conexion = accesoDB::conDB();
   		} 

   		public function datosCount($idClientes,$estado,$fechaInicial,$fechaFinal)
   		{
			$datosCount = 0;
			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));
			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));
			$subconsulta = ($estado == "Conciliado") ? " IN ('Conciliado','ConciliadoA','ConciliadoR','ConciliadoC')" : " = '".$estado."'";
			if(count($idClientes) > 0)
				foreach ($idClientes as $idCliente) 
				{

					$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
					$consulta = "SELECT count(*) AS total FROM spartodo_srs.tblprefacturas c WHERE c.idcliente = '$idCliente' AND c.estado $subconsulta and (c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal')";
					$resultado = $this->conexion->query($consulta);
					$filaTmp = $resultado->fetch_assoc();
					$datosCount += $filaTmp["total"];
				}
			return $datosCount;
		}

		public function datosCountC($idClientes,$estadoPago,$fechaInicial,$fechaFinal){
			$datosCount = 0;
			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));
			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			if(count($idClientes) > 0)
				foreach ($idClientes as $idCliente) {
					$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
					$consulta = "SELECT count(*) AS total FROM spartodo_srs.tblprefacturas c WHERE c.idcliente = '$idCliente' AND c.estado = 'Facturada' AND c.edopago = '$estadoPago' and (c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal')";
					$resultado = $this->conexion->query($consulta);
					$filaTmp = $resultado->fetch_assoc();
					$datosCount += $filaTmp["total"];

				}
			return $datosCount;
		}

		public function listarPrefacturas($datos){
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idCliente']))));
			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaInicial']))));	
			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaFinal']))));		
  			$consulta="SELECT idprefactura FROM spartodo_srs.tblprefacturas WHERE idcliente = '$idCliente' AND (fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal' ) AND (estado !='Cancelada') AND cfdi != ''";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$consulta = "SELECT pf.idprefactura,cl.nombreComercial AS clave, pf.anio,pf.fechaInicial, pf.nprefactura, pf.detalle AS servicio, pfc.idcotconcepto, pfc.idprefacturaconcepto, pfc.idordconcepto, pfc.concepto, pfc.precioUnitario, pfc.comision, pfc.cantidad, pf.descuento FROM spartodo_srs.tblprefacturas pf LEFT OUTER JOIN spartodo_srs.tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura LEFT OUTER JOIN tblClientes cl ON  pf.idcliente = cl.idclientes WHERE pf.idprefactura = '{$filaTmp['idprefactura']}' ";

				$resultadoConceptos = $this->conexion->query($consulta);

				while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {

					$consultaCantidad = "SELECT (pfc.total - (SELECT COALESCE(SUM(os.total),0) FROM spartodo_srs.tblordenesdeservicio o LEFT OUTER JOIN spartodo_srs.tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idpfconcepto = pfc.idprefacturaconcepto AND (o.estado != 'Cancelada') AND (o.estado != 'DevolucionC'))) AS total FROM spartodo_srs.tblprefacturasconceptos pfc WHERE pfc.idprefactura = '{$filaTmpConcepto["idprefactura"]}' AND pfc.idcotconcepto = '{$filaTmpConcepto['idcotconcepto']}'";
					$resultadoCantidad = $this->conexion->query($consultaCantidad);
					$cantidad = $resultadoCantidad->fetch_array();
					if($cantidad["total"] > 0 )
					{
						$filaTmpConcepto["saldoAnticipado"] = $cantidad["total"];
						$datos[] = $filaTmpConcepto;
					}
				}
			}
			if($resultado){
				return $datos;
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}



		public function datosPrefactura($idClientes,$estado,$fechaInicial,$fechaFinal){

			$datos = array();
			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));
			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));
			/// Para estados Conciliados
			if($estado == "Conciliado")
				$subconsulta = " AND pf.estado IN('Conciliado','ConciliadoA','ConciliadoR','ConciliadoC')";
			else
				$subconsulta = " AND pf.estado = '$estado'";

			foreach ($idClientes as $idCliente) {
				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
				$consulta = "SELECT pf.idprefactura,cl.nombreComercial AS clave_cliente, pf.anio, pf.nprefactura,pf.detalle, pf.fechaInicial,pf.cfdi, pf.estado, (SELECT SUM(total) as total FROM spartodo_srs.tblprefacturasconceptos WHERE idprefactura = pf.idprefactura) - pf.descuento AS total FROM spartodo_srs.tblprefacturas pf LEFT JOIN tblClientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente = '$idCliente' $subconsulta AND ((pf.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal' ) OR (pf.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal'))";
				$resultado = $this->conexion->query($consulta);
				if($resultado){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos[] =  $filaTmp;
					}
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			return $datos;
		}



		public function datosFactura($idClientes,$estado,$fechaInicial,$fechaFinal){

			$datos = array();
			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));
			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));

			foreach ($idClientes as $idCliente) {
				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
				if($estado != "Cancelada")
					$consulta = "SELECT pf.idprefactura,cl.nombreComercial AS clave_cliente, pf.anio, pf.nprefactura,pf.detalle, pf.fechaInicial, pf.estado,pf.cfdi, (SELECT SUM(total) as total FROM spartodo_srs.tblprefacturasconceptos WHERE idprefactura = pf.idprefactura) - pf.descuento as total FROM spartodo_srs.tblprefacturas pf LEFT JOIN tblClientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente = '$idCliente' AND pf.estado = 'Facturada' AND pf.edopago = '$estado' and ((pf.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal') OR (pf.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal'))";
				else
					$consulta = "SELECT pf.idprefactura,cl.nombreComercial AS clave_cliente, pf.anio, pf.nprefactura,pf.detalle, pf.fechaInicial, pf.estado,pf.cfdi, (SELECT SUM(total) as total FROM spartodo_srs.tblprefacturasconceptos WHERE idprefactura = pf.idprefactura) - pf.descuento as total FROM spartodo_srs.tblprefacturas pf LEFT JOIN tblClientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente = '$idCliente' AND pf.estado = '$estado' and ((pf.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal') OR (pf.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal'))";

				$resultado = $this->conexion->query($consulta);
				if($resultado){
					while ($filaTmp = $resultado->fetch_assoc()) {
						$datos[] =  $filaTmp;
					}
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			return $datos;
		}



		public function datosPrefacturas($idPrefactura){



			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPrefactura))));	

  			$consulta="SELECT pf.idprefactura, pf.idcliente, cl.nombreComercial AS clave, pf.anio, pf.fechaInicial, pf.nprefactura,pf.cfdi,pf.idclienteprefactura,pf.realizo,pf.fechacfdi,pf.descuento,pf.motivodescuento,pf.detalle,pf.estado,pf.tipo, pf.motivocancelacion FROM spartodo_srs.tblprefacturas pf LEFT OUTER JOIN tblClientes cl ON pf.idcliente = cl.idclientes WHERE idprefactura = '$idPrefactura'";

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



		public function datosPrefacturasConceptos($idPrefactura){

			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPrefactura))));	

  			$consulta="SELECT pf.nprefactura,pf.anio,pfc.idprefacturaconcepto,pfc.idcotconcepto,pfc.idordconcepto,pfc.cantidad, pfc.concepto, pfc.tipoplan, pfc.tiposervicio,cc.descrip AS descripcion,pfc.precioUnitario as precio, pfc.comision,pfc.total,cl.nombreComercial AS clave_cliente,c.anio AS anioCot,os.anio AS anioOs,c.ncotizacion,os.norden,'abc' as tipo FROM spartodo_srs.tblprefacturas pf LEFT JOIN spartodo_srs.tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura LEFT OUTER JOIN spartodo_srs.tblordenesconceptos osc ON pfc.idordconcepto = osc.idordconcepto LEFT OUTER JOIN spartodo_srs.tblcotizacionconceptos cc ON pfc.idcotconcepto = cc.idcotconcepto OR osc.idcotconcepto = cc.idcotconcepto LEFT OUTER JOIN spartodo_srs.tblcotizaciones c ON cc.idcotizacion = c.id LEFT OUTER JOIN spartodo_srs.tblordenesdeservicio os ON osc.idorden = os.idorden  LEFT OUTER JOIN tblClientes  cl ON cl.idclientes = os.idcliente OR cl.idclientes = c.idcliente WHERE pfc.idprefactura = '$idPrefactura'";

			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {

					$datos[] = $filaTmp;  

				}
				foreach ($datos as $dato) {
					if(is_null($dato["idordconcepto"])){
						$consulta="SELECT pf.nprefactura,pf.anio,pfc.idprefacturaconcepto,pfc.idcotconcepto,pfc.idordconcepto,pfc.cantidad, pfc.concepto, pfc.tipoplan,cc.descrip AS descripcion,pfc.tiposervicio,pfc.precioUnitario as precio, pfc.comision,pfc.total,cl.nombreComercial AS clave_cliente,c.anio AS anioCot,c.ncotizacion, os.anio as anioOs, os.norden, os.realizo,'acb' as tipo FROM spartodo_srs.tblordenesconceptos osc LEFT OUTER JOIN spartodo_srs.tblordenesdeservicio os ON osc.idorden = os.idorden LEFT JOIN spartodo_srs.tblprefacturasconceptos pfc ON pfc.idprefacturaconcepto = osc.idpfconcepto LEFT JOIN spartodo_srs.tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT JOIN spartodo_srs.tblcotizacionconceptos cc ON pfc.idcotconcepto = cc.idcotconcepto LEFT JOIN spartodo_srs.tblcotizaciones c ON c.id = cc.idcotizacion LEFT OUTER JOIN tblClientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND os.estado != 'DevolucionC' AND osc.idpfconcepto = '{$dato['idprefacturaconcepto']}'";
						$resultado = $this->conexion->query($consulta);
						if($resultado->num_rows != 0){	
							while($datosTmp = $resultado->fetch_assoc()){
								$datosResultado[] = $datosTmp;
							}
						}
						else
							$datosResultado[] = $dato;
					}
					else 
						$datosResultado[] = $dato; 
				}
				return $datosResultado;
			}
   			else {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}

			

		}



		public function detalleConceptoPrefactura($idPfConcepto){



			$idPfConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));	

  			$consulta="SELECT pfc.cantidad,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.precioUnitario,pfc.comision,pfc.total FROM spartodo_srs.tblprefacturasconceptos pfc WHERE pfc.idprefacturaconcepto = '$idPfConcepto'";

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



		public function detalleConceptoPrefacturaOs($idPfConcepto){



			$idPfConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));	

  			$consulta="SELECT osc.idorden,osc.cantidad as cantidadOS, os.servicio, osc.concepto as conceptoOS,osc.precioUnitario as precioUnitarioOS,osc.comision as comisionOS,osc.total as totalOrden,cl.nombreComercial as claveOrden, os.anio as anioOs, os.norden, os.estado FROM spartodo_srs.tblordenesconceptos osc LEFT OUTER JOIN spartodo_srs.tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblClientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND os.estado != 'DevolucionC' AND osc.idpfconcepto = '$idPfConcepto'";

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



		// , 



		public function detalleConceptoPrefacturaCot($idPfConcepto){



			$idPfConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));	

  			$consulta="SELECT pfc.cantidad,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.precioUnitario,pfc.comision,pfc.total,osc.idorden,osc.cantidad as cantidadOS,osc.concepto as conceptoOS,osc.precioUnitario as precioUnitarioOS,osc.comision as comisionOS,osc.total as totalOrden,cl.nombreComercial as claveOrden, os.anio as anioOs, os.norden FROM spartodo_srs.tblprefacturasconceptos pfc LEFT OUTER JOIN spartodo_srs.tblordenesconceptos osc ON pfc.idprefacturaconcepto = osc.idpfconcepto LEFT OUTER JOIN spartodo_srs.tblordenesdeservicio os ON os.idorden = osc.idorden LEFT OUTER JOIN tblClientes cl ON os.idcliente = cl.idclientes WHERE pfc.idprefacturaconcepto = '$idPfConcepto'";

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



		public function datosConcepto($arrPf,$arrPfCon){



			$datos = array();

			for ($i=0; $i<count($arrPf); $i++) {

				$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($arrPf[$i]))));	

				$idPfConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($arrPfCon[$i]))));

				$consulta = "SELECT (pfc.total - (SELECT COALESCE(SUM(os.total),0) FROM spartodo_srs.tblordenesdeservicio o LEFT OUTER JOIN spartodo_srs.tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idpfconcepto = pfc.idprefacturaconcepto AND (o.estado != 'Cancelada') AND (o.estado != 'DevolucionC')))  AS maximo, (pfc.cantidad - (SELECT COALESCE(SUM(os.cantidad),0) FROM spartodo_srs.tblordenesdeservicio o LEFT OUTER JOIN spartodo_srs.tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idpfconcepto = pfc.idprefacturaconcepto AND (o.estado != 'Cancelada') AND (o.estado != 'DevolucionC'))) AS cantidad, pfc.idprefacturaconcepto as id_rubro, pfc.idprefactura as id, pfc.precioUnitario as precio, pfc.comision as comisionagencia, pfc.total,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.idconcepto,c.precio as precioConcepto FROM spartodo_srs.tblprefacturasconceptos pfc LEFT OUTER JOIN spartodo_srs.tblconceptos c ON pfc.idconcepto = c.id  WHERE pfc.idprefacturaconcepto = '$idPfConcepto' AND pfc.idprefactura = '$idPrefactura'";

				$resultado = $this->conexion->query($consulta);

				if($resultado)

					$datos[] = $resultado->fetch_assoc();

				else

					break;

			}	

			if($resultado){

				// $ordenado = false;

				// while (false === $ordenado) {

			 //        $ordenado = true;

			 //        for ($i = 0; $i < count($datos)-1; ++$i) {

			 //            $actual = $datos[$i];

			 //            $sig = $datos[$i+1];

			 //            if ($datos[$i+1]["id"] < $datos[$i]["id"]) {

			 //                $datos[$i] = $sig;

			 //                $datos[$i+1] = $actual;

			 //                $ordenado = false;

			 //            }

			 //        }

    // 			}

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function guardarPrefactura($datos){

   			require_once('clientes.php');
   			require_once('cotizaciones.php');

			$clientes = new clientes();
			$cotizacion = new cotizaciones();	

			$idCliente= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idCliente"]))));
			$idClientePrefactura= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idClientePrefactura"]))));	
			$datosCliente = $clientes-> datosClienteEspecifico($idCliente);
			$clave= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCliente["clave_cliente"]))));
  			$anio = date("y");
  			$detalle = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["detalle"]))));

  			if(isset($datos["opcion"]))
  				$numPrefactura = ($datos["opcion"] == "Prefacturar") ? $this->nPrefactura($clave) : $this->nConciliacion($clave);
  			else
  				$numPrefactura = $this->nPrefactura($clave);

  			$nprefactura = $numPrefactura["maxima"] + 1;

  			$importe = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(str_replace(',', '', $datos["importe"])))));
  			$realizo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["usuario"]))));
  			$descuento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["descuento"]))));
  			$motivo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivo"]))));
  			$tipoPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tipoPrefactura"]))));
  			
  			if(isset($datos["opcion"]))
  				$opcion = ($datos["opcion"] == "Prefacturar") ? "Por facturar" : "Conciliado";
  			else
  				$opcion = "Por facturar";

  			$consultaPrincipal = "INSERT INTO tblprefacturas (idcliente, detalle, anio, fechaInicial, nprefactura, importe, realizo, estado,tipo, descuento,idclienteprefactura,motivodescuento) VALUES('".$idCliente."','".$detalle."','".$anio."','".date("Y-m-d")."','".$nprefactura."','".$importe."','".$realizo."','".$opcion."','".$tipoPrefactura."','".$descuento."','".$idClientePrefactura."','".$motivo."'); ";

			$resultado = $this->conexion->query($consultaPrincipal);
			$idPrefactura = $this->conexion->insert_id;
			$consulta = "";

			for ($i=0; $i < count($datos["conceptos"]); $i++) 
			{

				$idCotOs = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idcotos"][$i]))));
				$idCotOsConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idcotosconceptos"][$i]))));
	  			$idConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idconceptos"][$i]))));
	  			$concepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["conceptos"][$i]))));
				$tipoPlan = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tiposPlan"][$i]))));
	  			$tipoServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tiposServicio"][$i]))));
	  			$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cantidad"][$i]))));
				$precio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["precios"][$i]))));
	  			$comision = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["comisiones"][$i]))));
	  			$total = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["subtotales"][$i]))));
				$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tiposarrCotOsCon"][$i]))));

				if($tipo == "cot")
					$consulta .= "INSERT INTO tblprefacturasconceptos (idprefactura,idcotizacion, idcotconcepto, idconcepto, concepto, tipoplan, tiposervicio, cantidad, precioUnitario, comision, total) VALUES ";
				elseif ($tipo == "os") 
					$consulta .= "INSERT INTO tblprefacturasconceptos (idprefactura,idorden, idordconcepto, idconcepto, concepto, tipoplan, tiposervicio, cantidad, precioUnitario, comision, total) VALUES ";

				$valores = "('".$idPrefactura."','".$idCotOs."','".$idCotOsConcepto."','".$idConcepto."','".$concepto."','".$tipoPlan."','".$tipoServicio."','".$cantidad."','".$precio."','".$comision."','".$total."')";

				$consulta .= $valores;

				$consulta .= "; ";

			}
			// echo $consultaPrincipal;
			$resultado = $this->conexion->multi_query($consulta);

			if($resultado)
			{
				if(isset($datos["opcion"]))
					$folio = ($datos["opcion"] == "Prefacturar") ? "PF-".$clave."-".$anio."-".$nprefactura : "CL-".$clave."-".$anio."-".$nprefactura;
				else
					$folio = "PF-".$clave."-".$anio."-".$nprefactura;
				return $folio;
			}
   			elseif (!$this->conexion->query($consultaPrincipal)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}

			

		}



		public function nPrefactura($clave){

			$clave= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($clave))));	

  			$consulta = "SELECT COALESCE(MAX(pf.nprefactura),0) as maxima FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE cl.clave_cliente  = '".$clave."' AND pf.anio = '".date("y")."' AND pf.estado != 'Conciliado'";

			$resultado = $this->conexion->query($consulta);

			$datos =  $resultado->fetch_assoc();

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

		}
		public function nConciliacion($clave)
		{
			$clave = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($clave))));	
  			$consulta = "SELECT COALESCE(MAX(pf.nprefactura),0) as maxima FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE cl.clave_cliente  = '".$clave."' AND pf.anio = '".date("y")."' AND pf.estado = 'Conciliado'";
			$resultado = $this->conexion->query($consulta);
			$datos =  $resultado->fetch_assoc();
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}



		public function maximoConcepto($idCotOsConcepto,$tabla,$idPrefactura){

			$idCotOsConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotOsConcepto))));	
			$tabla = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tabla))));	

			switch ($tabla) {

				case 'cot':

  					$consulta="SELECT idcotizacion FROM spartodo_srs.tblcotizacionconceptos WHERE idcotconcepto = '$idCotOsConcepto'";
  					$resultado = $this->conexion->query($consulta);
					$datos =  $resultado->fetch_assoc();
					$idCotizacion = $datos["idcotizacion"];
					$consulta = "SELECT (cc.cant) - (SELECT COALESCE(SUM(os.cantidad),0) FROM spartodo_srs.tblordenesdeservicio o LEFT OUTER JOIN spartodo_srs.tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idcotconcepto = cc.idcotconcepto AND (o.estado != 'Cancelada' AND o.estado != 'DevolucionC')) - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM spartodo_srs.tblprefacturas pf LEFT OUTER JOIN spartodo_srs.tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idcotconcepto = cc.idcotconcepto AND (pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pf.idprefactura != '$idPrefactura')) AS maximo FROM spartodo_srs.tblcotizaciones c LEFT OUTER JOIN spartodo_srs.tblcotizacionconceptos cc ON c.id = cc.idcotizacion WHERE cc.idcotconcepto = '$idCotOsConcepto' AND cc.idcotizacion = '$idCotizacion'";

					$resultado = $this->conexion->query($consulta);

					$datos =  $resultado->fetch_assoc();

					return  $datos ["maximo"];

					break;



				case 'os':

  					$consulta="SELECT idorden FROM spartodo_srs.tblordenesconceptos WHERE idordconcepto = '$idCotOsConcepto'";
  					$resultado = $this->conexion->query($consulta);
					$datos =  $resultado->fetch_assoc();
					$idOrden= $datos["idorden"];

					$consulta = "SELECT (os.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM spartodo_srs.tblprefacturas pf LEFT OUTER JOIN spartodo_srs.tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = os.idordconcepto AND (pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pf.idprefactura != '$idPrefactura')))  AS maximo FROM spartodo_srs.tblordenesdeservicio o LEFT OUTER JOIN spartodo_srs.tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idordconcepto = '$idCotOsConcepto' AND os.idorden = '$idOrden'";

					$resultado = $this->conexion->query($consulta);
					$datos =  $resultado->fetch_assoc();

					return  $datos ["maximo"];



				default:

					# code...

					break;

			}

			

		}



		public function actualizarPrefactura($idPrefactura, $detalle,$idClientePrefactura, $descuento, $motivodescuento, $total,$estado){

			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPrefactura))));
			$detalle = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($detalle))));
			$idClientePrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idClientePrefactura))));
			$descuento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($descuento))));
			$motivodescuento = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($motivodescuento))));
			$hoy = date('Y-m-d');
			$total = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($total))));
			$estado = ($estado == "Conciliado" || $estado == "ConciliadoR") ? "Conciliado":"Por facturar";

 			$consulta = "UPDATE spartodo_srs.tblprefacturas SET detalle = '$detalle', descuento = '$descuento', motivodescuento = '$motivodescuento', importe = '$total', fechaInicial = '$hoy', estado = '$estado', idclienteprefactura = '$idClientePrefactura' WHERE idprefactura = '$idPrefactura'";

			$resultado = $this->conexion->query($consulta);

			if($resultado){
				echo "OK";
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}



		public function actualizarPrefacturaConcepto($datos){

			$idPrefacturaConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idPrefacturaConcepto"]))));	
			$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cantidad"]))));	
			$subtotal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["subtotal"]))));	
  			$consulta = "UPDATE spartodo_srs.tblprefacturasconceptos SET cantidad = '$cantidad', total = '$subtotal' WHERE idprefacturaconcepto = '$idPrefacturaConcepto'";

			$resultado = $this->conexion->query($consulta);

			if($resultado){
				return true;
			}

   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}



		public function asignarCfdi($idPrefactura,$cfdi,$fechaCfdi){

			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPrefactura))));
			$cfdi = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cfdi))));
			$fechaCfdi = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaCfdi))));
  			$consulta = "UPDATE spartodo_srs.tblprefacturas SET cfdi = '$cfdi', fechaCfdi = '$fechaCfdi', estado = 'Facturada', edopago='nopagado' WHERE idprefactura = '$idPrefactura'";
			$resultado = $this->conexion->query($consulta);

			if($resultado){
				return true;
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}



		public function numeroPrefacturas($idOrden)
		{
			$idOrden= $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrden))));
			$consulta="SELECT COUNT(*) AS num FROM spartodo_srs.tblprefacturasconceptos where idorden = '$idOrden'";
			$resultado= $this->conexion->query($consulta);
			if($resultado){
				$datos=$resultado->fetch_assoc();
				return $datos;
			}
			else
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
		}



		public function prefacturaEspecifica($idPfConcepto)

		{

			$idPfConcepto=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));

			$consulta = "SELECT idprefactura from tblprefacturasconceptos WHERE idprefacturaconcepto =".$idPfConcepto;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=null;

			return $datos;

		}



		public function prefactura($idprefactura)

		{

			$idprefactura=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idprefactura))));

			$consulta="SELECT * FROM tblprefacturas WHERE idprefactura =".$idprefactura;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			else

				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

			return $datos;



		}		



		public function folioPrefactura($idPfConcepto)

		{

			$idPfConcepto = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));

			$consulta="SELECT c.nombreComercial AS clave_cliente, pf.anio AS aniop, pf.nprefactura, pfc.idcotconcepto FROM spartodo_srs.tblprefacturasconceptos pfc JOIN spartodo_srs.tblprefacturas pf ON pfc.idprefactura=pf.idprefactura JOIN tblClientes c ON pf.idcliente=c.idclientes WHERE pfc.idprefacturaconcepto = '$idPfConcepto'";

			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				$datos=$resultado->fetch_assoc();

			}

			return $datos;

		}
		public function prefacturaPorRealizarOS($idCliente,$año,$usuario)
		{
			$saldoTotalPf = 0;
			$contPfConceptos = 0;
			$numPf = array();
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(implode(",",$idCliente)))));
			$año = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($año))));	
			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));		
			$consulta = "SELECT pfc.idprefactura,pfc.idprefacturaconcepto AS idpfconcepto FROM spartodo_srs.tblprefacturasconceptos pfc LEFT JOIN spartodo_srs.tblprefacturas pf ON pf.idprefactura = pfc.idprefactura WHERE pf.estado = 'Facturada' AND pf.cfdi IS NOT NULL AND pf.idcliente IN ($idCliente) AND pf.anio = '$año' AND pfc.idorden IS NULL";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) 
				{
					$consulta = "SELECT COALESCE((pfc.cantidad*pfc.precioUnitario)+((pfc.cantidad*pfc.precioUnitario)*(pfc.comision/100)),0)-COALESCE(SUM((oc.cantidad*oc.precioUnitario)+((oc.cantidad*oc.precioUnitario)*(oc.comision/100))),0) AS saldosPf FROM spartodo_srs.tblprefacturasconceptos pfc LEFT JOIN spartodo_srs.tblordenesconceptos oc ON oc.idpfconcepto = pfc.idprefacturaconcepto LEFT JOIN spartodo_srs.tblordenesdeservicio os ON os.idorden = oc.idorden WHERE os.estado != 'DevolucionC' AND os.estado != 'Cancelada' AND  pfc.idprefacturaconcepto = {$filaTmp["idpfconcepto"]}";
					$resultadoSaldos = $this->conexion->query($consulta);
					while ($filaTmpSaldos = $resultadoSaldos->fetch_assoc()) 
					{
						if($filaTmpSaldos["saldosPf"] > 0)
						{
							$saldoTotalPf += $filaTmpSaldos["saldosPf"];
							if(!in_array($filaTmp["idprefactura"], $numPf))
							{
								array_push($numPf, $filaTmp["idprefactura"]);
								$contPfConceptos ++;
							}
						}
					}
				}
				return [$saldoTotalPf,$contPfConceptos];
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}
		public function actualizarEstado($idPf,$estado){

			$idPf = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPf))));
			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));	
  			$consulta="UPDATE spartodo_srs.tblprefacturas SET estado = '$estado' WHERE idprefactura = '$idPf'";
			$resultado = $this->conexion->query($consulta);

			if($resultado){
	            if($estado == 'ConciliadoC'){
          			$consulta = "UPDATE spartodo_srs.tblprefacturasconceptos pc LEFT JOIN spartodo_srs.tblordenesconceptos oc ON pc.idordconcepto = oc.idordconcepto SET oc.conceptocompleto = 0 WHERE pc.idprefactura = '$idPf'";
          			if($this->conexion->query($consulta)){
						return "OK";
          			}
          			else{
   						return $this->conexion->errno . " : " . $this->conexion->error . "\n";
          			}
           		}
           		return "OK";
			}
   			else{
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}


		public function __destruct() {

				mysqli_close($this->conexion);

  		}

	}

?>