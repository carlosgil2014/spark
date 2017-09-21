<?php
// if(!isset($_SESSION['kiosco_usu']))
//     header('Location: ../index.html');
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
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../assets/css/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../assets/css/_all-skins.min.css">

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
        <a href="../index.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A | S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Administrativo | Spar</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">Que usuario está conectado</span>
                  <i class="fa fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Header -->
                  <li class="user-body">
                      <div class="pull-right">
                        <a href="#" class="btn btn-default btn-flat">?</a>
                      </div>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="row">
                      <div class="col-xs-12 text-center">
                        <a>?</a>
                      </div>
                    </div>
                    <!-- /.row -->
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Salir</a>
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
          <!-- search form -->
          <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form> -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a href="../">
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
                  <h3 class="box-title">Kiosco/Principal</h3>
                </div>
                <!-- /.box-header -->
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
                      <br>

                      <form  data-toggle="validator" role="form" method="POST" action="../controller/crudKiosco.php?accion=buscar">
                            <div class="form-group col-xs-3">
                                <label class="control-label" for="buscar">RFC</label>
                                <input list="rfcs" name="rfc" id="rfc" class="form-control" style="text-transform:uppercase" value="<?php if(isset($datos['empleados_rfc']))echo $datos['empleados_rfc'] ?>" pattern="^[A-Z0-9]{13}" maxlength="13" data-error="Es un campo obligatorio de 13 caracteres" required>
                                  <datalist id="rfcs">
                                    <?php 
                                      foreach ($rfc as $valor) {
                                      echo "<option value='".$valor."'>";
                                      }
                                    ?>
                                  </datalist>
                                  <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-xs-1">
                                <label class="control-label">&nbsp;</label>
                                <input type="submit" id="env_rfc" class="btn btn-primary" value="Buscar" disabled>
                            </div>                  
                      </form>
                      
                                                                   
                      <form method="POST" action="../controller/crudKiosco.php?accion=actualizar">
                        
                          <input type="hidden" class="form-control" value="<?php if(isset($datos['empleados_rfc']))echo $datos['empleados_rfc'] ?>" name="rfc" readonly >
                                                   
                          <div class="form-group col-xs-3">
                            <label class="control-label">Nombre:</label>
                            <input type="text" class="form-control" value="<?php if(isset($datos['nombres']))echo $datos['nombres'] ?>" readonly >
                          </div>  
                                   
                          <div class="form-group col-xs-2">
                            <label class="control-label">N°Empleado:</label>
                            <input type="text" class="form-control" value="<?php if(isset($datos['empleados_numero_empleado']))echo $datos['empleados_numero_empleado'] ?>" name="num_empleado" readonly>
                          </div> 
                            
                          <div class="form-group col-xs-3">  
                            <label class="control-label">Correo:</label>
                            <input type="text" class="form-control" value="<?php if(isset($datos["empleados_correo"]))echo $datos["empleados_correo"] ?>" name="correo" readonly >   
                          </div> 

                          <div class="form-group col-xs-12">
                            <label class="control-label"><?php if(isset($datos["empleados_empresa"]))echo "El usuario corresponde a la nomina de: ". $datos["empleados_empresa"] ?></label>
                          </div>
                          
                                              
                          <div class="form-group col-xs-2">
                            <label class="control-label">&nbsp;</label>
                          </div>
                       

                      </form>
                                        
                      <div class="form-group col-xs-12">
                          <button class="btn btn-primary" onclick="restablecer(<?php echo $datos['empleados_numero_empleado'];?>,'<?php echo $datos['empleados_rfc'];?>','<?php echo $datos["empleados_correo"];?>','<?php echo $datos["nombres"];?>');">Restablecer</button>
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
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <!-- <b>Version</b> 2.3.8 -->
        </div>
        <strong><!-- © 2017 Recibos de Nómina | Spar Todopromo, SAPI de CV --></strong>
      </footer>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- Modal Eliminar -->
    <div id="modalRestablecer" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Usuarios/Restablecer</h4>
          </div>
          <div class="modal-body text-center">
            <p>
              Esta apunto de restablecer la contraseña de: <b id="empleadoModal"></b><br>
              Contraseña asignada: <b id="rfcModal"></b><br>
              Se enviara al correo: <b id="correoModal"></b>

            </p>
         </div>
          <div class="modal-footer">
            <button type="button" id="restablecer" class="btn btn-sm btn-success" data-dismiss="modal">Continuar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar -->

    <!-- jQuery 2.2.3 -->
    <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Validaciones -->
    <script src="../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../assets/js/funciones.js"></script>
    <!-- Index Bancos -->
    <script src="../js/V1/bancos/index.js"></script>
    <!-- Validaciones -->
    <script src="../../assets/js/validacion/validacion.js"></script>
    <script src="../js/V1/kiosco/restablecer.js"></script>
    <script src="../js/V1/kiosco/index.js"></script>
    
  </body>
</html>
