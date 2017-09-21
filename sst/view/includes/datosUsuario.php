<nav class="navbar navbar-static-top">
  <!-- Botón de desplazamiento de la barra lateral-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- Detalle de usuario de la parte superior derecha -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="data:image;base64,<?php echo base64_encode( $datosUsuario['foto'] );?>" class="user-image" alt="Foto de Usuario">
          <span class="hidden-xs"><?php echo $datosUsuario["nombre"];?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- Foto del usuario -->
          <li class="user-header">
            <img src="data:image;base64,<?php echo base64_encode( $datosUsuario['foto'] );?>" class="img-circle" alt="Foto de Usuario">
            <p>
              <?php echo $datosUsuario["nombre"];?>
              <small>No. Empleado: <?php echo $datosUsuario["numEmpleado"];?> | <?php echo $datosUsuario["puesto"];?></small>
            </p>
          </li>
          <!-- Fin del cuerpo del Menú superior derecho -->
          <!-- Menú en pie de página del menú superior derecho-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="/sst/view/index.php?accion=perfil" class="btn btn-default btn-flat">Perfil del usuario</a>
            </div>
            <div class="pull-right">
              <a href="/sst/view/index.php?accion=logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Botón superior derecho asignado para bloquear la sesión -->
      <li>
          <a href="/sst/view/bloqueo/index.php?accion=index"><i class="fa fa-unlock"></i></a>
      </li>
    </ul>
  </div>
</nav>