<?php
// $basedir = realpath(__DIR__);
include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/cotizaciones.php");
include_once("../../model/ordenesdeservicio.php");
include_once("../../model/prefacturas.php");
include_once("../../model/permisos.php");


class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
		$this->varCotizacion = new cotizaciones();	
		$this->varOrden = new orden();	
		$this->varPrefactura = new prefacturas();	
		$this->varPermiso = new permisos();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"])){
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
			$permisos = array("cotizaciones" => 1, "ordenes" => 2, "prefacturas" => 3, "reportes" => 4, "estadodecuenta" => 5, "conceptos" => 6);
			$datosClientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$idClientes = array();
			foreach($datosClientes as $cliente){$idClientes[] = $cliente["idclientes"];}
			if(isset($_GET["accion"]))
			{
				switch($_GET["accion"])
				{
					case 'listarDatos':
					    $datos = $clientes -> listarClientes($usuario);
						if(is_array($datos))
						{
							$arrayTipoPlan=array('Promotoría o Merchandiser','Demostración o Impulso de Ventas','Administración de nómina');
							$arrayTipoServicio=array('Gestión de personal (Nómina)','Compras de Bienes o Servicios', 'Coordinación y/o Consultoría','Gastos y/o Viáticos');
							$arrayAyuda=array('Asistencias','Materiales o Celulares', 'Gastos Administrativos','Reembolso, Viajes u Hoteles');
							if(isset($_GET["nombreCliente"]) && $_GET["nombreCliente"] != "")
							{
								$_SESSION["cliente"]=$_GET["nombreCliente"];
								$_SESSION["idCliente"]=$_GET["idCliente"];
							}
							if(isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "")
							{
								$_SESSION["fechaInicial"]=$_GET["fechaInicial"];
							}
							if(isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "")
							{
								$_SESSION["fechaFinal"]=$_GET["fechaFinal"];
							}
							if(isset($_GET["servicio"]) && $_GET["servicio"] != "")
							{
								$_SESSION["servicio"]=$_GET["servicio"];
							}
							if(isset($_GET["tipoPlan"]) && $_GET["tipoPlan"] != "")
							{
								$_SESSION["tipoPLan"]=$_GET["tipoPlan"];
							}
							if(isset($_GET["tipoServicio"]) && $_GET["tipoServicio"] != "")
							{
								$_SESSION["tipoServicio"]=$_GET["tipoServicio"];
							}
							if(isset($_SESSION["idCliente"]) &&  isset($_SESSION["tipoServicio"]))
							{
								require_once("../model/conceptos.php");
								$conceptos= new conceptos();
								$datosConceptos=$conceptos->cargarConceptos($_SESSION["idCliente"],$_SESSION["tipoServicio"]);
							}
							include_once('../view/cotizaciones/index.php');
						}
						else
							header('location:../index.php');	
				        break;

				    case 'agregarCotizacion':
			        	session_start();

			        	if($_POST['txtComisionAgencia']=="")
						{
							$ComisionAgencia=0;
						}
						else
						$ComisionAgencia=$_POST['txtComisionAgencia'];

						$_SESSION['contador']=$_SESSION['contador']+1;
						$_SESSION['fInicial']=$_POST['fInicial'];
						$_SESSION['fFinal']=$_POST['fFinal'];
						$_SESSION['cmbTipoPlan'][$_SESSION['contador']]=$_POST['cmbTipoPlan'];
						$_SESSION['cmbTipoServicio'][$_SESSION['contador']]=$_POST['cmbTipoServicio'];
						$_SESSION['txtCantidad'][$_SESSION['contador']]=$_POST['txtCantidad'];

						$concepto=explode("#", $_POST['cmbTipoConcepto']);
						$_SESSION['idconcepto'][$_SESSION['contador']]=$concepto[0];
						$_SESSION['cmbTipoConcepto'][$_SESSION['contador']]=$concepto[1];
						$_SESSION['txtDescripcionConcepto'][$_SESSION['contador']]=$_POST['txtDescripcionConcepto'];

						$_SESSION['txtPUnitario'][$_SESSION['contador']]=$_POST['txtPUnitario'];
						$_SESSION['txtPUnitarioMostrar'][$_SESSION['contador']]=number_format($_SESSION['txtPUnitario'][$_SESSION['contador']],2);
						
						$_SESSION['txtComisionAgenciaM'][$_SESSION['contador']]=$ComisionAgencia;
						
						// $_SESSION["subTotal"][$_SESSION['contador']] = $_POST["txtCantidad"]*$_POST['txtPUnitario'];
						$_SESSION["precioTotal"][$_SESSION['contador']]=$_POST["txtCantidad"]*$_POST['txtPUnitario'];

						$pCa = (($_POST["txtComisionAgencia"]/100))*$_SESSION["precioTotal"][$_SESSION['contador']];
						$_SESSION['txtComisionAgencia'][$_SESSION['contador']] = $pCa;
						
						$_SESSION["subTotal"][$_SESSION['contador']] = $pCa+($_POST["txtCantidad"]*$_POST['txtPUnitario']);
						$_SESSION["subTotalMostrar"][$_SESSION['contador']]=number_format($_SESSION["subTotal"][$_SESSION['contador']],2);

						$_SESSION["subTotal2"]+=$_SESSION["subTotal"][$_SESSION['contador']];
						$_SESSION["subTotal2Mostrar"]=number_format($_SESSION["subTotal2"],2);

						$_SESSION["iva"]=($_SESSION["subTotal2"]*(.16));
						$_SESSION["ivaMostrar"]=number_format($_SESSION["iva"],2);

						$_SESSION["total2"]=$_SESSION["subTotal2"]+$_SESSION["iva"];
						$_SESSION["total2Mostrar"]=number_format($_SESSION["total2"],2);
						
						header("location:crudCotizaciones.php?accion=listarDatos");
			        	break;

				    case 'eliminarRubro':

			    		session_start();
			    		$i=$_GET["value"];
						$_SESSION["subTotal2"]-=$_SESSION['subTotal'][$i];
						$_SESSION["subTotal2Mostrar"]=number_format($_SESSION["subTotal2"],2);

						$_SESSION["iva"]=$_SESSION["subTotal2"]*.16;
						$_SESSION["ivaMostrar"]=number_format($_SESSION["iva"],2);

						$_SESSION["total2"]=$_SESSION["subTotal2"]+$_SESSION["iva"];
						$_SESSION["total2Mostrar"]=number_format($_SESSION["total2"],2);
						
						unset($_SESSION['cmbClientes'][$i]);
						unset($_SESSION['txtServicio'][$i]);
						unset($_SESSION['cmbTipoPlan'][$i]);
						unset($_SESSION['cmbTipoServicio'][$i]);
						unset($_SESSION['txtCantidad'][$i]);
						unset($_SESSION['cmbTipoConcepto'][$i]);
						unset($_SESSION['txtDescripcionConcepto'][$i]);
						unset($_SESSION['cmbClientes'][$i]);
						unset($_SESSION['txtPUnitario'][$i],$_SESSION['precioTotal'][$i],$_SESSION['txtComisionAgenciaM'][$i]);

						unset($_SESSION['txtComisionAgencia'][$i]);
						unset($_SESSION['txtPUnitarioMostrar'][$i]);
						unset($_SESSION["subTotalMostrar"][$i]);
						

						unset($_SESSION['subTotal'][$i]);

						

						$_SESSION['contador']=$_SESSION['contador']-1;
						if ($_SESSION["contador"]==0) 
						{
							unset($_SESSION["subTotal2Mostrar"],$_SESSION["ivaMostrar"],$_SESSION["total2Mostrar"]);
						}

						for($pos=$i;$pos<=$_SESSION['contador'];$pos++) 
						{

							$_SESSION['cmbClientes'][$pos]=$_SESSION['cmbClientes'][$pos+1];
							$_SESSION['txtServicio'][$pos]=$_SESSION['txtServicio'][$pos+1];
							$_SESSION['cmbTipoPlan'][$pos]=$_SESSION['cmbTipoPlan'][$pos+1];
							$_SESSION['cmbTipoServicio'][$pos]=$_SESSION['cmbTipoServicio'][$pos+1];
							$_SESSION['txtCantidad'][$pos]=$_SESSION['txtCantidad'][$pos+1];
							$_SESSION['cmbTipoConcepto'][$pos]=$_SESSION['cmbTipoConcepto'][$pos+1];
							$_SESSION['txtDescripcionConcepto'][$pos]=$_SESSION['txtDescripcionConcepto'][$pos+1];
							$_SESSION['txtPUnitario'][$pos]=$_SESSION['txtPUnitario'][$pos+1];
							$_SESSION['precioTotal'][$pos] = $_SESSION['precioTotal'][$pos+1];
							$_SESSION['txtComisionAgenciaM'][$pos]=$_SESSION['txtComisionAgenciaM'][$pos+1];
							$_SESSION['txtComisionAgencia'][$pos]=$_SESSION['txtComisionAgencia'][$pos+1];
							$_SESSION['txtPUnitarioMostrar'][$pos] = $_SESSION['txtPUnitarioMostrar'][$pos+1];
							$_SESSION["subTotalMostrar"][$pos] = $_SESSION["subTotalMostrar"][$pos+1];
							$_SESSION['subTotal'][$pos]=$_SESSION['subTotal'][$pos+1];
						}
						header("location:crudCotizaciones.php?accion=listarDatos");
				        break;

				    case 'guardarCotizacion':
						session_start();
						if(isset($_SESSION["srs_usuario"]))
						{
							require_once('../model/clientes.php');
							$cliente = new clientes();
							$claveCliente = $cliente->datosClienteEspecifico($_POST["idCmbCliente"]);
							require_once('../model/cotizaciones.php');
							$cotizaciones= new cotizaciones();
							$numeroCotizacion=$cotizaciones->numeroCotizacion($claveCliente["clave_cliente"]);
							$fechaElaboracion = date("Y-m-d");

							if(!empty($_SESSION["contador"]))
							{
								require_once("../model/permisos.php");
								$usuario = $_SESSION["srs_usuario"];
								$permiso = new permisos();
								$permisoAutorizar = $permiso -> verificarPermiso($usuario,1);
								$datosCotizacion = array ///Se agregan los datos de una cotizacion
								(
									"idCliente" => $_POST["idCmbCliente"],
									"anio" => date('y'),
									"servicio" => $_SESSION["servicio"],
									"fechaInicial" => $_SESSION['fechaInicial'],
									"fechaFinal" => $_SESSION["fechaFinal"],
									"numCotizacion" => $numeroCotizacion["cotizacion"],
									"total" => $_SESSION['total2'],
									"usuario" => $_SESSION['srs_usuario'],
									"fechaElaboracion" => $fechaElaboracion,
									"permisoAutorizar" => $permisoAutorizar["autorizar"]
								);
								for($pos=1;$pos<=$_SESSION['contador'];$pos++) // Agrega en un array los conceptos de la cotización
								{
									$cotizacionConceptos[] = array
									(
										"idConcepto" => $_SESSION['idconcepto'][$pos],
										"cmbTipoPlan" => $_SESSION['cmbTipoPlan'][$pos],
										"cmbTipoServicio" => $_SESSION['cmbTipoServicio'][$pos],
										"cmbTipoConcepto" => $_SESSION['cmbTipoConcepto'][$pos],
										"txtDescripcionConcepto" => $_SESSION['txtDescripcionConcepto'][$pos],
										"txtPUnitario" => $_SESSION['txtPUnitario'][$pos],
										"txtCantidad" => $_SESSION['txtCantidad'][$pos],
										"precioTotal" => $_SESSION["precioTotal"][$pos],
										"txtComisionAgencia" => $_SESSION['txtComisionAgencia'][$pos],
										"subTotal" => $_SESSION["subTotal"][$pos],
										"txtComisionAgenciaM" => $_SESSION['txtComisionAgenciaM'][$pos]
									);
								}
								if(count($cotizacionConceptos) > 0)
								{
									///////////Guarda la cotizacio en la la base de datos/////////////
									$resultadoCotizacion = $cotizaciones->almacenarCotizacion($datosCotizacion,$cotizacionConceptos);
									if($resultadoCotizacion == 1)
									{
										/////////////Limpia todas las sessiones para realizar nueva cotización/////////////////
										for($i=1;$i<=$_SESSION['contador'];$i++) 
									    {     
											unset($_SESSION['cmbTipoPlan'][$i]);
											unset($_SESSION['cmbTipoServicio'][$i]);
											unset($_SESSION['txtCantidad'][$i]);
											unset($_SESSION['cmbTipoConcepto'][$i]);
											unset($_SESSION['txtDescripcionConcepto'][$i]);
											unset($_SESSION['txtPUnitario'][$i]);

											unset($_SESSION['txtComisionAgencia'][$i]);
											unset($_SESSION['txtPUnitarioMostrar'][$i]);
											unset($_SESSION["subTotalMostrar"][$i]);
											

											unset($_SESSION['subTotal'][$i]);
									                       
									    }
									    unset($_SESSION['contador'],$_SESSION["cliente"],$_SESSION["idCliente"],$_SESSION["fechaInicial"],$_SESSION["fechaFinal"],$_SESSION["servicio"],$_SESSION["tipoPLan"],$_SESSION["tipoServicio"],$_SESSION["cmbClientesTmp"],$_SESSION["idcliente"],$_SESSION["cotizacionTxtServicioTmp"],$_SESSION["cmbTipoPlanTmp"],$_SESSION["cmbTipoServicioTmp"],$_SESSION["subTotal2"],$_SESSION["subTotal2Mostrar"],$_SESSION["iva"],$_SESSION["ivaMostrar"],$_SESSION["total2"],$_SESSION['total2Mostrar']);
									    
										echo "<span class='glyphicon glyphicon-warning-sign' style='float:left; margin:0 7px 50px ;'></span>¡La cotización se realizó correctamente! <br><strong>Folio:<br> COT - ".$claveCliente["clave_cliente"]." - ".date('y')." - ".($numeroCotizacion["cotizacion"])."</strong>";
									}
									else
									{
										echo "<strong>¡La cotización fallo al guardar los datos!</strong>";
									}
								}
							}
						}
						break;

					case "clonarCotizacion":
			    		session_start();
						require_once('../model/cotizaciones.php');
						$cotizacion = new cotizaciones();
						if(isset($_SESSION["srs_usuario"])){
							$usuario = $_SESSION["srs_usuario"];
							$folioNuevo = $cotizacion -> clonarCotizacion($_POST["idCotizacion"],$usuario);
							echo $folioNuevo;
						}
						else{
							echo "Expiro su sesión, presione la tecla F5";
						}
						break;

					case 'modalIndexCot':
						$tipoProceso = "";
						$origen = array();
						$datosModalCotizacion = $this->varCotizacion->datosCotizacionEspecifica($_POST["idCotizacion"]);
						$datosUsuarioCotizacion = $this->varUsuario->datosUsuario($datosModalCotizacion["realizo"]);
						$folioCotizacion = "COT-".$datosModalCotizacion['clave_cliente']."-".$datosModalCotizacion['anio']."-".$datosModalCotizacion['ncotizacion'];
						$filaConceptosCot = $this->varCotizacion->listarConceptosCot($_POST["idCotizacion"]);
						$sumaConceptos = $this->varCotizacion->sumaConceptosCot($_POST["idCotizacion"]);
						$permisosUsuario = $this->varPermiso->verificarPermiso($datosUsuario["idUsuario"],1);
						include_once('../../view/cotizaciones/modalindexcot.php');

						break;

					case 'modificarCotizacion':
						session_start();
						require_once('../model/cotizaciones.php');
						$cotizacion = new cotizaciones();
						$datosCotizacion=$cotizacion->datosCotizacionEspecifica($_GET["idCotizacion"]);
			    		require_once('../model/clientes.php');
						$clientes = new clientes();
						$usuario = $_SESSION["srs_usuario"];
						$datos = $clientes -> listarClientes($usuario);
						$arrayTipoPlan=array('Promotoría o Merchandiser','Demostración o Impulso de Ventas','Administración de nómina');
						$arrayTipoServicio=array('Gestión de personal (Nómina)','Compras de Bienes o Servicios', 'Coordinación y/o Consultoría','Gastos y/o Viáticos');
						$arrayAyuda=array('Asistencias','Materiales o Celulares', 'Gastos Administrativos','Reembolso, Viajes u Hoteles');
						$filaConceptosCot=$cotizacion->listarConceptosCot($_GET["idCotizacion"]);
						$sumaConceptos=$cotizacion->sumaConceptosCot($_GET["idCotizacion"]);
						require_once("../model/conceptos.php");
						$conceptos= new conceptos();
						if(isset($_SESSION["tipoServicio"]))
							$datosConceptos=$conceptos->cargarConceptos($_SESSION["idCliente"],$_SESSION["tipoServicio"]);
						if(isset($_SESSION["subTotal2Mod"]))
							$totalFinal=$sumaConceptos["totalT"]+$_SESSION["subTotal2Mod"];
						else
							$totalFinal=$sumaConceptos["totalT"];

						$totalIva=($totalFinal*.16);
						$totalFIva=$totalFinal+$totalIva;
						include_once("../view/cotizaciones/modcotizacion.php");
						break;

					case 'agregarRubroCotizacion':
						session_start();

			        	if($_POST['txtComisionAgencia']=="")
						{
							$ComisionAgencia=0;
						}
						else
						$ComisionAgencia=$_POST['txtComisionAgencia'];

						$_SESSION['cont']=$_SESSION['cont']+1;
						$_SESSION['fInicial']=$_POST['fInicial'];
						$_SESSION['fFinal']=$_POST['fFinal'];
						$_SESSION['cmbTipoPlanMod'][$_SESSION['cont']]=$_POST['cmbTipoPlan'];
						$_SESSION['cmbTipoServicioMod'][$_SESSION['cont']]=$_POST['cmbTipoServicio'];
						$_SESSION['txtCantidadMod'][$_SESSION['cont']]=$_POST['txtCantidad'];

						$concepto=explode("#", $_POST['cmbTipoConcepto']);
						$_SESSION['idconceptoMod'][$_SESSION['cont']]=$concepto[0];
						$_SESSION['cmbTipoConceptoMod'][$_SESSION['cont']]=$concepto[1];
						$_SESSION['txtDescripcionConceptoMod'][$_SESSION['cont']]=$_POST['txtDescripcionConcepto'];

						$_SESSION['txtPUnitarioMod'][$_SESSION['cont']]=$_POST['txtPUnitario'];
						$_SESSION['txtPUnitarioMostrarMod'][$_SESSION['cont']]=number_format($_SESSION['txtPUnitarioMod'][$_SESSION['cont']],2);
						
						$_SESSION['txtComisionAgenciaModm'][$_SESSION['cont']]=$ComisionAgencia;
						
						$_SESSION["subTotalMod"][$_SESSION['cont']] = $_POST["txtCantidad"]*$_POST['txtPUnitario'];
						$_SESSION["precioTotalMod"][$_SESSION['cont']]=$_SESSION["subTotalMod"][$_SESSION['cont']];

						$pCa = (($_POST["txtComisionAgencia"]/100))*$_SESSION["subTotalMod"][$_SESSION['cont']];
						$_SESSION['txtComisionAgenciaMod'][$_SESSION['cont']] = $pCa;
						
						$_SESSION["subTotalMod"][$_SESSION['cont']] = $pCa+($_POST["txtCantidad"]*$_POST['txtPUnitario']);
						$_SESSION["subTotalMostrarMod"][$_SESSION['cont']]=number_format($_SESSION["subTotalMod"][$_SESSION['cont']],2);

						$_SESSION["subTotal2Mod"]+=$_SESSION["subTotalMod"][$_SESSION['cont']];
						
						header("location:crudCotizaciones.php?accion=modificarCotizacion&idCotizacion=".$_POST["idCotizacionMod"]);

						break;
					case 'eliminarRubroCotizacion':
						session_start();
						$i=$_GET["value"];
						$_SESSION["subTotal2Mod"]-=$_SESSION['subTotalMod'][$i];
						
						unset($_SESSION['cmbTipoPlanMod'][$i]);
						unset($_SESSION['cmbTipoServicioMod'][$i]);
						unset($_SESSION['txtCantidadMod'][$i]);
						unset($_SESSION['cmbTipoConcepto'][$i]);
						unset($_SESSION['txtDescripcionConceptoMod'][$i]);
						unset($_SESSION['txtPUnitarioMod'][$i]);

						unset($_SESSION['txtComisionAgenciaMod'][$i]);
						unset($_SESSION['txtPUnitarioMostrarMod'][$i]);
						unset($_SESSION["subTotalMostrarMod"][$i]);
						

						unset($_SESSION['subTotalMod'][$i]);

						

						$_SESSION['cont']=$_SESSION['cont']-1;
						if ($_SESSION["cont"]==0) 
						{
							unset($_SESSION["subTotal2Mod"],$_SESSION["cont"]);
						}

						for($pos=$i;$pos<=$_SESSION['cont'];$pos++) 
						{
							$_SESSION['cmbTipoPlanMod'][$pos]=$_SESSION['cmbTipoPlanMod'][$pos+1];
							$_SESSION['cmbTipoServicioMod'][$pos]=$_SESSION['cmbTipoServicioMod'][$pos+1];
							$_SESSION['txtCantidadMod'][$pos]=$_SESSION['txtCantidadMod'][$pos+1];
							$_SESSION['cmbTipoConceptoMod'][$pos]=$_SESSION['cmbTipoConceptoMod'][$pos+1];
							$_SESSION['txtDescripcionConceptoMod'][$pos]=$_SESSION['txtDescripcionConceptoMod'][$pos+1];
							$_SESSION['txtPUnitarioMod'][$pos]=$_SESSION['txtPUnitarioMod'][$pos+1];
							
							$_SESSION['txtComisionAgenciaMod'][$pos]=$_SESSION['txtComisionAgenciaMod'][$pos+1];
							$_SESSION['txtPUnitarioMostrarMod'][$pos] = $_SESSION['txtPUnitarioMostrarMod'][$pos+1];
							$_SESSION["subTotalMostrarMod"][$pos] = $_SESSION["subTotalMostrarMod"][$pos+1];
							$_SESSION['subTotalMod'][$pos]=$_SESSION['subTotalMod'][$pos+1];
						}

						header("location:crudCotizaciones.php?accion=modificarCotizacion&idCotizacion=".$_GET["idCotizacion"]);
						break;
					case 'guardarModificacionModal':
						require_once('../model/cotizaciones.php');
						$cotizacion = new cotizaciones();
						$concepto=explode("#",$_POST['cmbTipoConceptoModal']);
						$estado=$cotizacion->estado($_POST["IdCotMod"],"Por autorizar");
						$cotGuardada=$cotizacion->guardarCambiosCotizacion($concepto[0],$_POST['IdCotMod'],$_POST['cmbTipoPlanModal'],$_POST['cmbTipoServicioModal'],$concepto[1],$_POST['txtDescripcionConceptoModal'],$_POST['txtPUnitarioModal'],$_POST['txtCantidadModal'],$_POST['txtSubtotalModal'],$_POST['txtComisionAgenciaModal']);
						if($cotGuardada == true)
						header("location:crudCotizaciones.php?accion=modificarCotizacion&idCotizacion=".$_POST["idCotizacionModal"]);
						else
							print_r($concepto);
						break;

					case 'eliminarRubroModificacion':
						require_once('../model/cotizaciones.php');
						$cotizacion = new cotizaciones();
						$rubroEliminado = $cotizacion->eliminarRubroCotizacion($_GET["idRubro"]);
						$cotizacion->estado($_GET["idCotizacion"],"Por autorizar");
						if($rubroEliminado == true)
							header("location:crudCotizaciones.php?accion=modificarCotizacion&idCotizacion=".$_GET["idCotizacion"]);
						break;

					case 'guardarModificacionCot':
						session_start();
						require_once('../model/clientes.php');
						$cliente = new clientes();
						$claveCliente = $cliente->datosClienteEspecifico($_POST["idCliente"]);
						require_once('../model/cotizaciones.php');
						$cotizaciones= new cotizaciones();
						$numeroCotizacion=$cotizaciones->numeroCotizacion($claveCliente["clave_cliente"]);
						if($claveCliente["clave_cliente"] == $_POST["clave_cliente"])
							$numeroCotizacion=$_POST["idNcotizacion"];
						else
							$numeroCotizacion=$numeroCotizacion["cotizacion"];

						$modCotGuardada=$cotizaciones->guardarModificacionCot($_POST["idCotizacion"],$_POST["idCliente"],$_POST["fInicial"],$_POST["fFinal"],$_POST["servicio"],$numeroCotizacion);

						for($pos=1;$pos<=$_SESSION['cont'];$pos++)
							{
								$resultadoConceptosCotizacion=$cotizaciones->almacenarCotConceptos($_POST["idCotizacion"],$_SESSION['idconceptoMod'][$pos],$_SESSION['cmbTipoPlanMod'][$pos],$_SESSION['cmbTipoServicioMod'][$pos],$_SESSION['cmbTipoConceptoMod'][$pos],$_SESSION['txtDescripcionConceptoMod'][$pos],$_SESSION['txtPUnitarioMod'][$pos],$_SESSION['txtCantidadMod'][$pos],$_SESSION["precioTotalMod"][$pos],$_SESSION['txtComisionAgenciaMod'][$pos],$_SESSION["subTotalMod"][$pos],$_SESSION['txtComisionAgenciaModm'][$pos]);
							}
							for($i=1;$i<=$_SESSION['cont'];$i++) 
						    {     
								unset($_SESSION['cmbTipoPlanMod'][$i]);
								unset($_SESSION['cmbTipoServicioMod'][$i]);
								unset($_SESSION['txtCantidadMod'][$i]);
								unset($_SESSION['cmbTipoConceptoMod'][$i]);
								unset($_SESSION['txtDescripcionConceptoMod'][$i]);
								unset($_SESSION['txtPUnitarioMod'][$i]);

								unset($_SESSION['txtComisionAgenciaModm'][$i]);
								unset($_SESSION['txtPUnitarioMod'][$i]);
								unset($_SESSION["subTotalMod"][$i]);
								

								unset($_SESSION['subTotalMod'][$i]);
						                       
						    }
						    $_SESSION['cont']=0;
						    $_SESSION['subTotal2Mod']=0;

						if($modCotGuardada == true)
							//header("location:crudCotizaciones.php?accion=modificarCotizacion&idCotizacion=".$_POST["idCotizacion"]);
							echo"La modificacion se guardo correctamente";
						else
							echo"Error al intentar guardar los datos modificados";
					break;

				    default:
						header("location:../view/index.php");	
						break;	
				}
			}
			else{
				header("Location: index.php?accion=index");
			}
		}
		else
			header("Location: ../index.php?accion=login");
	}
}

?>