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

    <title>IntraNet | Spar Todopromo</title>
    
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />

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

    <!-- Estilo Spar -->
    <link href="../css/estilo.css" rel="stylesheet" type="text/css">


    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../css/jquery-ui.css">

    <link rel="stylesheet" href="../css/jquery.multiselect.css">

    <script src="../js/jquery.min.js"></script>

    <script src="../js/jquery-ui.min.js"></script>

</head>
<body>
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
                <a class="navbar-brand" href="../../operaciones/">Módulo de operaciones</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="www.google.com">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../controller/CrudIndex.php?urlValue=logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
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
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <br/></br><br/>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <form action="../controller/crudConceptos.php?accion=guardarConcepto" id="formGuardarConcepto" method="post">
        			            <div class="row">    
                                    <legend class="titulo">Alta de Conceptos</legend>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-xs-4 col-sm-4 col-md-2 col-lg-1 text-right">
                                        <label class="input-sm">Concepto: </label>
                                    </div>
                                    <div class="form-group input-sm col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                        <input class="form-control input-sm " name="nombre" id="IdNombreConcepto" maxlength="100" tabindex="1" required/> 
                                    </div>
                                    <div class="form-group input-sm col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                        <select class="form-control input-sm text-center" name="categoria" id="tipoServicio" title="Categoría" tabindex="2" required>
                                            <option value="" disabled selected>Tipo de servicio</option>
                                            <option>Gestión de personal (Nómina)</option>
                                            <option>Compras de Bienes o Servicios</option>
                                            <option>Coordinación y/o Consultoría</option>
                                            <option>Gastos y/o Viáticos</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-sm col-lg-2">
                                        <select class="form-control input-sm text-center" id="idPrecioConcepto" name="precio" tabindex="3" title="Precio" required>
                                            <option value="">Tipo de Precio</option>
                                            <option >Variable</option>
                                            <option>Fijo</option>>
                                        </select>
                                    </div>
                                    <div class="form-group input-sm col-lg-2">
                                        <input class="form-control input-sm hidden" type="number" name="precioConcepto" id="idPrecioConceptotxt" step="0.01" tabindex="4" maxlength="100"/> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group  col-lg-1">
                                        <label class="input-sm">Cliente: </label>
                                    </div>
                                    <div class="form-group col-lg-7">
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
                                                                <input class="checkBox" type="checkbox" name="Datos[idCliente][]" value="<?php echo $cliente['idclientes']?>"/>
                                                            </label><?php echo $cliente['cliente']?>
                                                    </div>
                                                    <?php 
                                                    }
                                                ?> 
                                          </ul>
                                        </div>
                                    </div>
                                    <div class="form-group input-sm col-xs-4 col-sm-4 col-md-1 col-lg-1 text-center">
                                        <input class="btn btn-primary btn-xs" type="button" id="guardarConcepto" name="guardar" tabindex="6" value="Guardar"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" id="tablaConceptos">
                            <table id='TablaConceptos' width='100%' cellspacing='0'  class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th >
                                        </th>
                                        <th >Concepto
                                        </th >
                                        <th >Tipo de servicio
                                        </th>
                                        <th>Precio ($)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datosConcepto as $concepto) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><input type="radio" class="relacionar" data-toggle="modal" data-target="#modalClientes" name="concepto" value="<?php echo $concepto["id"] ?>"></td>
                                        <td style="text-align: left;"><a href="#"  class="editaConcepto" data-placeholder="Campo requerido" data-pk="<?php echo $concepto["id"] ?>" name="Concepto"><?php echo $concepto["nombreRubro"]?></a></td>
                                        <td style="text-align: left;"><?php echo $concepto["categoria"]?></td>   
                                        <td style="text-align: left;"><?php if ($concepto["precio"]==0.00){echo 'Variable';} else {?> <a href="#"  class="editaPrecio" data-placeholder="Campo requerido" data-pk="<?php echo $concepto["id"] ?>" name="Concepto"><?php echo $concepto["precio"];} ?></a></td>   
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="modalClientes" class="modal fade" role="dialog">
                        
                    </div>
                </div>
                <!-- /.row-->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>
    <!-- jQuery -->
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="../js/dataTables.bootstrap.min.js"></script>
    
    <script src="../js/bootstrap-editable.min.js"></script>
    
    <script src="../js/jquery.multiselect.min.js"></script>

    <script src="../js/conceptos/conceptos.js"></script>
</html>
