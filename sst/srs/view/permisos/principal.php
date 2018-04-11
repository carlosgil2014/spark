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
    <title>SRS | Spar México</title>
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
          <span class="logo-mini"><b>SRS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">SRS</span>
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
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-info">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Usuarios SRS
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse">
                    <div class="box-body">
                      <div class="row">
                        <div class="table-responsive container-fluid">
                          <table id="tblUsuarios" class="table table-bordered small">
                            <thead>
                              <tr>
                                <th>Usuario</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach($usuarios as $usuario){
                            ?>
                            <tr>
                              <td><?php echo $usuario["nombre"];?>
                              </td>
                              <td class = "text-center">
                                <a style="cursor: pointer;" onclick="permisos('<?php echo base64_encode($usuario['id']);?>');">
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
                  </div>
                </div>
                <div class="panel box box-info">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" >
                        Módulos/Permisos
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
                      <div class="row">
                        <div class="table-responsive container-fluid">
                          <table id="tblModulos" class="table table-bordered small">
                            <thead>
                            <tr>
                              <th>Módulo</th>
                              <th>Permisos</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach($modulos as $modulo){
                            ?>
                            <tr>
                              <td><?php echo $modulo["nombre"];?>
                              </td>
                              <td  class = "text-center"><?php echo $modulo["permisos"];?></td>                   
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
      <!-- Modal Principal -->
      <div  id="modalPermisos" class="modal" tabindex="-1" role="dialog">              
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
              <h4 class="modal-title" id="myModalLabel"><b>Modificar/Permisos</b></h4>
            </div>
            <div class="modal-body" id="modalDivPermisos">
              <?php 
              $disabled = "none";
              $mensaje = "";
              if(!isset($permisos["Modificar"]) || $permisos["Modificar"] !== "1"){
                $disabled = "block";
                $mensaje = "Permisos insuficientes";
              }
              ?>
              <div class="row">
                <div class="form-group" id="div_alert_modal" style="display:<?php echo $disabled;?>;">
                  <div class="col-md-6 col-md-offset-3">
                    <div class="alert alert-danger" >
                      <a onclick="cerrar('div_alert_modal')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
                      <p id="p_alert_modal" class="text-center"><?php echo $mensaje;?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
              </div> 
            </div>
        </div>
      </div>
      <!-- /.Modal Principal -->
      
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
    <!-- Index Permisos -->
    <script src="../../js/V1/permisos/index.js"></script>
  </body>
</html>
