<!DOCTYPE HTML>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SCG | Spar México</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../assets/css/datatables/dataTables.bootstrap.css">
  <!-- Bootstrap multisect -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../assets/css/_all-skins.min.css">

</head>
    <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
        <div class="loader">  
        </div>
        <div class="wrapper">
                <header class="main-header">
                <!-- Logo -->
                    <a href="../view" class="logo">
                      <!-- mini logo for sidebar mini 50x50 pixels -->
                      <span class="logo-mini"><b>SCG</b></span>
                      <!-- logo for regular state and mobile devices -->
                      <span class="logo-lg">Control de gastos</span>
                    </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span><?php echo $_SESSION["gxc_usuario"];?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-right">
                                                <a href="indexControlador.php?urlValue=logout" class="btn btn-default btn-flat">Salir</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                      <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li>
                              <a onclick="goBack()">
                                <i class="fa fa-arrow-left"></i><span>Regresar</span>
                              </a>
                            </li>
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                      <h4>
                        Nuevo Usuario
                      </h4>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body table-responsive">
                                        <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                                        <div class="row">
                                            <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                                                <div class="col-md-4 col-md-offset-4">
                                                    <div class="alert alert-<?php echo $clase;?>" >
                                                        <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                                                        <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                        <form data-toggle="validator" action="crudUsuarios.php?accion=guardar&idEmpleado=<?php echo $_GET['idEmpleado'];?>" method="POST">
                                          <div class="form-group col-md-2">
                                              <label class="control-label">Usuario</label>
                                              <input type="text" name="Datos[usuario]" class="form-control input-sm" required=>
                                              <div class="help-block with-errors">&nbsp;</div>
                                          </div>
                                          <div class="form-group col-md-2">
                                            <label class="control-label">Contraseña</label>
                                            <input type="password" name="Datos[contrasena]" class="form-control input-sm" id="contrasena" required>
                                            <div class="help-block with-errors">&nbsp;</div>
                                          </div>
                                          <div class="form-group col-md-2">
                                            <label class="control-label">Confirme contraseña</label>
                                            <input type="password" name="Datos[contrasena1]" class="form-control input-sm" data-match="#contrasena" data-match-error="La contraseñas no coinciden" required>
                                            <div class="help-block with-errors">&nbsp;</div>
                                          </div>
                                          <div class="form-group col-md-3">
                                            <label class="control-label">Nombre(s)</label>
                                            <input type="text" class="form-control input-sm" value="<?php echo $usuario['nombre'];?>" readonly>
                                          </div>
                                          <div class="form-group col-md-2">
                                            <label class="control-label">R.F.C.</label>
                                            <input type="text" class="form-control input-sm" value="<?php echo $usuario['rfc'];?>" readonly>
                                          </div>
                                          <div class="form-group col-md-1">
                                              <label class="control-label">&nbsp;</label>
                                              <button class="btn btn-block btn-flat btn-sm btn-success" >Crear</button>
                                          </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- ./Content wrapper -->
            </div>
            <!-- ./wrapper -->
            <!-- jQuery 2.2.3 -->
            <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="../../assets/js/jquery/jquery-ui.js"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
            <!-- DataTables -->
            <script src="../../assets/js/datatables/jquery.dataTables.min.js"></script>
            <script src="../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
            <!-- Validaciones -->
            <script src="../../assets/js/validacion/validacion.js"></script>
            <!-- AdminLTE App -->
            <script src="../../assets/js/app.min.js"></script>
            <!-- Bootstrap multisect -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
            <!-- Index empleados gastos -->
            <script src="../js/V1/usuarios/alta.js" language="javascript"></script>
            <!-- Index empleados gastos -->
            <script src="../js/V1/usuarios/alta.js" language="javascript"></script>
    </body>
    <div id="respuesta" title="Aviso">

    </div>
</html>