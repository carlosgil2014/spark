<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../index.php');
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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/css/datatables/dataTables.bootstrap.css">
  <!-- Bootstrap multisect -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../assets/css/_all-skins.min.css">

</head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="loader">  
        </div>
        <div class="wrapper">
                <header class="main-header">
                <!-- Logo -->
                     <a href="../view/" class="logo">
                        <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
                        <span class="logo-mini"><b>ST</b></span>
                        <!-- logotipo para el estado normal y dispositivos móviles  -->
                        <span class="logo-lg">Spar Todopromo</span>
                      </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <?php 
                    include_once("../view/includes/datosUsuario.php");
                    ?>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                      <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li>
                              <a href="index.php?accion=login">
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
                        <!--No se que poner XD -->
                      </h4>
                    </section>
                    <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                    <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                      <div class="col-md-4 col-md-offset-4">
                        <div class="alert alert-<?php echo $clase;?>" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                      </div>
                    </div>
                    <section class="content">
                      <div class="row">
                        <div class="col-md-7">
                          <!-- general form elements -->
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Mis Datos</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <div class="form-group col-md-5">
                                <label class="control-label">Nombre(s)</label>
                                <input type="text" class="form-control input-sm" value="<?php echo $datosUsuario['nombre'];?>" readonly>
                              </div>
                              <div class="form-group col-md-3">
                                  <label class="control-label">No. Empleado</label>
                                  <input type="text" class="form-control input-sm" value="<?php echo $datosUsuario['numEmpleado'];?>" readonly>
                                  <div class="help-block with-errors">&nbsp;</div>
                              </div>
                              <div class="form-group col-md-3">
                                <label class="control-label">R.F.C.</label>
                                <input type="text" class="form-control input-sm" value="<?php echo $datosUsuario['rfc'];?>" readonly>
                              </div>
                              <div class="form-group col-md-5">
                                  <label class="control-label">Correo</label>
                                  <input type="text" class="form-control input-sm" value="<?php echo $datosUsuario['correo'];?>" readonly>
                                  <div class="help-block with-errors">&nbsp;</div>
                              </div>
                               <div class="form-group col-md-6">
                                  <label class="control-label">Puesto</label>
                                  <input type="text" class="form-control input-sm" value="<?php echo $datosUsuario['puesto'];?>" readonly>
                                  <div class="help-block with-errors">&nbsp;</div>
                              </div>
                            </div>
                          </div>
                          <!-- /.box -->
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-5">
                          <!-- general form elements -->
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Mi Foto</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <div class="form-group col-md-12 text-center">
                                <img id="foto" <?php if(!empty($datosUsuario["foto"])){ ?> src="data:image;base64,<?php echo base64_encode( $datosUsuario['foto'] );?>" <?php } ?> width="90" height="90">
                              </div>
                              <form data-toggle="validator" role="form" method="POST" action="index.php?accion=actualizarPerfil" enctype="multipart/form-data">
                                <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario['idUsuario'];?>">
                                <div class="form-group col-md-5">
                                  <label class="control-label">Foto de Perfil</label>
                                  <input type="file" name="foto" class="form-control input-sm" onchange="cargarFoto(this);">
                                  <div class="help-block with-errors">&nbsp;</div>
                                </div>
                                <div class="form-group col-md-4">
                                  <label class="control-label">Usuario</label>
                                  <input type="text" name="usuario" class="form-control input-sm" value="<?php echo $datosUsuario['usuario'];?>" required>
                                  <div class="help-block with-errors">&nbsp;</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">&nbsp;</label>
                                    <button class="btn btn-block btn-flat btn-sm btn-success" >Guardar</button>
                                </div>
                              </form>
                            </div>
                          </div>
                          <!-- /.box -->
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-md-7">
                          <!-- general form elements -->
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Actualizar Contraseña</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <form data-toggle="validator" role="form" method="POST" action="index.php?accion=actualizarContrasena">
                                <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario['idUsuario'];?>">
                                <div class="form-group col-md-3">
                                  <label class="control-label">Contraseña Actual</label>
                                  <input type="password" name="contrasenaActual" class="form-control input-sm" required>
                                  <div class="help-block with-errors">&nbsp;</div>
                                </div>
                                <div class="form-group col-md-3">
                                  <label class="control-label">Contraseña Nueva</label>
                                  <input type="password" name="contrasenaNueva" class="form-control input-sm" id="contrasenaNueva" required>
                                  <div class="help-block with-errors">&nbsp;</div>
                                </div>
                                <div class="form-group col-md-4">
                                  <label class="control-label">Confirme contraseña</label>
                                  <input type="password" name="contrasenaNueva1" class="form-control input-sm" data-match="#contrasenaNueva" data-match-error="La contraseñas nuevas no coinciden" required>
                                  <div class="help-block with-errors">&nbsp;</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">&nbsp;</label>
                                    <button class="btn btn-block btn-flat btn-sm btn-success" >Actualizar</button>
                                </div>
                              </form>
                            </div>
                          </div>
                          <!-- /.box -->
                        </div>
                        <!-- /.col-md-6 -->
                      </div>
                      <!-- /.row -->
                    </section>
                </div>
                <!-- ./Content wrapper -->
            </div>
            <!-- ./wrapper -->
            <!-- jQuery 2.2.3 -->
            <script src="../assets/js/jquery/jquery-2.2.3.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="../assets/js/jquery/jquery-ui.js"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
            <!-- DataTables -->
            <script src="../assets/js/datatables/jquery.dataTables.min.js"></script>
            <script src="../assets/js/datatables/dataTables.bootstrap.min.js"></script>
            <!-- Validaciones -->
            <script src="../assets/js/validacion/validacion.js"></script>
            <!-- AdminLTE App -->
            <script src="../assets/js/app.min.js"></script>
            <!-- Funciones Generales -->
            <script src="../assets/js/funciones.js"></script>
            <!-- Alta Usuarios -->
            <script src="../js/V1/usuarios/perfil.js" language="javascript"></script>
    </body>
    <div id="respuesta" title="Aviso">

    </div>
</html>