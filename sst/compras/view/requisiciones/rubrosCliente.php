<div class="row">
  <section class="content-header">
    <h4>
    Detalles
      <small></small>
    </h4>
    <ol class="breadcrumb">
      <li><a style="cursor:pointer;" data-toggle="tooltip" onclick="agregarFila();"><i class="fa fa-plus"></i>Agregar rubro</a></li>
    </ol>
  </section>
</div>
<div class="table-responsive">
  <table id="tablaDetalles" class="table table-hover table-bordered table-responsive table-condensed text-center">
    <tr>
      <th>Cantidad</th>
      <th>Producto o Servicio</th>
      <th>Unidad</th>
      <th></th>
    </tr>
    <tr id="filaPrincipal">
      <td><input class="form-control input-sm" type="number" name="cantidades[]"></td>
      <td>
        <select class="form-control input-sm selectpicker" data-live-search="true">
          <option data-hidden="true"></option>
        <?php 
        foreach ($rubros as $rubro) {
        ?>
          <option data-subtext="(<?php echo $rubro['tipo'];?>)"><?php echo $rubro["nombre"]?></option>
        <?php
        }
        ?>
        </select>
      </td>
      <td>
        <select class="form-control input-sm selectpicker" data-live-search="true">
          <option data-hidden="true"></option>
        <?php 
        foreach ($unidades as $unidad) {
        ?>
          <option><?php echo $unidad["nombre"]?></option>
        <?php
        }
        ?>
        </select>
      </td>
    </tr>
  </table>
</div>
<div class="form-group row">
  <button type="submit" class="btn btn-sm btn-primary pull-right" name="Datos[tipo]" value="1" >Guardar</button>
</div>