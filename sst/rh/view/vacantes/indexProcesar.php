<?php
if(!isset($_SESSION['spar_usuario']) || $permisos["Procesar"] !== "1")
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
    <!-- selected -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap/bootstrap-select.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <?php 
      include_once("../../../view/includes/modalExpiracion.php");
    ?>
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
                  <h3 class="box-title">Procesar vacantes en búsqueda</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                  <div class="row">
                    <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                      <div class="col-md-4 col-md-offset-4">
                        <div class="alert alert-<?php echo $_GET['clase'];?>" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <form action="index.php?accion=indexProcesar" method="POST">
                        <div class="col-md-4 col-sm-4">
                          <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="clientes[]" id="cliente" multiple="multiple" data-container="body"  data-live-search = "true" data-selected-text-format="count > 5"> 
                            <?php
                            foreach ($clientes as $cliente) {
                            ?>
                            <option value="<?php echo base64_encode($cliente['idclientes'])?>" <?php if(isset($tmpClientes)) if (in_array(base64_encode($cliente['idclientes']), array_column($tmpClientes, "idclientes"))) echo "selected";?>><?php echo $cliente["nombreComercial"];?></option>
                            <?php 
                            }
                          ?> 
                          </select>
                        </div>
                        <div class="col-md-1 col-sm-4">
                          <button type="submit" class="btn btn-info pull-right btn-sm btn-block btn-flat">Buscar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <div class="table-responsive container-fluid">
                      <table id="tblPresupuestos" class="table table-bordered table-striped small">
                        <thead>
                        <tr>
                          <th>Folio</th>
                          <th>Cliente (Proyecto)</th>
                          <th>Presupuesto</th>
                          <th>Perfil</th>
                          <th>Elaborado</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        foreach($vacantes as $vacante){
                        ?>
                        <tr>
                          <td>
                            <?php echo $vacante['nombreComercial'].'-'.str_pad($vacante['mes'], 2, "0", STR_PAD_LEFT).'-'.$vacante['anio'].'-'.str_pad($vacante['folio'], 3, "0", STR_PAD_LEFT);?>
                          </td>
                          <td><?php echo $vacante["nombreComercial"]; if(!empty($vacante["proyecto"])) echo " (".$vacante["proyecto"].")";?></td>
                          <td><?php echo $vacante["presupuesto"]?></td>
                          <td><?php echo $vacante["perfil"]?></td>
                          <td><?php echo $vacante["solicitante"]." (". date_format(date_create($vacante["fechaRegistro"]),"d-m-Y H:i").")";?></td>
                          <td class = "text-center">
                            <a style="cursor: pointer;" onclick="procesar('<?php echo base64_encode($vacante['idPresupuesto']);?>','<?php echo base64_encode($vacante['idVacante']);?>');">
                              <i class="fa fa-pencil-square-o"></i>
                            </a>
                          </td>                      
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                      </table>
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
      <?php
      include_once("../../../view/includes/footer.php");
      ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
      <div  id="modalProcesar" class="modal" tabindex="-1" role="dialog">              
      </div>
      <!-- Modal Principal -->
      
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
    <!-- Index Sims -->
    <script src="../../js/V1/vacantes/procesar.js"></script>
  </body>
</html>
