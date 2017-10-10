<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../index.html');
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
  <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../assets/css/datatables/dataTables.bootstrap.css">
  <!-- Bootstrap multisect -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../assets/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../../assets/css/_all-skins.min.css">

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
                        Actualizar Usuario
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
                                        <form data-toggle="validator" action="index.php?accion=actualizar&idUsuario=<?php echo $_GET['idUsuario'];?>" method="POST">
                                          <div class="row">
                                            <div class="form-group col-md-2">
                                                <label class="control-label">Usuario</label>
                                                <input type="text" name="Datos[usuario]" class="form-control input-sm" value="<?php echo $usuario['usuario']?>" required=>
                                                <div class="help-block with-errors">&nbsp;</div>
                                            </div>
                                            <div class="form-group col-md-2">
                                              <label class="control-label">Nueva Contraseña</label>
                                              <input type="password" name="Datos[contrasena]" class="form-control input-sm" id="contrasena">
                                              <div class="help-block with-errors">&nbsp;</div>
                                            </div>
                                            <div class="form-group col-md-2">
                                              <label class="control-label">Confirme contraseña</label>
                                              <input type="password" name="Datos[contrasena1]" class="form-control input-sm" data-match="#contrasena" data-match-error="La contraseñas no coinciden">
                                              <div class="help-block with-errors">&nbsp;</div>
                                            </div>
                                            <div class="form-group col-md-4">
                                              <label class="control-label">Nombre(s)</label>
                                              <input type="text" class="form-control input-sm" value="<?php echo $usuario['nombre'];?>" readonly>
                                            </div>
                                            <div class="form-group col-md-2">
                                              <label class="control-label">Puesto</label>
                                              <input type="text" class="form-control input-sm" value="<?php echo $usuario['puesto'];?>" readonly>
                                            </div>
                                          </div>
                                          <table class="table small">
                                          <?php
                                          $columnas = 0;
                                          $i = 0;
                                          foreach($datosClientes as $cliente )                
                                          { 
                                            if($columnas == 0)
                                            {
                                          ?>
                                            <tr>
                                          <?php
                                            }  
                                            $razonSocial = substr($cliente["razonSocial"],0,20);
                                            if(strlen($cliente["razonSocial"])>20)
                                              $razonSocial .= "...";
                                          ?>
                                            <td class="<?php if(in_array($cliente["idclientes"],$usuariosClientes)){echo 'success';}else{echo 'danger';}?>" >
                                              <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" class="checkCliente" name="Datos[clientes][]" value="<?php echo $cliente['idclientes']?>" <?php if(in_array($cliente["idclientes"],$usuariosClientes)){echo 'checked';}?> /><?php echo $razonSocial." (".$cliente["nombreComercial"].")";?>
                                                </label>
                                              </div>
                                            </td>
                                          <?php    
                                            $columnas++;
                                            $i++;
                                            if($columnas==5){
                                              $columnas=0;
                                          ?>
                                            </tr>
                                          <?php
                                            }
                                          }
                                          ?>
                                          </table>
                                          <div class="form-group col-md-12">
                                            <label class="control-label">&nbsp;</label>
                                            <button class="btn btn-block btn-flat btn-sm btn-success" >Guardar</button>
                                          </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- ./Content wrapper -->
                <?php
                  include_once("../../../view/includes/footer.php");
                ?>
            </div>
            <!-- ./wrapper -->
            <!-- jQuery 2.2.3 -->
            <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="../../../assets/js/jquery/jquery-ui.js"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
            <!-- DataTables -->
            <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
            <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
            <!-- Validaciones -->
            <script src="../../../assets/js/validacion/validacion.js"></script>
            <!-- AdminLTE App -->
            <script src="../../../assets/js/app.min.js"></script>
            <!-- Bootstrap multisect -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
            <!-- Funciones Generales -->
            <script src="../../../assets/js/funciones.js"></script>
            <!-- Alta Usuarios -->
            <script src="../../js/V1/usuarios/alta.js" language="javascript"></script>
    </body>
    <div id="respuesta" title="Aviso">

    </div>
</html>