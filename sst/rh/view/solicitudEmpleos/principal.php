<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../index.html');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
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
    <!-- acordeon -->
    <link rel="stylesheet" href="../../../assets/css/acordeon.css">
    <!-- selected -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap/bootstrap-select.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../../assets/css/_all-skins.min.css">
        <!-- timepicker -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap/timepicker.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="../../../assets/css/daterangepicker.css">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="loader">
    </div>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../index.php?accion=index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A | S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Recursos humanos | Spar</span>
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
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <!--<li>
              <a style="cursor: pointer;" onclick="agregar();"> 
                <i class="fa fa-plus"></i> <span>Agregar</span>
              </a>
            </li>-->
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
                  <h3 class="box-title">Solicitud de empleo/Principal</h3>
                </div>
                <!-- /.box-header -->
                <div id="respuesta"></div>
               <!-- <div class="row">
                  <div class="btn-toolbar" role="toolbar"> -->

                    <div class="btn-group">
                       <button type="button" onclick="agregar();" class="btn btn-success">Agregar</button>
                    </div>

                  <!--</div>
                </div>-->
                <div class="box-body table-responsive">
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
                  <table id="tblSolicitudEmpleos" class="table table-bordered table-striped small">
                    <thead>
                    <tr>
                      <th>Solicitante</th>
                      <th>Puesto</th>
                      <th>Fecha de Solicitud</th>
                      <th>Celular</th>
                      <th>RFC</th>
                      <th></th>
                      <!--<th></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($varSolicitudEmpleos as $solicitudEmpleo){
                    ?>
                    <tr>
                      <td><?php echo $solicitudEmpleo['nombresDatosPersonales']." ".$solicitudEmpleo['apellidoPaternoDatosPersonales']." ".$solicitudEmpleo['apellidoMaternoDatosPersonales']?></td>
                      <td><?php echo $solicitudEmpleo['nombre'] ?></td>
                      <td><?php echo $solicitudEmpleo['fechaSolicitud'] ?></td>
                      <td><?php echo $solicitudEmpleo['telefonoCelular'] ?></td>
                      <td><?php echo $solicitudEmpleo['rfc'] ?></td>
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="modificar('<?php echo $solicitudEmpleo['idSolicitudEmpleo']; ?>','<?php echo $solicitudEmpleo['cpDatosPersonales'];?>');">
                          <i class="fa fa-pencil-square-o"></i>
                        </a>
                      </td>
                      <!--
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="eliminar('<?php echo $solicitudEmpleo['idSolicitudEmpleo'];?>');">
                          <i class="fa fa-trash-o text-red"></i>
                        </a>
                      </td>
                    -->
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                  </table>
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

      <div class="modal fade" id="modalSolicitudEmpleo" role="dialog">              
      </div>
      <!-- Modal Eliminar -->
      <div id="modalEliminar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Solicitud de empleo/Eliminar</h4>
            </div>
            <div class="modal-body text-center">
            ¿Está seguro de querer eliminar este solicitud de empleo?
            </div>
            <div class="modal-footer">
              <button type="button" id="eliminar" class="btn btn-sm btn-success" data-dismiss="modal">Si</button>
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Eliminar -->
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
    <!-- maskara para numeros telefonicos -->
    <script src="../../../assets/js/input-mask/jquery.inputmask.js"></script>
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="../../../assets/js/bootstrap/timepicker.js"></script>
    <!-- bootstrap dateranger -->
    <script src="../../../assets/js/dateranger/moment.min.js"></script>
    <script src="../../../assets/js/dateranger/daterangepicker.js"></script>
    <!-- Index solicitudEmpleos -->
    <script src="../../js/V1/solicitudEmpleos/index.js"></script>
  </body>
</html>
