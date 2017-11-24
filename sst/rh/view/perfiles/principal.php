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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a style="cursor: pointer;" onclick="agregar();"> 
                <i class="fa fa-plus"></i> <span>Agregar</span>
              </a>
            </li>
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
                  <h3 class="box-title">Perfiles/Principal</h3>
                </div>
                <!-- /.box-header -->
                <div id="respuesta"></div>
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
                  <table id="tblPerfiles" class="table table-bordered table-striped small">
                    <thead>
                    <tr>
                      <th>Nombres</th>
                      <th></th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($perfiles as $perfil){
                    ?>
                    <tr>
                      <td><?php echo ucwords(strtolower($perfil["empleados_nombres"]." ".$perfil["empleados_apellido_paterno"]." ".$perfil["empleados_apellido_materno"]))?></td>
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="modificar('<?php echo $perfil['empleados_id'];?>','<?php echo $perfil['codigoPostal'];?>');">
                          <i class="fa fa-pencil-square-o"></i>
                        </a>
                      </td>
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="eliminar('<?php echo $perfil['empleados_id'];?>');">
                          <i class="fa fa-trash-o text-red"></i>
                        </a>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                  </table>

                  <div id="container-main">
    <h1>Mejores Jugadores Liga BBVA</h1>
 
    <div class="accordion-container">
        <a href="#" class="accordion-titulo">Messi<span class="toggle-icon"></span></a>
        <div class="accordion-content">
            <img src="http://e0.365dm.com/15/05/660x350/champions-league-barcelona-bayern-munich-soccer-messi_3299830.jpg?20150506214236" alt=""/>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
 
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>  
    </div>
    
    <div class="accordion-container">
        <a href="#" class="accordion-titulo">Cristiano<span class="toggle-icon"></span></a>
        <div class="accordion-content">
            <img src="http://www.abc.es/Media/201301/10/cristiano-ronaldo--644x362.jpg" alt=""/>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
 
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
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

      <div class="modal fade" id="modalPerfil" role="dialog">              
      </div>
      <!-- Modal Eliminar -->
      <div id="modalEliminar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Perfil/Eliminar</h4>
            </div>
            <div class="modal-body text-center">
            ¿Está seguro de querer eliminar este perfil?
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
    <!-- maskaras -->
    <script src="../../../assets/js/input-mask/jquery.inputmask.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Index perfiles -->
    <script src="../../js/V1/perfiles/index.js"></script>
  </body>
</html>
