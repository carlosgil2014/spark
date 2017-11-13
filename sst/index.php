<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}
if(isset($_SESSION['spar_usuario']))
    header('Location: view/index.php?accion=login');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Carlos Enrique Gil, Gerardo Medina, Salvador Luna y Victor Nava">
  <title>Sistema Spar Todopromo | Spar México</title>
  <!-- Indicadores para respuestas de la plantilla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Estilo del tema -->
  <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
  <!-- Poner la carpeta de estilo CSS a utilizar-->
  <link rel="stylesheet" href="assets/css/_all-skins.min.css">
  <!-- Soporte de elementos HTML5 para Respond.js, IE8 y media queries -->
  <!-- ADVERTENCIA: Respond.js no funcionará si se visualiza con IE 9:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
  <body class="hold-transition login-page layout-top-nav">
    <div class="wrapper">
      <div class="content-wrapper">
        <div class="container">
          <div class="login-box">
            <div class="login-logo">
              <img src="img/spar.png" id="indexImage1" alt="Spar Todopromo">
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
              <p class="login-box-msg"></p>

              <form action="view/index.php?accion=login" method="post">
                <?php 
                if(isset($_SESSION["spar_error"]))
                {
                ?>
                <div class="alert alert-danger"><?php echo $_SESSION["spar_error"];?></div>
                <?php 
                unset($_SESSION["spar_error"]);
                }
                ?>
                <div class="form-group has-feedback">
                  <input type="text" class="form-control" name="usuario" placeholder="Usuario">
                  <span class="glyphicon glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" class="form-control" name="contrasena" placeholder="Contraseña">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-8">
                    <div class="checkbox icheck">
                      <label>
                        &nbsp;
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
            </div>
            <!-- /.login-box-body -->
          </div>
          <!-- /.login-box -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.content-wrapper -->
<!-- Inicio del pie de página -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versión</b> 1.0.0
        </div>
        Todos los derechos reservados 2017 - <strong>Sistema Spar Todopromo</strong> | Spar Todopromo, SAPI de C.V.
      </footer>
    <!-- Fin del pie de página -->
    </div>
    <!-- /.wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="assets/js/iCheck/icheck.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/js/app.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
