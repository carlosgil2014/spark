<?php
    if(!isset($_SESSION['spar_usuario']))
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
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="../../css/metisMenu.min.css" rel="stylesheet">
        <!-- DataTables CSS -->
        <link href="../../css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="../../css/dataTables.responsive.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="../operaciones">Módulo de Operaciones</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
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
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                           <li>
                                <a href="#" onclick='location.reload(true); return false;'><i class="fa fa-plus-circle"></i> Nueva</a>
                            </li>
                            <li>
                                <a href="../view/principal.php"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
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
                        <h1 class="page-header">Devoluciones</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12" >
                        <form id="formDevolucion" method="POST" action="crudDevoluciones.php?accion=listaClientes" >
                            <div class="form-group col-lg-6" >
                                <label>Cliente</label>
                                <div class="form-groupcol-lg-12" >
                                    <select class="form-control input-sm" onchange="saldoAnticipado();" name="Datos[idCliente]" required>
                                        <option hidden selected value="0">--- Seleccione Cliente---</option>
                                        <?php 
                                        foreach ($datos as $cliente)
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
                            <div class="form-group col-lg-3" >
                                <label>De</label>
                                <input  type="date" class="form-control input-sm listaCotizaciones" value="<?php if(isset($fechaInicial))echo $fechaInicial; else echo $fecha;?>" name="Datos[fechaInicial]" onchange="saldoAnticipado();" required>
                            </div>
                            <div class="form-group  col-lg-3" >
                                <label>Hasta</label>
                                <input type="date" class="form-control input-sm listaCotizaciones" value="<?php if(isset($fechaFinal))echo $fechaFinal; else echo $fecha;?>" name="Datos[fechaFinal]" onchange="saldoAnticipado();" required>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                if(isset($datosPrefacturas))
                {
                ?>
                <div class="col-lg-12">
                    <div class="table-responsive container-fluid row">
                        <table id="tblPrefacturas" class="table table-bordered table-striped small">
                            <thead>
                            <tr>
                              <th>Folio</th>
                              <th>Fecha</th>
                              <th>Servicio</th>
                              <th>Total</th>
                              <th>Disponible</th>
                              <th>OS's</th>
                              <th>DV's</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach($datosPrefacturas as $prefactura){
                            ?>
                            <tr>
                              <td><?php echo "PF-".$prefactura["clave"]."-".$prefactura["anio"]."-".$prefactura["nprefactura"];?></td>
                              <td><?php echo date_format(date_create($prefactura["fechaInicial"]),"d-m-Y");?></td>
                              <td><?php echo $prefactura["servicio"];?></td>
                              <td class="text-center">$ <?php echo number_format($prefactura["cantidad"]*$prefactura["precioUnitario"]*(1+($prefactura["comision"]/100)),2);?></td>
                              <td class="text-center">$ <?php echo number_format($prefactura["saldoAnticipado"],2);?></td>
                              <td class = "text-center">
                                <a style="cursor:pointer;" onclick="detalleConcepto('<?php echo $prefactura['idprefactura'];?>','<?php echo $prefactura['idprefacturaconcepto'];?>');">
                                  <i class="fa fa-search"></i>
                                </a>
                              </td>
                              <td class = "text-center">
                                <a style="cursor:pointer;" onclick="agregar('<?php echo $prefactura['idprefactura'];?>','<?php echo $prefactura['idprefacturaconcepto'];?>',<?php echo $prefactura["saldoAnticipado"];?>);">
                                  <i class="fa fa-mail-reply-all"></i>
                                </a>
                              </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>    
                <?php
                }
                ?>
            </div>
        </div>
        <div class="modal fade" id="modalDevolucion" role="dialog">             
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="datosConcepto">
                       
                </div>
            </div> 
        </div>
        <!-- /#wrapper -->
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
        <!--JavaScript Prefacturas-->
        <script type="text/javascript" src="../js/V1/devoluciones/index.js"></script>
    </body> 
</html>