<?php
    if(!isset($_SESSION['spar_usuario']))
        header('Location: ../view/index.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
        <title>IntraNet | Spar Todopromo</title>
        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">
        <!-- DataTables CSS -->
        <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="../css/dataTables.responsive.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
        <!--Jquery css-->
        <link rel="stylesheet" href="../css/jquery-ui.css">
        <!--Multiselect css-->
        <link rel="stylesheet" href="../css/jquery.multiselect.css">
        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../css/estilo.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="../js/jquery.min.js"></script>
    </head>
    <body>
        <div class="loader">  
            <label class="cargando" >CARGANDO...</label>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalExpiracion" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <p>En menos de 5 minutos expirará su sesión</p>
                    </div>
              </div>
            </div>
        </div>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../">Módulo de Operaciones v.1.2</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">
                    <li class="">
                        <a class="dropdown-toggle btnBuscar" title="Actualizar" href="#" >
                            <i class="fa fa-refresh fa-fw"></i>  
                        </a>
                    </li>
                    <!-- <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i>  
                            <span class="badge" id="cotNuevas">Número cot u ords por autorizar</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a data-toggle="tab" href="#" id="mensajePa" class="tablaPost" value="Por autorizar" tabla="Cotizaciones" onclick="cambiarTitulo('Cotizaciones');" >
                                    <div> 
                                        <i class="fa fa-file fa-fw" > </i>
                                        <label id="cotNuevastxt">cotizaciones u ordenes por autorizar</label>    
                                    </div>
                                </a>
                            </li>                        
                        </ul> -->
                        <!-- /.dropdown-alerts -->
                    <!-- </li> -->
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                            </li>-->
                            <?php if($resultados["conceptos"]["crear"] == 1){?>
                            <li>
                                <a href="../controller/crudConceptos.php?accion=listarConceptos"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
                            </li>
                            <?php 
                            }
                            ?>
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

                            <?php if($resultados["cotizaciones"]["crear"] == 1){?>
                            <li>
                                <a href="../controller/crudCotizaciones.php?accion=listarDatos"><i class="fa fa-file"></i> Cotizaciones</a>
                            </li>
                            <?php
                            }
                            if($resultados["ordenes"]["crear"] == 1){
                            ?>
                            <li>
                                <a href="../controller/crudOrdenes.php?accion=listaClientes"><i class="fa fa-clipboard"></i> Ordenes de Servicio</a>
                            </li>
                             <?php
                            }
                            if($resultados["prefacturas"]["crear"] == 1){
                            ?>
                            <li>
                                <a href="../controller/crudPrefacturas.php?accion=listaClientes"><i class="fa fa-file-text"></i> Prefacturas</a>
                            </li>
                            <!-- <li>
                                <a href="controller/crudNotasdecredito.php?accion=listaClientes"><i class="fa fa-file-text-o"></i> Notas de Crédito</a>
                            </li> -->
                             <?php
                            }
                            if($resultados["reportes"]["crear"] == 1){
                            ?>
                            <li> 
                                <a style="cursor:pointer;"><i class="glyphicon glyphicon-list-alt"></i> Reportes</a>
                                <ul>
                                    <li>
                                        <a href="../reportes/index.php"><i class="glyphicon glyphicon-list-alt"></i> General</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="crudReportes.php?accion=listaClientes"><i class="fa fa-clipboard"></i> Ventas</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="crudReportes.php?accion=listaClientesFacturacion"><i class="fa fa-file-text"></i> Facturación</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="crudReportes.php?accion=listaClientesTotal"><i class="fa fa-file-text"></i> Total</a>
                                    </li>
                                </ul>
                            </li>
                             <?php
                            }
                            if($resultados["estadodecuenta"]["crear"] == 1){
                            ?>
                           <!--  <li>
                                <a href="../estadocuenta/index.php"><i class="fa fa-dollar"></i> Estado de cuenta</a>
                            </li> -->
                             <?php
                            }
                            ?>
                            <li>
                                <a href="../controller/crudIndex.php?urlValue=login&principal=0"><i class="fa fa-clipboard"></i> Conciliaciones</a>
                            </li>
                            <li>
                                <a href="../controller/crudDevoluciones.php?accion=listaClientes"><i class="fa fa-file-text"></i> Devoluciones</a>
                            </li>
                            <!-- <li>
                                <a><i class="fa fa-paste"></i> OS por Facturar <span class="badge"><?php echo $_SESSION["contPorFacturar"];?></span></a>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">Total :</span>
                                    <input type="text" name="" value="<?php echo "$ ".number_format( $_SESSION["saldoTotalPorFacturarIndex"],2);?>" class="form-control input-sm text-right" disabled>
                                </div>
                            </li>
                            <li>
                                <a><i class="fa fa-file-text"></i> OS por Realizar <span class="badge"><?php echo $_SESSION["contPf"];?></span></a>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">Total :</span>
                                    <input type="text" name="" value="<?php echo "$ ".number_format($_SESSION["totalPf"],2);?>" class="form-control input-sm text-right" disabled>
                                </div>
                            </li> -->
                            <li>
                                <a href="#">OS por Facturar<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li onclick="saldosPorFacturar(this,'16');">
                                        <a href="#">2016<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level collapse">
                                            <li>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                    <li onclick="saldosPorFacturar(this,'17');">
                                        <a href="#">2017<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level collapse">
                                            <li>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#">OS por Realizar<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li onclick="osPorRealizar(this,'16');">
                                        <a href="#">2016<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level collapse">
                                            <li>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                    <li onclick="osPorRealizar(this,'17');">
                                        <a href="#">2017<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level collapse">
                                            <li>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="../controller/crudIndex.php?urlValue=logout"><i class="fa fa-arrow-circle-left"></i> Salir</a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <br>
            <br>
            <div id="page-wrapper">
            	<div class="row">
                    <div class="col-lg-12">
                        <br/>
                        <div class="col-lg-12">
                            <h6 class="pull-right" ><?php echo $nombre;?></h6>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
	            	<form method="POST" id="formPrincipal" action="crudPrincipal.php?accion=datosCount" >
	                    <div class="form-group col-lg-7">
                            <label>&nbsp;</label>
                            <div class="btn-group btn-block">
                                <button type="button" class="btn btn-block btn-sm dropdown-toggle" data-toggle="dropdown"> Clientes  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu col-lg-12" role="menu" style="height: auto; max-height: 200px; overflow-x: hidden;">
                                    &nbsp;<label><a href="#" class="seldesClientes" value="0">Seleccionar todos</a></label>
                                    &nbsp;<label><a href="#" class="seldesClientes" value="1">Deseleccionar todos</a></label>
                                    <?php 
                                        foreach ($datos as $cliente) {
                                        ?>
                                        <div class="checkbox">
                                          &nbsp;<label>
                                                    <input class="checkBox" type="checkbox" name="Datos[idCliente][]" value="<?php echo $cliente['idclientes']?>" 
                                                        <?php 
                                                        if(isset($idClientes))
                                                            for ($i=0; $i < count($idClientes) ; $i++) { 
                                                                if($idClientes[$i] == $cliente['idclientes'])
                                                                    echo "checked";
                                                            }   
                                                        ?>/><?php echo $cliente['cliente']?>
                                                </label>
                                        </div>
                                        <?php 
                                        }
                                    ?> 
                              </ul>
                            </div>
	                    </div>
	                    <div class="form-group col-lg-2" >
	                        <label>De</label>
	                        <input  type="date" class="form-control input-sm" value="<?php if(isset($fechaInicial))echo $fechaInicial; else echo $fecha;?>" name="Datos[fechaInicial]" required>
	                    </div>
	                    <div class="form-group  col-lg-2" >
	                        <label>Hasta</label>
	                        <input type="date" class="form-control input-sm" value="<?php if(isset($fechaFinal))echo $fechaFinal; else echo $fecha;?>" name="Datos[fechaFinal]" required>
	                    </div>
	                </form>
                    <div class="form-group col-lg-1" >
                        <label>&nbsp;</label>
                        <button class="btn btn-primary btn-sm btnBuscar">Buscar</button>
                    </div>
	            </div>
                <!-- /.row -->
                <?php 
                if(isset($datosCount))
                {
                ?>
                <div class="row" id="divIndex">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right"> 
                                        <div class="huge">A<!--<?php //echo $resultadoRegistros['total']; ?>--></div>
                                        <div>Cotizaciones</div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer">
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Por autorizar" tabla="Cotizaciones">
                                        <span class="pull-left">Por autorizar</span>
                                        <span class="pull-right"><?php echo $datosCount["cotPA"];?></span>
                                    <a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Autorizada" tabla="Cotizaciones"  >
                                        <span class="pull-left">Autorizadas</span>
                                        <span class="pull-right"><?php echo $datosCount["cotA"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Rechazada" tabla="Cotizaciones">
                                        <span class="pull-left">Rechazadas</span>
                                        <span class="pull-right"><?php echo $datosCount["cotR"];?></span>
                                    <a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Cancelada" tabla="Cotizaciones">
                                        <span class="pull-left">Canceladas</span>
                                        <span class="pull-right"><?php echo $datosCount["cotC"];?></span>
                                    <a>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">     
                                <div class="row">
                                    <div class="col-xs-3 text-right">
                                        <i class="fa fa-paste fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">B<!--<?php //echo $resultadoOrdenes['total']; ?>--></div>
                                        <div>Ordenes de servicio</div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer">
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Por autorizar" tabla="Ordenes">
                                        <span class="pull-left">En revisión</span> <!--amarillo-->
                                        <span class="pull-right"><?php echo $datosCount["ordPA"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Autorizada" tabla="Ordenes" >
                                        <span class="pull-left">Autorizadas</span> <!--verde-->
                                        <span class="pull-right"><?php echo $datosCount["ordA"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                    <!-- <a data-toggle="tab" href="#" class="tablaPost" estado="Rechazada" tabla="Ordenes" >
                                        <span class="pull-left">Rechazadas</span>
                                        <span class="pull-right"><?php echo $datosCount["ordR"];?></span>
                                    </a> -->
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Cancelada" tabla="Ordenes" >
                                        <span class="pull-left">Canceladas</span> <!--rojo-->
                                        <span class="pull-right"><?php echo $datosCount["ordC"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Devolucion" tabla="Ordenes" >
                                        <span class="pull-left">Devoluciones</span> <!--negro-->
                                        <span class="pull-right"><?php echo $datosCount["ordR"];?></span>
                                    </a>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" id="divCambio">
                        <div id="prefacturas">
                            <div class="panel panel-yellow" >
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">C<!--<?php //echo $resultadoPrefacturas['total']; ?>--></div>
                                            <div> Prefacturas <!-- <a id="cambio" value="pf" style="color:white; cursor:pointer;"><i class="fa fa-exchange"></i></a> --></div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="panel-footer">
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Por facturar" tabla="Prefacturas">
                                        <span class="pull-left">Por facturar</span>
                                        <span class="pull-right"><?php echo $datosCount["pfPF"];?></span>
                                    </a>
                                        <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Facturada" tabla="Prefacturas">
                                        <span class="pull-left">Facturadas</span>
                                        <span class="pull-right"><?php echo $datosCount["pfF"];?></span>
                                    </a>
                                        <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Cancelada" tabla="Prefacturas">
                                        <span class="pull-left">Canceladas</span>
                                        <span class="pull-right"><?php echo $datosCount["pfC"];?></span>
                                    </a>
                                        <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" estado="Conciliado" tabla="Prefacturas">
                                        <span class="pull-left">Conciliadas</span>
                                        <span class="pull-right"><?php echo $datosCount["pfCl"];?></span>
                                    </a>
                                        <span class="pull-left"> </span>
                                        <span class="pull-right"><i class="fa"></i></span>
                                        <div class="clearfix"></div>
                                    </div>                    
                            </div>
                        </div>
                    </div>
                    <!-- <div id="notasDeCredito" hidden>
                        <div class="panel" style="background-color: #FF8000; color: #FFFFFF;" >
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">C</div>
                                        <div>Notas de Crédito <a id="cambio" value="nc" style="color:white; cursor:pointer;"><i class="fa fa-exchange"></i></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <a data-toggle="tab" href="#" class="tablaPost" tabla="Notas" value="" onclick="cambiarTitulo('Notas de Crédito');">
                                    <span class="pull-left" style="color: #FF8000;" >Total</span>
                                    <span class="pull-right"><i class="fa" style="color: #FF8000;">Num</i></span>
                                </a>
                                    <div class="clearfix"></div>
                                    <span class="pull-left"></span>
                                    <span class="pull-right"><i class="fa"></i></span>
                                    <div class="clearfix"></div>
                                    <span class="pull-left"></span>
                                    <span class="pull-right"><i class="fa"></i></span>
                                    <div class="clearfix"></div>
                                    <span class="pull-left"> </span>
                                    <span class="pull-right"><i class="fa"></i></span>
                                    <div class="clearfix"></div>
                            </div>                    
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-money fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">D<!--<?php //echo $resultadoCfdi['total']; ?>--></div>
                                        <div>Facturas</div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer">
                                    <a data-toggle="tab" href="#" class="tablaPost" tabla="Cobrado" estado="Nopagado">   
                                        <span class="pull-left">No pagadas</span>
                                        <span class="pull-right"><?php echo $datosCount["facNP"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" tabla="Cobrado" estado="Parcialmente" >                            
                                            <span class="pull-left">Parcialmente pagadas</span>
                                            <span class="pull-right"><?php echo $datosCount["facPP"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" tabla="Cobrado" estado="Pagado">                            
                                            <span class="pull-left">Pagadas</span>
                                            <span class="pull-right"><?php echo $datosCount["facP"];?></span>
                                    </a>
                                        <div class="clearfix"></div>
                                    <a data-toggle="tab" href="#" class="tablaPost" tabla="Cobrado" estado="Cancelada"> 
                                        <span class="pull-left">Canceladas</span>
                                        <span class="pull-right"><?php echo $datosCount["pfC"];?></span>
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <!-- /.row -->
                <div class="tab-content">
                    <div  class="row tab-pane fade in active" id="COPC">
                    </div>
                </div>







            </div>
            <!-- /#page-wrapper -->
            <div id="modalCot" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header" id="IdModalCotizacion">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal ORDEN -->
            <div id="modalOrden" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" id="IdModaldetalle">
                        </div>
                    </div>
                </div>
            </div>
            <div id="modalPf" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header" id="IdModaldetallePf">
                    </div>
                </div>
              </div>
            </div>
            <div id="modalCobrado" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" id="IdModaldetalleCobrado">
                        </div>
                    </div>
                </div>
            </div>
            <div id="modalNota" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" id="IdModaldetalleNota">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#wrapper -->
        <!--Dialogo Jquery UI-->
        <div id="confirmacion" title="Aviso" style="display:none">
                 <p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>¿Estás seguro de realizar una copia de está cotización?</p>
                <!--  <input type="radio" id="pNoanticipada" name="pago" value="Noanticipado"checked> No anticipada
                 <input type="radio" id="pAnticipada" name="pago" value="Anticipado"> Anticipada -->
        </div>
        <!--Dialog motivo de cancelación de factura-->
        <div id="motivoCancelacionFactura" title="Motivo!" style="display:none">
            <textarea id="idMotivoCancelacionFactura" style="resize:none; width:100%; font-size: 8pt; height: 70px;"></textarea>
        </div>
        <div id="motivo" title="Motivo" style="display:none">
            <textarea id="motivoText" style="resize:none; width:100%; font-size: 8pt; height: 70px;"></textarea>
        </div>
        <div id="folioNuevo" title="Folio asignado" style="display:none">
            
        </div>
    </body>
    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
     <!-- Ui jQuery-->
    <script src="../js/jquery-ui.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/jquery.multiselect.min.js"></script>
    <script src="../js/V1/principal/indexV1.1.2.js"></script>
    <script src="../js/V1/sesion/funciones.1.js"></script>
    <script src="../js/prefactura/indexprefactura.js"></script>
    <!-- <script src="../js/cotizaciones/indexcotizaciones.js"></script> -->
    <script src="../js/cotizaciones/modalindexcot.js"></script>
    <script src="../js/ordenesdeservicio/modalindexord.js"></script>
    <script src="../js/facturas/modalindexfacturas.js"></script>
    <script src="../js/natural.js"></script>
    <!--<script language="javascript" src="../../backend/js/fancywebsocket.js"></script>-->
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
</html>