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
  <body class="hold-transition fixed skin-blue sidebar-mini">
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
              <a style="cursor: pointer;" onclick="goBack();">
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
                  <h3 class="box-title">Contratos/Nuevo</h3>
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
                    <?php
                    if(!isset($_POST["tipoContrato"]) && !isset($lineasDisponibles)){
                    ?>
                    <div class="row">
                      <form action="index.php?accion=agregar" method="POST" enctype="multipart/form-data">
                        <div class="form-group col-md-2 col-xs-4"> 
                            <label class="radio-inline"><input type="radio" name="tipoContrato" value="nuevo" <?php if(isset($_POST['tipoContrato'])){if($_POST['tipoContrato'] == 'nuevo') echo 'checked';} else echo 'checked';?> >Nuevo Contrato</label>
                        </div>
                        <div class="form-group col-md-2 col-xs-4">    
                            <label class="radio-inline"><input type="radio" name="tipoContrato" value="renovacion" <?php if(isset($_POST['tipoContrato'])) if($_POST['tipoContrato'] == 'renovacion') echo 'checked';?>>Renovación</label>
                        </div>
                        <div class="form-group col-md-2 col-xs-4">  
                            <label class="radio-inline"><input type="radio" name="tipoContrato" value="adicion" <?php if(isset($_POST['tipoContrato'])) if($_POST['tipoContrato'] == 'adicion') echo 'checked';?>>Líneas Adicionales</label>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <input type ="file" class="form-control input-sm text-center" name="archivoLineas" accept=".csv">
                        </div>                      
                        <div class="form-group col-md-2 col-xs-4">
                          <select type="text" class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="cliente" id="cliente" data-container="body">
                            <option data-hidden="true"></option>
                          <?php 
                          foreach ($clientes as $cliente) {
                          ?>
                            <option value="<?php echo $cliente['idclientes'];?>" <?php if(isset($_POST["cliente"]) && $_POST["cliente"] == $cliente['idclientes']){echo "selected";}?>><?php echo $cliente["nombreComercial"]?></option>
                          <?php
                          }
                          ?>
                          </select>
                        </div>

                        <div class="form-group col-md-1 col-xs-2">
                          <button type="submit" class="btn btn-flat btn-sm btn-success"><small>Continuar</small></button>
                        </div>
                      </form>
                    </div>                    
                    <?php
                    } 
                    if(isset($_POST["tipoContrato"]) && isset($lineasDisponibles)){
                    ?>
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label class="control-label">Contrato</label>
                        <input type="text" class="form-control input-sm" name="Datos[contrato]">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Cliente</label>
                        <input type="text" class="form-control input-sm text-center" value="<?php echo $datosCliente['nombreComercial'];?>" readonly>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">De</label>
                        <input type="date" class="form-control input-sm" value="<?php echo date('Y-m-d');?>" name="Datos[de]">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Hasta</label>
                        <input type="date" class="form-control input-sm" value="<?php echo date('Y-m-d');?>" name="Datos[hasta]">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Líneas</label>
                        <select type="text" id="linea" class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" data-selected-text-format="count > 2" onchange="añadirLinea();" data-container="body">
                          <option data-hidden="true"></option>
                        <?php 
                        foreach ($lineasDisponibles as $linea) {
                        ?>
                          <option value="<?php echo base64_encode($linea['idLinea']);?>"><?php echo $linea['linea'];?></option>
                        <?php
                        }
                        ?>
                        </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Total de líneas</label>
                        <input id="totalLineas" type="text" class="form-control input-sm" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12 pre-scrollable">
                        <table id="tablaLineas" class="table table-bordered table-striped small">
                          <thead>
                            <tr>
                              <th>Linea</th>
                              <th>Contrato</th>
                              <th>Estado</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                        <?php 
                        if(isset($lineasArchivo)){
                          foreach ($lineasArchivo as $linea)
                          {
                            if($linea["estado"] === "Existe en BD"){
                          ?>
                            <tr class="success text-center">
                              <td>
                                <input style="background:none; border:none;"" value="<?php echo $linea['linea']?>" readonly><input name="linea" value="<?php echo base64_encode($linea['idLinea']);?>" hidden>
                              </td>
                              <td>
                                <?php echo $linea['contrato']?>
                              </td>
                              <td>
                                <?php echo $linea['estado']?>
                              </td>
                              <td>
                                <a style="cursor:pointer;" data-toggle="tooltip" onclick="eliminarLinea(this,'<?php echo base64_encode($linea['idLinea'])?>','<?php echo $linea['linea'];?>');"><i class="fa fa-minus text-red"></i></a>
                              </td>
                            </tr>
                          <?php
                            }
                            else{
                          ?>
                            <tr class="danger text-center">
                              <td>
                                <input style="background:none; border:none;"" value="<?php echo $linea['linea']?>" readonly>
                              </td>
                              <td>
                                <?php echo $linea['contrato']?>
                              </td>
                              <td>
                                <?php echo $linea['estado']?>
                              </td>
                              <td>
                              </td>
                            </tr>
                          <?php
                            }
                          }
                          ?>
                        <?php
                        }
                        ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
                <!-- /.box-body -->
                <?php
                if(isset($_POST["tipoContrato"]) && isset($lineasDisponibles)){
                ?>
                <div class="box-footer">
                  <div class="row">
                    <div class="form-group col-md-12 text-right">
                      <button class="btn btn-flat btn-success btn-sm"> Guardar</button>
                    </div>
                  </div>
                </div>
                <!-- /.box-footer -->
                <?php 
                }
                ?>
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
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Index Bancos -->
    <script src="../../js/V1/contratos/agregar.js"></script>
  </body>
</html>
