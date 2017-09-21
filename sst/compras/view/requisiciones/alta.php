<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../../../index.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
  <link rel="shortcut icon" href="../../../img/favicon.ico" type="image/x-icon" />
  <title>Sistema Spar Todopromo | Spar México</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../assets/css/AdminLTE.min.css">
    <!-- Bootstrap select -->
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
          <span class="logo-mini"><b>ST</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Spar Todopromo</span>
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
              <a href="../../index.php?accion=index">
                <i class="fa fa-arrow-left"></i><span>Regresar</span>
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
                  <h3 class="box-title">Crear Requisición</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                  <div class="box-body">
                    <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                    <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                      <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-danger" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <form data-toggle="validator" role="form" method="POST" action="index.php?accion=guardar">
                        <div class="form-group col-md-3">
                          <label class="control-label">Almacén</label>
                          <select type="text" class="form-control input-sm" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="Bodega" data-error="Almacén no puede estar vacío." name="Datos[rfc]" data-toggle="tooltip" title="Si requiere dar de alta un nuevo almacén hágalo en el menú:'Párámetros Generales' de este módulo" required></select>
                          <div class="help-block with-errors">&nbsp;</div>
                        </div>
                        <div class="form-group col-md-2">
                          <label class="control-label">Fecha de solicitud</label>
                          <input type="date" class="form-control input-sm" maxlength="60" data-error="Este es un campo obligatorio" name="Datos[nombres]" required>
                          <div class="help-block with-errors">&nbsp;</div>
                        </div>
                        <div class="form-group col-md-2">
                          <label class="control-label">Fecha de entrega</label>
                          <input type="date" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" required>
                          <div class="help-block with-errors">&nbsp;</div>
                        </div>
                        <div class="form-group col-md-5">
                          <label class="control-label">Solicita</label>
                          <select type="text" class="form-control input-sm" maxlength="60" data-error="Este es un campo obligatorio" name="Datos[apellidoPaterno]" required></select>
                          <div class="help-block with-errors">&nbsp;</div>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label">Centro de costos</label>
                          <select type="text" class="form-control input-sm" maxlength="60" name="Datos[apellidoMaterno]">
                          <div class="help-block with-errors">&nbsp;</div></select>
                        </div>
                        <div class="form-group col-md-9">
                          <label class="control-label">Motivo o descripción de la requisición</label>
                          <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" required>
                          <div class="help-block with-errors">&nbsp;</div>
                        </div>
                        <h4>Detalles</h4>
                        <div class="col-lg-12 col-xs-12 table-responsive">
                          <table class="table table-hover table-bordered table-condensed text-center">
                            <tr>
                              <th>Cantidad</th>
                              <th>Producto o Servicio</th>
                              <th>Unidad</th>
                              <th>Prioridad</th>
                              <th></th>
                            </tr>
                            <tr>
                              <td><input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]"></td>
                              <td><select class="form-control input-sm"><option></option></select></td>
                              <td><select class="form-control input-sm"><option></option></select></td>
                              <td><select class="form-control input-sm"><option></option></select></td>
                              <td><a style="cursor:pointer;" data-toggle="tooltip"><i class="fa fa-plus"></i></a></td>
                            </tr>
                          </table>
                        </div>
                        <div class="form-group col-md-12">
                          <button type="submit" class="btn btn-primary pull-right" name="Datos[tipo]" value="1" >Guardar</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.col-md-12 -->
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
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- InputMask -->
    <script src="../../../assets/js/input-mask/jquery.inputmask.js"></script>
    <!-- Validaciones -->
    <script src="../../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Alta Proveedor -->
    <script src="../../js/V1/requisiciones/alta.js"></script>
  </body>
</html>
