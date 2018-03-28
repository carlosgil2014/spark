  <?php
if(!isset($_SESSION['spar_usuario']))
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
          <span class="logo-lg">Sistemas | Spar</span>
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
                  <h3 class="box-title">Consulta</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                    <div class="row">
                        <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                            <div class="col-md-6 col-md-offset-3">
                                <div class="alert alert-danger" >
                                    <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                                    <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                                </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <form action="index.php?accion=index" method="GET">
                        <div class="form-group col-md-2 col-xs-4">   
                            <label class="radio-inline"><input type="radio" name="tipoBusqueda" value="linea" <?php if(isset($_GET['tipoBusqueda'])){if($_GET['tipoBusqueda'] == 'linea') echo 'checked';} else echo 'checked';?> >Línea</label>
                        </div>
                        <div class="form-group col-md-2 col-xs-4">    
                            <label class="radio-inline"><input type="radio" name="tipoBusqueda" value="imei" <?php if(isset($_GET['tipoBusqueda'])) if($_GET['tipoBusqueda'] == 'imei') echo 'checked';?>>IMEI</label>
                        </div>
                        <div class="form-group col-md-2 col-xs-4">  
                            <label class="radio-inline"><input type="radio" name="tipoBusqueda" value="icc" <?php if(isset($_GET['tipoBusqueda'])) if($_GET['tipoBusqueda'] == 'icc') echo 'checked';?>>ICC</label>
                        </div>                      
                        <div class="form-group col-md-2 col-xs-4">  
                            <label class="radio-inline"><input type="radio" name="tipoBusqueda" value="empleado" <?php if(isset($_GET['tipoBusqueda'])) if($_GET['tipoBusqueda'] == 'empleado') echo 'checked';?>>Empleado</label>
                        </div>
                        <div class="form-group col-md-3 col-xs-4">
                          <input type="text" class="form-control input-sm" name="buscar" minlength="3" value="<?php if(isset($_GET['buscar'])) echo $_GET['buscar']; ?>">
                        </div>
                        <div class="form-group col-md-1 col-xs-2">
                          <button class="btn btn-flat btn-sm btn-success" name="accion" value="index">Buscar</button>
                        </div>
                      </form>
                    </div>
                    <?php
                    if(isset($_GET["tipoBusqueda"])){
                    ?>
                    <div class="row">
                      <div class="table-responsive container-fluid">
                        <table id="tblDatos" class="table table-bordered table-striped small">
                        <?php 
                        if(isset($datosEmpleados)){
                        ?>
                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>R.F.C.</th>
                              <th>Continuar</th>
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
                                <a href="index.php?accion=index&tipoBusqueda=empleado&buscar=id&idEmpleado=<?php echo $empleado['id']?>"><i style="cursor:pointer;" class="fa fa-arrow-circle-right" ></i></a>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                          </tbody>
                        <?php
                        }
                        if(isset($datosBusqueda)){
                        ?>
                          <thead>
                            <tr>
                              <th>Empleado</th>
                              <th>Cliente/Departamento</th>
                              <th>Ciudad</th>
                              <th>Estado</th>
                              <th>Línea</th>
                              <th>Equipo</th>
                              <th>IMEI</th>
                              <th>ICC</th>
                              <th>Fecha Asignación</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                          foreach ($datosBusqueda as $busqueda)
                          {
                          ?>
                            <tr>
                              <td><?php echo $busqueda['empleado'];?></td>
                              <td><?php echo $busqueda['departamento'];?></td>
                              <td><?php echo $busqueda['region'];?></td>
                              <td><?php echo $busqueda['estado'];?></td>
                              <td><?php echo $busqueda['linea'];?></td>
                              <td><?php echo $busqueda['modelo']." (".$busqueda['marca'].")";?></td>
                              <td><?php echo $busqueda['imei'];?></td>
                              <td><?php echo $busqueda['icc'];?></td>
                              <td><?php echo $busqueda['fecha'];?></td>
                            </tr>
                          <?php
                          }
                          ?>
                          </tbody>
                        <?php
                        }
                        ?>
                        </table>
                      </div>
                    </div>
                    <?php 
                    }
                    ?>
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
      <div class="control-sidebar-bg"></div>l Eliminar -->
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
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Index Bancos -->
    <script src="../../js/V1/consultas/index.js"></script>
        <!-- maskaras -->
    <script src="../../../assets/js/input-mask/jquery.inputmask.js"></script>
  </body>
</html>
