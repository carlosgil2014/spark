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
                        <h1 class="page-header">Ordenes de servicio</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12" >
                        <form id="formOrdendeServicio" method="POST" action="crudOrdenes.php?accion=listaClientes" >
                            <div class="form-group col-lg-6" >
                                <label>Cliente</label>
                                <div class="form-groupcol-lg-12" >
                                    <select class="form-control input-sm listaCotizaciones" name="Datos[idCliente]" required>
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
                                <input  type="date" class="form-control input-sm listaCotizaciones" value="<?php if(isset($fechaInicial))echo $fechaInicial; else echo $fecha;?>" name="Datos[fechaInicial]" required>
                            </div>
                            <div class="form-group  col-lg-3" >
                                <label>Hasta</label>
                                <input type="date" class="form-control input-sm listaCotizaciones" value="<?php if(isset($fechaFinal))echo $fechaFinal; else echo $fecha;?>" name="Datos[fechaFinal]" required>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                if(isset($datosCotizaciones))
                {
                ?>
                <div class="row">
                    <div class="form-group col-lg-7">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#Cotizaciones" class="reiniciarPf">Cotizaciones</a></li>
                            <li><a data-toggle="tab" href="#Prefacturas" class="reiniciarCot">Prefacturas</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="Cotizaciones" class="tab-pane fade in active scroll" style="font-size:10pt; font-family:Helvetica Neue,Helvetica,Arial,sans-serif">
                                <?php
                                    //print_r($datosCotizaciones);
                                if(count($datosCotizaciones)>0)
                                {
                                    $actual = 0; 
                                    foreach($datosCotizaciones as $cotizacion)
                                    {
                                        $tmp = $cotizacion['id'];
                                        if($actual != $tmp)
                                        {
                                    ?>      
                                        </ul>
                                    <?php
                                        }
                                        if($actual != $cotizacion['id'])
                                        {
                                            $actual = $cotizacion['id'];
                                            
                                    ?>
                                        <h6 cot="<?php echo $cotizacion["id"]; ?>" style="cursor:pointer;" class="txtCotizacion">COT-<?php echo $cotizacion["clave"] ?>-<?php echo $cotizacion["anio"] ?>-<?php echo $cotizacion["ncotizacion"] ?> &nbsp; <small cot="<?php echo $cotizacion["id"]; ?>" ><?php echo $cotizacion["servicio"]; ?>&nbsp;&nbsp;<b><?php echo "De: ".$cotizacion["fechaInicial"]." Hasta: ".$cotizacion["fechaFinal"];?></b></small></h6>
                                        <ul cot="<?php echo $cotizacion["id"]; ?>" class="cotizaciones">
                                    <?php
                                        }
                                    ?>
                                            <li><input type="checkbox" class = "cotConcepto" value='<?php echo $cotizacion["idcotconcepto"];?>' cot = '<?php echo $cotizacion["id"]; ?>'> <?php echo $cotizacion["concepto"]; ?> <a href="#IdmodalDetalleConcepto" class="detalleConceptoCotizacion" data-toggle='modal' value='<?php echo $cotizacion["idcotconcepto"]; ?>' cot='<?php echo $cotizacion["id"]; ?>' name="detalle">(Detalles)</a></li>
                                    <?php
                                        
                                    }
                                }
                                else
                                    echo "<br/>No existen resultados.";
                                ?>
                            </div>
                            <div id="Prefacturas" class="tab-pane fade scroll" style="font-size:10pt; font-family:Helvetica Neue,Helvetica,Arial,sans-serif">
                                <?php
                                //print_r($datosPrefacturas);
                                $actual = 0; 
                                if(count($datosPrefacturas) > 0){
                                    foreach($datosPrefacturas as $prefactura)
                                    {
                                        $tmp = $prefactura['idprefactura'];
                                        if($actual != $tmp)
                                        {
                                    ?>      
                                        </ul>
                                    <?php
                                        }
                                        if($actual != $prefactura['idprefactura'])
                                        {
                                            $actual = $prefactura['idprefactura'];
                                            
                                    ?>
                                        <h6 pf="<?php echo $prefactura["idprefactura"]; ?>" style="cursor:pointer;" class="txtPrefactura">PF-<?php echo $prefactura["clave"] ?>-<?php echo $prefactura["anio"] ?>-<?php echo $prefactura["nprefactura"] ?> &nbsp; <small pf="<?php echo $prefactura["idprefactura"]; ?>" ><?php echo $prefactura["servicio"]; ?>&nbsp;&nbsp;<b><?php echo "De: ".$prefactura["fechaInicial"]?></b></small></h6>
                                        <ul pf="<?php echo $prefactura["idprefactura"]; ?>" class="prefacturas" >
                                    <?php
                                        }
                                    ?>
                                            <li ><input type="checkbox" class = "pfConcepto" value='<?php echo $prefactura["idprefacturaconcepto"];?>' pf = '<?php echo $prefactura["idprefactura"]; ?>'> <?php echo $prefactura["concepto"]; ?> <a href="#IdmodalDetalleConcepto" class="detalleConceptoPrefactura" data-toggle='modal' value='<?php echo $prefactura["idprefacturaconcepto"]; ?>' pf='<?php echo $prefactura["idprefactura"]; ?>' name="detalle">(Detalles)</a></li>
                                    <?php
                                        
                                    }
                                }
                                else
                                    echo "<br/>No existen resultados.";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div  class="form-group col-lg-5" class="fijo" >
                        <h4 id="folioOrden">Incluir a orden de servicio</h4>
                        <div class="ui-widget-content">
                            <ol id="Ordendeservicio">
                            </ol>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="form-group col-lg-12" align="center">
                                <button class="btn btn-sm btn-primary" id="modalDetalleOrden">Generar</button>
                            </div>
                        </div>
                    </div>
                </div>
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
            <div class="modal fade " id="IdmodalDetalleOrden" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" id="datosOrden">
                       
                    </div>
                </div>
            </div>
            <!-- /#IdmodalDetalleOrden-->
            <div id="aviso" title="Aviso" style="display:none">
                     <p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>La orden de servicio no puede estar vacía.</p>
            </div>
            <div id="error" title="Aviso" style="display:none">
                     <p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>Complete correctamente la orden de servicio.</p>
            </div>
            <!-- /#aviso-->
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
        <!--JavaScript Prefacturas-->
        <script type="text/javascript" src="../js/V1/ordenesdeservicio/ordendeservicio.1.js"></script>
    </body> 
</html>