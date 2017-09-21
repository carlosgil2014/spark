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
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap-select.min.css">
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
              <a href="crudClientes.php?accion=index">
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
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Clientes/Agregar</h3>
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
                    <div class="col-md-4 text-center">
                      <div class="radio">
                        <label>
                          <input name="tabs" checked type="radio" data-target="#fisica">Persona Física
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4 text-center">
                      <div class="radio">
                        <label>
                          <input name="tabs" type="radio" data-target="#moral">Persona Moral
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4 text-center" >
                      <div class="radio">
                        <label>
                          <input name="tabs" type="radio" data-target="#extranjero">Cliente Extranjero
                        </label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="tab-content">
                        <!--DIV PARA RADIO BUTTON PERSONAFISICA-->
                        <div id="fisica" class="tab-pane active schedule-pane">
                          <form data-toggle="validator" role="form" method="POST" action="crudClientes.php?accion=guardar">
                            <div class="form-group col-md-3">
                              <label class="control-label">R.F.C.</label>
                              <input type="text" class="form-control input-sm" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU" data-error="Campo obligatorio de 13 caracteres" name="Datos[rfc]" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">Nombre(s)</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">Apellido Paterno</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">Apellido Materno</label>
                              <input type="text" class="form-control input-sm" maxlength="60" name="Datos[apellidoMaterno]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre Comercial</label>
                              <input type="text" class="form-control input-sm" maxlength="60" name="Datos[nombreComercial]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Calle</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Interior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Exterior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Colonia</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[colonia]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Delegación/Municipio</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Estado</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" name="Datos[estado]" required>
                              <?php 
                              foreach ($estados as $estado){
                              ?>
                                <option <?php if ($estado["nombre"] == "Ciudad de México") echo "selected";?>><?php echo $estado["nombre"]?></option>
                              <?php
                              }
                              ?>
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">C.P.</label>
                              <input type="text" class="form-control input-sm" pattern="^[0-9]{5}" maxlength="5" data-error="Es un campo obligatorio" name="Datos[cp]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <fieldset class="form-group col-md-12">
                              <legend>Contacto</legend>
                            </fieldset>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[nombreContacto]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Principal</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-error="Es un campo obligatorio" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoPrincipal]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Secundario</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoSecundario]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Otro</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask>
                              <div class="help-block with-errors" name="Datos[telefonoContactoOtro]">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-12">
                              <button type="submit" class="btn btn-success pull-right" name="Datos[tipo]" value="1" >Guardar</button>
                            </div>
                          </form>
                        </div>
                        <!--FIN DIV PARA RADIO BUTTON PERSONA FISICA-->

                        <!--DIV PARA RADIO BUTTON PERSONA MORAL-->
                        <div id="moral" class="tab-pane schedule-pane">
                          <form data-toggle="validator" role="form" method="POST" action="crudClientes.php?accion=guardar">
                            <div class="form-group col-md-3">
                              <label class="control-label">R.F.C.</label>
                              <input type="text" class="form-control input-sm" pattern="^[A-Z0-9]{12}" maxlength="12" placeholder="EJEM910825KY" data-error="Campo obligatorio de 13 caracteres" name="Datos[rfc]" data-toggle="tooltip" data-trigger="hover" title="12 caracteres, Mayúsculas y sin guiones" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-6">
                              <label class="control-label">Razón Social</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[razonSocial]" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre Comercial</label>
                              <input type="text" class="form-control input-sm" maxlength="60" name="Datos[nombreComercial]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Calle</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Interior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Exterior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Colonia</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[colonia]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Delegación/Municipio</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">País</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarEstados(this);"  name="Datos[pais]" required>
                              <?php 
                              foreach ($paises as $pais){
                              ?>
                                <option <?php if ($pais["nombre"] == "México") echo "selected";?>><?php echo $pais["nombre"]?></option>
                              <?php
                              }
                              ?>
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Estado</label>
                              <select id="estados" class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" name="Datos[estado]" required>
                              <?php 
                              foreach ($estados as $estado){
                              ?>
                                <option <?php if ($estado["nombre"] == "Ciudad de México") echo "selected";?>><?php echo $estado["nombre"]?></option>
                              <?php
                              }
                              ?>
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">C.P.</label>
                              <input type="text" class="form-control input-sm" pattern="^[0-9]{5}" maxlength="5" data-error="Es un campo obligatorio" name="Datos[cp]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <fieldset class="form-group col-md-12">
                              <legend>Contacto</legend>
                            </fieldset>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio"  name="Datos[nombreContacto]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Principal</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-error="Es un campo obligatorio" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask  name="Datos[telefonoContactoPrincipal]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Secundario</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoSecundario]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Otro</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoOtro]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-12">
                              <button type="submit" class="btn btn-success pull-right" name="Datos[tipo]" value="2">Guardar</button>
                            </div>
                          </form>
                        </div>
                        <!--FIN DIV PARA RADIO BUTTON PERSONA MORAL-->
                        <!--DIV PARA RADIO BUTTON CLIENTE EXTRANJERO-->
                        <div id="extranjero" class="tab-pane schedule-pane">
                          <form data-toggle="validator" role="form" method="POST" action="crudClientes.php?accion=guardar">
                            <div class="form-group col-md-3">
                              <label class="control-label">R.F.C.</label>
                              <input type="text" class="form-control input-sm" value="XEXX010101000" name="Datos[rfc]" required readonly>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-6">
                              <label class="control-label">Razón Social</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[razonSocial]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre Comercial</label>
                              <input type="text" class="form-control input-sm" maxlength="60" name="Datos[nombreComercial]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Calle</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Interior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Exterior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Colonia</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[colonia]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Delegación/Municipio</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Estado</label>
                              <input type="text" class="form-control input-sm" data-error="Es un campo obligatorio" name="Datos[estado]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">C.P.</label>
                              <input type="text" class="form-control input-sm" pattern="^[0-9]{5}" maxlength="5" data-error="Es un campo obligatorio" name="Datos[cp]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <fieldset class="form-group col-md-12">
                              <legend>Contacto</legend>
                            </fieldset>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[nombreContacto]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Principal</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-error="Es un campo obligatorio" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoPrincipal]" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Secundario</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoSecundario]"> 
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Otro</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoOtro]">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-12">
                              <button type="submit" class="btn btn-success pull-right" name="Datos[tipo]" value="3">Guardar</button>
                            </div>
                          </form>
                        </div>
                        <!--FIN DIV PARA RADIO BUTTON CLIENTE EXTRANJERO-->
                      </div>
                      <!-- /.tab-content -->
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

    <!-- jQuery 2.2.3 -->
    <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- InputMask -->
    <script src="../../assets/js/input-mask/jquery.inputmask.js"></script>
    <!-- Validaciones -->
    <script src="../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../assets/js/funciones.js"></script>
    <!-- Alta Cliente -->
    <script src="../js/V1/clientes/alta.js"></script>
  </body>
</html>
