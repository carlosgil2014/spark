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
                  <h3 class="box-title">Habilidades/Principal</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-1 col-sm-4">
                        <button type="button" onclick="agregar();" class="btn btn-success btn-block btn-flat btn-sm">Agregar</button>
                      </div>
                    </div>
                  </div>
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
                  <div class="row">
                    <div class="table-responsive container-fluid">
                      <table id="tblHabilidades" class="table table-bordered table-striped small">
                    <thead>
                    <tr>
                      <th>Habilidades</th>
                      <th></th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($habilidades as $habilidad){
                    ?>
                    <tr>
                      <td><?php echo $habilidad["nombreHabilidad"]?></td>
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="modificar('<?php echo $habilidad['idHabilidades'];?>');">
                          <i class="fa fa-pencil-square-o"></i>
                        </a>
                      </td>
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="historial('<?php echo $habilidad['idHabilidades'];?>');">
                          <i class="fa fa-search text-blue"></i>
                        </a>
                      </td>
                      <!--                       
                      <td class = "text-center">
                        <a style="cursor: pointer;" onclick="eliminar('<?php echo $habilidad['idhabilidad'];?>','<?php echo $habilidad['habilidad'];?>');">
                          <i class="fa fa-trash-o text-red"></i>
                        </a>
                      </td>-->
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                  </table>
                    </div>

                    <table id='ejemplo1' class='table table-bordered table-striped'>
    <thead>
        <tr>
            <th>Hora de entrega</th>
            <th>Cliente</th>
            <th>Dirección de obra</th>
            <th>Fecha de entrega</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr id='head'>
            <td>".$reg['hora']."</td>
            <td>".$reg['cliente']."</td>
            <td>".$reg['dir_obra']."<br/>".$reg['indicaciones']."</td>
            <td>".$reg['fecha_entrega']."</td>
            <td>        
                <button class='btn btn-danger btn-sm' aria-label='Left Align'> Borrar</button>
                <button class='btn btn-success btn-sm' aria-label='Left Align'> Editar</button></br>
                <button id='btnModal'>Abrir modal</button>
            </td>
        </tr>
    </tbody>
</table>

<script>
    var modal = document.getElementById('Modal');

    var btn = document.getElementById("btnModal");

    var span = document.getElementsByClassName("cerrar")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>



                  </div>
                  <div class="control-sidebar-bg"></div>
                  <div class="modal fade" id="modalHabilidad" role="dialog">              
                  </div>
                  <!-- Modal Eliminar -->
                  <div id="modalEliminar" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Habilidad/Eliminar</h4>
                        </div>
                        <div class="modal-body text-center">
                        ¿Eliminar habilidad <b id="habilidadEliminar"></b>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" id="eliminar" class="btn btn-sm btn-danger" data-dismiss="modal">Continuar</button>
                        </div>
                      </div>
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
      <div  id="modalPresupuesto" class="modal" tabindex="-1" role="dialog">              
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
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Index Conocimientos -->
    <script src="../../js/V1/habilidades/index.js"></script>
  </body>
</html>
