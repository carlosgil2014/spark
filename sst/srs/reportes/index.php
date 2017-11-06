<?php
require_once('../conexion.php');
session_start();
  if(!isset($_SESSION['srs_usuario']))
    header('Location: ../view/index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <title>IntraNet | Spar Todopromo</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!--Jquery css-->
    <link rel="stylesheet" href="../css/jquery-ui.css">

    <!-- DataTables CSS -->
    <link href="../css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom Fonts -->
    <link href="../css/estilo.css" rel="stylesheet" type="text/css">
    
    <!-- Jquery multiselect -->
    <link rel="stylesheet" href="../css/jquery.multiselect.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<!--Carga los campos de cliente,Servicio,tipo de plan, tipo de servicio con un valor estatico-->

</head>

<body>
    <div class="loader">  
        <label class="cargando" >CARGANDO...</label>
    </div>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../view/index.php">Módulo de Reportes</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="../controller/crudIndex.php?urlValue=logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="../view/index.php"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
              <br>
              <br>
              <div class="col-lg-12">
                <h1 class="page-header">Reportes</h1>
              </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <!--Muestra la clave, año y el numero de cotización-->
                <div id="lblCot"class="form-group col-xs-12 col-lg-12 text-right" >
                </div>

                <div class="row">
                  <div class="form-group col-xs-12 col-lg-6" >
                    <label>Cliente</label>
                    <div class="row">
                      <div class="form-group col-xs-8 col-lg-11" >

                        <select class="form-control input-sm reporte" name="cmbClientes" multiple="multiple" size="1" id="IdcmbClientes" required>
                            <?php
                              /////////Conecta a la BD para mostrar los clientes almacenados en el combobox/////////////////
                            $queryUsuario = "SELECT idusuarios FROM tblusuarios where user_name = '".$_SESSION['srs_usuario']."'";
                            $resultadoUsuario = mysql_query($queryUsuario,$conexion)or die(mysql_error());
                            $idUsuario = mysql_fetch_assoc($resultadoUsuario);
                                         
                              $query="SELECT idclientes,rfc,concat(razon_soc,' | ',rfc,' | ',nom_comercial) as cliente FROM tblclientes WHERE idclientes IN (SELECT idcliente FROM tblusuariosclientes WHERE idusuario = ".$idUsuario['idusuarios'].") order by razon_soc";                   
                              $resul=mysql_query($query,$conexion)or die(mysql_error());
                                while($cliente=mysql_fetch_assoc($resul))                
                                  {           
                                  ?>
                                    <option value="<?php echo $cliente['idclientes'] ?>">&nbsp;&nbsp;<?php echo utf8_encode($cliente["cliente"]);?></option>
                                  <?php  
                                  }
                                  ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group col-xs-12 col-lg-3" >
                    <label>De</label>
                    <input type="date" class="form-control reporte" id="fechaIn" value="<?php echo date('Y-m-d');?>" name="numIn"  required>
                  </div>
                  <div class="form-group col-xs-12 col-lg-3" >
                    <label>Hasta</label>
                    <input type="date" class="form-control reporte" id="fechaFin" value="<?php echo date('Y-m-d');?>" name="numFin"  required>
                  </div>
                  </div>
                </div>
            <?php
            $fila = 0;
            $cont = 0;
                $campos = array("COTIZACIÓN","ORDEN","PREFACTURA","CFDI","FECHA DE CFDI","ELABORÓ","CLIENTES","TIPO DE PLAN","TIPO DE SERVICIO","CANTIDAD","CONCEPTO","NOTA","P. UNITARIO","P. TOTAL","COMISIÓN ($)","COMISIÓN (%)","SUBTOTAL","ESTADO","ESTATUS","FECHA INICIAL","FECHA FINAL","ÚLTIMA MODIFICACIÓN OS","DESCUENTO","MOTIVO DE DESCUENTO","POLIZA","FOLIO"); 
            ?>
            <div class="row">
              <div class="row grupoRadios" hidden="hidden">
                <div class="form-group  col-lg-12" >
                        <table class="table table-condensed">
                          <?php
                          foreach ($campos as $campo) 
                          {
                            $cont++;
                            if($cont == 1 || $cont == 14)
                            {
                          ?>
                          <tr>
                          <?php
                            }
                          ?>

                            <td class="info text-center">
                              <input type="checkbox" class="campos" value="<?php echo $campo; ?>" checked>
                            </td>
                            <td class="info text-center"><label style="font-size:.6em;"><?php echo $campo;?></label>
                            </td>
                          <?php
                          }
                          ?>
                        </table>
                      <div class="panel-body text-center">
                          <label class="col-lg-3">
                            <input type="radio" class="reporte" name="radio" id="checkCotizacion" onclick="filtrar()"> Cotizaciones
                          </label>
                          <label class="col-lg-3">
                            <input type="radio" class="reporte" name="radio" id="checkoOrden" onclick="filtrar()"> Ordenes de Servicio
                          </label>
                          <label class="col-lg-3">
                            <input type="radio" class="reporte" name="radio" id="checkPrefacturas" onclick="filtrar()"> Prefacturas
                          </label>
                          <label>
                            <input type="radio" class="reporte" name="radio" id="checkFacturas" onclick="filtrar()"> Facturas
                          </label>
                      </div>
                </div>
              </div>
          </div>
      
      <div class="ocultarCategorias" hidden>    
          <div class="row" >
          <!-- <div class="col-lg-1"></div> -->
              
              <div class="ocultarCotizaciones" hidden>
              <div class="col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right"> 
                                    <?php
                                         $cConceptos= new conceptos();
                                         $consultaNumRegistrosA="select count(*) as total from tblcotizaciones where estado = 'Autorizada'";
                                         $consultaNumRegistrosP="select count(*) as total from tblcotizaciones where estado = 'Por autorizar'";
                                         $consultaNumRegistrosR="select count(*) as total from tblcotizaciones where estado = 'Rechazada'";
                                         $consultaNumRegistrosC="select count(*) as total from tblcotizaciones where estado = 'Cancelada'";
                                         $numeroRegistrosA=mysql_query($consultaNumRegistrosA,$cConceptos->conDB())or die(mysql_error());
                                         $numeroRegistrosP=mysql_query($consultaNumRegistrosP,$cConceptos->conDB())or die(mysql_error());
                                         $numeroRegistrosR=mysql_query($consultaNumRegistrosR,$cConceptos->conDB())or die(mysql_error());
                                         $numeroRegistrosC=mysql_query($consultaNumRegistrosC,$cConceptos->conDB())or die(mysql_error());
                                         $resultadoRegistrosA = mysql_fetch_assoc($numeroRegistrosA);
                                         $resultadoRegistrosP = mysql_fetch_assoc($numeroRegistrosP);
                                         $resultadoRegistrosR = mysql_fetch_assoc($numeroRegistrosR);
                                         $resultadoRegistrosC = mysql_fetch_assoc($numeroRegistrosC);
                                     ?>
                                    <div class="huge">A<!--<?php //echo $resultadoRegistros['total']; ?>--></div>
                                    <div>Cotizaciones</div>
                                </div>
                            </div>
                        </div>
                            <div class="panel-footer">
                                <input type="checkbox" class="reporte pull-left checkboxCot" id="idCheckCotRevision" value="Por autorizar">
                                    <span class="pull-left">&nbsp;Por autorizar</span>
                                    <span class="pull-right"><?php //echo $resultadoRegistrosP['total']; ?></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxCot" id="idCheckCotAutorizada" value="Autorizada">
                                    <span class="pull-left">&nbsp;Autorizadas</span>
                                    <span class="pull-right"><?php //echo $resultadoRegistrosA['total']; ?></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxCot" id="idCheckCotRechazada" value="Rechazada" >
                                    <span class="pull-left">&nbsp;Rechazadas</span>
                                    <span class="pull-right"><?php //echo $resultadoRegistrosR['total']; ?></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxCot" id="idCheckCotCancelada" value="Cancelada" >
                                    <span class="pull-left">&nbsp;Canceladas</span>
                                    <span class="pull-right"><?php //echo $resultadoRegistrosC['total']; ?></span>
                                <div class="clearfix"></div>
                                <!-- <input type="checkbox" class="reporte pull-left checkboxCot" value="Cerradas" onchange="filtrar();">
                                    <span class="pull-left">&nbsp;Cerradas</span> -->
                                    <span class="pull-right"></span>
                                <div class="clearfix"></div>
                            </div>
                    </div>
                    </div>
                    </div>

              <div class="ocultarOrdenes" hidden>
                  <div class="col-lg-3">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-paste fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 
                                    $cConceptos= new conceptos();
                                    $consultaNumOrdenesP="select count(*) as total from tblordenesdeservicio where estado = 'Por autorizar'";
                                    $consultaNumOrdenesA="select count(*) as total from tblordenesdeservicio where estado = 'Autorizada'";
                                    $consultaNumOrdenesR="select count(*) as total from tblordenesdeservicio where estado = 'Rechazada'";
                                    $consultaNumOrdenesC="select count(*) as total from tblordenesdeservicio where estado = 'Cancelada'";
                                    $numeroOrdenesP=mysql_query($consultaNumOrdenesP,$cConceptos->conDB())or die(mysql_error());
                                    $numeroOrdenesA=mysql_query($consultaNumOrdenesA,$cConceptos->conDB())or die(mysql_error());
                                    $numeroOrdenesR=mysql_query($consultaNumOrdenesR,$cConceptos->conDB())or die(mysql_error());
                                    $numeroOrdenesC=mysql_query($consultaNumOrdenesC,$cConceptos->conDB())or die(mysql_error());
                                    $resultadoOrdenesP = mysql_fetch_assoc($numeroOrdenesP);
                                    $resultadoOrdenesA = mysql_fetch_assoc($numeroOrdenesA);
                                    $resultadoOrdenesR = mysql_fetch_assoc($numeroOrdenesR);
                                    $resultadoOrdenesC = mysql_fetch_assoc($numeroOrdenesC);

                                ?>
                                    <div class="huge">B<!--<?php //echo $resultadoOrdenes['total']; ?>--></div>
                                    <div>Ordenes de servicio</div>
                                </div>
                            </div>
                        </div>
                                <div class="panel-footer">
                                <input type="checkbox" class="reporte pull-left checkboxOrdenes" id="idCheckOrdenRevision" value="Por autorizar">
                                    <span class="pull-left">&nbsp;En revisión</span> <!--amarillo-->
                                    <span class="pull-right"><?php //echo $resultadoOrdenesP['total']; ?></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxOrdenes" id="idCheckOrdenAutorizadas" value="Autorizada">
                                    <span class="pull-left">&nbsp;Autorizadas</span> <!--verde-->
                                    <span class="pull-right"><?php //echo $resultadoOrdenesA['total']; ?></span>
                                
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxOrdenes" id="idCheckOrdenRechazadas" value="Rechazada">
                                    <span class="pull-left">&nbsp;Rechazadas</span> <!--negro-->
                                    <span class="pull-right"><?php //echo $resultadoOrdenesR['total']; ?></span>
                                
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxOrdenes" id="idCheckOrdenCanceladas" value="Cancelada">
                                    <span class="pull-left">&nbsp;Canceladas</span> <!--rojo-->
                                    <span class="pull-right"><?php //echo $resultadoOrdenesC['total']; ?></span>
                                
                                <div class="clearfix"></div>
                                <!-- <input type="checkbox" class="reporte pull-left checkboxOrdenes" id="idCheckOrdenCerradas" value="Cerrada" onchange="filtrar();">
                                    <span class="pull-left">&nbsp;Cerradas</span> -->
                                    <span class="pull-right"></span>
                                
                            </div>
                    </div>
                  </div>
                </div>

                <div class="ocultarPrefacturas" hidden>
                <div class="col-lg-3">
                   <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $cConceptos= new conceptos();
                                        $consultaNumPrefacturasP="select count(*) as total from tblprefacturas where estado = 'Por facturar'";
                                        $consultaNumPrefacturasF="select count(*) as total from tblprefacturas where estado = 'Facturada' ";
                                        $consultaNumPrefacturasC="select count(*) as total from tblprefacturas where estado = 'Cancelada' ";
                                        $consultaNumPrefacturasCe="select count(*) as total from tblprefacturas where estado = 'Cerrada' ";
                                        $numeroPrefacturasP=mysql_query($consultaNumPrefacturasP,$cConceptos->conDB())or die(mysql_error());
                                        $numeroPrefacturasF=mysql_query($consultaNumPrefacturasF,$cConceptos->conDB())or die(mysql_error());
                                        $numeroPrefacturasC=mysql_query($consultaNumPrefacturasC,$cConceptos->conDB())or die(mysql_error());
                                        $numeroPrefacturasCe=mysql_query($consultaNumPrefacturasCe,$cConceptos->conDB())or die(mysql_error());
                                        $resultadoPrefacturasP = mysql_fetch_assoc($numeroPrefacturasP);
                                        $resultadoPrefacturasF = mysql_fetch_assoc($numeroPrefacturasF);
                                        $resultadoPrefacturasC = mysql_fetch_assoc($numeroPrefacturasC);
                                        $resultadoPrefacturasCe = mysql_fetch_assoc($numeroPrefacturasCe);
                                    ?>
                                    <div class="huge">C<!--<?php //echo $resultadoPrefacturas['total']; ?>--></div>
                                    <div>Prefacturas</div>
                                </div>
                            </div>
                        </div>
                            <div class="panel-footer">
                            <input type="checkbox" class="reporte pull-left checkboxPrefacturas" id="idCheckPrefacturaporFacturar" value="Por facturar">
                                <span class="pull-left">&nbsp;Por facturar</span>
                                <span class="pull-right"><?php //echo $resultadoPrefacturasP['total']; ?></span>
                            
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxPrefacturas" id="idCheckPrefacturaFacturada" value="Facturada">
                                <span class="pull-left">&nbsp;Facturadas</span>
                                <span class="pull-right"><?php //echo $resultadoPrefacturasF['total']; ?></span>
                            
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxPrefacturas" id="idCheckPrefacturaCancelada" value="Cancelada">
                                <span class="pull-left">&nbsp;Canceladas</span>
                                <span class="pull-right"><?php //echo $resultadoPrefacturasC['total']; ?></span>
                            
                            
                                
                                <!-- <input type="checkbox" class="reporte pull-left checkboxPrefacturas" id="idCheckPrefacturaCerrada" value="Cerrada" onchange="filtrar();">
                                 <span class="pull-left">&nbsp;Cerradas</span> 
                                <span class="pull-right"></span> -->
                            
                                <div class="clearfix"></div>
                                <span class="pull-left"> </span>
                                <span class="pull-right"><i class="fa"></i></span>
                                <div class="clearfix"></div>
                             
                            </div>                    
                    </div>
                </div>
                </div>

                <div class="ocultarFacturas" hidden>
                  <div class="col-lg-3">
                     <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-money fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                    $cConceptos= new conceptos();
                                    $consultaNumCfdi="select count(*) as total from tblprefacturas where cfdi != ''";
                                    $numeroCfdi=mysql_query($consultaNumCfdi,$cConceptos->conDB())or die(mysql_error());
                                    $resultadoCfdi = mysql_fetch_assoc($numeroCfdi);?>
                                    <div class="huge">D<!--<?php //echo $resultadoCfdi['total']; ?>--></div>
                                    <div>Facturas</div>
                                </div>
                            </div>
                        </div>
                        
                            <div class="panel-footer">
                               
                                <input type="checkbox" class="reporte pull-left checkboxFacturas" id="idCheckPrefacturanoPagadas" value="nopagado">
                                <span class="pull-left">&nbsp;No pagadas</span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxFacturas" id="idCheckPrefacturapPagadas" value="parcialmente">
                                <span class="pull-left">&nbsp;Pagadas parcialmente</span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxFacturas" id="idCheckPrefacturaPagadas" value="pagado">
                                <span class="pull-left">&nbsp;Pagadas</span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                                <input type="checkbox" class="reporte pull-left checkboxFacturas" id="idCheckPrefacturaCanceladas" value="Cancelada">
                                <span class="pull-left">&nbsp;Canceladas</span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                                <!-- <input type="checkbox" class="reporte pull-left checkboxFacturas" value="" onchange="filtrar();">
                                <span class="pull-left">&nbsp;Cerradas</span> -->
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                                <span class="pull-left"></span>
                                <span class="pull-right"><i class="fa"></i></span>
                               
                            </div>
                    </div>
                  </div>
                </div>

                <br><br>
                  <div class="form-group col-xs-12 col-lg-3 tipoPlanServicio" hidden>
                  <label >Tipo de plan</label>        
                  <select tabindex="5" class="form-control" name="cmbTipoPlan" size="1" id="IdcmbTipoPlan" required >
                    <option disabled selected value="">--- Seleccione ---</option>
                              <!--Muestra el tipo de plan seleccionado-->
                    <?php
                      $arraytipoplan = array('Todos','Promotoría o Merchandiser','Demostración o Impulso de ventas','Administración de nómina' );
                      for ($i=0; $i < 4 ; $i++) 
                      {
                        echo "<option value='".$arraytipoplan[$i]."'>".$arraytipoplan[$i]."</option>";
                      }
                    ?>
                  </select>

                   <label >Tipo de servicio</label>       
                  <select tabindex="6" class="form-control" name="cmbTipoServicio" size="1" id="IdcmbTipoServicio" required>
                    <option disabled selected value="">--- Seleccione ---</option>
                    <!--Muestra el tipo de servicio seleccionado-->
                      <?php
                        $arraytiposervicio = array('Todos','Gestión de personal (Nómina)','Compras de Bienes o Servicios', 'Coordinación y/o Consultoría','Gastos y/o Viáticos');
                        for ($i=0; $i < 5 ; $i++) 
                        { 
                          echo "<option value='".$arraytiposervicio[$i]."'>".$arraytiposervicio[$i]."</option>";
                        }
                      ?>
                  </select>
                  <br>
                  <button type="button" class="btn btn-primary btn-sm" name="btnBuscar" id="IdBtnBuscar" onclick="filtrar();"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                  <button type="button" class="btn btn-primary btn-sm" name="btnExportar" id="IdBtnExportar" style="display:none;"><i class="fa fa-file-excel-o"></i> Exportar</button>
                  <!-- <input type="button" class="btn btn-primary btn-sm pull-right" name="btnExportar" value="Exportar"> -->
                </div>

                </div>

              

                <div class="form-group col-xs-12 col-lg-3">
                </div>
                <div class="form-group col-xs-12 col-lg-2 pull-right tipoPlanServicio" hidden>
                  <label >Total</label>
                  <input type="text" class="form-control text-right" id="idTotal" name="subTotal" readonly="readonly" style="background-color: white">
                </div>
                
             
              <div class="row">
                <form action="exportar.php" method="post" id="idExportar">
                  <div class="tablareportes col-lg-12">
                  
                  </div>
                </form>
              </div>

              <!--Dialogo Jquery UI-->
              <div id="confirmacion" title="Aviso" style="display:none">
                  <p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>¡No existen datos con el Tipo de plan y Tipo de servicio seleccionado!</p>
              </div>

              <div class="modal fade" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        Procesando... Porfavor espere!
                    </div>
                    <div class="modal-body">
                      <div class="progress">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 100%">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              </div>
            </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>

      <!-- Ui jQuery-->
    <script src="../js/jquery-ui.min.js"></script>

    <!--Multi select  -->
    <script src="../js/jquery.multiselect.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>

    <script src="../js/reportes/reportes.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>
    <!-- JS Natural -->
    <script src="../js/natural.js"></script>

     <script>
    $(document).ready(function() {
       
    });

    function cambiarTitulo(titulo){
        document.getElementById('IdTituloOperaciones').innerHTML = titulo;   


    }
    </script>

</body>

</html>
