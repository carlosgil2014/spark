<?php 
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
        <!-- DataTables CSS -->
        <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="../css/dataTables.responsive.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../css/sb-admin-2.css" rel="stylesheet">
        <!--Jquery css-->
        <link rel="stylesheet" href="../css/jquery-ui.css">
        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../css/estilo.css" rel="stylesheet" type="text/css"> 
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
                    <a class="navbar-brand" href="../view">Módulo de Operaciones</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">
                    <li><a><?php echo $nombre;?></a></li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <img src="../img/user.png" class="imgUser" style="width: 27px; height: 27px;">  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                            </li> -->
                            <li><a href="../controller/crudConceptos.php?accion=listarConceptos"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="../controller/crudIndex.php?urlValue=logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <!-- <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="#" onclick='location.reload(true); return false;'><i class="fa fa-plus-circle"></i> Nueva</a>
                            </li>
                        </ul>
                    </div> -->
                    <!-- /.sidebar-collapse -->
                <!-- </div> -->
                <!-- /.navbar-static-side -->
            </nav>
            <div id="page-wrapper" style="margin: 0px;">
                <div class="row">
                    <br>
                    <br>
                    <div class="col-lg-11">
                        <div class="alert alert-danger page-header" style="color: #a94442;">
                          <strong><blink class="danger parpadeo">¡AVISO! - </blink></strong> Estas son sus ordenes de servicio por facturar.
                        </div>
                        <!-- <h1 class="page-header"> Estas son tus ordenes de servicio por facturar.</h1> -->
                    </div>
                    <div class="col-lg-1 page-header">
                        <a href="../controller/crudIndex.php?urlValue=login&principal=1" class="btn btn-success btn-sm" role="button">Continuar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    <div class="form-group col-lg-12" >
                        <form id="formPrefactura" method="POST" action="crudIndex.php?urlValue=login" > <!-- -->
                            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6" >
                                <label>Cliente</label>
                                <div class="form-group col-lg-12" >
                                    <select class="form-control input-sm listaCotizaciones" name="Datos[idCliente]" required>
                                        <option hidden selected value="0">--- Seleccione Cliente---</option>
                                        <?php 
                                        foreach ($datosPorFacturar as $cliente)
                                        {
                                            if(isset($idCliente)){
                                                if($idCliente != $cliente['idclientes']) {
                                            ?>
                                                <option value="<?php echo $cliente['idclientes'] ?>"><?php echo ($cliente["cliente"]);?></option>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                <option value="<?php echo $cliente['idclientes'] ?>" selected><?php echo ($cliente["cliente"]);?></option>
                                            <?php
                                                }
                                            }
                                            else{
                                            ?>
                                                <option value="<?php echo $cliente['idclientes'] ?>"><?php echo ($cliente["cliente"]);?></option>
                                            <?php
                                            }
                                        }
                                      ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group col-xs-3 col-sm-2 col-md-2 col-lg-1" >
                                <input type="button" name="btnGuardarConciliacion" value="Conciliar" class="btn btn-primary modalDetallePorFacturar">
                            </div>
                            <div class="form-group col-xs-3 col-sm-2 col-md-2 col-lg-1">
                                <input type="button" name="btnGuardarPrefactura" value="Prefacturar" class="btn btn-primary modalDetallePorFacturar">
                            </div>
                            <div class="form-group hidden" >
                                <label>De</label>
                                <input  type="date" class="form-control input-sm " value="0000-00-00" name="Datos[fechaInicial]" >
                            </div>
                            <div class="form-group hidden" >
                                <label>Hasta</label>
                                <input type="date" class="form-control input-sm " value="0000-00-00" name="Datos[fechaFinal]" >
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                <?php
                if(isset($pendientes))
                {
                ?>
                    <a class="seldes pull-right" value="0" style="cursor: pointer;"> 
                        <span> Seleccionar todos </span>
                    </a>
                    <a class=" pull-right" style="text-decoration:none;"> &nbsp; | &nbsp;</a>
                    <a class="seldes pull-right" value="1" style="cursor: pointer;"> 
                        <span> Deseleccionar todos </span>
                    </a>
                    <br>
                    <table class="table table-striped table-bordered table-hover" id="tablaConceptosPendientes" style="font-size:7.5pt">
                        <thead>
                            <th>FECHA INICIAL</th>
                            <th>FECHA FINAL</th>
                            <th>FOLIO</th>
                            <th>SERVICIO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>CANTIDAD</th>
                            <th>CONCEPTO</th>
                            <th>P. UNITARIO</th>
                            <th>P. TOTAL</th>
                            <th>COMISIÓN</th>
                            <th>SUBTOTAL</th>
                            <th></th>
                        </thead>
                        <tbody id="osPorFacturar">
                        <?php

                            foreach ($pendientes as $value) 
                            {
                                $totalPf = 0;
                                $datosOrden = $ordendeservicio -> datosOrdenes($value['idorden']); // Folio de OS
                                $datos = $ordendeservicio -> detalleConceptoOs($value['idordconcepto']); // Rubros OS
                                $datosPrefactura = $ordendeservicio -> detalleConceptoOsPf($value['idordconcepto']); //Rubros PF
                                foreach ($datosPrefactura as $dotosPf) 
                                {
                                    $totalPf += $dotosPf["cantidadPf"];
                                }
                                $porFacturar = $datos[0]["cantidad"]-$totalPf;
                                $precioUnitario = $datos[0]["precioUnitario"];
                                $precioTotal = $porFacturar*$datos[0]["precioUnitario"];
                                $comision = ($precioTotal*$datos[0]["comision"])/100;
                                $subtotal = $precioTotal+$comision;
                                if(is_array($datos) && is_array($datosOrden))
                                {
                                ?>
                                    <tr id="<?php echo $value['idordconcepto'];?>">
                                        <td><?php echo date("d-m-Y",strtotime($datos[0]["fechaInicial"]));?></td>
                                        <td><?php echo date("d-m-Y",strtotime($datos[0]["fechaFinal"]));;?></td>
                                        <td><?php echo "OS-".$datosOrden["clave"]."-".$datosOrden["anio"]."-".$datosOrden["norden"];?></td>
                                        <td><?php echo $datos[0]["servicio"];?></td>
                                        <td><?php echo $datos[0]["descripcion"];?></td>
                                        <td align="center"><?php echo $porFacturar;?></td>
                                        <td><?php echo $datos[0]["concepto"];?></td>
                                        <td class="text-right"><?php echo "$ ".number_format($precioUnitario,2);?></td>
                                        <td class="text-right"><?php echo "$ ".number_format($precioTotal,2);?></td>
                                        <td class="text-right"><?php echo "$ ".number_format($comision,2);?></td>
                                        <td class="text-right"><?php echo "$ ".number_format($subtotal,2);?></td>
                                        <td><input type="checkbox" name="Datos[concepto]" idOrden="<?php echo $value['idorden'];?>" value="<?php echo $value['idordconcepto'];?>" checked="checked"></td>
                                    </tr>
                                <?php
                                }
                            }   
                        ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>
            </div>
            <!-- /#page-wrapper -->
            <div class="modal fade " id="IdmodalDetalleConcepto" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" id="datosConcepto">
                       
                    </div>
                </div>
            </div>
            <!-- /#IdmodalDetalleConcepto-->
            <div class="modal fade " id="IdmodalDetalleCancelacion" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" id="datosPrefacturaCancelacion">
                       
                    </div>
                </div>
            </div>
            <!-- /#IdmodalDetallePrefactura-->
            <div class="modal fade " id="IdmodalDetallePrefactura" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" id="datosPrefactura">
                       
                    </div>
                </div>
            </div>
            <!-- /#IdmodalDetallePrefactura-->
            <div id="aviso" title="Aviso" style="display:none">
                     <p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>La prefactura no puede estar vacía.</p>
            </div>
            <div id="error" title="Aviso" style="display:none">
                     <p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>Complete correctamente la prefactura.</p>
            </div>
            <!-- /#Folio prefactura-->
            <div id="folioPrefactura" title="Folio de prefactura" style="display:none">
                     
            </div>
            <div id="folioConciliacion" title="Folio de conciliación" style="display: none;"></div>
            <!-- /#aviso-->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>
         <!-- Ui jQuery-->
        <script src="../js/jquery-ui.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
        <!-- DataTables JavaScript -->
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="../js/sb-admin-2.js"></script>
        <!-- Sort date -->
        <script src="//cdn.datatables.net/plug-ins/1.10.15/sorting/date-dd-MMM-yyyy.js"></script>
        <!--JavaScript Prefacturas-->
        <script type="text/javascript" src="../js/prefactura/prefactura.js"></script>
        <!--JavaScript Cancelación de rubros-->
        <!-- <script type="text/javascript" src="../js/prefactura/cancelacion.js"></script> -->
        <script type="text/javascript">
            function parpadeo()
            {
                $(".parpadeo").fadeOut(500);
                $(".parpadeo").fadeIn(500);
            }
            setInterval(parpadeo,1000);
        </script>
    </body> 
</html>