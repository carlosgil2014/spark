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
              <a href="index.php?accion=alta"> 
                <i class="fa fa-plus"></i> <span>Agregar</span>
              </a>
            </li>
            <li>
              <a href="index.php?accion=index">
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
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Clientes/Modificar</h3>
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
                          <input name="tabs" <?php if($cliente["tipo"] == 1) echo "checked"; ?> type="radio" data-target="#fisica">Persona Física
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4 text-center">
                      <div class="radio">
                        <label>
                          <input name="tabs" <?php if($cliente["tipo"] == 2) echo "checked"; ?> type="radio" data-target="#moral">Persona Moral
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4 text-center" >
                      <div class="radio">
                        <label>
                          <input name="tabs" <?php if($cliente["tipo"] == 3) echo "checked"; ?> type="radio" data-target="#extranjero">Cliente Extranjero
                        </label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="tab-content">
                        <!--DIV PARA RADIO BUTTON PERSONAFISICA-->
                        <div id="fisica" class="tab-pane <?php if($cliente["tipo"] == 1) echo 'active';?> schedule-pane">
                          <form data-toggle="validator" id="formularioFisica" role="form" method="POST" action="index.php?accion=actualizar&idCliente=<?php echo $_GET['idCliente'];?>">
                            <div class="form-group col-md-3">
                              <label class="control-label">R.F.C.</label>
                              <input type="text" class="form-control input-sm" style="text-transform:uppercase;" onchange="validarRfc('fisica')" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU" data-error="Es un campo obligatorio de 13 caracteres" tabindex="1" name="Datos[rfc]" value="<?php echo $cliente['rfc'];?>" required id="rfc">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">Nombre(s)</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" tabindex="2" value="<?php echo $cliente['nombres'];?>" required id="nombre">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">Apellido Paterno</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" tabindex="3" value="<?php echo $cliente['apellidoPaterno'];?>" required id="apellidoPaterno">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">Apellido Materno</label>
                              <input type="text" class="form-control input-sm" id="apellidoMaterno" maxlength="60" name="Datos[apellidoMaterno]" tabindex="4" value="<?php echo $cliente['apellidoMaterno'];?>">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre Comercial</label>
                              <input type="text" class="form-control input-sm" maxlength="60" name="Datos[nombreComercial]" tabindex="5" value="<?php echo $cliente['nombreComercial'];?>" id="nombreComercial">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Calle</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" tabindex="6" name="Datos[calle]" value="<?php echo $cliente['calle'];?>" required id="calle">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Interior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" tabindex="7" name="Datos[noInterior]" value="<?php echo $cliente['noInterior'];?>" required id="numeroInterior">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Exterior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]" tabindex="8" value="<?php echo $cliente['noExterior'];?>" id="numeroExterior">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                            <label class="control-label">Colonia</label>
                            <select class="form-control input-sm selectpicker" name="Datos[colonia]" data-error="Es un campo obligatorio" tabindex="10" data-live-search="true" required="required" id="coloniasFisica">
                              <?php 
                                foreach ($codigoPostal['colonias'] as $colonias){
                              ?>                            
                                <option <?php if($cliente["colonia"] == $colonias["idcp"]){echo "selected";}?> value="<?php echo $colonias['idcp']?>"><?php echo $colonias['asentamiento']?></option>';
                              <?php
                                }
                              ?>
                            </select>
                            <div class="help-block with-errors">&nbsp;</div>
                          </div>
                          <input type="hidden" name="Datos[idEstado]" value="<?php echo $cliente['estado']; ?>" id="idEstadoFisica">
                          <div class="form-group col-md-4">
                              <label class="control-label">Estado</label>
                              <input type="text" id="estadoFisica" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[estado]" required value="<?php echo $codigoPostal['estado']; ?>" readonly>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Delegación/Municipio</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" value="<?php echo $cliente['delegacion'];?>" required id="delegacionFisica" readonly>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">C.P.</label>
                              <input type="text" class="form-control input-sm" tabindex="9" onchange="codigoPostales(this,'fisica')"  maxlength="5" data-error="Es un campo obligatorio" name="Datos[cp]" value="<?php echo $cliente['cp'];?>" required id="codigoPostal">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <fieldset class="form-group col-md-12">
                              <legend>Contacto</legend>
                            </fieldset>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[nombreContacto]" tabindex="11" value="<?php echo $cliente['nombreContacto'];?>" required id="nombreContacto">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Principal</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-error="Es un campo obligatorio" tabindex="12" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoPrincipal]" value="<?php echo $cliente['telefonoContactoPrincipal'];?>" required id="telefonoPrincipal">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Secundario</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' tabindex="13" data-mask name="Datos[telefonoContactoSecundario]" value="<?php echo $cliente['telefonoContactoSecundario'];?>" id="nombreSecundario"> 
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Otro</label>
                              <input type="text" tabindex="14" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask id="otro">
                              <div class="help-block with-errors" name="Datos[telefonoContactoOtro]" value="<?php echo $cliente['telefonoContactoOtro'];?>">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-12">
                              <button type="button" class="btn btn-danger btn-sm pull-right" onclick="eliminar(<?php echo $_GET['idCliente'];?>,'<?php echo $cliente['razonSocial'];?>');">Eliminar</button>
                              <button type="submit" class="btn btn-warning btn-sm pull-right" name="Datos[tipo]" value="1">Actualizar</button>
                            </div>
                          </form>
                        </div>
                        <!--FIN DIV PARA RADIO BUTTON PERSONA FISICA-->

                        <!--DIV PARA RADIO BUTTON PERSONA MORAL-->
                        <div id="moral" class="tab-pane <?php if($cliente["tipo"] == 2) echo 'active';?> schedule-pane">
                          <form data-toggle="validator" role="form" method="POST" action="index.php?accion=actualizar&idCliente=<?php echo $_GET['idCliente'];?>">
                            <div class="form-group col-md-4">
                              <label class="control-label">R.F.C.</label>
                              <input type="text" class="form-control input-sm" id="rfcMoral" pattern="^[A-Z0-9]{12}" style="text-transform:uppercase;" tabindex="1" onchange="validarRfcMoral()" maxlength="12" placeholder="EJEM910825KY" data-error="Es un campo obligatorio de 12 caracteres" name="Datos[rfc]" value="<?php echo $cliente['rfc'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Razón Social</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[razonSocial]" tabindex="2" value="<?php echo $cliente['razonSocial'];?>" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Nombre Comercial</label>
                              <input type="text" tabindex="3" class="form-control input-sm" maxlength="60" name="Datos[nombreComercial]" value="<?php echo $cliente['nombreComercial'];?>" >
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Calle</label>
                              <input type="text" tabindex="4" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" value="<?php echo $cliente['calle'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Interior</label>
                              <input type="text" tabindex="5" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" value="<?php echo $cliente['noInterior'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Exterior</label>
                              <input type="text" tabindex="6" class="form-control input-sm" maxlength="10" name="Datos[noExterior]" value="<?php echo $cliente['noExterior'];?>" >
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <input type="hidden" name="Datos[idEstado]" value="<?php echo $cliente['estado']; ?>" id="idEstadoMoral">
                            <div class="form-group col-md-3">
                                <label class="control-label">Estado</label>
                                <input type="text" id="estadoMoral" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[estado]" required value="<?php echo $codigoPostal['estado']; ?>" readonly>
                                <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Colonia</label>
                              <select class="form-control input-sm selectpicker" tabindex="8" name="Datos[colonia]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="coloniasMoral">
                                <?php 
                                  foreach ($codigoPostal['colonias'] as $colonias){
                                ?>                            
                                  <option <?php if($cliente["colonia"] == $colonias["idcp"]){echo "selected";}?> value="<?php echo $colonias['idcp']?>"><?php echo $colonias['asentamiento']?></option>';
                                <?php
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Delegación/Municipio</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" value="<?php echo $cliente['delegacion'];?>" required id="delegacionMoral" readonly>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">País</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarEstados(this);"  name="Datos[pais]" required>
                              <?php 
                              foreach ($paises as $pais){
                              ?>
                                <option <?php if ($pais["nombre"] == $cliente["pais"]) echo "selected";?>><?php echo $pais["nombre"]?></option>
                              <?php
                              }
                              ?>
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">C.P.</label>
                              <input type="text" class="form-control input-sm"  maxlength="5" tabindex="7" onchange="codigoPostales(this,'moral')" data-error="Es un campo obligatorio" name="Datos[cp]" value="<?php echo $cliente['cp'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <fieldset class="form-group col-md-12">
                              <legend>Contacto</legend>
                            </fieldset>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio"  name="Datos[nombreContacto]" tabindex="9" value="<?php echo $cliente['nombreContacto'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Principal</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-error="Es un campo obligatorio" tabindex="10" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask  name="Datos[telefonoContactoPrincipal]" value="<?php echo $cliente['telefonoContactoPrincipal'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Secundario</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' tabindex="11" data-mask name="Datos[telefonoContactoSecundario]" value="<?php echo $cliente['telefonoContactoSecundario'];?>">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Otro</label>
                              <input type="text" class="form-control input-sm" tabindex="12" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoOtro]" value="<?php echo $cliente['telefonoContactoOtro'];?>">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-11 col-xs-6">
                              <div id="mensajeMoral"></div>
                              <button type="submit" class="btn btn-sm btn-warning pull-right" name="Datos[tipo]" value="2">Actualizar</button>
                            </div>
                            <div class="form-group col-md-1 col-xs-6">
                              <button type="button" class="btn btn-sm btn-danger pull-right" onclick="eliminar(<?php echo $_GET['idCliente'];?>,'<?php echo $cliente['razonSocial'];?>');">Eliminar</button>
                            </div>
                          </form>
                        </div>
                        <!--FIN DIV PARA RADIO BUTTON PERSONA MORAL-->
                        <!--DIV PARA RADIO BUTTON CLIENTE EXTRANJERO-->
                        <div id="extranjero" class="tab-pane <?php if($cliente["tipo"] == 3) echo 'active';?> schedule-pane">
                          <form data-toggle="validator" role="form" method="POST" action="index.php?accion=actualizar&idCliente=<?php echo $_GET['idCliente'];?>">
                            <div class="form-group col-md-4">
                              <label class="control-label">R.F.C.</label>
                              <input type="text" class="form-control input-sm" value="XEXX010101000" name="Datos[rfc]" required readonly>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Razón Social</label>
                              <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[razonSocial]" value="<?php echo $cliente['razonSocial'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Nombre Comercial</label>
                              <input type="text" class="form-control input-sm" maxlength="60" name="Datos[nombreComercial]" value="<?php echo $cliente['nombreComercial'];?>">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Calle</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" value="<?php echo $cliente['calle'];?>"required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Interior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" value="<?php echo $cliente['noInterior'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="control-label">No. Exterior</label>
                              <input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]" value="<?php echo $cliente['noExterior'];?>">
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Colonia</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[colonia]" value="<?php echo $cliente['colonia'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Delegación/Municipio</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]"  value="<?php echo $cliente['delegacion'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">Estado</label>
                              <input type="text" class="form-control input-sm" data-error="Es un campo obligatorio" name="Datos[estado]"  value="<?php echo $cliente['estado'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="control-label">C.P.</label>
                              <input type="text" class="form-control input-sm" pattern="^[0-9]{5}" maxlength="5" data-error="Es un campo obligatorio" name="Datos[cp]" value="<?php echo $cliente['cp'];?>" required>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <fieldset class="form-group col-md-12">
                              <legend>Contacto</legend>
                            </fieldset>
                            <div class="form-group col-md-3">
                              <label class="control-label">Nombre</label>
                              <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[nombreContacto]" value="<?php echo $cliente['nombreContacto'];?>" required >
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Principal</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-error="Es un campo obligatorio" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoPrincipal]" value="<?php echo $cliente['telefonoContactoPrincipal'];?>" required >
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Teléfono Secundario</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoSecundario]" value="<?php echo $cliente['telefonoContactoSecundario'];?>" > 
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-3">
                              <label class="control-label">Otro</label>
                              <input type="text" class="form-control input-sm" maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask name="Datos[telefonoContactoOtro]" value="<?php echo $cliente['telefonoContactoOtro'];?>" >
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="form-group col-md-11 col-xs-6">
                              <button type="submit" class="btn btn-sm btn-warning pull-right" name="Datos[tipo]" value="3">Actualizar</button>
                            </div>
                            <div class="form-group col-md-1 col-xs-6">
                              <button type="button" class="btn btn-sm btn-danger pull-right" onclick="eliminar(<?php echo $_GET['idCliente'];?>,'<?php echo $cliente['razonSocial'];?>');">Eliminar</button>
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
      <?php
      include_once("../../../view/includes/footer.php");
      ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- Modal Eliminar -->
    <div id="modalEliminar" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Clientes/Eliminar</h4>
          </div>
          <div class="modal-body text-center">
          ¿Eliminar el cliente <b id="clienteEliminar"></b>?
          </div>
          <div class="modal-footer">
            <button type="button" id="eliminar" class="btn btn-sm btn-danger" data-dismiss="modal">Continuar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar -->

    <div id="modalClienteEmpleado" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Cliente/Empleado</h4>
            </div>
            <div class="modal-body text-center">
            El RFC que ingreso ya existe como empleado spar, ¿Desea registrarlo como cliente?
            </div>
            <div class="modal-footer">
              <a style="cursor: pointer;" class="btn btn-success btn-sm" data-dismiss="modal" id="siFisicas">Si</a>
              <a style="cursor: pointer;" class="btn btn-danger btn-sm" data-dismiss="modal" id="noFisica">No</a>
            </div>
          </div>
    </div>
</div>

<div id="modalRfcCliente" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">RFC/Repetido</h4>
            </div>
            <div class="modal-body text-center">
            El RFC que ingreso ya existe como cliente, verifique…
            </div>
            <div class="modal-footer">
              <button style="cursor: pointer;" class="btn btn-success btn-sm" data-dismiss="modal" id="cerrar">Cerrar</button>
            </div>
          </div>
    </div>
</div>


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
    <!-- Alta Cliente -->
    <script src="../../js/V1/clientes/alta.js"></script>    
    <!-- Modificar Cliente -->
    <script src="../../js/V1/clientes/modificar.js"></script>
  </body>
</html>
