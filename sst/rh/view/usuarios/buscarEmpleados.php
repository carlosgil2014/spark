<?php
// if(!isset($_SESSION['gxc_usuario']))
//     header('Location:../view/index.php');
if($crud != "OK"){

  header('Location:../../index.html');

}
?>
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
                        BUSCAR EMPLEADO PARA CREAR USUARIO
                      </h4>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="">
                                    </div>
                                    <div class="box-body table-responsive">
                                        <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                                        <div class="row">
                                            <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                                                <div class="col-md-4 col-md-offset-4">
                                                    <div class="alert alert-danger" >
                                                        <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                                                        <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                          <form action="crudUsuarios.php" method="GET">
                                            <div class="form-group col-md-3">
                                              <div class="input-group margin">
                                                <input type="text" class="form-control" name="buscar" minlength="3" value="<?php if(isset($_GET['buscar'])) echo $_GET['buscar']; ?>">
                                                <span class="input-group-btn">
                                                  <button type="submit" class="btn btn-info btn-flat" name="accion" value="buscarEmpleados"><i class="fa fa-search"></i></button>
                                                </span>
                                              </div>  
                                            </div>
                                          </form>
                                        </div>
                                        <?php 
                                        if(isset($datosEmpleados) && is_array($datosEmpleados)){
                                        ?>
                                        <table id="empleados" class="table table-hover">
                                          <thead>
                                              <tr>
                                                  <th>Nombre</th>
                                                  <th>R.F.C.</th>
                                                  <th>Gastos</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php 
                                              foreach ($datosEmpleados as $empleado)
                                              {
                                              ?>
                                              <tr>
                                                  <td><?php echo $empleado['nombre'];?></td>
                                                  <td> 
                                                      <?php 
                                                          if(!empty($empleado['rfc']))
                                                              echo $empleado['rfc'];
                                                          else
                                                              echo "Sin R.F.C.";
                                                      ?>    
                                                  </td>
                                                  <td class="text-center">
                                                    <i style="cursor:pointer;" class="fa fa-arrow-circle-right" onclick="crearUsuario('<?php echo $empleado["id"];?>','<?php echo $empleado["nombre"];?>');"></i>
                                                  </td>
                                              </tr>
                                              <?php
                                              }
                                              ?>
                                          </tbody>
                                      </table>
                                      <?php 
                                      }
                                      ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- ./Content wrapper -->
            </div>
            <!-- ./wrapper -->
            <!-- Modal Eliminar -->
            <div id="modalContinuar" class="modal fade" role="dialog">
              <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Usuarios</h4>
                  </div>
                  <div class="modal-body text-center">
                  ¿Crear nuevo usuario para <b id="empleadoNombre"></b>?
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="continuar" class="btn btn-sm btn-primary" data-dismiss="modal">Continuar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Eliminar -->
            <!-- jQuery 2.2.3 -->
            <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="../../assets/js/jquery/jquery-ui.js"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
            <!-- DataTables -->
            <script src="../../assets/js/datatables/jquery.dataTables.min.js"></script>
            <script src="../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../../assets/js/app.min.js"></script>
            <!-- Index empleados gastos -->
            <script src="../js/V1/usuarios/buscarEmpleados.js" language="javascript"></script>
    </body>
    <div id="respuesta" title="Aviso">

    </div>
</html>