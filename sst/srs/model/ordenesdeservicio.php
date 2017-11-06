<?php 
	class orden{
		
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

					$consulta = "SELECT count(*) AS total FROM spartodo_srs.tblordenesdeservicio c WHERE c.idcliente = '$idCliente' AND c.estado = '$estado' and ((c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal' and c.fechaFinal BETWEEN '$fechaInicial' AND '$fechaFinal')or(c.fechaInicial BETWEEN '$fechaInicial' AND '$fechaFinal') or ('$fechaInicial' BETWEEN c.fechaInicial AND c.fechaFinal))";

					$resultado = $this->conexion->query($consulta);

					$filaTmp = $resultado->fetch_assoc();

					$datosCount += $filaTmp["total"];

				}

			return $datosCount;

		}



   		public function listarOrdenes($datos){



			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idCliente']))));

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaInicial']))));	

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaFinal']))));		

  			$consulta="SELECT * FROM tblordenesdeservicio WHERE idcliente =".$idCliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."')or(fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (estado ='Autorizada') ";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$consulta = "SELECT os.idorden,cl.nombreComercial as clave, os.anio,os.fechaInicial, os.fechaFinal,os.norden, os.servicio, osc.idcotconcepto, osc.idpfconcepto, osc.idordconcepto, osc.concepto FROM tblordenesdeservicio os LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden = '".$filaTmp['idorden']."' ";

				$resultadoConceptos = $this->conexion->query($consulta);

				while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {

					$consultaCantidad = "SELECT (osc.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = osc.idordconcepto AND (pf.estado != 'Cancelada'))) AS cantidad FROM tblordenesconceptos osc WHERE osc.idcotconcepto = '".$filaTmpConcepto['idcotconcepto']."' AND osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

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



		public function datosOrden($idClientes,$estado,$fechaInicial,$fechaFinal){



			$datos = array();

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));

			foreach ($idClientes as $idCliente) {

				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));

				$consulta = "SELECT o.idorden,cl.nombreComercial, o.anio, o.norden,o.servicio, o.fechaInicial, o.fechaFinal,o.folio, o.estado, (SELECT SUM(total) as total FROM tblordenesconceptos WHERE idorden = o.idorden) as total,o.ejecucion FROM tblordenesdeservicio o LEFT JOIN tblclientes cl ON o.idcliente = cl.idclientes WHERE o.idcliente = '".$idCliente."' AND o.estado = '".$estado."' and ((o.fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and o.fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."')or(o.fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN o.fechaInicial AND o.fechaFinal))";

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



		public function datosOrdenes($idOrden){



			$idOrden = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idOrden))));	

  			$consulta="SELECT cl.nombreComercial as clave, os.anio, os.norden FROM spartodo_srs.tblordenesdeservicio os LEFT OUTER JOIN tblClientes cl ON os.idcliente = cl.idclientes WHERE idOrden = '$idOrden'";

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



		public function actualizarEstado($idOrden,$estado,$motivo,$fechaInicial,$fechaFinal){



			$idOrden = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idOrden))));	

			$estado = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($estado))));	

			$motivo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($motivo))));
			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));
			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

  			$consulta="UPDATE tblordenesdeservicio SET estado = '".$estado."', motivo = '".$motivo."', fechaEstado = '".date("Y-m-d")."',fechaInicial = '".$fechaInicial."', fechaFinal = '".$fechaFinal."' WHERE idorden = ".$idOrden;

			$resultado = $this->conexion->query($consulta);

			if($resultado){

				$estilo = "style=\"cursor: pointer; text-decoration:none; color: black;\"";

		        $imgAutorizar = "<img src=\"../img/imgBotonVerde16x16.png\">";

		        $imgPorAutorizar = "<img src=\"../img/imgBotonAmarillo16x16.png\">";

		       	$imgRechazar = "<img src=\"../img/imgBotonNegro16x16.png\">";

		        $imgCancelar = "<img src=\"../img/imgBotonRojo16x16.png\">";

		        $aAutorizar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$idOrden."\" estado=\"Autorizada\">".$imgAutorizar."Autorizar</a>";

		        $aPorAutorizar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$idOrden."\" estado=\"Por autorizar\">".$imgPorAutorizar."Por Autorizar</a>";

		        $aRechazar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$idOrden."\" estado=\"Rechazada\">".$imgRechazar."Rechazar</a>";

		        $aCancelar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$idOrden."\" estado=\"Cancelada\">".$imgCancelar."Cancelar</a>";

	            switch($estado) {

	              	case 'Por autorizar':

	                    $nuevoEstado = "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aRechazar."<br/>".$aCancelar."' data-placement='top' ><img src='../img/imgBotonAmarillo16x16.png'></a>";

	                break;

	                 

	              	case 'Autorizada':

	                  	$nuevoEstado = "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aPorAutorizar."<br/>".$aRechazar."<br/>".$aCancelar."' data-placement='top'><img src='../img/imgBotonVerde16x16.png'></a>";

	                break;



	              	case 'Rechazada':

	                  	$nuevoEstado = "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aPorAutorizar."<br/>".$aCancelar."' data-placement='top'><img src='../img/imgBotonNegro16x16.png'></a>";

	                break;



              		case 'Cancelada':

                  		$nuevoEstado = "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aRechazar."<br/>".$aPorAutorizar."' data-placement='top'><img src='../img/imgBotonRojo16x16.png'></a>";

                	break;

                    

		            default:

		                # code...

		             break; 

           		}

           		return $nuevoEstado;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function detalleConceptoOs($idOsConcepto){



			$idOsConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idOsConcepto))));	

  			$consulta="SELECT os.servicio,osc.cantidad,osc.tipoplan,osc.tiposervicio,osc.concepto,osc.precioUnitario,osc.comision,osc.total,osc.descripcion,os.fechaInicial,os.fechaFinal FROM spartodo_srs.tblordenesconceptos osc LEFT JOIN spartodo_srs.tblordenesdeservicio os ON os.idorden = osc.idorden WHERE osc.idordconcepto = '$idOsConcepto' AND osc.conceptocompleto = 0";

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



		public function detalleConceptoOsPf($idOsConcepto){



			$idOsConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idOsConcepto))));	

  			$consulta="SELECT pfc.idprefactura, pf.estado,pfc.cantidad as cantidadPf,pfc.concepto as conceptoPf,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.nombreComercial as clavePf, pf.anio as anioPf, pf.nprefactura FROM spartodo_srs.tblprefacturasconceptos pfc LEFT OUTER JOIN spartodo_srs.tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblClientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pfc.idordconcepto = '$idOsConcepto'";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {

					$datos[] = $filaTmp;

				}
				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		//



		public function datosConcepto($arrCotOs,$arrCotOsCon,$tipo){



			$datos = array();

			for ($i=0; $i<count($arrCotOs); $i++) {

				$idCotOs = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($arrCotOs[$i]))));	

				$idCotOsConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($arrCotOsCon[$i]))));

				if($tipo[$i] == "cot")

					$consulta = "SELECT (cc.cant) - (SELECT COALESCE(SUM(os.cantidad),0) FROM tblordenesdeservicio o LEFT OUTER JOIN tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idcotconcepto = cc.idcotconcepto AND (o.estado != 'Cancelada')) - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idcotconcepto = cc.idcotconcepto AND (pf.estado != 'Cancelada')) AS maximo,'cot' as tipo, cc.cant, cc.idcotizacion as id, cc.precio, cc.comision,cc.comisionagencia, cc.total,cc.tipoplan,cc.tiposervicio,cc.concepto,cc.descrip AS descripcion,cc.idconcepto,cl.nombreComercial AS clave,c.ncotizacion,c.anio FROM tblcotizaciones c LEFT OUTER JOIN tblcotizacionconceptos cc ON c.id = cc.idcotizacion LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE cc.idcotconcepto = '".$idCotOsConcepto."' AND cc.idcotizacion = '".$idCotOs."'";

				elseif($tipo[$i] == "os")

					$consulta = "SELECT (os.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = os.idordconcepto AND (pf.estado != 'Cancelada')))  AS maximo, 'os' as tipo, os.cantidad, os.idorden as id, os.precioUnitario as precio, os.comision as comisionagencia, os.total,os.tipoplan,os.tiposervicio,os.concepto,os.descripcion,os.idconcepto,cl.nombreComercial as clave,o.norden,o.anio FROM tblordenesdeservicio o LEFT OUTER JOIN tblordenesconceptos os ON o.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON o.idcliente = cl.idclientes WHERE os.idordconcepto = '".$idCotOsConcepto."' AND os.idorden = '".$idCotOs."'";

				$resultado = $this->conexion->query($consulta);

				if($resultado)

					$datos[] = $resultado->fetch_assoc();

				else

					break;

			}	

			if($resultado){

				//Ordenar

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



   		public function guardarOrden($datos){

   			require_once('clientes.php');

   			require_once('cotizaciones.php');

			$clientes = new clientes();

			$cotizacion = new cotizaciones();

			$tipo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tipo"]))));	

			$idCliente= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idCliente"]))));	

			$datosCliente = $clientes-> datosClienteEspecifico($idCliente);

			$clave= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosCliente["clave_cliente"]))));

  			$anio = date("y");

  			$servicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["servicio"]))));

  			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaInicial"]))));

  			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaFinal"]))));

  			$numOrden = $this->nOrden($clave); 

  			$norden = $numOrden["maxima"] + 1;

  			$importe = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(str_replace(',', '', $datos["importe"])))));

  			$realizo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["usuario"]))));

  			$consultaPrincipal = "INSERT INTO tblordenesdeservicio (idcliente, anio, fechaInicial, fechaFinal, norden, importe, realizo, servicio,estado, ejecucion, elaboracion ) VALUES('".$idCliente."','".$anio."','".$fechaInicial."','".$fechaFinal."','".$norden."','".$importe."','".$realizo."','".$servicio."','Por autorizar','noejecutandose','".date("Y-m-d")."'); ";

			$resultado = $this->conexion->query($consultaPrincipal);

			$idOrden = $this->conexion->insert_id;

			$consulta = "";

			for ($i=0; $i < count($datos["conceptos"]); $i++) {

				$idCotConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idcotconceptos"][$i]))));

	  			$idConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idconceptos"][$i]))));

	  			$concepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["conceptos"][$i]))));

	  			$descripcion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["descripciones"][$i]))));

				$tipoPlan = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tiposPlan"][$i]))));

	  			$tipoServicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["tiposServicio"][$i]))));

	  			$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cantidad"][$i]))));

				$precio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["precios"][$i]))));

	  			$comision = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["comisiones"][$i]))));

	  			$total = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["subtotales"][$i]))));

				$valores[] = "('".$idOrden."','".$idCotConcepto."','".$idConcepto."','".$concepto."','".$tipoPlan."','".$tipoServicio."','".$cantidad."','".$precio."','".$comision."','".$total."','".$descripcion."')";

			}

			if($tipo == "cot")

				$consulta .= "INSERT INTO tblordenesconceptos (idorden, idcotconcepto, idconcepto, concepto, tipoplan, tiposervicio, cantidad, precioUnitario, comision, total,descripcion) VALUES ";

			elseif ($tipo == "pf") 

				$consulta .= "INSERT INTO tblordenesconceptos (idorden, idpfconcepto, idconcepto, concepto, tipoplan, tiposervicio, cantidad, precioUnitario, comision, total,descripcion) VALUES ";

			$consulta = $consulta.implode(",", $valores);

			$consulta .= "; ";

			$resultado = $this->conexion->multi_query($consulta);

			if($resultado){

				$folio = "OS-".$clave."-".$anio."-".$norden;

				return $folio;

			}

   			elseif (!$this->conexion->query($consultaPrincipal)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}



		public function nOrden($clave){

			$clave= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($clave))));	

  			$consulta = "SELECT COALESCE(MAX(o.norden),0) as maxima FROM tblordenesdeservicio o LEFT OUTER JOIN tblclientes cl ON o.idcliente = cl.idclientes WHERE cl.nombreComercial = '".$clave."' AND o.anio = '".date("y")."'";

			$resultado = $this->conexion->query($consulta);

			$datos =  $resultado->fetch_assoc();

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

		}





		public function maximoConcepto($idCotPfConcepto,$tabla,$idOrden){



			$idCotPfConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCotPfConcepto))));	

			$tabla = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($tabla))));	

			switch ($tabla) {

				case 'cot':

  					$consulta="SELECT idcotizacion FROM tblcotizacionconceptos WHERE idcotconcepto = '".$idCotPfConcepto."'";

  					$resultado = $this->conexion->query($consulta);

					$datos =  $resultado->fetch_assoc();

					$idCotizacion = $datos["idcotizacion"];

					$consulta = "SELECT (cc.cant) - (SELECT COALESCE(SUM(os.cantidad),0) FROM tblordenesdeservicio o LEFT OUTER JOIN tblordenesconceptos os ON o.idorden = os.idorden WHERE idcotconcepto = cc.idcotconcepto AND o.estado != 'Cancelada' AND o.estado != 'DevolucionC' AND o.idorden != '".$idOrden."') - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idcotconcepto = cc.idcotconcepto AND (pf.estado != 'Cancelada')) AS maximo FROM tblcotizacionconceptos cc WHERE cc.idcotconcepto = '".$idCotPfConcepto."' AND cc.idcotizacion = '".$idCotizacion."'";

					$resultado = $this->conexion->query($consulta);

					$datos =  $resultado->fetch_assoc();

					return  $datos ["maximo"];

					break;



				case 'pf':

  					$consulta="SELECT idprefactura FROM tblprefacturasconceptos WHERE idprefacturaconcepto = '".$idCotPfConcepto."'";

  					$resultado = $this->conexion->query($consulta);

					$datos =  $resultado->fetch_assoc();

					$idPrefactura= $datos["idprefactura"];

					$consulta = "SELECT (pfc.total - (SELECT COALESCE(SUM(os.total),0) FROM tblordenesdeservicio o LEFT OUTER JOIN tblordenesconceptos os ON o.idorden = os.idorden WHERE os.idpfconcepto = pfc.idprefacturaconcepto AND (o.estado != 'Cancelada' AND o.estado != 'DevolucionC' AND o.idorden != '".$idOrden."')))  AS maximo, pfc.cantidad, pfc.idprefactura as id, pfc.precioUnitario as precio, pfc.comision as comisionagencia, pfc.total,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.idconcepto,c.precio as precioConcepto FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblconceptos c ON pfc.idconcepto = c.id  WHERE pfc.idprefacturaconcepto = '".$idCotPfConcepto."' AND pfc.idprefactura = '".$idPrefactura."'";

					$resultado = $this->conexion->query($consulta);

					$datos =  $resultado->fetch_assoc();

					return  $datos ["maximo"];

					break;

				default:

					# code...

					break;

			}

			

		}

		

		public function actualizarOrden($idOrden, $servicio, $fechaInicial, $fechaFinal, $total){

			$idOrden = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idOrden))));

			$servicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($servicio))));

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			$total = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($total))));

 			$consulta = "UPDATE tblordenesdeservicio SET servicio = '".$servicio."', fechaInicial = '".$fechaInicial."', fechaFinal = '".$fechaFinal."', importe = '".$total."', elaboracion = '".date('Y-m-d')."', estado = 'Por autorizar' WHERE idorden = '".$idOrden."'";

			$resultado = $this->conexion->query($consulta);

			if($resultado){

				return true;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

		}



		public function actualizarOrdenConcepto($datos){

			$idOrdenConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idOrdenConcepto"]))));	

			$cantidad = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["cantidad"]))));	

			$precioUnitario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["precioUnitario"]))));

			$subtotal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["subtotal"]))));	

  			$consulta = "UPDATE tblordenesconceptos SET cantidad = '".$cantidad."', precioUnitario = '".$precioUnitario."', total = '".$subtotal."' WHERE idordconcepto = '".$idOrdenConcepto."'";

			$resultado = $this->conexion->query($consulta);

			if($resultado){

				return true;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

		}



		public function ordenEspecifica($idOrdenEspecifica)

		{

			$idOrdenEspecifica = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrdenEspecifica))));

			$consulta = "SELECT o.realizo,o.fechaInicial,o.fechaFinal,o.anio,o.norden,o.estado,o.ejecucion,o.idorden,o.servicio,o.numeropoliza,o.motivo,o.folio,cl.nombreComercial as clave FROM tblordenesdeservicio o LEFT OUTER JOIN tblclientes cl ON o.idcliente = cl.idclientes WHERE idorden=".$idOrdenEspecifica;

			$resultado = $this->conexion->query($consulta);

			$datos=$resultado->fetch_assoc();

			if($resultado)

				return $datos;

			elseif (!$this->conexion->query($consulta))

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";



		}



		public function conceptosOrden($idOrdenEspecifica)

		{

			$idOrdenEspecifica = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrdenEspecifica))));

			$consulta = "SELECT idcotconcepto, idpfconcepto FROM tblordenesconceptos WHERE idorden=".$idOrdenEspecifica;

			$resultado= $this->conexion->query($consulta);

			if($resultado)

				return $datos=$resultado->fetch_assoc();

			elseif (!$this->conexion->query($consulta))

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

		}



		public function listarConceptosOrden($idOrdenEspecifica)

		{

			$datos=array();

			$idOrdenEspecifica = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrdenEspecifica))));

			$consulta = "SELECT idordconcepto, idcotconcepto, idpfconcepto,cantidad,tipoplan,descripcion, tiposervicio,idconcepto, concepto, precioUnitario,comision,total FROM tblordenesconceptos WHERE idorden=".$idOrdenEspecifica;

			$resultado= $this->conexion->query($consulta);

			while($datosCon=$resultado->fetch_assoc())

			{

				$datos[]=$datosCon;

			}

			if (!$this->conexion->query($consulta))

	   			$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";

	   		return $datos;

		}



		public function sumaConceptosOrden($idOrdenEspecifica)

		{

			$idOrdenEspecifica=$this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrdenEspecifica))));

			$consulta="SELECT SUM(precioUnitario * cantidad) as totalPu, SUM((cantidad * precioUnitario) * (1*(comision/100))) as totalCa, SUM(total) as totalT from tblordenesconceptos where idorden =".$idOrdenEspecifica;

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos=$resultado->fetch_assoc();

			elseif (!$this->conexion->query($consulta)) {

				$datos=null;

			}

			return $datos;

		}

		public function agregarNumeroPoliza($idOrden,$numeroPoliza,$numeroFolio)

		{

			$idOrden=$this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrden))));

			$numeroPoliza=$this->conexion->real_escape_string($numeroPoliza);

			$numeroFolio=$this->conexion->real_escape_string($numeroFolio);

			if($numeroPoliza != "")

			{

				$consulta = "UPDATE tblordenesdeservicio SET ejecucion='ejecutandose',numeropoliza='".$numeroPoliza."',folio='".$numeroFolio."' WHERE idorden=".$idOrden;

			}

			else

			{

				$consulta = "UPDATE tblordenesdeservicio SET ejecucion='noejecutandose',numeropoliza='".$numeroPoliza."',folio='".$numeroFolio."' WHERE idorden=".$idOrden;

			}

			$resultado=$this->conexion->query($consulta);

			if($resultado)

				$datos="Número de póliza actual: ".$numeroPoliza. " \n Folio actual: ".$numeroFolio;

			else

				$datos=null;

			return $datos;

		}

		public function autorizarOrden($idOrden,$estadoOrden,$motivoCotizacion)

		{

			$idOrden=$this->conexion->real_escape_string(strip_tags(stripslashes(trim($idOrden))));

			$estadoOrden=$this->conexion->real_escape_string($estadoOrden);

			$motivoCotizacion=$this->conexion->real_escape_string($motivoCotizacion);

			if(!empty($motivoCotizacion))

				$consulta = "UPDATE tblordenesdeservicio SET estado = '".$estadoOrden."', motivo = '', fechaEstado = '".date("Y-m-d")."' where idorden = ".$idOrden;

			else

				$consulta = "UPDATE tblordenesdeservicio SET estado = '".$estadoOrden."', motivo = '".$motivoCotizacion."' where idorden = ".$idOrden;



			$resultado=$this->conexion->query($consulta);

			if($resultado)

			{

				switch ($estadoOrden) 

				{

					case 'Por autorizar':

						$datos = "../img/imgBotonAmarillo16x16.png-imgEstadoOrdenpAutorizar";

						break;



					case 'Autorizada':

						$datos = "../img/imgBotonVerde16x16.png-imgEstadoOrdenAutorizada";

						break;



					case 'Rechazada':

						$datos = "../img/imgBotonNegro16x16.png-imgEstadoOrdenRechazada";

						break;



					case 'Cancelada':

						$datos = "../img/imgBotonRojo16x16.png-imgEstadoOrdenCancelada";

						break;

					

					default:

						# code...

						break;

				}

			}

			else

				$datos=null;

			return $datos;

		}

		public function ordenesPorFacturarClientes($idClientes,$fechaBusqueda,$usuario){

			$datos = array();
			$idordconcepto = array();
			foreach ($idClientes as $idCliente) {
	            $idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente)))); 
	            $idsClientes[] = $idCliente;
	        }

            $subconsulta = "";
            $subconsulta = implode(",", $idsClientes); 
			$fechaBusqueda = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaBusqueda))));	
			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));			
			$clientes = array();
  			$consulta="SELECT os.idorden,osc.idordconcepto,osc.idcotconcepto,cl.idclientes,cl.rfc,concat(cl.razon_soc,' | ',cl.rfc,' | ',cl.nom_comercial) AS cliente, cl.nombreComercial FROM tblclientes cl LEFT JOIN tblordenesdeservicio os ON os.idcliente = cl.idclientes LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden WHERE os.idcliente IN (".$subconsulta.") AND '".$fechaBusqueda."' > os.fechaInicial AND os.estado ='Autorizada' AND osc.conceptocompleto = 0 AND osc.idpfconcepto IS NULL";
			$resultado = $this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) 
			{
				$consultaCantidad = "SELECT (osc.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = osc.idordconcepto AND pfc.idorden = osc.idorden AND (pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC'))) AS cantidad FROM tblordenesconceptos osc WHERE osc.idcotconcepto = '".$filaTmp['idcotconcepto']."' AND osc.idordconcepto = '".$filaTmp['idordconcepto']."'";
					$resultadoCantidad = $this->conexion->query($consultaCantidad);
					$cantidad = $resultadoCantidad->fetch_array();
					if($cantidad["cantidad"] > 0 )
					{
						if(!in_array($filaTmp["idclientes"],$clientes)){
							array_push($clientes,$filaTmp["idclientes"]);
							$datos[] = $filaTmp;
						}
					}
					else if($cantidad["cantidad"] == 0)
					{
						if(!in_array($filaTmp['idordconcepto'], $idordconcepto))
						{
							array_push($idordconcepto,$filaTmp['idordconcepto']);
							$consulta = "UPDATE tblordenesconceptos SET conceptocompleto = 1 where idordconcepto = ".$filaTmp['idordconcepto'];
							$this->conexion->query($consulta);

						}
						
					}

			}

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}
		public function ordenesPorFacturar($idCliente,$fechaBusqueda,$usuario,$añoBusqueda)
		{
			if(is_array($idCliente))
			{
				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim(implode(",",$idCliente)))));
				$subConsulta = "IN (".$idCliente.")";
			}
			else
			{
	        	$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
	        	$subConsulta = " = ".$idCliente; 
			}
			$fechaBusqueda = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaBusqueda))));	
			$añoBusqueda = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($añoBusqueda))));	
			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));			
  			$consulta = "SELECT os.idorden,cl.nombreComercial as clave, os.anio,os.fechaInicial, os.fechaFinal,os.norden, os.servicio, osc.idcotconcepto, osc.idpfconcepto, osc.idordconcepto, osc.concepto FROM tblClientes cl LEFT JOIN spartodo_srs.tblordenesdeservicio os ON os.idcliente = cl.idclientes LEFT OUTER JOIN spartodo_srs.tblordenesconceptos osc ON os.idorden = osc.idorden WHERE os.idcliente $subConsulta AND os.anio = '$añoBusqueda' AND '$fechaBusqueda' > os.fechaInicial AND os.estado ='Autorizada' AND osc.conceptocompleto = 0 AND osc.idpfconcepto IS NULL";
			$resultado = $this->conexion->query($consulta);
			$datos = array();

			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) 
				{
					
					$consultaCantidad = "SELECT (osc.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM spartodo_srs.tblprefacturas pf LEFT OUTER JOIN spartodo_srs.tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = osc.idordconcepto AND pfc.idorden = osc.idorden AND (pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC'))) AS cantidad FROM spartodo_srs.tblordenesconceptos osc WHERE osc.idcotconcepto = '".$filaTmp['idcotconcepto']."' AND osc.idordconcepto = '".$filaTmp['idordconcepto']."'";
						$resultadoCantidad = $this->conexion->query($consultaCantidad);
						$cantidad = $resultadoCantidad->fetch_assoc();
							
						if($cantidad["cantidad"] > 0 )
							$datos[] = $filaTmp;


				}


				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}
		public function ordensPorFacturarClientesSaldos($idClientes,$fechaBusqueda,$usuario)
		{
			$datosOS = array();
			$datosConceptos = array();
			$idordconcepto = array();

			foreach ($idClientes as $idCliente) 
			{
	            $idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente)))); 
	            $idsClientes[] = $idCliente;
	        }

            $subconsulta = "";
            $subconsulta = implode(",", $idsClientes); 
			$fechaBusqueda = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaBusqueda))));	
			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));			
			$clientes = array();

  			$consulta="SELECT os.idorden,cl.idclientes,cl.rfc,concat(cl.razon_soc,' | ',cl.rfc,' | ',cl.nom_comercial) AS cliente, cl.nombreComercial FROM tblclientes cl LEFT JOIN tblordenesdeservicio os ON os.idcliente = cl.idclientes WHERE os.idcliente IN (".$subconsulta.") and '".$fechaBusqueda."' > os.fechaInicial and os.estado ='Autorizada'";
			$resultado = $this->conexion->query($consulta);
			while ($filaTmp = $resultado->fetch_assoc()) 
			{
				$consulta = "SELECT os.idorden,cl.nombreComercial as clave, os.anio,os.fechaInicial, os.fechaFinal,os.norden, os.servicio, osc.idcotconcepto, osc.idpfconcepto, osc.idordconcepto, osc.concepto FROM tblordenesdeservicio os LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden = '".$filaTmp['idorden']."' AND osc.conceptocompleto = 0 AND osc.idpfconcepto IS NULL";
				$resultadoConceptos = $this->conexion->query($consulta);
				while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) 
				{
					$consultaCantidad = "SELECT (osc.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = osc.idordconcepto AND pfc.idorden = osc.idorden AND (pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC'))) AS cantidad FROM tblordenesconceptos osc WHERE osc.idcotconcepto = '".$filaTmpConcepto['idcotconcepto']."' AND osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";
					$resultadoCantidad = $this->conexion->query($consultaCantidad);
					$cantidad = $resultadoCantidad->fetch_array();
					if($cantidad["cantidad"] > 0 )
					{
						if(!in_array($filaTmp["idclientes"],$clientes)){
							array_push($clientes,$filaTmp["idclientes"]);
							$datosOS[] = $filaTmp;
						}
						$datosConceptos[] = $filaTmpConcepto;
					}
					else if($cantidad["cantidad"] <= 0)
					{
						if(!in_array($filaTmpConcepto['idordconcepto'], $idordconcepto))
						{
							array_push($idordconcepto,$filaTmpConcepto['idordconcepto']);
							$consulta = "UPDATE tblordenesconceptos SET conceptocompleto = 1 where idordconcepto = ".$filaTmpConcepto['idordconcepto'];
							$this->conexion->query($consulta);

						}
						
					}

				}

			}

			if($resultado){

				return [$datosOS,$datosConceptos];

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}
		}

		public function __destruct() {

				mysqli_close($this->conexion);

  		}

	}

?>