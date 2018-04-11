<?php 
	require_once('../db/conectadb.php');
	
	class reportes{



		protected $acceso;

 		protected $conexion;



		public function __construct() {

			$this->acceso = new accesoDB(); 

 		 	$this->conexion = $this->acceso->conDB();

   		} 

   		public function reporteVentas($datos,$campos,$fInicial,$fFinal){
			ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	        header("Content-Disposition: attachment; filename=ReporteVentas.csv");
			header("Content-Type: application/vnd.ms-excel;");
			header("Pragma: no-cache");
			header("Expires: 0");


			$fInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fInicial))));
			$fFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fFinal))));
		    $fInicial = date('Y-m-d', strtotime($fInicial));
		    $fFinal = date('Y-m-d', strtotime($fFinal));

   			foreach ($datos as $dato) {
               $idOrden = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idorden"])))); 
               $idsOrdenes[] = $idOrden;
            }

            $subconsulta = "";
            $subconsulta = implode(",", $idsOrdenes);	

			$listaCampos = array();
			$idsPrefacturasConceptos = array();
			$idsPfConceptos = array();
			$idsOrdConceptos = array();
			$descuentos = array();
			$idConciliaciones = array();

			$consulta = "SELECT osc.idpfconcepto, osc.idordconcepto FROM tblordenesdeservicio os LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden WHERE os.idorden IN (".$subconsulta.")";
			// echo $consulta;

			$resultadoConceptos = $this->conexion->query($consulta);
			$out = fopen("php://output", 'w');  
			
			foreach ($campos as $campo) {
				switch ($campo) 
				{
					case 'CLIENTE':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA INICIAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA FINAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ORDEN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PREFACTURA': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo))));
									   $listaCampos[] = "FECHA FACTURACION";	break;
					case 'CFDI': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CONCEPTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CANTIDAD': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO UNITARIO':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO TOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN ($)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN (%)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'SUBTOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE PLAN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE SERVICIO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ELABORÓ':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ESTADO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'MOTIVO DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					default: /*nada...*/ break;
				}
			}
			
			fputcsv($out,array_map("utf8_decode",$listaCampos));
			while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {
				$datosCamposOrden = array();
				$consulta="SELECT os.fechaInicial,os.fechaFinal,os.norden,os.anio,osc.cantidad,os.realizo,cl.clave_cliente,osc.tipoplan,osc.tiposervicio,osc.concepto,osc.precioUnitario,osc.comision,osc.total,osc.descripcion FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";
					$resultado = $this->conexion->query($consulta); 
					$datosOrden = $resultado->fetch_array();
					$subtotal = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100));
				foreach ($campos as $campo) {
					switch ($campo) 
					{
						case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
						case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
						case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
						case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
						case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
						case 'CFDI': $datosCamposOrden[] = ""; break;
						case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
						case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
						case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
						case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
						case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
						case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
						case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
						case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
						case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
						case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
						case 'ESTADO': $datosCamposOrden[] = "OS AUTORIZADA DEL PERIODO"; break;
						case 'DESCUENTO': $datosCamposOrden[] = ""; break;
						case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
						default: /*nada...*/ break;
					}
				}
				fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
				if(is_null($filaTmpConcepto["idpfconcepto"])){ // Caso abc

					$consulta="SELECT pf.estado,pfc.idprefacturaconcepto,pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.descuento,pf.motivodescuento,pf.cfdi FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pfc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

						$resultado = $this->conexion->query($consulta);
					if($resultado->num_rows != 0){	
						$sumCantidad = 0;	
						$sumSubtotal = 0;
						while ($datosConceptoPrefactura = $resultado->fetch_assoc()) {

							array_push($idsPfConceptos,$datosConceptoPrefactura['idprefacturaconcepto']);
							//Saber tipo de facturado (en el periodo o antes)
								$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechacfdi"]));
							    //echo $paymentDate; // echos today! 
							    if($datosConceptoPrefactura["estado"] !== 'Conciliado' && $datosConceptoPrefactura["estado"] !== 'ConciliadoA' && $datosConceptoPrefactura["estado"] !== 'ConciliadoR'){
							    	$tipo_doc = "PF";
									if(($fechaFactura < $fInicial) && !empty($datosConceptoPrefactura["cfdi"]))
								    {
								      $tipo = "FACTURACION DEL PERIODO ANTERIOR";
								    }
								    if(($fechaFactura >= $fInicial) && ($fechaFactura <= $fFinal))
								    {
								      $tipo = "FACTURACION DEL PERIODO";
								    }
								    if(($fechaFactura > $fFinal) || empty($datosConceptoPrefactura["cfdi"]))
								    {
								      $tipo = "OS POR FACTURAR";  
								    }
								}
								else{
									array_push($idConciliaciones, $datosConceptoPrefactura["idprefacturaconcepto"]);
									$tipo_doc = "CL";
								    $tipo = "CONCILIACION";  
									$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechaInicial"]));
								    if(($fechaFactura > $fFinal))
								    {
								      $tipo = "OS POR FACTURAR";  
								    }
								}

							//Fin tipo de facturado (en el periodo o antes)



							if(!in_array($datosConceptoPrefactura['idprefactura'], $descuentos) && $tipo === "FACTURACION DEL PERIODO")
							{
								$descuentoAbc = $datosConceptoPrefactura["descuento"];
								$motivoAbc = $datosConceptoPrefactura["motivodescuento"];
								array_push($descuentos,$datosConceptoPrefactura['idprefactura']);
							}
							else{
								$descuentoAbc = "";
								$motivoAbc = "";
							}
							$datosCamposPrefactura = array();
							$sumCantidad += $datosConceptoPrefactura["cantidadPf"];
							$sumSubtotal += $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
									case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
									case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];
													   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];	break;
									case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
									case 'CANTIDAD': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]; break;
									case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosConceptoPrefactura["precioUnitarioPf"]; break;
									case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]; break;
									case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*($datosConceptoPrefactura["comisionPf"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
									case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
									case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
									case 'DESCUENTO': $datosCamposPrefactura[] =  $descuentoAbc; break;
									case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] =  $motivoAbc; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
						}

						if($sumCantidad < $datosOrden["cantidad"] && ($sumSubtotal < ($subtotal + .05))){
							$datosCamposOrden = array();
							$disponible = $datosOrden["cantidad"] - $sumCantidad;
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
									case 'CFDI': $datosCamposOrden[] = ""; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $disponible; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $disponible*$datosOrden["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($disponible*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($disponible*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = "OS POR FACTURAR"; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}

					}
					else{

						$datosCamposOrden = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
								case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
								case 'CFDI': $datosCamposOrden[] = ""; break;
								case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
								case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
								case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
								case 'ESTADO': $datosCamposOrden[] = "OS POR FACTURAR"; break;
								case 'DESCUENTO': $datosCamposOrden[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
								default: /*nada...*/ break;
							}
						}						
						fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
					}
				}
				else //Caso acb 
				{
					// if(!in_array($filaTmpConcepto['idpfconcepto'], $idsPrefacturasConceptos))
					// { EMPIEZA PREFACTURA ORIGINAL (FALTARIA OS POR REALIZAR SI ES QUE QUEDARA SALDO)
						array_push($idsPrefacturasConceptos,$filaTmpConcepto['idpfconcepto']);
						$consulta="SELECT pfc.idprefacturaconcepto,pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.estado, pf.nprefactura, pf.realizo,pf.cfdi,pf.descuento,pf.motivodescuento FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pfc.idprefacturaconcepto = '".$filaTmpConcepto['idpfconcepto']."'";

						$resultado = $this->conexion->query($consulta);
						$datosConceptoPrefactura = $resultado->fetch_assoc();
						$datosCamposPrefactura = array();

						array_push($idsPfConceptos,$datosConceptoPrefactura['idprefacturaconcepto']);
						//Saber tipo de facturado (en el periodo o antes)
						$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechacfdi"]));
					    //echo $paymentDate; // echos today! 

						if($datosConceptoPrefactura["estado"] !== 'Conciliado' && $datosConceptoPrefactura["estado"] !== 'ConciliadoA' && $datosConceptoPrefactura["estado"] !== 'ConciliadoR'){
							$tipo_doc = "PF";
							if(($fechaFactura < $fInicial) && !empty($datosConceptoPrefactura["cfdi"]))
						    {
						      $tipo = "FACTURACION DEL PERIODO ANTERIOR";
						    }
						    if(($fechaFactura >= $fInicial) && ($fechaFactura <= $fFinal))
						    {
						      $tipo = "FACTURACION DEL PERIODO";
						    }
						    if(($fechaFactura > $fFinal) || empty($datosConceptoPrefactura["cfdi"]))
						    {
						      $tipo = "OS POR FACTURAR";  
						    }
						}
						else{
							array_push($idConciliaciones, $datosConceptoPrefactura["idprefacturaconcepto"]);
							$tipo_doc = "CL";
							$tipo = "CONCILIACION";
							if(($fechaFactura > $fFinal))
						    {
							  $fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechaInicial"]));
						      $tipo = "OS POR FACTURAR";  
						    }
						}

						//Fin tipo de facturado (en el periodo o antes)
						if(!in_array($datosConceptoPrefactura['idprefactura'], $descuentos) && $tipo === "FACTURACION DEL PERIODO")
						{
							$descuentoAcb = $datosConceptoPrefactura["descuento"];
							$motivoAcb = $datosConceptoPrefactura["motivodescuento"];
							array_push($descuentos,$datosConceptoPrefactura['idprefactura']);
						}
						else{
							$descuentoAcb = "";
							$motivoAcb = "";
						}

						//TEMPORAL 
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
								case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
								case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
												   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];break;
								case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
								case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
								case 'CANTIDAD': $datosCamposPrefactura[] = $datosOrden["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosOrden["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosOrden["comision"]; break;
								case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
								case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
								case 'DESCUENTO': $datosCamposPrefactura[] = $descuentoAcb; break;
								case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $motivoAcb; break;
								default: /*nada...*/ break;
							}
						}
						fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));

						//FIN TEMPORAL 
				}
			}

			//IMPRIMIR LAS CONCILIACIONES EN EL PERIODO SELECCIONADO
			$consulta="SELECT o.fechaInicial as osFechaInicial, o.fechaFinal as osFechaFinal, CONCAT('OS-',cl.clave_cliente,'-',o.anio,'-',o.norden) as folioOs,pf.estado,pfc.idprefacturaconcepto,pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.descuento,pf.motivodescuento,pf.cfdi FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblordenesconceptos os ON pfc.idordconcepto = os.idordconcepto LEFT OUTER JOIN tblordenesdeservicio o ON os.idorden = o.idorden LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado LIKE '%Conciliado%' AND pf.estado != 'ConciliadoC' AND (pf.fechaInicial BETWEEN '$fInicial' AND '$fFinal')";

			$resultado = $this->conexion->query($consulta);
			while ($datosConceptoConciliacion = $resultado->fetch_assoc()) {
				$datosCamposConciliacion = array();
				$subtotal = $datosConceptoConciliacion["cantidadPf"]*$datosConceptoConciliacion["precioUnitarioPf"]*(1+($datosConceptoConciliacion["comisionPf"]/100));
				if(!in_array($datosConceptoConciliacion["idprefacturaconcepto"], $idConciliaciones)){
					foreach ($campos as $campo) {
						switch ($campo) 
						{
							case 'CLIENTE':	$datosCamposConciliacion[] = $datosConceptoConciliacion["clavePf"]; break;
							case 'FECHA INICIAL': $datosCamposConciliacion[] = $datosConceptoConciliacion["fechaInicial"]; break;
							case 'FECHA FINAL': $datosCamposConciliacion[] = ""; break;
							case 'ORDEN': $datosCamposConciliacion[] = $datosConceptoConciliacion["folioOs"]; break;
							case 'PREFACTURA': $datosCamposConciliacion[] = "CL-".$datosConceptoConciliacion["clavePf"]."-".$datosConceptoConciliacion["anioPf"]."-".$datosConceptoConciliacion["nprefactura"]; $datosCamposConciliacion[] = "";	break;
							case 'CFDI': $datosCamposConciliacion[] = ""; break;
							case 'CONCEPTO': $datosCamposConciliacion[] = $datosConceptoConciliacion["conceptoPf"]; break;
							case 'CANTIDAD': $datosCamposConciliacion[] = $datosConceptoConciliacion["cantidadPf"]; break;
							case 'PRECIO UNITARIO':	$datosCamposConciliacion[] = $datosConceptoConciliacion["precioUnitarioPf"]; break;
							case 'PRECIO TOTAL': $datosCamposConciliacion[] = $datosConceptoConciliacion["cantidadPf"]*$datosConceptoConciliacion["precioUnitarioPf"]; break;
							case 'COMISIÓN ($)': $datosCamposConciliacion[] = number_format($datosConceptoConciliacion["cantidadPf"]*$datosConceptoConciliacion["precioUnitarioPf"]*($datosConceptoConciliacion["comisionPf"]/100),2); break;
							case 'COMISIÓN (%)': $datosCamposConciliacion[] = $datosConceptoConciliacion["comisionPf"]; break;
							case 'SUBTOTAL': $datosCamposConciliacion[] = number_format($subtotal,2); break;
							case 'TIPO DE PLAN': $datosCamposConciliacion[] = $datosConceptoConciliacion["tipoplan"]; break;
							case 'TIPO DE SERVICIO': $datosCamposConciliacion[] = $datosConceptoConciliacion["tiposervicio"]; break;
							case 'ELABORÓ':	$datosCamposConciliacion[] = $datosConceptoConciliacion["realizo"]; break;
							case 'ESTADO': $datosCamposConciliacion[] = "CONCILIACION"; break;
							case 'DESCUENTO': $datosCamposConciliacion[] = ""; break;
							case 'MOTIVO DESCUENTO': $datosCamposConciliacion[] = ""; break;
							default: /*nada...*/ break;
						}
					}
					fputcsv($out,array_map("utf8_decode",$datosCamposConciliacion));
				}
			}

			// FIN IMPRIMIR LAS CONCILIACIONES EN EL PERIODO SELECCIONADO 


			//IMPRIMIR LAS FACTURAS CON DESCUENTO EN EL PERIODO SELECCIONADO
			$consulta="SELECT o.fechaInicial as osFechaInicial, o.fechaFinal as osFechaFinal, CONCAT('OS-',cl.clave_cliente,'-',o.anio,'-',o.norden) as folioOs,pf.estado,pfc.idprefacturaconcepto,pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.descuento,pf.motivodescuento,pf.cfdi FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblordenesconceptos os ON pfc.idordconcepto = os.idordconcepto LEFT OUTER JOIN tblordenesdeservicio o ON os.idorden = o.idorden LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado = 'FACTURADA' AND pf.descuento > 0.00 AND (pf.fechacfdi BETWEEN '$fInicial' AND '$fFinal')  GROUP BY pf.idprefactura";

			$resultado = $this->conexion->query($consulta);
			while ($datosConceptoPrefactura = $resultado->fetch_assoc()) {
				$datosCamposPrefactura = array();
				$subtotal = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100));
				// if(!in_array($datosConceptoPrefactura["idprefacturaconcepto"], $idsPfConceptos)){
					foreach ($campos as $campo) {
						switch ($campo) 
						{
							case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
							case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["osFechaInicial"]; break;
							case 'FECHA FINAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["osFechaFinal"]; break;
							case 'ORDEN': $datosCamposPrefactura[] = $datosConceptoPrefactura["folioOs"]; break;
							case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"]; $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];	break;
							case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
							case 'CONCEPTO': $datosCamposPrefactura[] = "Descuento"; break;
							case 'CANTIDAD': $datosCamposPrefactura[] = ""; break;
							case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = ""; break;
							case 'PRECIO TOTAL': $datosCamposPrefactura[] = ""; break;
							case 'COMISIÓN ($)': $datosCamposPrefactura[] = ""; break;
							case 'COMISIÓN (%)': $datosCamposPrefactura[] = ""; break;
							case 'SUBTOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["descuento"]; break;
							case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
							case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
							case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
							case 'ESTADO': $datosCamposPrefactura[] = "DESCUENTOS DEL PERIODO"; break;
							case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
							case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["motivodescuento"]; break;
							default: /*nada...*/ break;
						}
					}
					fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
				// }
			}

			// FIN IMPRIMIR  LAS FACTURAS CON DESCUENTO EN EL PERIODO SELECCIONADO 







			fclose($out);
		}

		public function datosFactura($idClientes,$fechaInicial,$fechaFinal){



			$datos = array();

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			foreach ($idClientes as $idCliente) {
				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente)))); 
               	$idsClientes[] = $idCliente;
            }

            $subconsulta = "";
            $subconsulta = implode(",", $idsClientes);

			$consulta = "SELECT pf.idprefactura,cl.clave_cliente, pf.anio, pf.nprefactura,pf.detalle, pf.fechaInicial, pf.estado,pf.cfdi, (SELECT SUM(total) as total FROM tblprefacturasconceptos WHERE idprefactura = pf.idprefactura) - pf.descuento as total FROM tblprefacturas pf LEFT JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente IN (".$subconsulta.") AND pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pf.cfdi IS NOT NULL AND TRIM(pf.cfdi) != '' AND ((pf.fechacfdi BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (pf.fechacfdi BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'))";

				$resultado = $this->conexion->query($consulta);

				if($resultado){

					while ($filaTmp = $resultado->fetch_assoc()) {

						$datos[] =  $filaTmp;

					}

				}

				else{

					return $this->conexion->errno . " : " . $this->conexion->error . "\n";

				}

			

			return $datos;

		}


		public function reporteFacturacion($datos,$campos,$fInicial,$fFinal){
			ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	        header("Content-Disposition: attachment; filename=ReporteFacturacion.csv");
			header("Content-Type: application/vnd.ms-excel;");
			header("Pragma: no-cache");
			header("Expires: 0");

			$fInicial = date('Y-m-d', strtotime($fInicial));
		    $fFinal = date('Y-m-d', strtotime($fFinal));
		    $idDevoluciones = array();

   			foreach ($datos as $dato) {
               $idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idprefactura"])))); 
               $idsPrefacturas[] = $idPrefactura;
            }

            $subconsulta = "";
            $subconsulta = implode(",", $idsPrefacturas);
			$idsOrdenesConceptos = array();	

			$listaCampos = array();

			$pfDescuentos = array();

			$consulta = "SELECT pfc.idprefacturaconcepto, pfc.idordconcepto FROM tblprefacturasconceptos pfc WHERE pfc.idprefactura IN (".$subconsulta.")";
			// echo $consulta;

			$resultadoConceptos = $this->conexion->query($consulta);
			$out = fopen("php://output", 'w');  
			
			foreach ($campos as $campo) {
				switch ($campo) 
				{
					case 'CLIENTE':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA INICIAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA FINAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ORDEN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PREFACTURA': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo))));	
									   $listaCampos[] = "FECHA FACTURACION";	break;
					case 'CFDI': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CONCEPTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CANTIDAD': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO UNITARIO':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO TOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN ($)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN (%)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'SUBTOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE PLAN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE SERVICIO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ELABORÓ':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ESTADO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'MOTIVO DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					default: /*nada...*/ break;
				}
			}
			
			fputcsv($out,array_map("utf8_decode",$listaCampos));
			$prefactura = 0;
			while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {
				$datosCamposPrefactura = array();
				$consulta="SELECT pf.estado,pfc.idprefactura,pf.fechaInicial,pf.fechacfdi,pf.nprefactura,pf.anio,pf.cfdi,pf.descuento,pf.motivodescuento,pfc.cantidad,pf.realizo,cl.clave_cliente,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.precioUnitario,pfc.comision,pfc.total FROM tblprefacturas pf LEFT JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura LEFT JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE TRIM(pf.cfdi) != '' AND pfc.idprefacturaconcepto = '".$filaTmpConcepto['idprefacturaconcepto']."'";
					$resultado = $this->conexion->query($consulta); 
					$datosPrefactura = $resultado->fetch_array();
					$subtotal = round($datosPrefactura["cantidad"]*round($datosPrefactura["precioUnitario"],2)*(1+($datosPrefactura["comision"]/100)),2);
					if(!in_array($datosPrefactura['idprefactura'], $pfDescuentos))
					{
						$descuentoAcb = $datosPrefactura["descuento"];
						$motivoAcb = $datosPrefactura["motivodescuento"];
						array_push($pfDescuentos,$datosPrefactura['idprefactura']);
					}
					else{
						$descuentoAcb = "";
						$motivoAcb = "";
					}


				if($datosPrefactura["estado"] !== 'Conciliado' && $datosPrefactura["estado"] !== 'ConciliadoA' && $datosPrefactura["estado"] !== 'ConciliadoR'){
					$tipo_doc = "PF";
					$tipo = "FACTURACION DEL PERIODO";
				}
				else{
					$tipo_doc = "CL";
					$tipo = "CONCILIACION";
				}	

				foreach ($campos as $campo) {
					switch ($campo) 
					{
						case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
						case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
						case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
						case 'ORDEN': $datosCamposPrefactura[] = ""; break;
						case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
										   $datosCamposPrefactura[] = $datosPrefactura["fechacfdi"]; break;
						case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
						case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
						case 'CANTIDAD': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]; break;
						case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosPrefactura["precioUnitario"]; break;
						case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
						case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
						case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
						case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
						case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
						case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
						case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
						case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
						case 'DESCUENTO': $datosCamposPrefactura[] = $descuentoAcb; break;
						case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $motivoAcb; break;
						default: /*nada...*/ break;
					}
				}
				fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
				if(is_null($filaTmpConcepto["idordconcepto"])){ // Caso acb
					$consulta="SELECT osc.idordconcepto, osc.idorden,os.estado,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOs,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOs,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idpfconcepto = '".$filaTmpConcepto['idprefacturaconcepto']."'";

						$resultado = $this->conexion->query($consulta);
					if($resultado->num_rows != 0){	
						$sumCantidad = 0;	
						$sumSubtotal = 0;
						while ($datosConceptoOrden = $resultado->fetch_assoc()) {
							//Saber tipo de os (en el periodo o antes)
							$fechaInicialOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaInicial"]));
							$fechaFinalOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaFinal"]));
						    //echo $paymentDate; // echos today! 
						    $tipoTmp = "OS";
						    if($datosConceptoOrden["estado"] == 'Autorizada'){
								if($fechaInicialOrden < $fInicial && $fechaFinalOrden < $fInicial)
							    {
							      $tipo = "OS DEL PERIODO ANTERIOR";
							    }
							    if((($fechaInicialOrden >= $fInicial) && ($fechaInicialOrden <= $fFinal)) || (($fechaFinalOrden >= $fInicial) && ($fechaFinalOrden <= $fFinal)))
							    {
							      $tipo = "OS AUTORIZADA DEL PERIODO";
							    }
							    if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
							    {
							      $tipo = "OS POR REALIZAR";  
							    }
							}
							else{
								if($datosConceptoOrden["estado"] == 'DevolucionA'){
									$tipo = "DEVOLUCION";
									$tipoTmp = "DV";
									array_push($idDevoluciones, $datosConceptoOrden["idordconcepto"]);
									
									if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
								    {
								      $tipo = "OS POR REALIZAR";  
								    }
								}
								else{
									$tipo = "OS EN REVISION";
								}
							}

							//VARIABLES NUMBER FORMAT 2 
							$tmpPrecioUnitario = round($datosConceptoOrden["precioUnitarioOs"],2);


							//Fin tipo de os (en el periodo o antes)
							$datosCamposOrden = array();
							$sumCantidad += $datosConceptoOrden["cantidadOs"];
							$sumSubtotal += round($datosConceptoOrden["cantidadOs"]*$tmpPrecioUnitario*(1+($datosConceptoOrden["comisionOs"]/100)),2);
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = $tipoTmp."-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
														$datosCamposOrden[] = $datosPrefactura["fechacfdi"]; break;
									case 'CFDI': $datosCamposOrden[] = $datosPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosConceptoOrden["conceptoOs"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosConceptoOrden["precioUnitarioOs"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]*$tmpPrecioUnitario; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$tmpPrecioUnitario*($datosConceptoOrden["comisionOs"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosConceptoOrden["comisionOs"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$tmpPrecioUnitario*(1+($datosConceptoOrden["comisionOs"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = $tipo; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}

						if(($sumSubtotal < ($subtotal))){
							$datosCamposPrefactura = array();
							$disponible = ($subtotal - $sumSubtotal) / (1+($datosPrefactura["comision"]/100));
							$disponible = round($disponible,2);
							$tmpTotal = round(1*$disponible*(1+($datosPrefactura["comision"]/100)),2);
							if($tmpTotal > 0){
								foreach ($campos as $campo) {
									switch ($campo) 
									{
										case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
										case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
										case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
										case 'ORDEN': $datosCamposPrefactura[] = ""; break;
										case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
															$datosCamposPrefactura[] = $datosPrefactura["fechacfdi"]; break;
										case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
										case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
										case 'CANTIDAD': $datosCamposPrefactura[] = 1; break;
										case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $disponible; break;
										case 'PRECIO TOTAL': $datosCamposPrefactura[] = 1*$disponible; break;
										case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format(1*$disponible*($datosPrefactura["comision"]/100),2); break;
										case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
										case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($tmpTotal,2); break;
										case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
										case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
										case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
										case 'ESTADO': $datosCamposPrefactura[] = "OS POR REALIZAR"; break;
										case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
										case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
										default: /*nada...*/ break;
									}
								}

								fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
							}
						}

					}
					else{

						$datosCamposPrefactura = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
								case 'ORDEN': $datosCamposPrefactura[] = ""; break;
								case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
													$datosCamposPrefactura[] = $datosPrefactura["fechacfdi"]; break;
								case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
								case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
								case 'CANTIDAD': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosPrefactura["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
								case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
								case 'ESTADO': $datosCamposPrefactura[] = "OS POR REALIZAR"; break;
								case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
								default: /*nada...*/ break;
							}
						}						
						fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
					}
				}
				else //Caso abc 
				{
					// if(!in_array($filaTmpConcepto['idordconcepto'], $idsOrdenesConceptos))
					// {
						array_push($idsOrdenesConceptos,$filaTmpConcepto['idordconcepto']);
						$consulta="SELECT osc.idordconcepto, osc.idorden,os.estado,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOS,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOS,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

						$resultado = $this->conexion->query($consulta);
						$datosConceptoOrden = $resultado->fetch_assoc();
						$datosCamposOrden = array();
						//Saber tipo de os (en el periodo o antes)
							$fechaInicialOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaInicial"]));
							$fechaFinalOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaFinal"]));
						    //echo $paymentDate; // echos today! 
						    $cantidadTmp = $datosPrefactura["cantidad"];
						    if($datosConceptoOrden["estado"] == 'Autorizada'){
								if($fechaInicialOrden < $fInicial && $fechaFinalOrden < $fInicial)
							    {
							      $tipo = "OS DEL PERIODO ANTERIOR";
							    }
							    if((($fechaInicialOrden >= $fInicial) && ($fechaInicialOrden <= $fFinal)) || (($fechaFinalOrden >= $fInicial) && ($fechaFinalOrden <= $fFinal)))
							    {
							      $tipo = "OS AUTORIZADA DEL PERIODO";
							    }
							    if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
							    {
							      $tipo = "OS POR REALIZAR";  
							    }
							}
							else{
								if($datosConceptoOrden["estado"] == 'DevolucionA'){
									$tipo = "DEVOLUCION";
									// array_push($idDevoluciones, $datosConceptoOrden["idordconcepto"]);
									$cantidadTmp = -1 * $datosPrefactura["cantidad"];
									if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
								    {
								      $tipo = "OS POR REALIZAR";  
								    }
								}
								else{
									$tipo = "OS EN REVISION";
								}
							}

						//Fin tipo de os (en el periodo o antes)
						if($datosConceptoOrden["estado"] != 'DevolucionA'){
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
													   $datosCamposOrden[] = $datosPrefactura["fechacfdi"]; break;
									case 'CFDI': $datosCamposOrden[] = $datosPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosPrefactura["concepto"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $cantidadTmp; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosPrefactura["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosPrefactura["comision"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = $tipo; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}
							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}
					// }
				}
			}

			//IMPRIMIR LAS DEVOLUCIONES EN EL PERIODO SELECCIONADO
			$consulta="SELECT pf.fechaInicial as pfFechaInicial, CONCAT('PF-',cl.clave_cliente,'-',pf.anio,'-',pf.nprefactura) as folioPf, pf.fechacfdi, osc.idordconcepto, osc.idorden,os.estado,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOs,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOs,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblprefacturasconceptos pfc ON osc.idpfconcepto = pfc.idprefacturaconcepto LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado = 'DevolucionA' AND os.estado != 'DevolucionC' AND (os.fechaInicial BETWEEN '$fInicial' AND '$fFinal')";

			$resultado = $this->conexion->query($consulta);
			while ($datosConceptoDevolucion = $resultado->fetch_assoc()) {
				$datosCamposDevolucion = array();
				$subtotal = $datosConceptoDevolucion["cantidadOs"]*$datosConceptoDevolucion["precioUnitarioOs"]*(1+($datosConceptoDevolucion["comisionOs"]/100));
				if(!in_array($datosConceptoDevolucion["idordconcepto"], $idDevoluciones)){
					foreach ($campos as $campo) {
						switch ($campo) 
						{
							case 'CLIENTE':	$datosCamposDevolucion[] = $datosConceptoDevolucion["claveOs"]; break;
							case 'FECHA INICIAL': $datosCamposDevolucion[] = $datosConceptoDevolucion["fechaInicial"]; break;
							case 'FECHA FINAL': $datosCamposDevolucion[] = $datosConceptoDevolucion["fechaFinal"]; break;
							case 'ORDEN': $datosCamposDevolucion[] = "DV-".$datosConceptoDevolucion["claveOs"]."-".$datosConceptoDevolucion["anioOs"]."-".$datosConceptoDevolucion["norden"]; break;
							case 'PREFACTURA': $datosCamposDevolucion[] = $datosConceptoDevolucion["folioPf"]; $datosCamposDevolucion[] = $datosConceptoDevolucion["fechacfdi"]; break;
							case 'CFDI': $datosCamposDevolucion[] = $datosConceptoDevolucion["cfdi"]; break;
							case 'CONCEPTO': $datosCamposDevolucion[] = $datosConceptoDevolucion["conceptoOs"]; break;
							case 'CANTIDAD': $datosCamposDevolucion[] = $datosConceptoDevolucion["cantidadOs"]; break;
							case 'PRECIO UNITARIO':	$datosCamposDevolucion[] = $datosConceptoDevolucion["precioUnitarioOs"]; break;
							case 'PRECIO TOTAL': $datosCamposDevolucion[] = $datosConceptoDevolucion["cantidadOs"]*$datosConceptoDevolucion["precioUnitarioOs"]; break;
							case 'COMISIÓN ($)': $datosCamposDevolucion[] = number_format($datosConceptoDevolucion["cantidadOs"]*$datosConceptoDevolucion["precioUnitarioOs"]*($datosConceptoDevolucion["comisionOs"]/100),2); break;
							case 'COMISIÓN (%)': $datosCamposDevolucion[] = $datosConceptoDevolucion["comisionOs"]; break;
							case 'SUBTOTAL': $datosCamposDevolucion[] = number_format($subtotal,2); break;
							case 'TIPO DE PLAN': $datosCamposDevolucion[] = $datosConceptoDevolucion["tipoplan"]; break;
							case 'TIPO DE SERVICIO': $datosCamposDevolucion[] = $datosConceptoDevolucion["tiposervicio"]; break;
							case 'ELABORÓ':	$datosCamposDevolucion[] = $datosConceptoDevolucion["realizo"]; break;
							case 'ESTADO': $datosCamposDevolucion[] = "DEVOLUCION"; break;
							case 'DESCUENTO': $datosCamposDevolucion[] = ""; break;
							case 'MOTIVO DESCUENTO': $datosCamposDevolucion[] = ""; break;
							default: /*nada...*/ break;
						}
					}
					fputcsv($out,array_map("utf8_decode",$datosCamposDevolucion));
				}
			}

			// FIN IMPRIMIR LAS DEVOLUCIONES EN EL PERIODO SELECCIONADO 




			fclose($out);
		}

		public function reporteTotal($datos,$datosPrefacturas,$campos,$fInicial,$fFinal){
		
			ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	        header("Content-Disposition: attachment; filename=ReporteTotal.csv");
			header("Content-Type: application/vnd.ms-excel;");
			header("Pragma: no-cache");
			header("Expires: 0");


		    $fInicial = date('Y-m-d', strtotime($fInicial));
		    $fFinal = date('Y-m-d', strtotime($fFinal));

   			foreach ($datos as $dato) {
               $idOrden = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idorden"])))); 
               $idsOrdenes[] = $idOrden;
            }

            $subconsultaOrdenes = "";
            $subconsultaOrdenes = implode(",", $idsOrdenes);	

			$listaCampos = array();
			$idsPrefacturasConceptos = array();
			$idsPfConceptos = array();
			$idsOrdConceptos = array();
			$descuentos = array();

			foreach ($datosPrefacturas as $dato) {
               $idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idprefactura"])))); 
               $idsPrefacturas[] = $idPrefactura;
            }

			$consulta = "SELECT osc.idpfconcepto, osc.idordconcepto FROM tblordenesdeservicio os LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden WHERE os.idorden IN (".$subconsultaOrdenes.")";
			// echo $consulta;

			$resultadoConceptos = $this->conexion->query($consulta);
			$out = fopen("php://output", 'w');  
			
			foreach ($campos as $campo) {
				switch ($campo) 
				{
					case 'CLIENTE':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA INICIAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA FINAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ORDEN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PREFACTURA': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo))));
									   $listaCampos[] = "FECHA FACTURACION";	break;
					case 'CFDI': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CONCEPTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CANTIDAD': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO UNITARIO':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO TOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN ($)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN (%)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'SUBTOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE PLAN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE SERVICIO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ELABORÓ':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ESTADO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'MOTIVO DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					default: /*nada...*/ break;
				}
			}
			
			fputcsv($out,array_map("utf8_decode",$listaCampos));
			while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {
				$datosCamposOrden = array();
				$consulta="SELECT os.fechaInicial,os.fechaFinal,os.norden,os.anio,osc.cantidad,os.realizo,cl.clave_cliente,osc.tipoplan,osc.tiposervicio,osc.concepto,osc.precioUnitario,osc.comision,osc.total,osc.descripcion FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";
					$resultado = $this->conexion->query($consulta); 
					$datosOrden = $resultado->fetch_array();
					$subtotal = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100));
				
				if(is_null($filaTmpConcepto["idpfconcepto"])){ // Caso abc

					$consulta="SELECT pf.estado,pfc.idprefacturaconcepto,pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.descuento,pf.motivodescuento,pf.cfdi FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pf.estado != 'ConciliadoC' AND pfc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

						$resultado = $this->conexion->query($consulta);
					if($resultado->num_rows != 0){	
						$sumCantidad = 0;	
						$sumSubtotal = 0;

						$i = 0;
						while ($datosConceptoPrefactura = $resultado->fetch_assoc()) {
							if($i == 0){
								if($datosConceptoPrefactura["estado"] !== "Conciliado" && $datosConceptoPrefactura["estado"] !== "ConciliadoA" && $datosConceptoPrefactura["estado"] !== "ConciliadoR"){
									$tipo_doc = "PF";
								}
								else{
									$tipo_doc = "CL";
								}
								$datosCamposOrden = array();
								foreach ($campos as $campo) {
									switch ($campo) 
									{
										case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
										case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
										case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
										case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
										case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];
															   $datosCamposOrden[] = $datosConceptoPrefactura["fechacfdi"];	break;
										case 'CFDI': $datosCamposOrden[] = $datosConceptoPrefactura["cfdi"]; break;
										case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
										case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
										case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
										case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
										case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
										case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
										case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
										case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
										case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
										case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
										case 'ESTADO': $datosCamposOrden[] = "OS AUTORIZADA DEL PERIODO"; break;
										case 'DESCUENTO': $datosCamposOrden[] = ""; break;
										case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
										default: /*nada...*/ break;
									}
								}
								fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
								$i = 1;
							}
							array_push($idsPfConceptos,$datosConceptoPrefactura['idprefacturaconcepto']);
							//Saber tipo de facturado (en el periodo o antes)
								$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechacfdi"]));
							    //echo $paymentDate; // echos today! 
							if($datosConceptoPrefactura["estado"] !== "Conciliado" && $datosConceptoPrefactura["estado"] !== "ConciliadoA" && $datosConceptoPrefactura["estado"] !== "ConciliadoR"){
								$tipo_doc = "PF";
								if(($fechaFactura < $fInicial) && !empty($datosConceptoPrefactura["cfdi"]))
							    {
							      $tipo = "FACTURACION DEL PERIODO ANTERIOR";
							    }
							    if(($fechaFactura >= $fInicial) && ($fechaFactura <= $fFinal))
							    {
							      $tipo = "FACTURACION DEL PERIODO";
							    }
							    if(($fechaFactura > $fFinal) || empty($datosConceptoPrefactura["cfdi"]))
							    {
							      $tipo = "OS POR FACTURAR";  
							    }
							}
							else{
								$tipo_doc = "CL";
								$tipo = "CONCILIACION";
								$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechaInicial"]));
								if(($fechaFactura > $fFinal))
							    {
							      $tipo = "OS POR FACTURAR";  
							    }
							}

							//Fin tipo de facturado (en el periodo o antes)



							if(!in_array($datosConceptoPrefactura['idprefactura'], $descuentos))
							{
								$descuentoAbc = $datosConceptoPrefactura["descuento"];
								$motivoAbc = $datosConceptoPrefactura["motivodescuento"];
								array_push($descuentos,$datosConceptoPrefactura['idprefactura']);
							}
							else{
								$descuentoAbc = "";
								$motivoAbc = "";
							}
							$datosCamposPrefactura = array();
							$sumCantidad += $datosConceptoPrefactura["cantidadPf"];
							$sumSubtotal += $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
									case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposPrefactura[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];
													   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];	break;
									case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
									case 'CANTIDAD': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]; break;
									case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosConceptoPrefactura["precioUnitarioPf"]; break;
									case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]; break;
									case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*($datosConceptoPrefactura["comisionPf"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
									case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
									case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
									case 'DESCUENTO': $datosCamposPrefactura[] =  $descuentoAbc; break;
									case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] =  $motivoAbc; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
						}

						if($sumCantidad < $datosOrden["cantidad"] && ($sumSubtotal < ($subtotal + .05))){
							$datosCamposOrden = array();
							$disponible = $datosOrden["cantidad"] - $sumCantidad;
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
									case 'CFDI': $datosCamposOrden[] = ""; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $disponible; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $disponible*$datosOrden["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($disponible*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($disponible*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = "OS POR FACTURAR"; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}

					}
					else{

						$datosCamposOrden = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
								case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
								case 'CFDI': $datosCamposOrden[] = ""; break;
								case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
								case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
								case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
								case 'ESTADO': $datosCamposOrden[] = "OS AUTORIZADA DEL PERIODO"; break;
								case 'DESCUENTO': $datosCamposOrden[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
								default: /*nada...*/ break;
							}
						}
						fputcsv($out,array_map("utf8_decode",$datosCamposOrden));

						$datosCamposOrden = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
								case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
								case 'CFDI': $datosCamposOrden[] = ""; break;
								case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
								case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
								case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
								case 'ESTADO': $datosCamposOrden[] = "OS POR FACTURAR"; break;
								case 'DESCUENTO': $datosCamposOrden[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
								default: /*nada...*/ break;
							}
						}						
						fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
					}
				}
				else //Caso acb 
				{
					// if(!in_array($filaTmpConcepto['idpfconcepto'], $idsPrefacturasConceptos))
					// { EMPIEZA PREFACTURA ORIGINAL (FALTARIA OS POR REALIZAR SI ES QUE QUEDARA SALDO)
						$consulta="SELECT pf.estado,pfc.idprefacturaconcepto,pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.cfdi,pf.descuento,pf.motivodescuento FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pfc.idprefacturaconcepto = '".$filaTmpConcepto['idpfconcepto']."'";

						$resultado = $this->conexion->query($consulta);
						$datosConceptoPrefactura = $resultado->fetch_assoc();
						$datosCamposPrefactura = array();
						
						$subtotalPrefactura = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100));

						if(!in_array($datosConceptoPrefactura['idprefactura'], $descuentos))
						{
							$descuentoAcb = $datosConceptoPrefactura["descuento"];
							$motivoAcb = $datosConceptoPrefactura["motivodescuento"];
							array_push($descuentos,$datosConceptoPrefactura['idprefactura']);
						}
						else{
							$descuentoAcb = "";
							$motivoAcb = "";
						}

						if($datosConceptoPrefactura["estado"] !== "Conciliado" && $datosConceptoPrefactura["estado"] !== "ConciliadoA" && $datosConceptoPrefactura["estado"] !== "ConciliadoR"){
							$tipo_doc = "PF";
						}
						else{
							$tipo_doc = "CL";
						}

						$datosCamposOrden = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
								case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
															   $datosCamposOrden[] = $datosConceptoPrefactura["fechacfdi"];break;
								case 'CFDI': $datosCamposOrden[] = $datosConceptoPrefactura["cfdi"]; break;
								case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
								case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
								case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
								case 'ESTADO': $datosCamposOrden[] = "OS AUTORIZADA DEL PERIODO"; break;
								case 'DESCUENTO': $datosCamposOrden[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
								default: /*nada...*/ break;
							}
						}

						fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						array_push($idsPfConceptos,$datosConceptoPrefactura['idprefacturaconcepto']);
						//Saber tipo de facturado (en el periodo o antes)
							$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechacfdi"]));
						    //echo $paymentDate; // echos today! 
							if(($fechaFactura < $fInicial) && !empty($datosConceptoPrefactura["cfdi"]))
						    {

								$ok = 1;
								if($datosConceptoPrefactura["estado"] !== "Conciliado" && $datosConceptoPrefactura["estado"] !== "ConciliadoA" && $datosConceptoPrefactura["estado"] !== "ConciliadoR"){
									$tipo_doc = "PF";
								    $tipo = "FACTURACION DEL PERIODO ANTERIOR";
								}
								else{
									$tipo_doc = "CL";
									$tipo = "CONCILIACION";
									$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechaInicial"]));
									if(($fechaFactura > $fFinal))
								    {
								      $tipo = "OS POR FACTURAR";  
								    }
								}
						    }
						    if(($fechaFactura >= $fInicial) && ($fechaFactura <= $fFinal))
						    {
						    	$ok = 0;
						    	if(!in_array($filaTmpConcepto['idpfconcepto'], $idsPrefacturasConceptos))
								{ 
									array_push($idsPrefacturasConceptos,$filaTmpConcepto['idpfconcepto']);
									if($datosConceptoPrefactura["estado"] !== "Conciliado" && $datosConceptoPrefactura["estado"] !== "ConciliadoA" && $datosConceptoPrefactura["estado"] !== "ConciliadoR"){
										$tipo_doc = "PF";
						      			$tipo = "FACTURACION DEL PERIODO";
									}
									else{
										$tipo_doc = "CL";
										$tipo = "CONCILIACION";
										$fechaFactura = date('Y-m-d', strtotime($datosConceptoPrefactura["fechaInicial"]));
										if(($fechaFactura > $fFinal))
									    {
									      $tipo = "OS POR FACTURAR";  
									    }
									}
						      		foreach ($campos as $campo) {
										switch ($campo) 
										{
											case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
											case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
											case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
											case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
											case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
															   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];break;
											case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
											case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
											case 'CANTIDAD': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]; break;
											case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosConceptoPrefactura["precioUnitarioPf"]; break;
											case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]; break;
											case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*($datosConceptoPrefactura["comisionPf"]/100),2); break;
											case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
											case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100)),2); break;
											case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
											case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
											case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
											case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
											case 'DESCUENTO': $datosCamposPrefactura[] = $descuentoAcb; break;
											case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $motivoAcb; break;
											default: /*nada...*/ break;
										}
									}
									fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
						      		$consulta="SELECT osc.idorden,os.estado,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOs,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOs,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idpfconcepto = '".$filaTmpConcepto['idpfconcepto']."'";

										$resultado = $this->conexion->query($consulta);
									if($resultado->num_rows != 0){	
										$sumCantidad = 0;	
										$sumSubtotal = 0;
										while ($datosConceptoOrden = $resultado->fetch_assoc()) {
											//Saber tipo de os (en el periodo o antes)
											$fechaInicialOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaInicial"]));
											$fechaFinalOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaFinal"]));
										    //echo $paymentDate; // echos today! 
										    $tipoTmp = "OS";
										    if($datosConceptoOrden["estado"] == 'Autorizada'){
												if($fechaInicialOrden < $fInicial && $fechaFinalOrden < $fInicial)
											    {
											      $tipo = "OS DEL PERIODO ANTERIOR";
											    }
											    if((($fechaInicialOrden >= $fInicial) && ($fechaInicialOrden <= $fFinal)) || (($fechaFinalOrden >= $fInicial) && ($fechaFinalOrden <= $fFinal)))
											    {
											      $tipo = "OS AUTORIZADA DEL PERIODO";
											    }
											    if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
											    {
											      $tipo = "OS POR REALIZAR";  
											    }
											}
											else{
												if($datosConceptoOrden["estado"] == 'DevolucionA'){
													$tipo = "DEVOLUCION";
													$tipoTmp = "DV";
													if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
												    {
												      $tipo = "OS POR REALIZAR";  
												    }
												}
												else{
													$tipo = "OS EN REVISION";
												}
											}

											//Fin tipo de os (en el periodo o antes)
											$datosCamposOrden = array();
											$sumCantidad += $datosConceptoOrden["cantidadOs"];
											$sumSubtotal += $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100));
											if(!in_array($datosConceptoOrden['idorden'], $idsOrdenes)){
												foreach ($campos as $campo) {
													switch ($campo) 
													{
														case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
														case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
														case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaFinal"]; break;
														case 'ORDEN': $datosCamposOrden[] = $tipoTmp."-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
														case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
																			$datosCamposOrden[] = $datosConceptoPrefactura["fechacfdi"]; break;
														case 'CFDI': $datosCamposOrden[] = $datosConceptoPrefactura["cfdi"]; break;
														case 'CONCEPTO': $datosCamposOrden[] = $datosConceptoOrden["conceptoOs"]; break;
														case 'CANTIDAD': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]; break;
														case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosConceptoOrden["precioUnitarioOs"]; break;
														case 'PRECIO TOTAL': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]; break;
														case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*($datosConceptoOrden["comisionOs"]/100),2); break;
														case 'COMISIÓN (%)': $datosCamposOrden[] = $datosConceptoOrden["comisionOs"]; break;
														case 'SUBTOTAL': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100)),2); break;
														case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
														case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
														case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
														case 'ESTADO': $datosCamposOrden[] = $tipo; break;
														case 'DESCUENTO': $datosCamposOrden[] = ""; break;
														case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
														default: /*nada...*/ break;
													}
												}

												fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
											}
										}

										if(($sumSubtotal < ($subtotalPrefactura))){
											$datosCamposPrefactura = array();
											$disponible = ($subtotalPrefactura - $sumSubtotal) / (1+($datosConceptoPrefactura["comisionPf"]/100));
											foreach ($campos as $campo) {
												switch ($campo) 
												{
													case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
													case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
													case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
													case 'ORDEN': $datosCamposPrefactura[] = ""; break;
													case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
																		$datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"]; break;
													case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
													case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
													case 'CANTIDAD': $datosCamposPrefactura[] = 1; break;
													case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $disponible; break;
													case 'PRECIO TOTAL': $datosCamposPrefactura[] = 1*$disponible; break;
													case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format(1*$disponible*($datosConceptoPrefactura["comisionPf"]/100),2); break;
													case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
													case 'SUBTOTAL': $datosCamposPrefactura[] = number_format(1*$disponible*(1+($datosConceptoPrefactura["comisionPf"]/100)),2); break;
													case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
													case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
													case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
													case 'ESTADO': $datosCamposPrefactura[] = "OS POR REALIZAR"; break;
													case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
													case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
													default: /*nada...*/ break;
												}
											}

											fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
										}

									}
									else{

										$datosCamposPrefactura = array();
										foreach ($campos as $campo) {
											switch ($campo) 
											{
												case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
												case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
												case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
												case 'ORDEN': $datosCamposPrefactura[] = ""; break;
												case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
																	$datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"]; break;
												case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;/// En esta parte se supone q va cfdi no fechacfdi
												case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
												case 'CANTIDAD': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]; break;
												case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosConceptoPrefactura["precioUnitarioPf"]; break;
												case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]; break;
												case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*($datosConceptoPrefactura["comisionPf"]/100),2); break;
												case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
												case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotalPrefactura,2); break;
												case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
												case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
												case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
												case 'ESTADO': $datosCamposPrefactura[] = "OS POR REALIZAR"; break;
												case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
												case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
												default: /*nada...*/ break;
											}
										}						
										fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
									}
						      	}
						    }
						    if(($fechaFactura > $fFinal) || empty($datosConceptoPrefactura["cfdi"]))
						    {
						      $ok = 1;
						      $tipo = "OS POR FACTURAR";  
						    }

						//Fin tipo de facturado (en el periodo o antes)
						
						if(isset($ok) && $ok == 1){
							//TEMPORAL 
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
									case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposPrefactura[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
													   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];break;
									case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
									case 'CANTIDAD': $datosCamposPrefactura[] = $datosOrden["cantidad"]; break;
									case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosOrden["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosOrden["comision"]; break;
									case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
									case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
									case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
									case 'DESCUENTO': $datosCamposPrefactura[] = $descuentoAcb; break;
									case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $motivoAcb; break;
									default: /*nada...*/ break;
								}
							}
							fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));

							//FIN TEMPORAL 
						}

					//} TERMINA PRECTURA ORIGINAL SIN REPETIR
				}
			}
			//FACTURACION DEL MES 

			foreach ($datosPrefacturas as $dato) {
               $idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idprefactura"])))); 
               $idsPrefacturas[] = $idPrefactura;
            }

           	$subconsulta = "";
            $subconsulta = implode(",", $idsPrefacturas);	

			$idsOrdenesConceptos = array();	
			$listaCampos = array();

			$consulta = "SELECT pfc.idprefacturaconcepto, pfc.idordconcepto FROM tblprefacturasconceptos pfc WHERE pfc.idprefactura IN (".$subconsulta.")";
			// echo $consulta;

			$resultadoConceptos = $this->conexion->query($consulta);

			$prefactura = 0;
			while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {
				if(!in_array($filaTmpConcepto['idprefacturaconcepto'], $idsPfConceptos))
				{
					$datosCamposPrefactura = array();
					$consulta="SELECT pf.estado,pfc.idprefactura,pf.fechaInicial,pf.fechacfdi,pf.nprefactura,pf.anio,pf.cfdi,pf.descuento,pf.motivodescuento,pfc.cantidad,pf.realizo,cl.clave_cliente,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.precioUnitario,pfc.comision,pfc.total FROM tblprefacturas pf LEFT JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura LEFT JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE TRIM(pf.cfdi) != '' AND pfc.idprefacturaconcepto = '".$filaTmpConcepto['idprefacturaconcepto']."'";
						$resultado = $this->conexion->query($consulta); 
						$datosPrefactura = $resultado->fetch_array();
						$subtotal = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*(1+($datosPrefactura["comision"]/100));
						if(!in_array($datosPrefactura['idprefactura'], $descuentos))
						{
							$descuentoAcb = $datosPrefactura["descuento"];
							$motivoAcb = $datosPrefactura["motivodescuento"];
							array_push($descuentos,$datosPrefactura['idprefactura']);
						}
						else{
							$descuentoAcb = "";
							$motivoAcb = "";
						}

					if($datosPrefactura["estado"] !== "Conciliado" && $datosPrefactura["estado"] !== "ConciliadoA" && $datosPrefactura["estado"] !== "ConciliadoR"){
						$tipo_doc = "PF";
		      			$tipo = "FACTURACION DEL PERIODO";
					}
					else{
						$tipo_doc = "CL";
						$tipo = "CONCILIACION";
						$fechaFactura = date('Y-m-d', strtotime($datosPrefactura["fechaInicial"]));
						if(($fechaFactura > $fFinal))
					    {
					      $tipo = "OS POR FACTURAR";  
					    }
					}
					foreach ($campos as $campo) {
						switch ($campo) 
						{
							case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
							case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
							case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
							case 'ORDEN': $datosCamposPrefactura[] = ""; break;
							case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
											   $datosCamposPrefactura[] = $datosPrefactura["fechacfdi"]; break;
							case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
							case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
							case 'CANTIDAD': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]; break;
							case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosPrefactura["precioUnitario"]; break;
							case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
							case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
							case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
							case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
							case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
							case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
							case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
							case 'ESTADO': $datosCamposPrefactura[] = $tipo; break;
							case 'DESCUENTO': $datosCamposPrefactura[] = $descuentoAcb; break;
							case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $motivoAcb; break;
							default: /*nada...*/ break;
						}
					}
					fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
					if(is_null($filaTmpConcepto["idordconcepto"])){ // Caso acb
						$consulta="SELECT osc.idorden,os.estado,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOs,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOs,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idpfconcepto = '".$filaTmpConcepto['idprefacturaconcepto']."'";

							$resultado = $this->conexion->query($consulta);
						if($resultado->num_rows != 0){	
							$sumCantidad = 0;	
							$sumSubtotal = 0;
							while ($datosConceptoOrden = $resultado->fetch_assoc()) {
								//Saber tipo de os (en el periodo o antes)
								$fechaInicialOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaInicial"]));
								$fechaFinalOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaFinal"]));
							    //echo $paymentDate; // echos today! 
							    $tipoTmp = "OS";
							    if($datosConceptoOrden["estado"] == 'Autorizada'){
									if($fechaInicialOrden < $fInicial && $fechaFinalOrden < $fInicial)
								    {
								      $tipo = "OS DEL PERIODO ANTERIOR";
								    }
								    if((($fechaInicialOrden >= $fInicial) && ($fechaInicialOrden <= $fFinal)) || (($fechaFinalOrden >= $fInicial) && ($fechaFinalOrden <= $fFinal)))
								    {
								      $tipo = "OS AUTORIZADA DEL PERIODO";
								    }
								    if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
								    {
								      $tipo = "OS POR REALIZAR";  
								    }
								}
								else{
									if($datosConceptoOrden["estado"] == 'DevolucionA'){
										$tipo = "DEVOLUCION";
										$tipoTmp = "DV";
										if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
									    {
									      $tipo = "OS POR REALIZAR";  
									    }
									}
									else{
										$tipo = "OS EN REVISION";
									}
								}

								//Fin tipo de os (en el periodo o antes)
								$datosCamposOrden = array();
								$sumCantidad += $datosConceptoOrden["cantidadOs"];
								$sumSubtotal += $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100));
								foreach ($campos as $campo) {
									switch ($campo) 
									{
										case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
										case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
										case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaFinal"]; break;
										case 'ORDEN': $datosCamposOrden[] = $tipoTmp."-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
										case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
															$datosCamposOrden[] = $datosPrefactura["fechacfdi"]; break;
										case 'CFDI': $datosCamposOrden[] = $datosPrefactura["cfdi"]; break;
										case 'CONCEPTO': $datosCamposOrden[] = $datosConceptoOrden["conceptoOs"]; break;
										case 'CANTIDAD': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]; break;
										case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosConceptoOrden["precioUnitarioOs"]; break;
										case 'PRECIO TOTAL': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]; break;
										case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*($datosConceptoOrden["comisionOs"]/100),2); break;
										case 'COMISIÓN (%)': $datosCamposOrden[] = $datosConceptoOrden["comisionOs"]; break;
										case 'SUBTOTAL': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100)),2); break;
										case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
										case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
										case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
										case 'ESTADO': $datosCamposOrden[] = $tipo; break;
										case 'DESCUENTO': $datosCamposOrden[] = ""; break;
										case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
										default: /*nada...*/ break;
									}
								}

								fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
							}

							if(($sumSubtotal < ($subtotal))){
								$datosCamposPrefactura = array();
								$disponible = ($subtotal - $sumSubtotal) / (1+($datosPrefactura["comision"]/100));
								foreach ($campos as $campo) {
									switch ($campo) 
									{
										case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
										case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
										case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
										case 'ORDEN': $datosCamposPrefactura[] = ""; break;
										case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
															$datosCamposPrefactura[] = $datosPrefactura["fechacfdi"]; break;
										case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
										case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
										case 'CANTIDAD': $datosCamposPrefactura[] = 1; break;
										case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $disponible; break;
										case 'PRECIO TOTAL': $datosCamposPrefactura[] = 1*$disponible; break;
										case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format(1*$disponible*($datosPrefactura["comision"]/100),2); break;
										case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
										case 'SUBTOTAL': $datosCamposPrefactura[] = number_format(1*$disponible*(1+($datosPrefactura["comision"]/100)),2); break;
										case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
										case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
										case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
										case 'ESTADO': $datosCamposPrefactura[] = "OS POR REALIZAR"; break;
										case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
										case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
										default: /*nada...*/ break;
									}
								}

								fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
							}

						}
						else{

							$datosCamposPrefactura = array();
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
									case 'ORDEN': $datosCamposPrefactura[] = ""; break;
									case 'PREFACTURA': $datosCamposPrefactura[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
														$datosCamposPrefactura[] = $datosPrefactura["fechacfdi"]; break;
									case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
									case 'CANTIDAD': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]; break;
									case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosPrefactura["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
									case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
									case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
									case 'ESTADO': $datosCamposPrefactura[] = "OS POR REALIZAR"; break;
									case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
									default: /*nada...*/ break;
								}
							}						
							fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
						}
					}
					else //Caso abc 
					{
						// if(!in_array($filaTmpConcepto['idordconcepto'], $idsOrdenesConceptos))
						// {
							array_push($idsOrdenesConceptos,$filaTmpConcepto['idordconcepto']);
							$consulta="SELECT osc.idorden,os.estado,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOS,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOS,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

							$resultado = $this->conexion->query($consulta);
							$datosConceptoOrden = $resultado->fetch_assoc();
							$datosCamposOrden = array();
							$tipoTmp = "OS";
							//Saber tipo de os (en el periodo o antes)
								$fechaInicialOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaInicial"]));
								$fechaFinalOrden = date('Y-m-d', strtotime($datosConceptoOrden["fechaFinal"]));
							    //echo $paymentDate; // echos today! 
							    if($datosConceptoOrden["estado"] == 'Autorizada'){
									if($fechaInicialOrden < $fInicial && $fechaFinalOrden < $fInicial)
								    {
								      $tipo = "OS DEL PERIODO ANTERIOR";
								    }
								    if((($fechaInicialOrden >= $fInicial) && ($fechaInicialOrden <= $fFinal)) || (($fechaFinalOrden >= $fInicial) && ($fechaFinalOrden <= $fFinal)))
								    {
								      $tipo = "OS AUTORIZADA DEL PERIODO";
								    }
								    if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
								    {
								      $tipo = "OS POR REALIZAR";  
								    }
								}
								else{
									if($datosConceptoOrden["estado"] == 'DevolucionA'){
										$tipo = "DEVOLUCION";
										$tipoTmp = "DV";
										if($fechaInicialOrden > $fFinal && $fechaFinalOrden > $fFinal)
									    {
									      $tipo = "OS POR REALIZAR";  
									    }
									}
									else{
										$tipo = "OS EN REVISION";
									}
								}

							//Fin tipo de os (en el periodo o antes)
							if($datosConceptoOrden["estado"] != 'DevolucionA'){
								foreach ($campos as $campo) {
									switch ($campo) 
									{
										case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
										case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
										case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
										case 'ORDEN': $datosCamposOrden[] = $tipoTmp."-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
										case 'PREFACTURA': $datosCamposOrden[] = $tipo_doc."-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	
														   $datosCamposOrden[] = $datosPrefactura["fechacfdi"]; break;
										case 'CFDI': $datosCamposOrden[] = $datosPrefactura["cfdi"]; break;
										case 'CONCEPTO': $datosCamposOrden[] = $datosPrefactura["concepto"]; break;
										case 'CANTIDAD': $datosCamposOrden[] = $datosPrefactura["cantidad"]; break;
										case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosPrefactura["precioUnitario"]; break;
										case 'PRECIO TOTAL': $datosCamposOrden[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
										case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
										case 'COMISIÓN (%)': $datosCamposOrden[] = $datosPrefactura["comision"]; break;
										case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
										case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
										case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
										case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
										case 'ESTADO': $datosCamposOrden[] = $tipo; break;
										case 'DESCUENTO': $datosCamposOrden[] = ""; break;
										case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
										default: /*nada...*/ break;
									}
								}
								fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
							}
						// }
					}
				}
			}






			//FACTURACION DEL MES
			fclose($out);
		}



		public function __destruct() {

				mysqli_close($this->conexion);

  		}

	}

?>