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
                        <h1 class="page-header">Reporte de Ventas</h1>
                </div>
                <form action="crudReportes.php?accion=reporteVentas" method="POST">
                    <div class="row">
                        <div class="form-group row col-lg-6" >
                            <label>Cliente</label>
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
                                            &nbsp;
                                            <label>
                                                <input class="checkBox" type="checkbox" name="idClientes[]" checked value="<?php echo $cliente['idclientes']?>" 
                                                <?php 
                                                if(isset($idClientes))
                                                    for ($i=0; $i < count($idClientes) ; $i++) { 
                                                        if($idClientes[$i] == $cliente['idclientes'])
                                                            echo "checked";
                                                    }   
                                                ?>/><small><?php echo $cliente['cliente']?></small>
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
                            <input  type="date" class="form-control input-sm listaCotizaciones" value="<?php if(isset($fechaInicial))echo $fechaInicial; else echo $fecha;?>" name="fechaInicial" required>
                        </div>
                        <div class="form-group  col-lg-2" >
                            <label>Hasta</label>
                            <input type="date" class="form-control input-sm listaCotizaciones" value="<?php if(isset($fechaFinal))echo $fechaFinal; else echo $fecha;?>" name="fechaFinal" required>
                        </div>
                        <div class="form-group  col-lg-1">
                            <label>&nbsp;</label>
                            <button class="btn btn-sm btn-success" type="button" id="btnBuscar">Buscar</button>
                        </div>
                        <div class="form-group col-lg-1" style="text-align:right;">
                            <label>&nbsp;</label>
                            <button class="btn btn-sm btn-success hidden" id="btnExportar" type="submit">Exportar</button>
                        </div>
                    </div>
                    <?php
                    $campos = array("CLIENTE","FECHA INICIAL","FECHA FINAL","ORDEN","PREFACTURA","CFDI","CONCEPTO","CANTIDAD","PRECIO UNITARIO","PRECIO TOTAL","COMISIÓN ($)","COMISIÓN (%)","SUBTOTAL","TIPO DE PLAN","TIPO DE SERVICIO","ELABORÓ","ESTADO","DESCUENTO","MOTIVO DESCUENTO"); 
                    ?>
                    <div class="row">
                        <div class="table-responsive hidden" id="tablaCampos">
                            <table class="table table-condensed">
                                <tbody>
                                  <?php
                                    $cont = 0;
                                    $i = 0;
                                    foreach($campos as $campo )                
                                    { 
                                        if($cont == 0)
                                        {
                                    ?>
                                    <tr>
                                    <?php
                                        }
                                    $hidden = "";
                                    if($campo == "ORDEN" || $campo == "PREFACTURA" || $campo == "ESTADO"){
                                        $hidden = "hidden";
                                        $cont--;
                                    }

                                    ?>
                                        <td class="success text-center" <?php echo $hidden;?>>
                                        <input type="checkbox" class="campos" name="campos[]" checked value="<?php echo $campo?>" >
                                        </td>
                                        <td class="success text-center" <?php echo $hidden;?>>
                                            <label style="font-size:.7em;"><?php echo $campo;?></label>
                                        </td>
                                    <?php    
                                        $cont++;
                                        $i++;
                                        if($cont==8){
                                            $cont=0;
                                    ?>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <div  class="row tab-pane fade in active" id="COPC">
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
        <!-- Custom Theme JavaScript -->
        <script src="../js/sb-admin-2.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="../js/reportes/ventas.js"></script>
        <!-- DataTables JavaScript -->
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
    </body> 
</html>