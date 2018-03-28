<div class="form-group col-md-12">
  <div class="table-responsive">
    <table id="tablaPuestos" class="table table-hover table-bordered table-responsive table-condensed text-center small">
      <tr>
        <th >Puesto</th>
        <th >Cantidad</th>
        <th >Costo Unitario</th>
        <th >Perfil</th>
        <th></th>
      </tr>
      <?php
      foreach ($filasPresupuesto as $filaPresupuesto) {
      ?>
      <tr>
        <td>
          <input type="text" class="form-control input-sm text-center hidden"  name="filaPresupuesto" value="<?php echo base64_encode($filaPresupuesto['idPresupuestoPuesto']);?>" hidden readonly>
          <input type="text" class="form-control input-sm text-center" name="puesto" value="<?php echo $filaPresupuesto['nombre'];?>" readonly>
        </td>
        <td>
          <input type="number" class="form-control input-sm text-center" min="1" step="1" name="cantidad" value="<?php echo $filaPresupuesto['disponible'];?>" oninput="validarCantidad(this,<?php echo $filaPresupuesto["disponible"]?>);">
        </td>
        <td>
          <input type="number" class="form-control input-sm text-center" name="costoUnitario" value="<?php echo $filaPresupuesto['costoUnitario'];?>" readonly>
        </td>
        <td>
          <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="perfil" id="perfiles" data-container="body"  data-container="body" data-width="auto">
            <option data-hidden="true"></option>
          <?php 
          foreach ($perfiles as $perfil) {
          ?>
            <option value="<?php echo base64_encode($perfil['idPerfil']);?>"><?php echo $perfil["nombrePerfil"]." ($".number_format($perfil["salario"],2).")";?></option>
          <?php
          }
          ?>
          </select>
        </td>
        <td></td>
      </tr> 
      <?php 
      }
      ?>
    </table>
  </div>
</div>