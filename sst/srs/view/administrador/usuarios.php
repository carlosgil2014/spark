<table class="table table-striped table-bordered table-hover" id="tablaUsuarios" style="font-size:7.5pt">
  <thead>
    <tr>
      <th style="background-color: #bce8f1 ;" >Nombre</th>
      <th style="background-color: #bce8f1 ;" >Usuario</th>
      <th style="background-color: #bce8f1 ;" >Contraseña</th>
      <th style="background-color: #bce8f1 ;" >Clientes</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $usuario) {
    ?>
      <tr>
        <td align = "center"><?php echo $usuario["nombre"] ?></td>
        <td align = "center"><?php echo $usuario["usuario"] ?></td>
        <td align = "center"><?php echo $usuario["contrasena"] ?></td>
        <td align = "center">
            <div class="radio">
                <label><input type="radio" style="cursor:pointer;" name="clientes" class="clientes" data-toggle="modal" data-target="#modal" value="<?php echo $usuario["idusuarios"];?>" ></label>
            </div>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table> 