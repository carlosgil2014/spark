<?php
if(!isset($_SESSION['spar_usuario']) || $permisos["Principal"] !== "1")
    header('Location: ../index.php');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../../../assets/img/favicon.ico" type="image/x-icon" />
    <title>Módulo de Control de Recursos | Spar México</title>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../assets/css/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../assets/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../../assets/css/_all-skins.min.css">
    <!-- selected -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap/bootstrap-select.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <?php 
      include_once("../../../view/includes/modalExpiracion.php");
    ?>
    <div class="loader">
    </div>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../index.php?accion=index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A | S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Administrativo | Spar</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <?php 
          include_once("../../../view/includes/datosUsuario.php");
        ?>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php 
            include_once("../../../view/includes/menuIzquierdo.php");
          ?>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a href="../../index.php?accion=index">
                <i class="fa fa-arrow-left"></i> <span>Regresar</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Vacantes/Principal</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-1 col-sm-4" <?php if(!isset($permisos["Agregar"]) || $permisos["Agregar"] !== "1"){ echo 'data-toggle="tooltip" data-container="body" title="Permisos insuficientes."';}?>>
                       
                        <button type="button" onclick="agregar();" class="btn btn-success btn-block btn-flat btn-sm" <?php 
                        if(!isset($permisos["Agregar"]) || $permisos["Agregar"] !== "1"){ echo 'disabled';}
                        ?>>Agregar</button>
                        
                      </div>
                      <form action="index.php?accion=index" method="POST">
                        <div class="col-md-3 col-sm-4">
                          <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="clientes[]" multiple="multiple" data-container="body"  data-live-search = "true" data-selected-text-format="count > 5">
                            <?php
                            foreach ($clientes as $cliente) {
                            ?>
                            <option value="<?php echo base64_encode($cliente['idclientes'])?>" <?php if(isset($tmpClientes)) if (in_array(base64_encode($cliente['idclientes']), array_column($tmpClientes, "idclientes"))) echo "selected";?>><?php echo $cliente["nombreComercial"];?></option>
                            <?php 
                            }
                          ?> 
                          </select>
                        </div>
                        <div class="col-md-1 col-sm-4">
                          <button type="submit" class="btn btn-info pull-right btn-sm btn-block btn-flat">Buscar</button>
                        </div>
                        <div class="col-md-7">
                          <div class="col-md-2 col-md-offset-1 col-sm-4"><h6><i class="fa fa-square" style="color:#00c0ef;"></i> Búsqueda</h6></div>
                          <div class="col-md-2 col-sm-4"><h6><i class="fa fa-square" style="color:#dd4b39;"></i> Canceladas</h6></div>
                          <div class="col-md-2 col-sm-4"><h6><i class="fa fa-square" style="color:#00a65a;"></i> Cubiertas</h6></div>
                          <div class="col-md-2 col-sm-4"><h6><i class="fa fa-square" style="color:#f39c12;"></i> Proceso</h6></div>
                          <div class="col-md-2  col-sm-4"><h6><i class="fa fa-square" style="color:#3c8dbc;"></i> Solicitadas</h6></div>
                        </div>                      </form>
                    </div>
                  </div>
                  <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                  <div class="row">
                    <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                      <div class="col-md-4 col-md-offset-4">
                        <div class="alert alert-<?php echo $_GET['clase'];?>" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="table-responsive container-fluid">
                      <table id="tblVacantes" class="table table-bordered small">
                        <thead>
                        <tr>
                          <th class="col-md-6">Vacantes</th>
                          <th class="col-md-2">Cliente</th>
                          <th class="col-md-3">Elaborado</th>
                          <th class="col-md-1"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        foreach($vacantes as $vacante){
                        ?>
                        <tr>
                          <td>
                            <div class="progress-group">
                              <span class="progress-text"><?php echo $vacante["presupuesto"]?></span>
                              <span class="progress-number"><b><?php echo $vacante["cubiertas"] + $vacante["canceladas"];?></b>/<?php echo $vacante["vacantes"];?></span>
                              <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?php echo ($vacante["búsqueda"] * 100) / $vacante["vacantes"];?>%">
                                <?php echo $vacante["búsqueda"];?>
                                </div>
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width:<?php echo ($vacante["cubiertas"] * 100) / $vacante["vacantes"];?>%">
                                <?php echo $vacante["cubiertas"];?>
                                </div>
                                <div class="progress-bar progress-bar-primary" role="progressbar" style="width:<?php echo ($vacante["solicitadas"] * 100) / $vacante["vacantes"];?>%">
                                  <?php echo $vacante["solicitadas"];?>
                                </div>
                                <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?php echo ($vacante["proceso"] * 100) / $vacante["vacantes"];?>%">
                                  <?php echo $vacante["proceso"];?>
                                </div>
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?php echo ($vacante["canceladas"] * 100) / $vacante["vacantes"];?>%">
                                  <?php echo $vacante["canceladas"];?>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td  class = "text-center"><?php echo $vacante["nombreComercial"];?></td>
                          <td><?php echo $vacante["solicitante"];?></td>
                          <td class = "text-center">
                            <a style="cursor: pointer;" <?php if(!isset($permisos["Consultar"]) || $permisos["Consultar"] !== "1"){ ?> data-toggle="tooltip" data-container="body" title="Permisos insuficientes."';<?php } else{ ?> onclick="modificar('<?php echo base64_encode($vacante['idCliente']);?>','<?php echo base64_encode($vacante['idPresupuesto']);?>','<?php echo base64_encode($vacante['idPerfil']);?>','<?php echo base64_encode($vacante['idPuesto']);?>','<?php echo base64_encode($vacante['fechaModificacion']);?>');" <?php }?>>
                              <i class="fa fa-search"></i>
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
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php
      include_once("../../../view/includes/footer.php");
      ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
      <div  id="modalVacante" class="modal" tabindex="-1" role="dialog">              
      </div>
      <!-- Modal Principal -->
      
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Validaciones -->
    <script src="../../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Index Vacantes -->
    <script src="../../js/V1/vacantes/index.js"></script>
  </body>
</html>
